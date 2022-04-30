<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
    private function process_delivery_form(){
        
        $nombre       = $this->input->post('nombreApellido', true);
        $email        = $this->input->post('mail', true);
        $celular      = $this->input->post('celular', true);
        $barrio       = $this->input->post('idBarrio', true);
        $bolsonCant   = $this->input->post('rbBolson', true);
        $direccion    = $this->input->post('domicilio', true);
        $piso         = $this->input->post('domicilioPisoDepto', true);
        //$confirmation = $this->input->post('confirmation', true);
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        $aExtras      = $this->input->post('arrExtras-ebo', true); 
        $codigoCupon  = $this->input->post('cuponDescuento', true);
        //$montoDelivery = $this->input->post('montoDelivery', true);

        //Con esto revierto el stringify del js.
        if(!isset($bolsonCant)){
            $bolsonCant = 0;
        }
        if(isset($aExtras) && count($aExtras)>0){
            $aExtras = json_decode($aExtras);
        }
        /*
        printf($nombre."\n");
        printf($email."\n");
        printf($celular."\n");
        printf($barrio."\n");
        printf($direccion."\n");
        printf($piso."\n");
        print("BOLSON CANT.:".$bolsonCant."\n");
        foreach($aExtras as $oExtra){
            printf("\nEXTRA: ".$oExtra->idExtra.", ".$oExtra->cantExtra);
        }
        */

        $errors = [];
        /*if(empty($nombre)) {
            array_push($errors, 'Nombre y apellido son obligatorios.');
        }
        if(empty($email)) {
            array_push($errors, 'El correo electrónico es obligatorio.');
        }
        if(empty($barrio)) {
            array_push($errors, 'Elige barrio para entregar el pedido.');
        }
        if(empty($direccion)) {
            array_push($errors, 'La dirección de entrega es obligatoria.');
        }
        if(!isset($bolson)) {
            array_push($errors, 'Elige un bolsón para añadir al pedido.');
        }
        if(!isset($idDiaEntrega)) {
            array_push($errors, 'Por favor, confirma la fecha de retiro marcando la casilla.');
        }*/        
        if(count($errors) > 0) {
            $this->session->processErrors = $errors;
            $this->renderMain([
                'nombre' => $nombre ?? null,
                'email' => $email ?? null,
                'celular' => $celular ?? null,
                'barrio' => $barrio ?? null,
                'bolson' => $bolsonCant ?? null,
                'extras' => $extras ?? null,
                'confirmation' => $idDiaEntrega ?? null,
                'idDiaEntrega' => $idDiaEntrega ?? null,
                'direccion' => $direccion ?? null,
                'piso' => $piso ?? null,
                'errors' => $errors ?? null,
                'type' => 'delivery'
            ]);
        }else{  
            
            // Todo ok, lo doy de alta
            $this->load->model('Order');
            $hash = sha1($nombre.uniqid());
            //ID TIPO PEDIDO 2 => DELIVERY
            $idTipoPedido = 2;
            
            $this->load->model('DiasEntregaPedidos');
            $oDiaEntregaPedido = $this->DiasEntregaPedidos->getById($idDiaEntrega);
            $pushOrderResult = $this->Order->add(
                $nombre,
                $email,
                $celular,
                null,
                $bolsonCant,
                $oDiaEntregaPedido->descripcion,
                $idDiaEntrega,
                $idTipoPedido,
                false,
                $direccion,
                $piso,
                $barrio,
                $hash
            );

            $pedidoSoloExtras = false;

            $montoTotalPedido = 0;

            $this->load->model('Pocket');
            
            $oBolson = null;

            if(isset($bolsonCant) && $bolsonCant>0){
                //SI LA CANTIDAD DE BOLSON ES > 0, ES QUE PIDIERON.
                //oBOLSON viene de la base, no del front
                //HARDCODEO EL ID DEL BOLSON PORQUE AHORA SE USA SOLO ESTE REGISTRO.
                $oBolson = $this->Pocket->getById(1);
                if(isset($oBolson->price)){
                    $montoTotalPedido = $montoTotalPedido + ($oBolson->price * $bolsonCant);
                }
            }

            $_extras = [];
            if(isset($aExtras) && count($aExtras)>0){
                $this->load->model('Extra');
                foreach($aExtras as $oExtra) {
                    
                    $this->Order->addExtra($pushOrderResult, $oExtra->idExtra, $oExtra->cantExtra);
                    $this->Extra->reducirStockExtra($oExtra->idExtra,$oExtra->cantExtra);
                    $extra = $this->Extra->getById($oExtra->idExtra);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => ($extra->price * $oExtra->cantExtra)
                    ];
                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + ($extra->price * $oExtra->cantExtra);
                    }
                }
            }

            $valorReserva = 0;
            $montoDelivery = 0;
            $esReserva = false;

            $this->load->model('Parameter');
            $montoMinimoParaEnvioSinCargo = (int)$this->Parameter->get('montoMinimoPedidosExtrasEnvioSinCargo');
            
            if($montoTotalPedido>=$montoMinimoParaEnvioSinCargo){
                //SI EL ENVIO ES SIN CARGO, SE LE COBRA LA RESERVA
                $valorReserva = $this->getValorReservaByMontoPedido($montoTotalPedido);
                $esReserva = true;
            }else{
                //SI EL ENVIO ES CON CARGO, NO SE COBRA LA RESERVA
                $this->load->model('Barrio');
                $oBarrio = $this->Barrio->getById($barrio);
                $montoDelivery = (int)$oBarrio->costo_envio;
            }

            //EN ESTE CAMPO UNIFICO EL MONTO DE ENVIO SI ES QUE SE COBRA O LA RESERVA, SI NO SE COBRA EL ENVIO
            $montoEnvioReserva = $montoDelivery + $valorReserva;

            if(!$esReserva) {
                $montoTotalPedido = $montoTotalPedido + $montoEnvioReserva;
            }

            $montoDescuento = 0;

            if(isset($codigoCupon) && $codigoCupon!="") {
                $this->load->model('Cupones');
                $cupon = $this->Cupones->getByCodigo($codigoCupon);        
                if(isset($cupon) && $cupon->idCupon > 0) {
                    if($cupon->idTipoDescuento==1) {
                        //monto fijo
                        $montoDescuento = $cupon->descuento;
                    } else {
                        // porcentaje
                        $montoDescuento = ceil(($montoTotalPedido*$cupon->descuento)/100);
                    }
                    $montoTotalPedido = $montoTotalPedido - $montoDescuento;
                }
            }

            $this->Order->updateMontoTotal($pushOrderResult,$montoTotalPedido);
            $this->Order->updateMontoPagado($pushOrderResult,$montoEnvioReserva);
            $this->Order->updateMontoDescuento($pushOrderResult,$cupon->idCupon,$montoDescuento);

            $orderData = [
                'nombre' => $nombre,
                'email' => $email,
                'celular' => $celular,
                'pocket_id' => 1,
                'bolson_cant' => $bolsonCant,
                'deliver_date' => $oDiaEntregaPedido->descripcion,
                'deliver_address' => $direccion,
                'deliver_extra' => $piso,
                'barrio_id' => $barrio,
                'extras' => $_extras,
                'hash' => $hash,
                'idTipoPedido' => $idTipoPedido,
                'montoEnvioReserva' => $montoEnvioReserva
            ];
            
            
            // Despacho el checkout
            $this->dispatchCheckout($pushOrderResult, $orderData);
        }
    }
    
    private function process_sucursal_form()
    {
        $nombre        = $this->input->post('nombreApellido', true);
        $email         = $this->input->post('mail', true);
        $celular       = $this->input->post('celular', true);
        $idPuntoRetiro = $this->input->post('idPuntoRetiro', true);
        $bolsonCant    = $this->input->post('rbBolson', true);
        $idDiaEntrega  = $this->input->post('idDiaEntrega', true);
        $codigoCupon   = $this->input->post('cuponDescuento', true);
        $aExtras       = $this->input->post('arrExtras-ebo', true); 

        //Con esto revierto el stringify del js.
        if(isset($aExtras) && count($aExtras)>0){
            $aExtras = json_decode($aExtras);
        }
        
        $errors = [];

        if(count($errors) > 0) {
            $this->session->processErrors = $errors;
            $this->renderMain([
                'nombre' => $nombre ?? null,
                'email' => $email ?? null,
                'celular' => $celular ?? null,
                'sucursal' => $sucursal ?? null,
                'bolson' => $bolson ?? null,
                'extras' => $extras ?? null,
                'confirmation' => $idDiaEntrega ?? null,
                'idDiaEntrega' => $idDiaEntrega ?? null,
                'errors' => $errors ?? null,
                'type' => 'sucursal'
            ]);
        }else{
            // Todo ok, lo doy de alta
            $this->load->model('Order');
            $hash = sha1($nombre.uniqid());
            //ID TIPO PEDIDO 1 => SUCURSAL
            $idTipoPedido = 1;
            $this->load->model('DiasEntregaPedidos');
            $oDiaEntregaPedido = $this->DiasEntregaPedidos->getById($idDiaEntrega);

            $pushOrderResult = $this->Order->add(
                $nombre,
                $email,
                $celular,
                $idPuntoRetiro,
                $bolsonCant,
                $oDiaEntregaPedido->descripcion,
                $idDiaEntrega,
                $idTipoPedido,
                false,
                null,
                null,
                null,
                $hash
            );
            
            $pedidoSoloExtras = false;

            $montoTotalPedido = 0;
            
            $this->load->model('Pocket');

            $oBolson = null;

            if(isset($bolsonCant) && $bolsonCant>0){
                //SI LA CANTIDAD DE BOLSON ES > 0, ES QUE PIDIERON.
                //oBOLSON viene de la base, no del front
                //HARDCODEO EL ID DEL BOLSON PORQUE AHORA SE USA SOLO ESTE REGISTRO.
                $oBolson = $this->Pocket->getById(1);
                if(isset($oBolson->price)){
                    $montoTotalPedido = $montoTotalPedido + ($oBolson->price * $bolsonCant);
                }
            }

            $_extras = [];
            if(isset($aExtras) && count($aExtras)>0){
                $this->load->model('Extra');
                foreach($aExtras as $oExtra) {
                    $this->Order->addExtra($pushOrderResult, $oExtra->idExtra, $oExtra->cantExtra);
                    $this->Extra->reducirStockExtra($oExtra->idExtra,$oExtra->cantExtra);
                    $extra = $this->Extra->getById($oExtra->idExtra);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => ($extra->price * $oExtra->cantExtra)
                    ];
                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + ($extra->price * $oExtra->cantExtra);
                    }
                }
            }
            $valorReserva = $this->getValorReservaByMontoPedido($montoTotalPedido);
            $montoDescuento = 0;

            if(isset($codigoCupon) && $codigoCupon!="") {
                $this->load->model('Cupones');
                $cupon = $this->Cupones->getByCodigo($codigoCupon);        
                if(isset($cupon) && $cupon->idCupon > 0) {
                    if($cupon->idTipoDescuento==1) {
                        //monto fijo
                        $montoDescuento = $cupon->descuento;
                    } else {
                        // porcentaje
                        $montoDescuento = ceil(($montoTotalPedido*$cupon->descuento)/100);
                    }
                    $montoTotalPedido = $montoTotalPedido - $montoDescuento;
                }
            }
            $this->Order->updateMontoTotal($pushOrderResult,$montoTotalPedido);
            $this->Order->updateMontoPagado($pushOrderResult,$valorReserva);
            $this->Order->updateMontoDescuento($pushOrderResult,$cupon->idCupon,$montoDescuento);

            $orderData = [
                'nombre' => $nombre,
                'email' => $email,
                'celular' => $celular,
                'pocket_id' => 1,
                'bolson_cant' => $bolsonCant,
                'deliver_date' => $oDiaEntregaPedido->descripcion,
                'idPuntoRetiro' => $idPuntoRetiro,
                'extras' => $_extras,
                'hash' => $hash,
                'idTipoPedido' => $idTipoPedido,
                'montoEnvioReserva' => $valorReserva
            ];
            // Despacho el checkout
            if($valorReserva > 0) {
                $this->dispatchCheckout($pushOrderResult, $orderData);
            }else{
                //PEDIDOS CHICOS VAN CON RESERVA = $0. NO PASA POR MP.
                redirect('/success/'.$hash);  
            }

            //redirect('/success/'.$hash);
        }
    }

    private function old_process_delivery_form()
    {   
        /*********************************************** */
        //NO SE USA MAS. SI TODO FUNCIONA, DEPSUES LA BORRO
        /*********************************************** */
        $nombre       = $this->input->post('nombre', true);
        $email        = $this->input->post('email', true);
        $celular      = $this->input->post('celular', true);
        $barrio       = $this->input->post('barrio', true);
        $bolson       = $this->input->post('bolson', true);
        $extras       = $this->input->post('extras', true);
        $direccion    = $this->input->post('direccion', true);
        $piso         = $this->input->post('piso', true);
        //$confirmation = $this->input->post('confirmation', true);
        $idDiaEntrega = $this->input->post('confirmation', true);

        $aExtras      = $this->input->post('arrExtras-delivery', true); 

        //Con esto revierto el stringify del js.
        $aExtras = json_decode($aExtras);

        $errors = [];
        if(empty($nombre)) {
            array_push($errors, 'Nombre y apellido son obligatorios.');
        }
        if(empty($email)) {
            array_push($errors, 'El correo electrónico es obligatorio.');
        }
        if(empty($barrio)) {
            array_push($errors, 'Elige barrio para entregar el pedido.');
        }
        if(empty($direccion)) {
            array_push($errors, 'La dirección de entrega es obligatoria.');
        }
        /*if(!isset($bolson)) {
            array_push($errors, 'Elige un bolsón para añadir al pedido.');
        }*/
        if(!isset($idDiaEntrega)) {
            array_push($errors, 'Por favor, confirma la fecha de retiro marcando la casilla.');
        }

        if(count($errors) > 0) {
            $this->session->processErrors = $errors;
            $this->renderMain([
                'nombre' => $nombre ?? null,
                'email' => $email ?? null,
                'celular' => $celular ?? null,
                'barrio' => $barrio ?? null,
                'bolson' => $bolson ?? null,
                'extras' => $extras ?? null,
                'confirmation' => $idDiaEntrega ?? null,
                'idDiaEntrega' => $idDiaEntrega ?? null,
                'direccion' => $direccion ?? null,
                'piso' => $piso ?? null,
                'errors' => $errors ?? null,
                'type' => 'delivery'
            ]);
        }else{
            
            // Todo ok, lo doy de alta
            $this->load->model('Order');
            $hash = sha1($nombre.uniqid());
            /*$celularFormateado = $celular;
            $celularFormateado = str_replace(" ","",$celularFormateado);
            $celularFormateado = str_replace("-","",$celularFormateado);
            if( substr($celularFormateado,0,2)=="15" ){
                //SI ARRANCA CON 15 HAGO QUE ARRANQUE CON 11 y lo formateo con el +549
                $celularFormateado = preg_replace("/15/","11",$celularFormateado,1);
                $celularFormateado = "+549".$celularFormateado;
            }else if( substr($celularFormateado,0,2)=="11"){
                //SI ARRANCA CON 11, SOLAMENTE LE AGREGO EL +549 ADELANTE
                $celularFormateado = "+549".$celularFormateado;
            }else if( substr($celularFormateado,0,3)=="549"){
                //SI ARRANCA CON EL 549, SOLAMENTE LE AGREGO EL +
                $celularFormateado = "+".$celularFormateado;
            }else if( substr($celularFormateado,0,5)=="+5415"){
                $celularFormateado = preg_replace("/15/","11",$celularFormateado,1);
                $celularFormateado = substr_replace( $celularFormateado, "9", 3, 0 );
            }else if( substr($celularFormateado,0,5)=="+5411"){
                $celularFormateado = substr_replace( $celularFormateado, "9", 3, 0 );
            }*/

            //ID TIPO PEDIDO 2 => DELIVERY
            $idTipoPedido = 2;
            
            $this->load->model('DiasEntregaPedidos');
            $oDiaEntregaPedido = $this->DiasEntregaPedidos->getById($idDiaEntrega);
            
            $pushOrderResult = $this->Order->add(
                $nombre,
                $email,
                $celular,
                null,
                $bolson,
                $oDiaEntregaPedido->descripcion,
                $idDiaEntrega,
                $idTipoPedido,
                false,
                $direccion,
                $piso,
                $barrio,
                $hash
            );

            $pedidoSoloExtras = false;

            $montoTotalPedido = 0;
            $montoDelivery = 0;
            $this->load->model('Pocket');
            $oBolson = $this->Pocket->getById($bolson);
                        
            $_extras = [];
            if(isset($aExtras)) {
                $this->load->model('Extra');
                foreach($aExtras as $oExtra) {
                    
                    $this->Order->addExtra($pushOrderResult, $oExtra->idExtra, $oExtra->cantExtra);
                    $this->Extra->reducirStockExtra($oExtra->idExtra,$oExtra->cantExtra);
                    $extra = $this->Extra->getById($oExtra->idExtra);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => ($extra->price * $oExtra->cantExtra)
                    ];
                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + ($extra->price * $oExtra->cantExtra);
                    }
                }
            }

            if(isset($oBolson)){
                if(isset($oBolson->price)){
                    $montoTotalPedido = $montoTotalPedido + $oBolson->price;
                    $montoDelivery = $oBolson->delivery_price;
                    $montoTotalPedido = $montoTotalPedido + $oBolson->delivery_price;
                }
            }else{
                //SI NO TIENE BOLSON ES UN PEDIDO DE EXTRAS SOLAMENTE
                $pedidoSoloExtras = true;
                $this->load->model('Parameter');
                $montoEnvioSinCargo = (double)$this->Parameter->get('montoMinimoPedidosExtrasEnvioSinCargo');
                $montoDelivery = (double)$this->Parameter->get('costoEnvioPedidosExtras');
                if($montoTotalPedido < $montoEnvioSinCargo){
                    //SI NO TIENE ENVIO SIN CARGO
                    $montoTotalPedido = $montoTotalPedido + $montoDelivery;
                }

            }

            /*if(isset($extras)) {
                $this->load->model('Extra');
                foreach($extras as $extraId) {
                    $this->Order->addExtra($pushOrderResult, $extraId);
                    $this->Extra->reducirStockExtra($extraId);

                    $extra = $this->Extra->getById($extraId);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => $extra->price
                    ];

                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + $extra->price;
                    }
                }
            }*/
            
            $this->Order->updateMontoTotal($pushOrderResult,$montoTotalPedido);

            //EL MONTO DEL DELIVERY DEL BOLSON ES LO QUE EL CLIENTE PAGA POR MERCADO PAGO.
            $this->Order->updateMontoPagado($pushOrderResult,$montoDelivery);
            
            $orderData = [
                'nombre' => $nombre,
                'email' => $email,
                'celular' => $celular,
                'pocket_id' => $bolson,
                'deliver_date' => $confirmation,
                'deliver_address' => $direccion,
                'deliver_extra' => $piso,
                'barrio_id' => $barrio,
                'extras' => $_extras,
                'pedidoSoloExtras' => $pedidoSoloExtras,
                'idTipoPedido' => $idTipoPedido,
                'hash' => $hash
            ];

            // Despacho el checkout
            $this->dispatchCheckout($pushOrderResult, $orderData);
        }
    }

    private function dispatchCheckout($orderId, $orderData)
    {
        $this->load->helper('parser');
        $this->load->model('Pocket');
        $this->load->model('Barrio');
        $this->load->model('Office');
        $this->load->model('Extra');
        $this->load->model('Parameter');

        MercadoPago\SDK::setAccessToken($this->Parameter->get('mp_at'));

        $preference = new MercadoPago\Preference();
        $orderItems = [];

        // Agrego el bolsón como item
        
        $bolson = $this->Pocket->getById($orderData['pocket_id']);

        $tituloReserva = "";

        $montoReserva = $orderData['montoEnvioReserva'];
        
        if($orderData['idTipoPedido'] == 1){
            //PUNTO DE RETIRO
            $tituloReserva = "Reserva por pedido en El Brote Tienda Natural";
        }else{
            $tituloReserva = "Envío-Reserva pedido El Brote Tienda";
        }
        
        // Agrego el costo de envío como otro ítem
        $shippingItem = new MercadoPago\Item();
        $shippingItem->title = $tituloReserva;
        $shippingItem->quantity = 1;
        $shippingItem->unit_price = priceToDouble($montoReserva);
        $orderItems[] = $shippingItem;

        $preference->items = $orderItems;

        // Agrego la info del cliente que tengo disponible
        $customer = new MercadoPago\Payer();
        $customer->email = $orderData['email'];
        $customer->phone = [
            'area_code' => '',
            'number' => $orderData['celular']
        ];
        $preference->payer = $customer;

        // URLs de retorno
        /*COMENTO ESTO SOLO POR PRUEBAS: PARA DESPLEGAR VA ESTO DESCOMENTADO*/
        /*
        if($orderData['idTipoPedido'] == 1){
            $preference->back_urls = [
                'success' => base_url().'success/'.$orderData['hash'].'/',
                'failure' => base_url().'failure/'.$orderData['hash'].'/'
            ];
        }else{
            $preference->back_urls = [
                'success' => base_url().'success/'.$orderData['hash'].'/delivery/',
                'failure' => base_url().'failure/'.$orderData['hash'].'/'
            ];
        }
        $preference->notification_url = base_url().'payment_confirmation/'.$orderData['hash'];
        */
        /*  Esta propiedad se define para que en el momento que se procesa OK el pago en la web de MP, 
            si el cliente no espera a retornar a la web y cierra la ventana, MP nos notifique a nosotros del pago realizado.
        */
    
        /*Back URLs de prueba */
        
        if($orderData['idTipoPedido'] == 1){
            $preference->back_urls = [
                'success' => 'http://antezana228.ar.camaras.proseguralarmas.com:81/ebo/success/'.$orderData['hash'].'/',
                'failure' => 'http://antezana228.ar.camaras.proseguralarmas.com:81/ebo/failure/'.$orderData['hash'].'/'
            ];
        }else{
            $preference->back_urls = [
                'success' => 'http://antezana228.ar.camaras.proseguralarmas.com:81/ebo/success/'.$orderData['hash'].'/delivery/',
                'failure' => 'http://antezana228.ar.camaras.proseguralarmas.com:81/ebo/failure/'.$orderData['hash'].'/'
            ];
        }
        $preference->notification_url = 'http://antezana228.ar.camaras.proseguralarmas.com:81/ebo/payment_confirmation/'.$orderData['hash'];
        

        // Desactivo estado 'pendiente' y métodos en efectivo.
        $preference->binary_mode = true;
        $preference->auto_return = "all";
        $preference->payment_methods = [
            'excluded_payment_methods' => [],
            'excluded_payment_types' => [
                ['id' => 'ticket'],
                ['id' => 'atm']
            ],
            'installments' => 1
        ];
        
        $preference->save();
            
        header("Location: " . $preference->init_point);
    }

    private function old_process_sucursal_form()
    {
        $nombre       = $this->input->post('nombre', true);
        $email        = $this->input->post('email', true);
        $celular      = $this->input->post('celular', true);
        $sucursal     = $this->input->post('sucursal', true);
        $bolson       = $this->input->post('bolson', true);
        $extras       = $this->input->post('extras', true); 

        $aExtras      = $this->input->post('arrExtras-sucursal', true); 
        //Con esto revierto el stringify del js.
        $aExtras = json_decode($aExtras);

        /*foreach($aExtras as $oExtra){    
            printf($oExtra->idExtra.":".$oExtra->cantExtra."\n");
        }*/

        //$confirmation = $this->input->post('confirmation', true);
        
        $idDiaEntrega = $this->input->post('confirmation', true);

        $errors = [];
        if(empty($nombre)) {
            array_push($errors, 'Nombre y apellido son obligatorios.');
        }
        if(empty($email)) {
            array_push($errors, 'El correo electrónico es obligatorio.');
        }
        if(empty($sucursal)) {
            array_push($errors, 'Elige una sucursal para retirar tu pedido.');
        }
        /*if(!isset($bolson)) {
            array_push($errors, 'Elige un bolsón para añadir al pedido.');
        }*/
        if(!isset($idDiaEntrega)) {
            array_push($errors, 'Por favor, confirma la fecha de retiro marcando la casilla.');
        }

        if(count($errors) > 0) {
            $this->session->processErrors = $errors;
            $this->renderMain([
                'nombre' => $nombre ?? null,
                'email' => $email ?? null,
                'celular' => $celular ?? null,
                'sucursal' => $sucursal ?? null,
                'bolson' => $bolson ?? null,
                'extras' => $extras ?? null,
                'confirmation' => $idDiaEntrega ?? null,
                'idDiaEntrega' => $idDiaEntrega ?? null,
                'errors' => $errors ?? null,
                'type' => 'sucursal'
            ]);
        }else{
            // Todo ok, lo doy de alta
            $this->load->model('Order');
            $hash = sha1($nombre.uniqid());
            /*$celularFormateado = $celular;
            $celularFormateado = str_replace(" ","",$celularFormateado);
            $celularFormateado = str_replace("-","",$celularFormateado);
            if( substr($celularFormateado,0,2)=="15" ){
                //SI ARRANCA CON 15 HAGO QUE ARRANQUE CON 11 y lo formateo con el +549
                $celularFormateado = preg_replace("/15/","11",$celularFormateado,1);
                $celularFormateado = "+549".$celularFormateado;
            }else if( substr($celularFormateado,0,2)=="11"){
                //SI ARRANCA CON 11, SOLAMENTE LE AGREGO EL +549 ADELANTE
                $celularFormateado = "+549".$celularFormateado;
            }else if( substr($celularFormateado,0,3)=="549"){
                //SI ARRANCA CON EL 549, SOLAMENTE LE AGREGO EL +
                $celularFormateado = "+".$celularFormateado;
            }else if( substr($celularFormateado,0,5)=="+5415"){
                $celularFormateado = preg_replace("/15/","11",$celularFormateado,1);
                $celularFormateado = substr_replace( $celularFormateado, "9", 3, 0 );
            }else if( substr($celularFormateado,0,5)=="+5411"){
                $celularFormateado = substr_replace( $celularFormateado, "9", 3, 0 );
            }*/
            
            //ID TIPO PEDIDO 1 => SUCURSAL
            $idTipoPedido = 1;

            $this->load->model('DiasEntregaPedidos');
            $oDiaEntregaPedido = $this->DiasEntregaPedidos->getById($idDiaEntrega);

            $pushOrderResult = $this->Order->add(
                $nombre,
                $email,
                $celular,
                $sucursal,
                $bolson,
                $oDiaEntregaPedido->descripcion,
                $idDiaEntrega,
                $idTipoPedido,
                false,
                null,
                null,
                null,
                $hash
            );

            $montoTotalPedido = 0;
            $this->load->model('Pocket');
            $oBolson = $this->Pocket->getById($bolson);

            if(isset($oBolson)){
                if(isset($oBolson->price)){
                    $montoTotalPedido = $montoTotalPedido + $oBolson->price;
                }
            }


            $_extras = [];
            if(isset($aExtras)) {
                $this->load->model('Extra');
                foreach($aExtras as $oExtra) {
                    $this->Order->addExtra($pushOrderResult, $oExtra->idExtra, $oExtra->cantExtra);
                    $this->Extra->reducirStockExtra($oExtra->idExtra,$oExtra->cantExtra);
                    $extra = $this->Extra->getById($oExtra->idExtra);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => ($extra->price * $oExtra->cantExtra)
                    ];
                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + ($extra->price * $oExtra->cantExtra);
                    }
                }
            }

            /*$_extras = [];
            if(isset($extras)) {
                $this->load->model('Extra');
                foreach($extras as $extraId) {
                    $this->Order->addExtra($pushOrderResult, $extraId);
                    $this->Extra->reducirStockExtra($extraId);
                    $extra = $this->Extra->getById($extraId);
                    $_extras[] = [
                        'name'  => $extra->name,
                        'price' => $extra->price
                    ];
                    if(isset($extra->price)){
                        $montoTotalPedido = $montoTotalPedido + $extra->price;
                    }
                }
            }*/
            //COMO ESTAMOS EN SUCURSAL, EL MONTO QUE DEBE ES IGUAL AL TOTAL YA QUE NO SE PAGA POR ADELANTADO.
            //ES DIFERENTE PARA DOMICILIOS PORQUE SE TIENE QUE DESCONTAR LO PAGADO POR MERCADO PAGO
            
            $this->Order->updateMontoTotal($pushOrderResult,$montoTotalPedido);
            $this->Order->updateMontoPagado($pushOrderResult,0);

            redirect('/success/'.$hash);
        }
    }

    public function index()
    {
        if(!is_null($this->input->post('csrfv'))) {
            $this->load->model('Parameter');
            switch ($this->input->post('type')) {
                case 'DEL':
                    //if ($this->Parameter->get('delivery_enabled') == 0) {
                    if ($this->Parameter->get('form_enabled') == 0) {
                        redirect('/');
                    } else {
                        $this->process_delivery_form();
                    }
                    break;

                case 'SUC':
                    if ($this->Parameter->get('form_enabled') == 0) {
                        redirect('/');
                    }else {
                        $this->process_sucursal_form();
                    }
                    break;

                default:
                    redirect('/');
                    break;
            }
        }else{
            $this->renderMain();
        }
    }

    public function about(){
        
        $this->load->view('about');
    }

    public function renderMain($args = [])
    {
        $this->load->model('Pocket');

        $this->load->model('Office');
        $this->load->model('Extra');
        $this->load->model('Parameter');
        $this->load->model('Barrio');
        $this->load->model('DiasEntregaPedidos');
        
        if (empty($args)) {
            $args = [
                'nombre'            => null,
                'email'             => null,
                'celular'           => null,
                'sucursal'          => null,
                'bolson'            => null,
                'extrasInput'       => null,
                'confirmation'      => null,
                'diaEntrega'        => null,
                'errors'            => null,
            ];
        }
        
        
        //$this->load->view('main', array_merge($args, [
        $this->load->view('index', array_merge($args, [
            'bolsones'           => $this->Pocket->getAll(),
            'bolsonIndividual'   => $this->Pocket->getById(1),
            'bolsonBasico'       => $this->Extra->getById(1),
            'sucursales'         => $this->Office->getAll(),
            'extras'             => $this->Extra->getAllWithStock(),
            'extrasDomicilios'   => $this->Extra->getAllVisiblesInDomicilio(),
            'extrasSucursales'   => $this->Extra->getAllVisiblesInSucursal(),
            'barrios'            => $this->Barrio->getAll(),
            'enabled'            => $this->Parameter->get('form_enabled'),
            'delivery'           => $this->Parameter->get('delivery_enabled'),
            'confirmationLabel'  => $this->Parameter->get('confirmation_label'),
            'diaEntregaPedidos'  => $this->DiasEntregaPedidos->getLastDay(),
            'formTitle'          => $this->Parameter->get('form_title'),
            'formText'           => $this->Parameter->get('form_text'),
            'disabledText'       => $this->Parameter->get('form_disabled_text'),
            'mainText'           => $this->Parameter->get('main_text'),
            'montoMinimoPedidoExtra' => $this->Parameter->get('montoMinimoPedidosExtras'),
            'costoEnvioPedidoExtra' => $this->Parameter->get('costoEnvioPedidosExtras'),
            'montoMinimoEnvioSinCargoPedidoExtra' => $this->Parameter->get('montoMinimoPedidosExtrasEnvioSinCargo'),
            'costoEnvioPedidos'  => $this->Parameter->get('costoEnvioPedidos'),
            'descripcionBolson'  => $this->Parameter->get('descripcionBolson'),
            'descripcionBolsonesFormCerrado'  => $this->Parameter->get('descripcionBolsonesFormCerrado'),
            'descripcionTienda'  => $this->Parameter->get('descripcionTienda'),
            'descripcionTiendaFormCerrado'  => $this->Parameter->get('descripcionTiendaFormCerrado'),
            'imagenBolson' => $this->Parameter->get('archivo_imagen_bolson'),
            'moduloCuponesEnabled' => $this->Parameter->get('moduloCuponesEnabled'),
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos()
        ]));
    }

    public function success($orderHash)
    {
        $this->load->model('Order');
        $this->load->model('Parameter');
        $this->load->model('Pocket');
        $this->load->model('Barrio');
        $this->load->model('Office');
        $this->load->model('Extra');

        $order = $this->Order->getByHash($orderHash);
        if (!$order) {
            redirect('/failure');
        }
        // Ejecuto tareas de validación y mailing solo la primera vez.
        if (!$order->valid) {
            $this->Order->validate($orderHash, 1);
            $this->sendConfirmationMail($order);
            
        } else {
            //error_log("\nORDEN YA VALIDADA!\n".json_encode($order),3,"/home/c1510066/public_html/application/logs/debug.log");
        }

        $extras = $this->Order->getDetailedExtras($order->id);

        $montoDescuento = 0;
        $hayDescuento = false;

        if( isset($order->monto_descuento) && $order->monto_descuento>0 ) {
            $montoDescuento = $order->monto_descuento;
            $hayDescuento = true;
        }


        $totalPriceExtras = 0;
        
        if(!empty($extras) && is_array($extras)) {
            foreach ($extras as $extra) {
                $totalPriceExtras += $extra->total;
            }    
        }
        
        $bolson = $this->Pocket->getById($order->pocket_id);

        $totalPrice = $order->monto_total - $order->monto_pagado;

        $this->load->view('success',[
            'confirmationLabel' => $this->Parameter->get('confirmation_label'),
            'successMessage'    => $this->Parameter->get('order_success'),
            'order'             => $order,
            'pocket'            => $this->Pocket->getById($order->pocket_id),
            'extras'            => $extras,
            'office'            => (($order->office_id) ? $this->Office->getById($order->office_id) : null),
            'barrio'            => (($order->barrio_id) ? $this->Barrio->getById($order->barrio_id) : null),
            'totalPrice'        => $totalPrice,
            'montoDescuento'    => $montoDescuento,
            'montoPagado'       => $order->monto_pagado,
            'hayDescuento'      => $hayDescuento
        ]);
    }

    public function failure($orderHash)
    {
        // Debería borrar las órdenes que volvieron por no ser válidas.
        $this->load->model('Order');

        $order = $this->Order->getByHash($orderHash);
        if (!$order) {
            redirect('/');
        }

        $this->Order->remove($order->id);
        $this->load->view('failure');
    }

    private function getValorReservaByMontoPedido($montoTotalPedido){
        $valorReserva = 0;
        if($montoTotalPedido >= 0 && $montoTotalPedido <= 2000){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango1');
        }else if($montoTotalPedido >= 2001 && $montoTotalPedido <= 3999){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango2');
        }else if($montoTotalPedido >= 4000){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango3');
        }                    
        return $valorReserva;
    }

    public function getCostoDeEnvio(){
        $this->load->model('Parameter');
        $costoEnvio  = $this->Parameter->get('costoEnvioPedidos');

        if( isset($costoEnvio)){
            return $costoEnvio;
        }else{
            //SI LLEGA A FALLAR, DEVUELVO HARDCODEADO EL VALOR ACTUAL. SI MANDAMOS 0, NO LLEGA A MERCADO PAGO
            //PORQUE ESPERA SI O SI QUE VAYA CON MONTO > 0
            return 250;
        }
    }

    public function recetario() {
        $filename = base_url()."assets/resources/recetario.pdf"; //<-- specify the file
        $this->output->set_content_type('application/pdf')->set_output(file_get_contents($filename));
    }

    public function newsletterSuscribe(){
        $this->output->set_content_type('application/json');
        $this->load->model('Newsletter');

        $success = false;
        
        $mail = $this->input->post('mail', true);
        $idNewsletter = $this->Newsletter->add($mail);        

        if($idNewsletter>0) {
            $success = true;
            $this->sendNewsletterMail($mail);
        }

        $return['success'] = $success;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getIsMailSuscribedToNewsletter() {
        $this->output->set_content_type('application/json');
        $this->load->model('Newsletter');

        $isSuscribed = false;
        
        $mail = $this->input->post('mail', true);
        $newsletter = $this->Newsletter->getByMail($mail);        

        if(isset($newsletter) && $newsletter->id_newsletter > 0) {
            $isSuscribed = true;
        }
        $return['isSuscribed'] = $isSuscribed;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function sendNewsletterMail($destinatario) {
        $this->load->library('phpmailer_lib');
        $this->load->model('Parameter');
        $mailServer = $this->Parameter->get("mail_server");
        $mailAccount = $this->Parameter->get("mail_account");
        $mailCopy = $this->Parameter->get("mail_copy");
        $mailPass = $this->Parameter->get("mail_pass");
        $mail = $this->phpmailer_lib->load();
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $mailServer;
        $mail->Username = $mailAccount;
        $mail->Password = $mailPass;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($mailAccount, "El Brote Tienda Natural");
        $mail->addAddress(str_replace(' ','',$destinatario));
        $mail->addReplyTo($mailAccount, "El Brote Tienda Natural");
        
        $mail->addBCC($mailCopy);

        $mailingData = [
            'mail' => $destinatario
        ];

        $this->load->model('Parameter');
        if((int)$this->Parameter->get("recetarioStatus") == 1) {
            $mail->addAttachment("assets/resources/recetario.pdf","Recetario");
        }
        $this->load->model('NewsletterAdjuntos');
        $cAdjuntos = $this->NewsletterAdjuntos->getAllActive();
        if(isset($cAdjuntos) && count($cAdjuntos)>0) {
            foreach($cAdjuntos as $oAdjunto){
                $mail->addAttachment("assets/resources/newsletter/adjuntos/".$oAdjunto->archivo,$oAdjunto->nombre);
            }                
        }
        $mail->isHTML(true);
        $mail->Subject = 'El Brote Tienda Natural - Newsletter.';
        $mail->Body = $this->load->view('mailing/newsletterSuscription', $mailingData, true);
        

        try {
            $mail->send();
        } catch (Exception $e) {
            printf($e->getMessage());
            //print_r("ERROR EXCEPTION: ".$e->getMesssage().":".$e->getLine());
            /*error_log(json_encode($e),3,"/home/c1510066/public_html/application/logs/debug.log");
            $this->load->model('Error');
            $extras = [
                'task' => 'Sending mail notification',
                'mailto' => str_replace(' ','',$order->email)
            ];
            $this->Error->add($e->getMessage(), $e->getFile(), $e->getLine(), json_encode($extras));*/
        }        
        return true;
    }

    function getCuponByCodigo() {
        $this->output->set_content_type('application/json');
        $this->load->model('Cupones');

        $cuponExists = false;

        $codigoCupon = $this->input->post('codigoCupon', true);

        $cupon = $this->Cupones->getByCodigo($codigoCupon);        

        if(isset($cupon) && $cupon->idCupon > 0) {
            $cuponExists = true;
        }
        $return['cuponExists'] = $cuponExists;
        $return['cupon'] = $cupon;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));                  
    }

    function paymenConfirmation($hash) {
        $this->output->set_content_type('application/json');
        $this->load->model('Order');
        $this->load->model('Parameter');
/*
        MercadoPago\SDK::setAccessToken("TEST-7107678042081801-051415-08aeeb15d693ede10d6e35cad0e10741-75232795");
        error_log(json_encode($_GET["data_id"]),3,"../../logs/errorAgus.log");
        switch($_GET["type"]) {
            case "merchant_order":
                $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["data"]["id"]);
                error_log("MERCHANT".json_encode($merchant_order),3,"../../logs/errorAgus.log");
                break;
            case "payment":
                $payment = MercadoPago\Payment::find_by_id($_GET["data"]["id"]);
                error_log("PAYMENT".json_encode($payment),3,"../../logs/errorAgus.log");
                break;
            case "plan":
                print_r("Plan:\n");
                $plan = MercadoPago\Plan::find_by_id($_POST["data"]["id"]);
                break;
            case "subscription":
                print_r("Subscription:\n");
                $plan = MercadoPago\Subscription::find_by_id($_POST["data"]["id"]);
                break;
            case "invoice":
                print_r("Invoice:\n");
                $plan = MercadoPago\Invoice::find_by_id($_POST["data"]["id"]);
                break;
            case "point_integration_wh":
                print_r("Point Integracion Wh:\n");
                // $_POST contiene la informaciòn relacionada a la notificaciòn.
                break;
        }
*/
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        //parse_str($url_components['query'], $params);
        parse_str($url_components['query'], $params);
        //EN DEV ME FUNCIONA CON ESTO
        //$paymentId = $_GET["data_id"];
        $obs = "QueryString: ".$_SERVER['QUERY_STRING']." PostDataId: ".$_POST["data_id"]
            ." PostId: ".$_POST["id"]." GetDataId: ".$_GET["data_id"]." GetId: ".$_GET["id"]
            ." ParamsId: ".$params["id"];
            /*
                QueryString: id=4035729191&topic=merchant_order 
                PostDataId:  
                PostId: 
                GetDataId: 
    }           GetId: 4035729191 ParamsId: 4035729191
            */
        //$this->Order->setObs($hash,$obs);
        //EN PROD ME FUNCIONA CON ESTO PERO SIEMPRE ME DEVUELVE EL MISMO NRO.
        $merchantOrderId = $_GET["id"];
        
        $mercadoPagoAT = $this->Parameter->get("mp_at");
        //error_log("\MP URL:\n".json_encode($params["data_id"]),3,"../../logs/errorAgus.log");        
        
        $order = $this->Order->getByHash($hash);
        $this->Order->savePaymentId($hash,$merchantOrderId);
        
        //$ch = curl_init('https://api.mercadopago.com/v1/payments/'.$paymentId);
        $ch = curl_init('https://api.mercadopago.com/merchant_orders/'.$merchantOrderId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$mercadoPagoAT
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        
        $responseJson = json_decode($result, true);
        
        $status = $responseJson['order_status'];
        
        //error_log("\Fecha Aprobacion:\n".isset($fechaAprobacion)."\nStatus: ".$status."\n ",3,"../../logs/errorAgus.log");        
        
        if(isset($status) && $status=="paid") {
            $this->Order->validate($hash,1);

            $this->sendConfirmationMail($order);        
        }
        
        $this->output->set_status_header(200);
        return $this->output->set_output(true);
    }

    function sendConfirmationMail($order) {
        $this->load->model('Order');
        $this->load->model('Pocket');
        $this->load->model('Office');
        $this->load->model('Barrio');
        $montoDescuento = 0;
        $hayDescuento = false;
        if( isset($order->monto_descuento) && $order->monto_descuento>0 ) {
            $montoDescuento = $order->monto_descuento;
            $hayDescuento = true;
        }
        
        $bolson = $this->Pocket->getById($order->pocket_id);
        
        $totalPriceExtras = 0;
        
        $extras = $this->Order->getDetailedExtras($order->id);
        if(!empty($extras) && is_array($extras)) {
            foreach ($extras as $extra) {
                $totalPriceExtras += (int)$extra->total;
            }
        }
        
        $totalPrice = (int)$order->monto_total - (int)$order->monto_pagado;
        
        if ($order->deliver_type == 'SUC') {
            $viewName = 'normal';
            $viewAltName = 'alt';
            $sucursal = $this->Office->getById($order->office_id);
            $mailingData = [
                'nombre'   => $order->client_name,
                'bolson'   => $bolson,
                'cantBolson' => $order->cant_bolson,
                'totalBolson' => $order->total_bolson,
                'sucursal' => $sucursal->name . ' > ' . $sucursal->address,
                'retiro'   => $order->deliver_date,
                'extras'   => $extras,
                'totalPrice' => $totalPrice,
                'montoDescuento'   => $montoDescuento,
                'montoPagado' => $order->monto_pagado,
                'hayDescuento' => $hayDescuento
            ];
        } else {
            $viewName = 'delivery';
            $viewAltName = 'delivery_alt';
            $barrio = $this->Barrio->getById($order->barrio_id);
            $mailingData = [
                'nombre' => $order->client_name,
                'bolson' => $bolson,
                'cantBolson' => $order->cant_bolson,
                'totalBolson' => $order->total_bolson,
                'extras' => $extras,
                'entrega' => $order->deliver_date,
                'direccion' => $order->deliver_address . ' ' . $order->deliver_extra . ' - ' . $barrio->nombre,
                'totalPrice' => $totalPrice,
                'horarioEntrega' => $barrio->observaciones,
                'montoDescuento'   => $montoDescuento,
                'montoPagado' => $order->monto_pagado,
                'hayDescuento' => $hayDescuento
            ];
        }

        if(!isset($extras)) {
            unset($mailingData['extras']);
        }

        $this->load->library('phpmailer_lib');
        $this->load->model('Parameter');
        
        $mailServer = $this->Parameter->get("mail_server");
        $mailAccount = $this->Parameter->get("mail_account");
        $mailCopy = $this->Parameter->get("mail_copy");
        $mailPass = $this->Parameter->get("mail_pass");
        
        $mail = $this->phpmailer_lib->load();
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $mailServer;
        $mail->Username = $mailAccount;
        $mail->Password = $mailPass;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($mailAccount, "El Brote Tienda Natural");
        $mail->addAddress(str_replace(' ','',$order->email));
        $mail->addReplyTo($mailAccount, "El Brote Tienda Natural");
        $mail->addBCC($mailCopy);

        $mail->isHTML(true);
        $mail->Subject = 'Pedido confirmado en El Brote Tienda Natural.';
        $mail->Body = $this->load->view('mailing/'.$viewName, $mailingData, true);
        $mail->AltBody = $this->load->view('mailing/'.$viewAltName, $mailingData, true);

        try {
            $mail->send();
        } catch (Exception $e) {
        }            
    }
}