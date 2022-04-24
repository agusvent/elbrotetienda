<?php

class Order extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAll($applyFilter = false, $filterType = 'SUC')
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash');
        $this->db->from('orders');
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('valid', 1);

        if ($applyFilter) {
            $this->db->where('deliver_type', $filterType);
        }
    
        return $this->db->get()->result();
    }

    public function getExtras($orderId) 
    {
        $this->load->model('Extra');
        $this->db->select('extra_id');
        $this->db->from('orders_extras');
        $this->db->where('order_id', $orderId);
        $orderExtras = $this->db->get()->result();
        $toReturn = [];
        foreach($orderExtras as $orderExtra) {
            $extra = $this->Extra->getById($orderExtra->extra_id);
            array_push($toReturn, $extra);
        }
        return $toReturn;
    }

    public function getExtrasWithCantidad($orderId) 
    {
        $this->load->model('Extra');
        $this->db->select('oe.extra_id, oe.cant, oe.total, extra.name, extra.nombre_corto, extra.price');
        $this->db->from('orders_extras as oe');
        $this->db->join('extra_products as extra', 'oe.extra_id = extra.id', 'left');
        $this->db->where('order_id', $orderId);
        $orderExtras = $this->db->get()->result();
        return $orderExtras;
    }

    public function getCantOrderExtraByPedidoAndExtra($orderId, $extraId) 
    {
        $this->db->select('cant');
        $this->db->from('orders_extras');
        $this->db->where('order_id', $orderId);
        $this->db->where('extra_id', $extraId);
        $cantExtra = $this->db->get()->result();
        return $cantExtra;
    }

    public function getCantExtraByPedidoAndExtra($orderId, $extraId) 
    {
        $this->db->select('cant');
        $this->db->from('orders_extras');
        $this->db->where('order_id', $orderId);
        $this->db->where('extra_id', $extraId);
        $cantExtra = $this->db->get()->result()[0]->cant;
        return $cantExtra;
    }

    public function getMontoTotalExtrasSumadosByPedido($idPedido) 
    {
        $montoTotal = 0;
        
        $this->load->model('Extra');
        $this->db->select('extra_id');
        $this->db->from('orders_extras');
        $this->db->where('order_id', $idPedido);
        $orderExtras = $this->db->get()->result();
        
        foreach($orderExtras as $orderExtra) {
            $extra = $this->Extra->getById($orderExtra->extra_id);
            $montoTotal = $montoTotal + $extra->price;
        }
        return $montoTotal;
    }

    public function getTotalBolsonesByDiaBolson($diaBolson){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO DE BOLSONES
        $this->db->select('orders.id, bolson.id as id_bolson');
        $this->db->from('orders');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "deliver_date = '$diaBolson' AND deliver_type = 'SUC'";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        $contBolsones = $this->generateGetTotalBolsonesResponse($orders);

        return $contBolsones;
    }

    public function getTotalBolsonesBetweenDates($fechaDesde,$fechaHasta){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO DE BOLSONES
        $this->db->select('orders.id, bolson.id as id_bolson');
        $this->db->from('orders');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND deliver_type = 'SUC'";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        $contBolsones = $this->generateGetTotalBolsonesResponse($orders);

        return $contBolsones;
    }

    public function getTotalExtrasBySucursalBetweenDatesByExtra($fechaDesde,$fechaHasta,$idSucursal,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR EXTRA POR SUCURSAL
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.office_id  = $idSucursal AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.deliver_type = 'SUC'  AND orders.id_estado_pedido not in (4) AND orders.valid = 1) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();        
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalExtrasBySucursalByDiaBolsonByExtra($diaBolson,$idSucursal,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR EXTRA POR SUCURSAL
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.deliver_date = '$diaBolson' AND orders.office_id = $idSucursal AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4) and orders.valid = 1) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalExtraByDiaBolsonByExtra($idDiaEntrega,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR EXTRA POR DIA BOLSON
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = $idDiaEntrega AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4) and orders.valid = 1) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalExtraBetweenDatesByExtra($fechaDesde,$fechaHasta,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR EXTRA ENTRE FECHAS
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4)) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalOrdersBySucursalBetweenDates($fechaDesde,$fechaHasta,$idSucursal){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR SUCURSAL
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "sucursal.id = $idSucursal AND deliver_type = 'SUC' AND created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59'";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalOrdersResponse($orders);
        }

        return $contBolsones;
    }

    public function getTotalOrdersBySucursalByDiaBolson($diaBolson,$idSucursal){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR SUCURSAL
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "deliver_date = '$diaBolson' AND sucursal.id = $idSucursal AND deliver_type = 'SUC'";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalOrdersResponse($orders);
        }

        return $contBolsones;
    }

    public function generateGetTotalBolsonesResponse($orders){
        $contBolsones = 0;
        foreach ($orders as $order){
            if(isset($order->cant_bolson) && $order->cant_bolson > 0) {
                $contBolsones = $contBolsones + $order->cant_bolson;
            }
            /*$this->load->model('Pocket');
            if(isset($order->id_bolson) && (int)$order->id_bolson>0){
                $bolsonDeLaOrden = $this->Pocket->getById($order->id_bolson);
                $contBolsones = $contBolsones + $bolsonDeLaOrden->cant;
            }*/
        }
        return $contBolsones;
    }    

    public function generateGetTotalOrdersResponse($orders){
        $contBolsones = 0;
        foreach ($orders as $order){
            if(isset($order->cant_bolson) && $order->cant_bolson > 0) {
                $contBolsones = $contBolsones + $order->cant_bolson;
            }
            
            /*$this->load->model('Pocket');
            if(isset($order->id_bolson) && (int)$order->id_bolson>0){
                $bolsonDeLaOrden = $this->Pocket->getById($order->id_bolson);
            
                $contBolsones = $contBolsones + $bolsonDeLaOrden->cant;
            }*/
        }
        return $contBolsones;
    }    

    public function generateGetTotalExtrasResponse($extras){
        $contExtras = 0;
        $cantExtra = 1;
        foreach ($extras as $extra){
            if($extra->cant > 0){
                $cantExtra = $extra->cant;
            }
            $contExtras = $contExtras + $cantExtra;
        }
        return $contExtras;
    }    

    public function generateOrdersArray($orders){
        $toAppend = [];
        foreach ($orders as $order){

            $orderExtras = $this->getExtrasWithCantidad($order->id);
            $extrasArray = [];
            $cant_bolsones_individuales = "-";
            foreach($orderExtras as $extra) {
                array_push($extrasArray,array(
                    'id_extra' => $extra->extra_id,
                    'name' => $extra->name,
                    'nombre_corto' => $extra->nombre_corto,
                    'extra_price' =>  $extra->price
                ));
                if($extra->extra_id == 1) {
                    //SI ES EL BOLSON INDIVIDUAL
                    $cant_bolsones_individuales = $extra->cant;
                }
            }
            $idEstadoPedido = 0;
            if(isset($order->id_estado_pedido)){
                $idEstadoPedido = $order->id_estado_pedido;
            }
            $montoDebe = 0;
            $montoDebe = round(intval($order->monto_total) - intval($order->monto_pagado),0);
            
            array_push($toAppend, array(
                'order_id' => $order->id,
                'cliente' => $order->client_name,
                'mail' => $order->email,
                'celular' => $order->phone,
                'id_sucursal' => $order->id_sucursal,
                'sucursal' => $order->sucursal,
                'domicilio_sucursal' => $order->domicilio_sucursal,
                'nombre_bolson' => $order->nombre_bolson,
                //$order->precio_bolson sale de la tabla pockets, esta asi en la consulta. lo cambio por el nuevo total, que si sale de la tabla orders
                //'precio_bolson' => $order->precio_bolson,
                'total_bolson' => $order->total_bolson,
                'cant_bolson' => $order->cant_bolson,
                'cant_bolsones_individuales' => $cant_bolsones_individuales,
                'fecha_entrega' => $order->deliver_date,
                'fecha_creacion' => $order->created_at,
                'observaciones' => $order->observaciones,
                'monto_total' => $order->monto_total,
                'monto_pagado' => round($order->monto_pagado,0),
                'monto_debe' => $montoDebe,
                'id_estado_pedido' => $idEstadoPedido,
                'extras' => $extrasArray,
                'nro_orden' => $order->nro_orden,
                'id_cupon' => $order->id_cupon,
                'monto_descuento' => $order->monto_descuento,
                'id_tipo_pedido' => $order->id_tipo_pedido,
                'cant_items' => isset($order->cantItems) ? $order->cantItems : 0
            ));
                                        
        }
        return $toAppend;
    }

    public function generateOrdersDeliveryArray($orders){
        $toAppend = [];
        foreach ($orders as $order){
            $cant_bolsones_individuales = "-";
            $orderExtras = $this->getExtrasWithCantidad($order->id);
                $extrasArray = [];
                foreach($orderExtras as $extra) {
                    array_push($extrasArray,array(
                       'id_extra' => $extra->extra_id,
                       'name' => $extra->name,
                       'nombre_corto' => $extra->nombre_corto,
                       'extra_price' =>  $extra->price
                    ));
                    if($extra->extra_id == 1) {
                        //SI ES EL BOLSON INDIVIDUAL
                        $cant_bolsones_individuales = $extra->cant;
                    }    
                }

            $montoDebe = 0;
            $montoDebe = round(intval($order->monto_total) - intval($order->monto_pagado),0);
    
            array_push($toAppend, array(
                'order_id' => $order->id,
                'cliente' => $order->client_name,
                'mail' => $order->email,
                'celular' => $order->phone,
                'id_barrio' => $order->id_barrio,
                'barrio' => $order->nombre_barrio,
                'barrio_observaciones' => $order->barrio_observaciones,
                'costo_envio' => $order->costo_envio,
                'nombre_bolson' => $order->nombre_bolson,
                'total_bolson' => $order->total_bolson,
                'cant_bolson' => $order->cant_bolson,
                'cant_bolsones_individuales' => $cant_bolsones_individuales,
                'fecha_entrega' => $order->deliver_date,
                'cliente_domicilio' => $order->cliente_domicilio,
                'cliente_domicilio_extra' => $order->cliente_domicilio_extra,
                'cliente_domicilio_full' => $order->cliente_domicilio." ".$order->cliente_domicilio_extra,
                'fecha_creacion' => $order->created_at,
                'observaciones' => $order->observaciones,
                'monto_total' => $order->monto_total,
                'monto_pagado' => round($order->monto_pagado,0),
                'monto_debe' => $montoDebe,
                'id_estado_pedido' => $order->id_estado_pedido,
                'extras' => $extrasArray,
                'nro_orden' => $order->nro_orden,
                'id_cupon' => $order->id_cupon,
                'monto_descuento' => $order->monto_descuento,
                'id_tipo_pedido' => $order->id_tipo_pedido,
                'cant_items' => isset($order->cantItems) ? $order->cantItems : 0
            ));
        }
        return $toAppend;
    }

    public function getOrdersSucursalWithExtrasBetweenDates($fechaDesde,$fechaHasta){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL
        //$this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as cantidad_bolsones, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden');
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //$where = "deliver_type = 'SUC' AND created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59'";
        //Excluyo los pedidos en estado CANCELADO
        $where = "deliver_type = 'SUC' AND valid = 1 AND created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $this->db->order_by('sucursal ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();
        
        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersArray($orders);
        }
        return $toAppend;

    }

    public function getOrdersSucursalWithExtrasByDiaDeBolson($diaBolson){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL
        //$this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as cantidad_bolsones, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //$where = "deliver_type = 'SUC' AND deliver_date = '$diaBolson'";    
        //Excluyo los pedidos en estado CANCELADO
        $where = "deliver_type = 'SUC' AND valid = 1 AND deliver_date = '$diaBolson' AND id_estado_pedido not in (4)";    
        
        $this->db->where($where);
        $this->db->order_by('sucursal ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersArray($orders);
        }
        return $toAppend;

    }

    public function getOrdersADomicilioWithExtrasByDiaDeBolson($diaBolson){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS A DOMICILIO
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, barrio.id as id_barrio, barrio.nombre as nombre_barrio, barrio.observaciones as barrio_observaciones, barrio.costo_envio, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //$where = "deliver_type = 'DEL' AND valid = 1 AND deliver_date = '$diaBolson'";
        //Excluyo los pedidos en estado CANCELADO
        $where = "deliver_type = 'DEL' AND valid = 1 AND deliver_date = '$diaBolson' AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $this->db->order_by('nombre_barrio ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersDeliveryArray($orders);
        }
        return $toAppend;

    }

    public function getOrdersADomicilioWithExtrasBetweenDates($fechaDesde,$fechaHasta){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS A DOMICILIO
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, barrio.id as id_barrio, barrio.nombre as nombre_barrio, barrio.observaciones as barrio_observaciones, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //Excluyo los pedidos en estado CANCELADO
        $where = "orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $this->db->order_by('nombre_barrio ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();
        
        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersDeliveryArray($orders);
        }
        return $toAppend;

    }

    public function getTotalOrdersADomicilioByBarrioByDiaBolson($diaBolson,$idBarrio){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO A
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, barrio.id as id_barrio, barrio.nombre as nombre_barrio, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "deliver_date = '$diaBolson' AND barrio.id = $idBarrio AND deliver_type = 'DEL' AND valid = 1 AND id_estado_pedido not in (4)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalOrdersResponse($orders);
        }
        return $contBolsones;
    }

    public function getTotalOrdersADomicilioByBarrioBetweenDates($fechaDesde,$fechaHasta,$idBarrio){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO POR SUCURSAL
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, barrio.id as id_barrio, barrio.nombre as nombre_barrio, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "barrio.id = $idBarrio AND deliver_type = 'DEL' AND valid = 1 AND created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND id_estado_pedido not in (4)";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalOrdersResponse($orders);
        }
        return $contBolsones;
    }

    public function getTotalExtrasByBarrioBetweenDatesByExtra($fechaDesde,$fechaHasta,$idBarrio,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL
        //ME DA EL TOTALIZADO POR EXTRA POR BARRIO ENTRE FECHAS
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.barrio_id  = $idBarrio AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.deliver_type = 'DEL' AND orders.valid = 1  AND orders.id_estado_pedido not in (4) ) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalExtrasByBarrioByDiaBolsonByExtra($diaBolson,$idBarrio,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL
        //ME DA EL TOTALIZADO POR EXTRA POR BARRIO POR DIA BOLSON
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.deliver_date = '$diaBolson' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_estado_pedido not in (4)) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
            
        }
        return $contExtra;
    }

    public function getTotalBolsonesADomicilioByDiaBolson($diaBolson){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL
        //ME DA EL TOTALIZADO DE BOLSONES A DOMICILIO POR DIA BOLSON
        $this->db->select('orders.id, bolson.id as id_bolson, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "deliver_date = '$diaBolson' AND deliver_type = 'DEL' AND valid = 1 AND id_estado_pedido not in (4)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }

        return $contBolsones;
    }

    public function getTotalBolsonesADomicilioBetweenDates($fechaDesde,$fechaHasta){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL. 
        //ME DA EL TOTALIZADO DE BOLSONES A DOMICILIO ENTRE FECHAS
        $this->db->select('orders.id, bolson.id as id_bolson, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND deliver_type = 'DEL' AND valid = 1 AND id_estado_pedido not in (4)";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }
        return $contBolsones;
    }

    public function getTotalExtraADomicilioByDiaBolsonByExtra($idDiaEntrega,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL
        //ME DA EL TOTALIZADO POR EXTRA POR DIA BOLSON A DOMICILIO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = $idDiaEntrega AND orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_estado_pedido not in (4)) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalExtraADomicilioBetweenDatesByExtra($fechaDesde,$fechaHasta,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL
        //ME DA EL TOTALIZADO POR EXTRA ENTRE FECHAS A DOMICILIO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_estado_pedido not in (4)) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }



    //Para infoPedidosBox

    public function getTotalPedidosConBolsonesFamiliaresByDiaBolsonForSucursal($idDiaEntrega, $tipoBolson=1){
        $this->db->select('orders.id, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "deliver_type = 'SUC' AND valid = 1 AND id_dia_entrega = $idDiaEntrega AND pocket_id = $tipoBolson AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        return $orders;

    }

    public function getTotalPedidosConBolsonesFamiliaresByDiaBolsonForDomicilio($idDiaEntrega, $tipoBolson=1){
        $this->db->select('orders.id, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "deliver_type = 'DEL' AND valid = 1 AND id_dia_entrega = '$idDiaEntrega' AND pocket_id = $tipoBolson AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        return $orders;

    }

    public function getTotalOrdersByDiaBolsonAndTipoBolsonForSucursal($diaBolson, $tipoBolson){
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "deliver_type = 'SUC' AND deliver_date = '$diaBolson' AND pocket_id = $tipoBolson AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        return count($orders);

    }

    public function getTotalOrdersByDiaBolsonAndTipoBolsonForDomicilio($diaBolson, $tipoBolson){
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "deliver_type = 'DEL' AND valid = 1 AND deliver_date = '$diaBolson' AND pocket_id = $tipoBolson AND id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        $cont = 0;
        if(!empty($orders)){
            $cont = count($orders);
        }
        return $cont;
    }

    public function getTotalOrdersByFechaDesdeHastaAndTipoBolsonForSucursal($fechaDesde,$fechaHasta, $tipoBolson){
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "deliver_type = 'SUC' AND pocket_id = $tipoBolson AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        $cont = 0;
        if(!empty($orders)){
            $cont = count($orders);
        }
        return $cont;
    }

    public function getTotalPedidosConBolsonByFechaDesdeHastaForSucursal($fechaDesde,$fechaHasta, $tipoBolson = 1){
        $this->db->select('orders.id, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "deliver_type = 'SUC' AND pocket_id = $tipoBolson AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        return $orders;
    }

    public function getTotalOrdersByFechaDesdeHastaAndTipoBolsonForDomicilio($fechaDesde,$fechaHasta, $tipoBolson){
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "deliver_type = 'DEL' AND valid = 1 AND pocket_id = $tipoBolson AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        $cont = 0;
        if(!empty($orders)){
            $cont = count($orders);
        }
        return $cont;
    }

    public function getTotalPedidosConBolsonByFechaDesdeHastaForDomicilio($fechaDesde,$fechaHasta, $tipoBolson = 1){
        $this->db->select('orders.id, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "deliver_type = 'DEL' AND valid = 1 AND pocket_id = $tipoBolson AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();
        return $orders;
    }

    public function getTotalExtrasByFechaDesdeHastaAndTipoBolsonForSucursal($fechaDesde,$fechaHasta, $tipoExtra){
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "deliver_type = 'SUC' AND pocket_id = $tipoBolson AND orders.created_at >= '$fechaDesde 00:00:00' AND orders.created_at <= '$fechaHasta 23:59:59' AND orders.id_estado_pedido not in (4)";
        $this->db->where($where);
        $orders = $this->db->get()->result();

        $cont = 0;
        if(!empty($orders)){
            $cont = count($orders);
        }
        return $cont;

    }

    public function getByOffice($officeId, $applyCurrentDate = false)
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash');
        $this->db->from('orders');
        $this->db->where('office_id', $officeId);
        $this->db->where('deliver_type', 'SUC');
        
        if($applyCurrentDate == true) {
            if(isset($_SESSION['dataFrom'])) {
                $this->db->where('created_at >= ', $_SESSION['dataFrom']);
            }else{
                $this->db->where('created_at >= ', date('Y-m-d'));
            }
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function getByBarrio($barrioId, $applyCurrentDate = false)
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash');
        $this->db->from('orders');
        $this->db->where('barrio_id', $barrioId);
        $this->db->where('deliver_type', 'DEL');
        $this->db->where('valid', 1);
        
        if($applyCurrentDate == true) {
            if(isset($_SESSION['dataFrom'])) {
                $this->db->where('created_at >= ', $_SESSION['dataFrom']);
            }else{
                $this->db->where('created_at >= ', date('Y-m-d'));
            }
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function buildOfficeOrdersTable($officeId)
    {
        // Las columnas que me sé por defecto
        $columns = [
            'Fecha',
            'Nombre',
            'Mail',
            'Celular',
            'Cantidad de Bolsones'
        ];
        // Agrego columna por cada item extra activo en el sistema
        $this->load->model('Extra');
        $activeExtras = $this->Extra->getActive();
        foreach($activeExtras as $extra) {
            array_push($columns, $extra->name);
        }

        $rows = [];
        $this->load->model('Office');
        $this->load->model('Pocket');

        foreach($this->getByOffice($officeId, true) as $order) {
            $office = $this->Office->getById($order->office_id);
            $pocket = $this->Pocket->getById($order->pocket_id);
            $toAppend = [];
            array_push($toAppend, date('d/m/Y', strtotime($order->created_at)));
            array_push($toAppend, $order->client_name);
            array_push($toAppend, $order->email);
            array_push($toAppend, $order->phone);
            array_push($toAppend, $pocket->name);

            // Me traigo los extras de la orden
            $orderExtras = $this->getExtras($order->id);

            foreach($activeExtras as $extra) {
                // Busco el extra de la orden
                $__extra = null;
                foreach($orderExtras as $_extra) {
                    if($_extra->id == $extra->id) {
                        $__extra = $_extra;
                    }
                }
                if(!is_null($__extra)) {
                    array_push($toAppend, $__extra->price);
                }else{
                    array_push($toAppend, "");
                }
            }
            array_push($rows, $toAppend);
        }
        return [
            'columns' => $columns,
            'rows'    => $rows
        ];
    }

    public function buildFullOrdersTable($deliver_type)
    {
        switch ($deliver_type) {
            case 'sucursal':
            return $this->fullOrdersSucursal();

            case 'delivery':
            return $this->fullOrdersDelivery();
        }
    }

    public function fullOrdersDelivery()
    {
        // Las columnas que me sé por defecto
        $columns = [
            'Fecha',
            'Nombre',
            'Mail',
            'Celular',
            'Barrio',
            'Fecha confirmada',
            'Cantidad de Bolsones',
            'Dirección'
        ];
        // Agrego columna por cada item extra activo en el sistema
        $this->load->model('Extra');
        $activeExtras = $this->Extra->getActive();
        foreach($activeExtras as $extra) {
            array_push($columns, $extra->name);
        }

        $rows = [];
        $this->load->model('Barrio');
        $this->load->model('Pocket');

        foreach($this->getAll(true, 'DEL') as $order) {
            $barrio = $this->Barrio->getById($order->barrio_id);
            $pocket = $this->Pocket->getById($order->pocket_id);
            $toAppend = [];
            array_push($toAppend, date('d/m/Y', strtotime($order->created_at)));
            array_push($toAppend, $order->client_name);
            array_push($toAppend, $order->email);
            array_push($toAppend, $order->phone);
            array_push($toAppend, $barrio->nombre);
            array_push($toAppend, $order->deliver_date);
            array_push($toAppend, $pocket->name);
            array_push($toAppend, $order->deliver_address . ' ' . $order->deliver_extra);

            // Me traigo los extras de la orden
            $orderExtras = $this->getExtras($order->id);

            foreach($activeExtras as $extra) {
                // Busco el extra de la orden
                $__extra = null;
                foreach($orderExtras as $_extra) {
                    if($_extra->id == $extra->id) {
                        $__extra = $_extra;
                    }
                }
                if(!is_null($__extra)) {
                    array_push($toAppend, $__extra->price);
                }else{
                    array_push($toAppend, "");
                }
            }
            array_push($rows, $toAppend);
        }
        return [
            'columns' => $columns,
            'rows'    => $rows
        ];
    }

    public function fullOrdersSucursal()
    {
        // Las columnas que me sé por defecto
        $columns = [
            'Fecha',
            'Nombre',
            'Mail',
            'Celular',
            'Sucursal',
            'Fecha confirmada',
            'Cantidad de Bolsones'
        ];
        // Agrego columna por cada item extra activo en el sistema
        $this->load->model('Extra');
        $activeExtras = $this->Extra->getActive();
        foreach($activeExtras as $extra) {
            array_push($columns, $extra->name);
        }

        $rows = [];
        $this->load->model('Office');
        $this->load->model('Pocket');

        foreach($this->getAll(true, 'SUC') as $order) {
            $office = $this->Office->getById($order->office_id);
            $pocket = $this->Pocket->getById($order->pocket_id);
            $toAppend = [];
            array_push($toAppend, date('d/m/Y', strtotime($order->created_at)));
            array_push($toAppend, $order->client_name);
            array_push($toAppend, $order->email);
            array_push($toAppend, $order->phone);
            array_push($toAppend, $office->name);
            array_push($toAppend, $order->deliver_date);
            array_push($toAppend, $pocket->name);

            // Me traigo los extras de la orden
            $orderExtras = $this->getExtras($order->id);

            foreach($activeExtras as $extra) {
                // Busco el extra de la orden
                $__extra = null;
                foreach($orderExtras as $_extra) {
                    if($_extra->id == $extra->id) {
                        $__extra = $_extra;
                    }
                }
                if(!is_null($__extra)) {
                    array_push($toAppend, $__extra->price);
                }else{
                    array_push($toAppend, "");
                }
            }
            array_push($rows, $toAppend);
        }
        return [
            'columns' => $columns,
            'rows'    => $rows
        ];
    }

    public function getOrdersResume()
    {
        $toReturn = [
            'delivery' => [
                'pockets'   => null,
                'extras'    => null,
                'barrios'   => null
            ],
            'sucursal' => [
                'pockets'   => null,
                'extras'    => null,
                'offices'   => null
            ]
        ];

        /*********************************************
         * Calculo pedidos de tipo SUCURSAL (SUC).
         *********************************************/

        // Cantidad de tipos de bolsones
        $this->load->model('Pocket');
        $pockets = $this->Pocket->getAll();
        $ordersByPockets = [];
        foreach($pockets as $pocket) {
            $orders = $this->getByPocketId($pocket->id, 'SUC', true);
            $ordersByPockets[] = [
                'pocketName' => $pocket->name,
                'quantity'   => count($orders)
            ];
        }

        // Cantidad de cada producto extra
        $this->load->model('Extra');
        $extras = $this->Extra->getAll();
        $ordersByExtras = [];
        foreach($extras as $extra) {
            $query = "SELECT o.id FROM orders o LEFT JOIN orders_extras OE ON (OE.order_id = o.id) WHERE OE.extra_id = {$extra->id} AND o.deliver_type = 'SUC'";

            if (isset($_SESSION['dataFrom'])) {
                $query .= " AND created_at >= '" . $_SESSION['dataFrom'] ."'";
            }

            $query = $this->db->query($query);
            
            $ordersByExtras[] = [
                'extraName' => $extra->name,
                'quantity'  => count($query->result())
            ];
        }

        // Cantidad por sucursales
        $this->load->model('Office');
        $ordersByOffice = [];
        foreach($this->Office->getAll() as $office) {
            $ordersByOffice[] = [
                'officeName' => $office->name,
                'quantity'   => count($this->getByOffice($office->id, true))
            ];
        }

        $toReturn['sucursal']['pockets'] = $ordersByPockets;
        $toReturn['sucursal']['extras'] = $ordersByExtras;
        $toReturn['sucursal']['offices'] = $ordersByOffice;

        /*********************************************
         * Calculo pedidos de tipo DELIVERY (DEL).
         *********************************************/

        // Cantidad de tipos de bolsones
        $ordersByPockets = [];
        foreach($pockets as $pocket) {
            $orders = $this->getByPocketId($pocket->id, 'DEL', true);
            $ordersByPockets[] = [
                'pocketName' => $pocket->name,
                'quantity'   => count($orders)
            ];
        }

        // Cantidad de cada producto extra
        $ordersByExtras = [];
        foreach($extras as $extra) {
            $query = "SELECT o.id FROM orders o LEFT JOIN orders_extras OE ON (OE.order_id = o.id) WHERE OE.extra_id = {$extra->id} AND o.deliver_type = 'DEL'";

            if (isset($_SESSION['dataFrom'])) {
                $query .= " AND created_at >= '" . $_SESSION['dataFrom']."'";
            }

            $query = $this->db->query($query);

            $ordersByExtras[] = [
                'extraName' => $extra->name,
                'quantity'  => count($query->result())
            ];
        }

        // Cantidad por barrios
        $this->load->model('Barrio');
        $ordersByOffice = [];
        foreach($this->Barrio->getAll() as $barrio) {
            $ordersByOffice[] = [
                'barrioName' => $barrio->nombre,
                'quantity'   => count($this->getByBarrio($barrio->id))
            ];
        }

        $toReturn['delivery']['pockets'] = $ordersByPockets;
        $toReturn['delivery']['extras'] = $ordersByExtras;
        $toReturn['delivery']['barrios'] = $ordersByOffice;

        return $toReturn;
    }

    public function getByPocketId($pocketId, $deliver_type = 'SUC', $applyCurrentDate = false)
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash');
        $this->db->from('orders');
        $this->db->where('pocket_id', $pocketId);
        $this->db->where('deliver_type', $deliver_type);
        $this->db->where('valid', 1);
        $this->db->order_by('created_at', 'DESC');
        if($applyCurrentDate == true) {
            if(isset($_SESSION['dataFrom'])) {
                $this->db->where('created_at >= ', $_SESSION['dataFrom']);
            }else{
                $this->db->where('created_at >= ', date('Y-m-d'));
            }
        }

        return $this->db->get()->result();
    }

    public function addOrder(
                        $diaBolson,
                        $idDiaBolson,
                        $nombre,
                        $telefono,
                        $mail,
                        $direccion,
                        $direccionPisoDepto,
                        $idTipoPedido,
                        $idBarrio,
                        $idSucursal,
                        $idBolson,
                        $cantBolson,
                        $montoTotal,
                        $montoPagado,
                        $idEstadoPedido,
                        $observaciones,
                        $idCupon,
                        $montoDescuento,
                        $idPedidoFijo,
                        $idPedidoOriginal,
                        $valid = true
) 
    {

        $this->db->set('client_name', $nombre);
        $this->db->set('email', $mail);
        $this->db->set('phone', $telefono);

        $this->db->set('id_tipo_pedido', $idTipoPedido);
        $this->load->model('TiposPedidos');
        $oTipoPedido = $this->TiposPedidos->getById($idTipoPedido);
        $this->db->set('deliver_type', $oTipoPedido->codigo);

        if($idTipoPedido==1){
            //SI ES SUCURSAL
            $this->db->set('office_id', $idSucursal);
        }else if($idTipoPedido==2){
            //SI ES DOMICILIO
            $this->db->set('barrio_id', $idBarrio);
            $this->db->set('deliver_address', $direccion);
            $this->db->set('deliver_extra', $direccionPisoDepto);
        }
        if($montoTotal!=""){
            $this->db->set('monto_total', $montoTotal);    
        }
        if($montoPagado!=""){
            $this->db->set('monto_pagado', $montoPagado);    
        }
        if($idEstadoPedido!="" && $idEstadoPedido>0){
            $this->db->set('id_estado_pedido', $idEstadoPedido);    
        }else{
            //LO PONEMOS COMO DEFAULT EN ESTADO 1 ==> CONFIRMADO
            $this->db->set('id_estado_pedido', 1);    
        }
        if($observaciones!=null && $observaciones!=""){
            $this->db->set('observaciones', $observaciones);    
        }
        if($idPedidoFijo!=null){
            $this->db->set('id_pedido_fijo', $idPedidoFijo);    
        }
        if($idPedidoOriginal!=null && $idPedidoOriginal>0){
            $this->db->set('id_pedido_original', $idPedidoOriginal);    
        }
        if(isset($idBolson) && $idBolson>0 && $cantBolson>0){
            $this->load->model('Pocket');
            $oBolson = $this->Pocket->getById($idBolson);
            $this->db->set('pocket_id', $idBolson);
            $this->db->set('cant_bolson', $cantBolson);
            $total = $cantBolson * $oBolson->price;
            $this->db->set('total_bolson', $total);
        }
        $this->db->set('deliver_date', $diaBolson);
        $this->db->set('id_dia_entrega', $idDiaBolson);

        if(isset($idCupon) && $idCupon > 0 && isset($montoDescuento) && $montoDescuento > 0) {
            $this->db->set('id_cupon', $idCupon);
            $this->db->set('monto_descuento', $montoDescuento);
        }

        $this->db->set('valid', $valid);
        $hash = sha1($nombre.uniqid());
        $this->db->set('hash', $hash);
        $this->db->insert('orders');

        return $this->db->insert_id();
    }    

    public function updateMontoTotal($id, $montoTotal)
    {
        $this->db->set('monto_total', $montoTotal);
        $this->db->where('id', $id);
        $this->db->update('orders');

        return true;
    }

    public function updateMontoPagado($id, $montoPagado)
    {
        $this->db->set('monto_pagado', $montoPagado);
        $this->db->where('id', $id);
        $this->db->update('orders');

        return true;
    }

    public function updatePedido($id, $nombre, $telefono, $mail, $direccion, $direccionPisoDepto, $idTipoPedido, $idBarrio, $idSucursal, 
                                 $idBolson, $cantBolson, $montoTotal, $montoPagado, $idEstadoPedido, $observaciones, $idCupon, $montoDescuento, $idPedidoFijo)
    {

        $this->db->set('client_name', $nombre);
        $this->db->set('email', $mail);
        $this->db->set('phone', $telefono);

        $this->db->set('id_tipo_pedido', $idTipoPedido);
        $this->load->model('TiposPedidos');
        $oTipoPedido = $this->TiposPedidos->getById($idTipoPedido);
        $this->db->set('deliver_type', $oTipoPedido->codigo);

        if($idTipoPedido==1){
            //SI ES SUCURSAL
            $this->db->set('office_id', $idSucursal);
            $this->db->set('barrio_id', null);
            $this->db->set('deliver_address', null);
            $this->db->set('deliver_extra', null);
        }else if($idTipoPedido==2){
            //SI ES DOMICILIO
            $this->db->set('barrio_id', $idBarrio);
            $this->db->set('deliver_address', $direccion);
            $this->db->set('deliver_extra', $direccionPisoDepto);
            $this->db->set('office_id', null);
        }
        if($montoTotal!=""){
            $this->db->set('monto_total', $montoTotal);    
        }
        if($montoPagado!=""){
            $this->db->set('monto_pagado', $montoPagado);    
        }
        if($idEstadoPedido!="" && $idEstadoPedido>0){
            $this->db->set('id_estado_pedido', $idEstadoPedido);    
        }else{
            //LO PONEMOS COMO DEFAULT EN ESTADO 1 ==> CONFIRMADO
            $this->db->set('id_estado_pedido', 1);    
        }
        if($observaciones!=null && $observaciones!=""){
            $this->db->set('observaciones', $observaciones);    
        }
        if($idPedidoFijo!=null){
            $this->db->set('id_pedido_fijo', $idPedidoFijo);    
            if($idPedidoFijo==0){
                $this->db->set('id_pedido_original', null);    
            }
        }
        if(isset($idBolson) && $idBolson>0) {
            $this->db->set('pocket_id', $idBolson);
            if(isset($cantBolson) && $cantBolson>0) {
                $this->db->set('cant_bolson', $cantBolson);
                $this->load->model('Pocket');
                $oBolson = $this->Pocket->getById($idBolson);
                $total = $cantBolson * $oBolson->price;
                $this->db->set('total_bolson', $total);                    
            }
        }else{
            $this->db->set('pocket_id', null);
            $this->db->set('cant_bolson', null);
            $this->db->set('total_bolson', null);
        }
        if(isset($idCupon) && $idCupon > 0 && isset($montoDescuento) && $montoDescuento > 0) {
            $this->db->set('id_cupon', $idCupon);
            $this->db->set('monto_descuento', $montoDescuento);
        }
        $this->db->where('id', $id);
        $this->db->update('orders');

        return true;
    }
    
    public function addExtra($orderId, $extraId, $cant)
    {
        $this->db->set('order_id', $orderId);
        $this->db->set('extra_id', $extraId);
        $this->db->set('cant', $cant);
        
        $this->load->model('Extra');
        $oExtra = $this->Extra->getById($extraId);
        if(isset($oExtra)){
            $total = ($oExtra->price * $cant);
            $this->db->set('total', $total);
        }
        
        $this->db->insert('orders_extras');

        return $this->db->insert_id();
    }

    public function deleteAllExtrasFromOrder($idPedido) 
    {
        $this->db->where('order_id', $idPedido);
        $this->db->delete('orders_extras');

        return true;
    }

    public function deleteExtraFromOrder($idPedido,$idExtra) 
    {
        $this->db->where('order_id', $idPedido);
        $this->db->where('extra_id', $idExtra);
        $this->db->delete('orders_extras');

        return true;
    }

    public function getById($orderId)
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash, monto_total, monto_pagado, id_estado_pedido, observaciones, id_tipo_pedido, id_pedido_fijo, id_pedido_original, cant_bolson, total_bolson, id_cupon, monto_descuento');
        $this->db->from('orders');
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('id', $orderId);
    
        return $this->db->get()->result()[0];
    }

    public function getDetailedExtras($orderId) 
    {
        $query = $this->db->query("SELECT ep.*, oe.cant, oe.total FROM extra_products ep LEFT JOIN orders_extras oe ON (ep.id = oe.extra_id) WHERE oe.order_id = " . $orderId);
        return $query->result();
    }

    public function getOrdersFromConsultaPedidos($diaBolson,$soloDiaBolson,$incluirCancelados,$fechaDesde,$fechaHasta,$nombre,$mail,$nroPedido){
        $this->db->select('o.id, o.client_name, o.email, o.phone, o.deliver_type, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, barrio.id as id_barrio, barrio.nombre as nombre_barrio, o.deliver_address as cliente_domicilio, o.deliver_extra as cliente_domicilio_extra, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, o.deliver_date, o.created_at, o.observaciones, o.monto_total, o.monto_pagado, o.id_estado_pedido, ep.descripcion as estadoPedido');
        $this->db->from('orders as o');
        $this->db->join('offices as sucursal', 'sucursal.id = o.office_id', 'left');
        $this->db->join('barrios as barrio', 'barrio.id = o.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = o.pocket_id', 'left');
        $this->db->join('estados_pedidos as ep', 'ep.id_estado_pedido = o.id_estado_pedido', 'left');
        //$where = "(o.deliver_type = 'SUC' or (o.deliver_type = 'DEL' and o.valid = 1))";        
        $where = "o.valid = 1";        
        if(isset($nroPedido) && $nroPedido != "") {
            $where .= " AND o.id = ".$nroPedido;
        }else{
            //SI FILTRO POR BOLSON DEL DIA NO PUEDO FILTRAR POR FECHA
            if(isset($soloDiaBolson) && $soloDiaBolson==1){
                $where .= " AND o.deliver_date = '".$diaBolson."'";
            }else{
                if(isset($fechaDesde) && $fechaDesde != "") {
                    $where .= " AND o.created_at >= '".$fechaDesde." 00:00:00'";
                }
                if(isset($fechaHasta) && $fechaHasta != "") {
                    $where .= " AND o.created_at <= '".$fechaHasta." 23:59:59'";
                }    
            }
            if(isset($incluirCancelados) && $incluirCancelados==0){
                //ID ESTADO = 4 ==> CANCELADO
                $where .= " AND o.id_estado_pedido not in (4)";
            }
            if(isset($nombre) && $nombre != "") {
                $where .= " AND o.client_name like '%".$nombre."%'";
            }
            if(isset($mail) && $mail != "") {
                $where .= " AND o.email like '%".$mail."%'";
            }
        }
        $this->db->where($where);
        $this->db->order_by('o.created_at', 'DESC');
        $pedidos = $this->db->get()->result();
        return $pedidos;
    }

    public function getAllPedidosFijos(){
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash, monto_total, monto_pagado, id_estado_pedido, observaciones, id_tipo_pedido, id_pedido_fijo, cant_bolson, total_bolson');
        $this->db->from('orders');
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('valid', 1);
        $this->db->where('id_pedido_fijo', 1);

        return $this->db->get()->result();
    }

    public function getPuntosRetiroInDiaEntrega($idDiaEntrega){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        //ME DA TODAS LAS SUCURSALES QUE TIENEN PEDIDOS ESE ID_DIA_ENTREGA
        $this->db->select('distinct(office.id), office.name, office.address');
        $this->db->from('offices as office');
        $where = "office.id in (select orders.office_id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4) AND orders.valid = 1)";
        $this->db->where($where);        
        $this->db->order_by('office.name', 'ASC');
        $cPuntosRetiro = $this->db->get()->result();
        return $cPuntosRetiro;
    }

    //TODO: CAMBIAR EL NOMBRE DEL METODO YA QUE DEVUELVE EL TOTAL DE BOLSONES, NO DE ORDENES
    public function getTotalOrdersByIdDiaEntregaAndIdPuntoRetiro($idDiaBolson,$idPuntoRetiro){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        //$this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as cantidad_bolsones, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido');
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, orders.pocket_id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "(orders.id_estado_pedido not in (4) AND orders.id_dia_entrega = '$idDiaBolson' AND orders.office_id = $idPuntoRetiro AND orders.deliver_type = 'SUC' AND orders.valid = 1)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }

        return $contBolsones;
    }

    public function getSumatoriaPedidosByIdDiaEntregaAndIdPuntoRetiro($idDiaBolson,$idPuntoRetiro){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "(orders.id_estado_pedido not in (4) AND orders.id_dia_entrega = '$idDiaBolson' AND orders.office_id = $idPuntoRetiro AND orders.deliver_type = 'SUC' AND orders.valid = 1)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        return count($orders);
    }

    public function getOrdersInDiaEntrega($idDiaEntrega){
        //FUNCION QUE SE USA PARA OBTENER LAS ORDENES DE UN DIA ESPECIFICO Y DEPSUES DEFINIR EL NRO DE ORDEN DE CADA ORDEN PARA LOS XLS/PDF.
        $this->db->select('orders.id');
        $this->db->from('orders');
        $where = "orders.id_estado_pedido not in (4) AND orders.id_dia_entrega = '$idDiaEntrega' AND (orders.deliver_type = 'SUC' OR (orders.deliver_type = 'DEL' AND orders.valid = 1) )";        
        $this->db->where($where);        
        $this->db->order_by('orders.office_id', 'ASC');
        $this->db->order_by('orders.barrio_id', 'ASC');
        $this->db->order_by('orders.client_name', 'ASC');
        $orders = $this->db->get()->result();
        return $orders;        
    }

    public function getBarriosInDiaEntrega($idDiaEntrega){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        //ME DA TODOS LOS BARRIOS  QUE TIENEN PEDIDOS ESE ID_DIA_ENTREGA
        $this->db->select('distinct(barrio.id), barrio.nombre, barrio.observaciones');
        $this->db->from('barrios as barrio');
        $where = "barrio.id in (select orders.barrio_id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_estado_pedido not in (4) and orders.valid = 1)";
        $this->db->where($where);        
        $this->db->order_by('barrio.nombre', 'ASC');
        $cBarrios = $this->db->get()->result();
        return $cBarrios;
    }

    //TODO: CAMBIAR EL NOMBRE DEL METODO YA QUE DEVUELVE EL TOTAL DE BOLSONES, NO DE PEDIDOS
    public function getTotalOrdersByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido not in (4) and orders.valid = 1";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }

        return $contBolsones;
    }

    public function getSumatoriaPedidosByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido not in (4) and orders.valid = 1";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        return count($orders);
    }

    public function getTotalOrdersEspecialesByIdDiaEntregaAndIdPuntoRetiro($idDiaBolson,$idPuntoRetiro){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "(orders.id_estado_pedido in (2) AND orders.id_dia_entrega = '$idDiaBolson' AND orders.office_id = $idPuntoRetiro AND orders.deliver_type = 'SUC' AND orders.valid = 1)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }

        return $contBolsones;
    }    
    
    public function getTotalOrdersEspecialesByIdDiaEntregaAndIdBarrio($idDiaEntrega,$idBarrio){
        //FUNCION QUE SE USA PARA EL MODULO DE LOGISTICA
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $where = "orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido in (2) and orders.valid = 1";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contBolsones = 0;
        if(!empty($orders)){
            $contBolsones = $this->generateGetTotalBolsonesResponse($orders);
        }

        return $contBolsones;
    }

    public function getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiro($idDiaEntrega, $idPuntoRetiro){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.id_tipo_pedido, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.id_dia_entrega, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //$where = "deliver_type = 'SUC' AND deliver_date = '$diaBolson'";    
        //Excluyo los pedidos en estado CANCELADO
        $where = "orders.deliver_type = 'SUC' AND orders.valid = 1 AND orders.id_dia_entrega = '$idDiaEntrega' AND orders.office_id = '$idPuntoRetiro' AND orders.id_estado_pedido not in (4)";    
        
        $this->db->where($where);
        $this->db->order_by('sucursal ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersArray($orders);
        }
        return $toAppend;
    }    

    public function getTotalExtrasByPuntoDeRetiroByIdDiaEntregaByIdExtra($idPuntoDeRetiro,$idDiaEntrega,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL / PDF DESDE LA PREPARACION DE LOGISTICA
        //ME DA EL TOTALIZADO POR EXTRA POR PUNTO DE RETIRO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.office_id = $idPuntoDeRetiro AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4) AND orders.valid = 1) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrio($idDiaEntrega, $idBarrio){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL DE LOS PEDIDOS ENTRE LAS FECHAS DE SUCURSAL
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.id_tipo_pedido, barrio.id as id_barrio, barrio.nombre as nombre_barrio, barrio.observaciones as barrio_observaciones, barrio.costo_envio, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.id_dia_entrega, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        //Excluyo los pedidos en estado CANCELADO
        $where = "orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = '$idBarrio' AND orders.id_estado_pedido not in (4)";    
        
        $this->db->where($where);
        $this->db->order_by('nombre_barrio ASC, orders.client_name ASC');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersDeliveryArray($orders);
        }
        return $toAppend;
    }    

    public function getTotalExtrasByBarrioByIdDiaEntregaByIdExtra($idBarrio,$idDiaEntrega,$idExtra){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL / PDF DESDE LA PREPARACION DE LOGISTICA
        //ME DA EL TOTALIZADO POR EXTRA POR PUNTO DE RETIRO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido not in (4) AND orders.valid = 1) AND oe.extra_id = $idExtra";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }    

    public function setNroOrden($id, $nroOrden)
    {
        $this->db->set('nro_orden', $nroOrden);
        $this->db->where('id', $id);
        $this->db->update('orders');

        return true;
    }
    /*
    NO USAMOS ESTA PORQUE QUEREMOS QUE SI UN PEDIDO TIENE UN BOLSON FAMILIAR Y UNO INDIVIDUAL, CUENTE UNO y UNO LOS ESPECIALES. ESTA QUERY EXCLUYE A LOS QUE TIENEN FAMILIAR.

    public function getTotalOrdersEspecialesSinBolsonFamiliarConBolsonIndividualByPuntoDeRetiroByIdDiaEntrega($idPuntoDeRetiro,$idDiaEntrega) {
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND (orders.pocket_id<1 OR orders.pocket_id is null) AND orders.office_id = $idPuntoDeRetiro AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido in (2) AND orders.valid = 1) AND oe.extra_id = 1";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        //print_r($extras);
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }
    */

    public function getTotalOrdersEspecialesConBolsonIndividualByPuntoDeRetiroByIdDiaEntrega($idPuntoDeRetiro,$idDiaEntrega) {
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.office_id = $idPuntoDeRetiro AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido in (2) AND orders.valid = 1) AND oe.extra_id = 1";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        //print_r($extras);
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }

    public function getTotalPedidosTiendaByPuntoDeRetiroByIdDiaEntrega($idPuntoDeRetiro,$idDiaEntrega) {
        $this->db->select('distinct(orders.id)');
        $this->db->from('orders');
        //$this->db->join('orders_extras as oe', 'oe.order_id = orders.id', 'left');
        $where = "orders.id_dia_entrega = '$idDiaEntrega' AND orders.office_id = $idPuntoDeRetiro AND orders.deliver_type = 'SUC' AND orders.id_estado_pedido not in (4) 
                    AND orders.valid = 1  AND (orders.pocket_id is null OR orders.pocket_id in (0) ) 
                    AND not exists (select 1 from orders_extras oe where oe.order_id = orders.id  and oe.extra_id in (1))";
        $this->db->where($where);        
        $cPedidosTienda = $this->db->get()->result();
        
        return count($cPedidosTienda);
    }

    public function getTotalPedidosTiendaByBarrioByIdDiaEntrega($idBarrio,$idDiaEntrega) {
        $this->db->select('distinct(orders.id)');
        $this->db->from('orders');
        //$this->db->join('orders_extras as oe', 'oe.order_id = orders.id', 'left');
        $where = "orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido not in (4) 
                    AND orders.valid = 1 AND (orders.pocket_id is null OR orders.pocket_id in (0) ) 
                    AND not exists (select 1 from orders_extras oe where oe.order_id = orders.id  and oe.extra_id in (1))";
        $this->db->where($where);        
        $cPedidosTienda = $this->db->get()->result();
        
        return count($cPedidosTienda);
    }
    
    /*
    NO USAMOS ESTA PORQUE QUEREMOS QUE SI UN PEDIDO TIENE UN BOLSON FAMILIAR Y UNO INDIVIDUAL, CUENTE UNO y UNO LOS ESPECIALES. ESTA QUERY EXCLUYE A LOS QUE TIENEN FAMILIAR.

    public function getTotalOrdersEspecialesSinBolsonFamiliarConBolsonIndividualByBarrioByIdDiaEntrega($idBarrio,$idDiaEntrega){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL / PDF DESDE LA PREPARACION DE LOGISTICA
        //ME DA EL TOTALIZADO POR EXTRA POR PUNTO DE RETIRO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND (orders.pocket_id<1 OR orders.pocket_id is null)  AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido in (2) AND orders.valid = 1) AND oe.extra_id = 1";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        print_r($extras);
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }    
    */

    public function getTotalOrdersEspecialesConBolsonIndividualByBarrioByIdDiaEntrega($idBarrio,$idDiaEntrega){
        //FUNCION QUE SE USA PARA EL EXPORT A EXCEL / PDF DESDE LA PREPARACION DE LOGISTICA
        //ME DA EL TOTALIZADO POR EXTRA POR PUNTO DE RETIRO
        $this->db->select('oe.id, oe.cant');
        $this->db->from('orders_extras as oe');
        $where = "oe.order_id in (select orders.id from orders where orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = $idBarrio AND orders.deliver_type = 'DEL' AND orders.id_estado_pedido in (2) AND orders.valid = 1) AND oe.extra_id = 1";
        $this->db->where($where);        
        $extras = $this->db->get()->result();
        $contExtra = 0;
        if(!empty($extras)){
            $contExtra = $this->generateGetTotalExtrasResponse($extras);
        }
        return $contExtra;
    }    

    public function getTotalPedidosByDiaBolsonForPuntoDeRetiro($idDiaEntrega) {
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "id_dia_entrega = '$idDiaEntrega' AND deliver_type = 'SUC' and valid = 1 and id_estado_pedido not in (4)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contPedidos = 0;
        if(!empty($orders)){
            $contPedidos = $this->countPedidos($orders);
        }
        return $contPedidos;
    }

    public function getTotalPedidosByDiaBolsonForDomicilio($idDiaEntrega) {
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "id_dia_entrega = '$idDiaEntrega' AND deliver_type = 'DEL' and valid = 1 and id_estado_pedido not in (4)";        
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contPedidos = 0;
        if(!empty($orders)){
            $contPedidos = $this->countPedidos($orders);
        }
        return $contPedidos;
    }

    public function getTotalPedidosByFechaDesdeFechaHastaForPuntoDeRetiro($fechaDesde, $fechaHasta) {
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND deliver_type = 'SUC' and valid = 1 and id_estado_pedido not in (4)";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contPedidos = 0;
        if(!empty($orders)){
            $contPedidos = $this->countPedidos($orders);
        }
        return $contPedidos;
    }

    public function getTotalPedidosByFechaDesdeFechaHastaForDomicilio($fechaDesde, $fechaHasta) {
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.deliver_date, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson');
        $this->db->from('orders');
        $where = "created_at >= '$fechaDesde 00:00:00' AND created_at <= '$fechaHasta 23:59:59' AND deliver_type = 'DEL' and valid = 1 and id_estado_pedido not in (4)";
        $this->db->where($where);        
        $orders = $this->db->get()->result();
        $contPedidos = 0;
        if(!empty($orders)){
            $contPedidos = $this->countPedidos($orders);
        }
        return $contPedidos;
    }

    public function countPedidos($cPedidos) {
        return count($cPedidos);
    }

    public function getOrdersPuntosRetiroWithExtrasByIdDiaEntregaAndIdPuntoRetiroOrderedByCantExtras($idDiaEntrega, $idPuntoRetiro){
        //FUNCION QUE SE USA PARA EL EXPORT A PDF DE PEDIDOS EN TARJETAS.
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.id_tipo_pedido, sucursal.id as id_sucursal, sucursal.name as sucursal, sucursal.address as domicilio_sucursal, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.id_dia_entrega, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento, count(oe.order_id)+ifnull(cant_bolson,0)  as cantItems');
        $this->db->from('orders');
        $this->db->join('offices as sucursal', 'sucursal.id = orders.office_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $this->db->join('orders_extras as oe', 'oe.order_id = orders.id', 'left');
        $where = "orders.deliver_type = 'SUC' AND orders.valid = 1 AND orders.id_dia_entrega = '$idDiaEntrega' AND orders.office_id = '$idPuntoRetiro' AND orders.id_estado_pedido not in (4)";    
        
        $this->db->where($where);
        $this->db->order_by('sucursal ASC, cantItems DESC, orders.client_name ASC');
        $this->db->group_by('orders.id');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersArray($orders);
        }
        return $toAppend;
    }    

    public function getOrdersBarriosWithExtrasByIdDiaEntregaAndIdBarrioOrderedByCantExtras($idDiaEntrega, $idBarrio){
        //FUNCION QUE SE USA PARA EL EXPORT A PDF DE PEDIDOS EN TARJETAS.
        $this->db->select('orders.id, orders.client_name, orders.email, orders.phone, orders.id_tipo_pedido, barrio.id as id_barrio, barrio.nombre as nombre_barrio, barrio.observaciones as barrio_observaciones, barrio.costo_envio, orders.deliver_address as cliente_domicilio, orders.deliver_extra as cliente_domicilio_extra, bolson.name as nombre_bolson, bolson.price as precio_bolson, bolson.cant as cant_bolson, bolson.id as id_bolson, orders.deliver_date, orders.id_dia_entrega, orders.created_at, orders.observaciones, orders.monto_total, orders.monto_pagado, orders.id_estado_pedido, orders.nro_orden, orders.cant_bolson, orders.total_bolson, orders.id_cupon, orders.monto_descuento, count(oe.order_id) as cantExtras');
        $this->db->from('orders');
        $this->db->join('barrios as barrio', 'barrio.id = orders.barrio_id', 'left');
        $this->db->join('pockets as bolson', 'bolson.id = orders.pocket_id', 'left');
        $this->db->join('orders_extras as oe', 'oe.order_id = orders.id', 'left');
        //Excluyo los pedidos en estado CANCELADO
        $where = "orders.deliver_type = 'DEL' AND orders.valid = 1 AND orders.id_dia_entrega = '$idDiaEntrega' AND orders.barrio_id = '$idBarrio' AND orders.id_estado_pedido not in (4)";    
        
        $this->db->where($where);
        $this->db->order_by('nombre_barrio ASC, cantExtras DESC, orders.client_name ASC');
        $this->db->group_by('orders.id');
        $orders = $this->db->get()->result();

        $toAppend = [];
        if(!empty($orders)){
            $toAppend = $this->generateOrdersDeliveryArray($orders);
        }
        return $toAppend;
    }        
}
