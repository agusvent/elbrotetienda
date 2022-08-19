<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function add($clientName,
                        $email,
                        $phone,
                        $idPuntoDeRetiro,
                        $cantBolson,
                        $deliverDate,
                        $idDiaEntrega,
                        $idTipoPedido,
                        $valid = false,
                        $deliverAddress = null,
                        $deliverExtra = null,
                        $idBarrio = null,
                        $hash = null) 
    {
        $this->db->set('client_name', $clientName);
        $this->db->set('email', $email);
        $this->db->set('phone', $phone);
        $this->db->set('office_id', $idPuntoDeRetiro);
        if(isset($cantBolson) && $cantBolson>0){
            //HARDCODEO EL ID DEL BOLSON PORQUE AHORA SE USA SOLO ESTE REGISTRO.
            $idBolson = 1;
            $this->load->model('Pocket');
            $oBolson = $this->Pocket->getById($idBolson);
            $total = 0;
            $this->db->set('pocket_id', $idBolson);
            $this->db->set('cant_bolson', $cantBolson);
            $total = $cantBolson * $oBolson->price;
            $this->db->set('total_bolson', $total);
            
        }
        $this->db->set('deliver_date', $deliverDate);
        $this->db->set('id_dia_entrega', $idDiaEntrega);
        $this->db->set('id_tipo_pedido', $idTipoPedido);
        $this->load->model('TiposPedidos');
        $oTipoPedido = $this->TiposPedidos->getById($idTipoPedido);
        $this->db->set('deliver_type', $oTipoPedido->codigo);
        
        $this->db->set('deliver_address', $deliverAddress);
        $this->db->set('deliver_extra', $deliverExtra);
        $this->db->set('barrio_id', $idBarrio);
        $this->db->set('valid', $valid);
        //LO PONEMOS COMO DEFAULT EN ESTADO 1 ==> CONFIRMADO
        $this->db->set('id_estado_pedido', 1);
        $this->db->set('hash', $hash);
        $this->db->insert('orders');

        return $this->db->insert_id();
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

    public function validate($hash, $status) 
    {
        $this->db->where('hash', $hash);
        $this->db->set('valid', $status);
        $this->db->update('orders');
    }

    public function mailConfirmationSent($id) 
    {
        $this->db->where('id', $id);
        $this->db->set('mail_confirmation_sent', 1);
        $this->db->update('orders');
    }

    public function setObs($hash, $obs) 
    {
        $this->db->where('hash', $hash);
        $this->db->set('observaciones', $obs);
        $this->db->update('orders');
    }

    public function savePaymentId($hash,$paymentId) {
        $this->db->where('hash', $hash);
        $this->db->set('payment_id', $paymentId);
        $this->db->update('orders');
    }

    public function getByHash($hash) 
    {
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash, cant_bolson, total_bolson, id_tipo_pedido, monto_total, monto_pagado, monto_descuento, mail_confirmation_sent');
        $this->db->from('orders');
        $this->db->where('hash', $hash);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getDetailedExtras($orderId) 
    {
        $query = $this->db->query("SELECT ep.*, oe.cant, oe.total FROM extra_products ep LEFT JOIN orders_extras oe ON (ep.id = oe.extra_id) WHERE oe.order_id = " . $orderId);
        return $query->result();
    }

    public function remove($orderId)
    {
        $this->db->query('DELETE FROM orders_extras WHERE order_id = ' . $orderId);
        $this->db->query('DELETE FROM orders WHERE id = ' . $orderId);
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

    public function updateMontoDescuento($id, $idCupon, $montoDescuento)
    {
        $this->db->set('id_cupon', $idCupon);
        $this->db->set('monto_descuento', $montoDescuento);
        $this->db->where('id', $id);
        $this->db->update('orders');

        return true;
    }       

    public function getOrdersByDiaBolsonAndMail($idDiaEntrega,$mailCliente,$telefono){
        $this->db->select('id, client_name, email, phone, office_id, pocket_id, deliver_date, created_at, deliver_type, deliver_address, deliver_extra, barrio_id, valid, hash, id_estado_pedido, cant_bolson, total_bolson');
        $this->db->from('orders');
        $this->db->where('valid', 1);
        $this->db->where('email', $mailCliente);
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->where('phone', $telefono);

        return $this->db->get()->result();
    }


}