<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index() {
        if(!valid_session()) {
            redirect('/logout');
        }

        /*$this->db->set('password', hashed('3lBr0te2020+'));
        $this->db->where('id', 2);
        $this->db->update('users');*/

        $this->load->model('DiasEntregaPedidos');
        $this->renderHead('Inicio');
        $this->load->view('dashboard/main',[
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos()
        ]);
        $this->load->view('dashboard/footer');
    }

    public function renderHead($title)
    {
        $this->load->model('Content');
        $params = [
            'title'           => $title,
            'formEnabled'     => $this->Content->get('form_enabled'),
            'deliveryEnabled' => $this->Content->get('delivery_enabled')
        ];
        $this->load->view('dashboard/head', $params);
    }

    public function formtexts()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Content');
        $renderParams = [
            'formTitle'         => $this->Content->get('form_title'),
            'formText'          => $this->Content->getFormText(),
            'descripcionBolson' => $this->Content->getDescripcionBolson(),
            'descripcionBolsonesFormCerrado' => $this->Content->getDescripcionBolsonesFormCerrado(),
            'descripcionTienda' => $this->Content->getDescripcionTienda(),
            'descripcionTiendaFormCerrado' => $this->Content->getDescripcionTiendaFormCerrado(),
            'confirmationLabel' => $this->Content->getConfirmationLabel(),
            'orderSuccess'      => $this->Content->get('order_success'),
            'formDisabledText'  => $this->Content->get('form_disabled_text'),
            'mainText'          => $this->Content->get('main_text'),
            'success'           => false,
            'failed'            => false,
            'submited'          => false
        ];

        if($this->input->post('subm')) {
            $renderParams['submited'] = true;

            $formTitle                      = $this->input->post('form_title', true);
            $formText                       = $this->input->post('form_text', true);
            $descripcionBolson              = $this->input->post('descripcionBolson', true);
            $descripcionBolsonesFormCerrado = $this->input->post('descripcionBolsonesFormCerrado', true);
            $descripcionTienda              = $this->input->post('descripcionTienda', true);
            $descripcionTiendaFormCerrado   = $this->input->post('descripcionTiendaFormCerrado', true);
            $confirmationLabel              = $this->input->post('confirmation_label', true);
            $orderSuccess                   = $this->input->post('order_success', true);
            $formDisabledText               = $this->input->post('form_disabled_text', true);
            $mainText                       = $this->input->post('main_text', true);

            // Seteo
            $this->Content->set('form_title', $formTitle);
            $this->Content->set('order_success', $orderSuccess);
            $this->Content->set('form_disabled_text', $formDisabledText);
            $this->Content->set('main_text', $mainText);
            $this->Content->set('descripcionBolson', $descripcionBolson);
            $this->Content->set('descripcionBolsonesFormCerrado', $descripcionBolsonesFormCerrado);
            $this->Content->set('descripcionTienda', $descripcionTienda);
            $this->Content->set('descripcionTiendaFormCerrado', $descripcionTiendaFormCerrado);

            if($this->Content->setConfirmationAndText($confirmationLabel, $formText)) {
                $renderParams['success']           = true;
                $renderParams['formText']          = $formText;
                $renderParams['descripcionBolson'] = $descripcionBolson;
                $renderParams['descripcionBolsonesFormCerrado'] = $descripcionBolsonesFormCerrado;
                $renderParams['descripcionTienda'] = $descripcionTienda;
                $renderParams['descripcionTiendaFormCerrado'] = $descripcionTiendaFormCerrado;
                $renderParams['confirmationLabel'] = $confirmationLabel;
                $renderParams['orderSuccess']      = $orderSuccess;
                $renderParams['formDisabledText']  = $formDisabledText;
                $renderParams['mainText']          = $mainText;
            }else{
                $renderParams['failed'] = true;
            }
        }

        $this->renderFormTexts($renderParams);
    }

    public function renderFormTexts($params)
    {
        $params['csrf_name'] = $this->security->get_csrf_token_name();
        $params['csrf_hash'] = $this->security->get_csrf_hash();
        $this->renderHead('Texto del formulario');
        $this->load->view('dashboard/formtexts', $params);
        $this->load->view('dashboard/footer');
    }

    public function offices() 
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Office');
        $this->renderHead('Sucursales');
        $this->load->view('dashboard/offices', ['offices'  => $this->Office->getAll()]);
        $this->load->view('dashboard/footer');
    }

    public function barrios()
    {
        if (!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Barrio');
        $this->renderHead('Zonas de entrega');
        $this->load->view('dashboard/barrios', ['barrios' => $this->Barrio->getAll()]);
        $this->load->view('dashboard/footer');
    }

    public function pockets() 
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Pocket');
        $this->renderHead('Bolsones');
        $this->load->view('dashboard/pockets', ['pockets' => $this->Pocket->getAll()]);
        $this->load->view('dashboard/footer');
    }

    public function extras()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Extra');
        $this->renderHead('Productos extras');
        $this->load->view('dashboard/extras', ['extras' => $this->Extra->getAll()]);
        $this->load->view('dashboard/footer');
    }

    public function ordersSucursal()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Order');
        $this->renderHead('Pedidos');
        $this->load->view('dashboard/orders', ['orders' => $this->Order->buildFullOrdersTable('sucursal')]);
        $this->load->view('dashboard/footer');
    }

    public function ordersDelivery()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Order');
        $this->renderHead('Pedidos');
        $this->load->view('dashboard/orders', ['orders' => $this->Order->buildFullOrdersTable('delivery')]);
        $this->load->view('dashboard/footer');
    }

    public function altaPedidos()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('TiposPedidos');
        $this->load->model('Barrio');
        $this->load->model('Office');
        $this->load->model('Pocket');
        $this->load->model('EstadosPedidos');
        $this->load->model('Content');
        $this->load->model('DiasEntregaPedidos');
        $this->load->model('Cupones');
        $this->renderHead('EBO - Alta de Pedidos');
        $this->load->view('dashboard/altaPedidos',[
            'cTiposPedidos' => $this->TiposPedidos->getAll(),
            'cBarrios' => $this->Barrio->getAll(),
            'cSucursales'  => $this->Office->getAllOrderesByNameASC(),
            'cBolsones' => $this->Pocket->getAll(),
            'cEstadosPedidos' => $this->EstadosPedidos->getAll(),
            'diaBolson' => $this->DiasEntregaPedidos->getLastDay(),
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos(),
            'costoEnvioPedidos' => $this->Content->get("costoEnvioPedidos"),
            'cCupones' => $this->Cupones->getAllActivos()
            ]
        );
        $this->load->view('dashboard/footer');
    }

    public function listadoPedidos()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('TiposPedidos');
        $this->load->model('EstadosPedidos');
        $this->load->model('Content');
        $this->load->model('DiasEntregaPedidos');
        $this->renderHead('EBO - Listado de Pedidos');
        $this->load->view('dashboard/listadoPedidos',[
            'cTiposPedidos' => $this->TiposPedidos->getAll(),
            'diaBolson' => $this->Content->get("confirmation_label"),
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos(),]
        );
        $this->load->view('dashboard/footer');
    }

    public function volverListadoPedidos(){
        if(!valid_session()) {
            redirect('/logout');
        }

        $accion = $this->input->post('accion', true);
        $consultaFechaDesde = $this->input->post('consultaFechaDesde', true);
        $consultaFechaHasta = $this->input->post('consultaFechaHasta', true);
        $consultaIncluirCancelados = $this->input->post('consultaIncluirCancelados', true);
        $consultaSoloNoValidos = $this->input->post('consultaSoloNoValidos', true);
        $consultaIdDiaEntrega = $this->input->post('consultaIdDiaEntrega', true);
        $consultaNombre = $this->input->post('consultaNombre', true);
        $consultaMail = $this->input->post('consultaMail', true);
        $consultaNroPedido = $this->input->post('consultaNroPedido', true);
        if($accion=="editar"){

        }
        $this->load->model('Order');
        $incluirCancelados = 1;
        if($consultaIncluirCancelados=="false"){
            $incluirCancelados = 0;
        }
        $soloNoValidos = 1;
        if($consultaSoloNoValidos=="false"){
            $soloNoValidos = 0;
        }
        $cPedidos = $this->Order->getOrdersFromConsultaPedidos($consultaIdDiaEntrega,$incluirCancelados,$consultaFechaDesde,$consultaFechaHasta,$consultaNombre,$consultaMail,$consultaNroPedido,$soloNoValidos);
        $this->load->model('TiposPedidos');
        $this->load->model('EstadosPedidos');
        $this->load->model('DiasEntregaPedidos');

        $this->renderHead('EBO - Listado de Pedidos');
        $this->load->view('dashboard/listadoPedidos',[
            'cPedidos' => $cPedidos,
            'cTiposPedidos' => $this->TiposPedidos->getAll(),
            'diaBolson' => $this->Content->get("confirmation_label"),
            'consultaFechaDesde' => $consultaFechaDesde,
            'consultaFechaHasta' => $consultaFechaHasta,
            'consultaIdDiaEntrega' => $consultaIdDiaEntrega,
            'consultaIncluirCancelados' => $consultaIncluirCancelados,
            'consultaSoloNoValidos' => $consultaSoloNoValidos,
            'consultaNombre' => $consultaNombre,
            'consultaMail' => $consultaMail,
            'consultaNroPedido' => $consultaNroPedido,
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos()
            ]
        );
        $this->load->view('dashboard/footer');
    }

    public function goToCamionesPreConfigurados(){
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('CamionesPreConfigurados');
        
        $this->renderHead('EBO - Camiones Pre Configurados');
        $this->load->view('dashboard/camionesPreConfigurados',
            [
            'cCamionesPreConfigurados' => $this->CamionesPreConfigurados->getAll()
            ]
        );
        $this->load->view('dashboard/footer');
    }

    public function goToEditarPedido(){
        if(!valid_session()) {
            redirect('/logout');
        }
        $idPedido = $this->input->post('idPedido', true);
        $consultaFechaDesde = $this->input->post('consultaFechaDesde', true);
        $consultaFechaHasta = $this->input->post('consultaFechaHasta', true);
        $consultaIncluirCancelados = $this->input->post('consultaIncluirCancelados', true);
        $consultaSoloNoValidos = $this->input->post('consultaSoloNoValidos', true);
        $consultaIdDiaEntrega = $this->input->post('consultaIdDiaEntrega', true);
        $consultaNombre = $this->input->post('consultaNombre', true);
        $consultaMail = $this->input->post('consultaMail', true);
        $consultaNroPedido = $this->input->post('consultaNroPedido', true);

        $this->load->model('Order');
        $this->load->model('Pocket');
        $this->load->model('TiposPedidos');
        $this->load->model('Barrio');
        $this->load->model('Office');
        $this->load->model('EstadosPedidos');
        $this->load->model('Cupones');
        $this->load->model('Content');
        $this->load->model('DiasEntregaPedidos');

        $pedido = $this->Order->getById($idPedido);

        $bolson = null;
        $costoEnvio = 0;
        $tieneBolson = 0;
        if(isset($pedido->pocket_id) && $pedido->pocket_id>0){
            $bolson = $this->Pocket->getById($pedido->pocket_id);
            $tieneBolson = 1;
        }
        if(isset($pedido->id_tipo_pedido) && $pedido->id_tipo_pedido == 2){
            //SI ES DOMICILIO
            $barrio = $this->Barrio->getById($pedido->barrio_id);
            $costoEnvio = $barrio->costo_envio;
        }
        
        $this->renderHead('EBO - Editar Pedidos');
        $this->load->view('dashboard/editarPedido',[
            'pedido' => $pedido,
            'cExtras' => $this->Order->getExtras($idPedido),
            'cTiposPedidos' => $this->TiposPedidos->getAll(),
            'cBarrios' => $this->Barrio->getAll(),
            'cSucursales'  => $this->Office->getAllOrderesByNameASC(),
            'cBolsones' => $this->Pocket->getAll(),
            'cEstadosPedidos' => $this->EstadosPedidos->getAll(),
            'consultaFechaDesde' => $consultaFechaDesde,
            'consultaFechaHasta' => $consultaFechaHasta,
            'consultaIncluirCancelados' => $consultaIncluirCancelados,
            'consultaSoloNoValidos' => $consultaSoloNoValidos,
            'consultaIdDiaEntrega' => $consultaIdDiaEntrega,
            'consultaNombre' => $consultaNombre,
            'consultaMail' => $consultaMail,
            'consultaNroPedido' => $consultaNroPedido,
            'costoEnvio' => $costoEnvio,
            'precioBolson' => $bolson->price ?? null,
            'precioDeliveryBolson' =>$bolson->delivery_price ?? null,
            'montoTotalExtras' => $this->Order->getMontoTotalExtrasSumadosByPedido($idPedido),
            'diaBolson' => $this->Content->get("confirmation_label"),
            'tieneBolson' => $tieneBolson,
            'cCupones' => $this->Cupones->getAllActivos(),
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos()]
        );
        $this->load->view('dashboard/footer');
    }    

    public function goToLogistica(){
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('DiasEntregaPedidos');
        
        $this->renderHead('EBO - Logística');
        $this->load->view('dashboard/logistica',
            [
            'cDiasEntrega' => $this->DiasEntregaPedidos->getAllActivos()
            ]
        );
        $this->load->view('dashboard/footer');
    }

    public function preciosPedidosExtras()
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Content');
        $costoEnvioPedidos = $this->Content->get("costoEnvioPedidos");
        $montoMinimoPedidoExtras = $this->Content->get("montoMinimoPedidosExtras");
        $costoEnvioPedidoExtras = $this->Content->get("costoEnvioPedidosExtras");
        $montoMinimoEnvioSinCargoPedidoExtras = $this->Content->get("montoMinimoPedidosExtrasEnvioSinCargo");
        $pedidoExtrasPuntoDeRetiroHabilitado = $this->Content->get("pedidoExtrasPuntoDeRetiroHabilitado");
        $pedidoExtrasDomicilioHabilitado = $this->Content->get("pedidoExtrasDomicilioHabilitado");

        /*Valores de señas para los pedidos. Se cobran por MP.
        */
        $valorReservaRango1 = $this->Content->get("valorReservaRango1");
        $valorReservaRango2 = $this->Content->get("valorReservaRango2");
        $valorReservaRango3 = $this->Content->get("valorReservaRango3");

        $this->renderHead('Precios Pedidos de Extras');
        $this->load->view('dashboard/preciosPedidosExtras', 
            ['costoEnvioPedidos' => $costoEnvioPedidos,
             'montoMinimoPedidoExtras' => $montoMinimoPedidoExtras,
             'costoEnvioPedidoExtras' => $costoEnvioPedidoExtras,
             'montoMinimoEnvioSinCargoPedidoExtras' => $montoMinimoEnvioSinCargoPedidoExtras,
             'pedidoExtrasPuntoDeRetiroHabilitado' => $pedidoExtrasPuntoDeRetiroHabilitado,
             'pedidoExtrasDomicilioHabilitado' => $pedidoExtrasDomicilioHabilitado,
             'valorReservaRango1' => $valorReservaRango1,
             'valorReservaRango2' => $valorReservaRango2,
             'valorReservaRango3' => $valorReservaRango3
            ]
        );
        $this->load->view('dashboard/footer');
    }

    public function getCostoEnvioPedidosExtras(){
        $this->output->set_content_type('application/json');

        $this->load->model('Content');
        $costoEnvioPedidoExtras = (float)$this->Content->get("costoEnvioPedidosExtras");

        $return['costoEnvioPedidoExtras'] = $costoEnvioPedidoExtras;
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));           
    }

    public function getCostoEnvioPedidos(){
        $this->output->set_content_type('application/json');

        $this->load->model('Content');
        $costoEnvioPedidos = (float)$this->Content->get("costoEnvioPedidos");

        $return['costoEnvioPedidos'] = $costoEnvioPedidos;
        $this->output->set_status_header(200);

        return $this->output->set_output(json_encode($return));           
    }

    public function newsletter() 
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Content');
        $this->load->model('NewsletterAdjuntos');

        $this->renderHead('Newsletter');
        $this->load->view('dashboard/newsletter', [
            'newsletterEnabled'  => $this->Content->getNewsletterEnabled(),
            'recetarioStatus' => $this->Content->getRecetarioStatus(),
            'cNewsletterAdjuntos' => $this->NewsletterAdjuntos->getAll()
        ]);
        $this->load->view('dashboard/footer');
    }

    public function cupones() 
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('Cupones');
        $this->load->model('TiposDescuento');

        $this->renderHead('Cupones');
        $this->load->view('dashboard/cupones', [
            'moduloCuponesEnabled'  => $this->Content->getModuloCuponesEnabled(),
            'cupones'  => $this->Cupones->getAll(),
            'tiposDescuento'  => $this->TiposDescuento->getAll(),
        ]);
        $this->load->view('dashboard/footer');
    }

    public function diasEntrega() 
    {
        if(!valid_session()) {
            redirect('/logout');
        }
        $this->load->model('DiasEntregaPedidos');

        $this->renderHead('Días de Entrega');
        $this->load->view('dashboard/diasEntrega', []);
        $this->load->view('dashboard/footer');
    }

}    
