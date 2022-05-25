<?php

class DiasEntregaPedidos extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->select('id_dia_entrega, fecha_entrega, descripcion,id_estado_logistica');
        $this->db->from('dias_entrega_pedidos');

        return $this->db->get()->result();
    }

    public function add($fecha_entrega, $descripcion, $aceptaBolsones, $puntoDeRetiroStatus, $deliveryStatus, $aceptaPedidos)
    {
        $this->db->set('fecha_entrega', $fecha_entrega);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('acepta_bolsones', $aceptaBolsones);
        $this->db->set('punto_de_retiro_enabled', $puntoDeRetiroStatus);
        $this->db->set('delivery_enabled', $deliveryStatus);
        $this->db->set('acepta_pedidos', $aceptaPedidos);
        $this->db->insert('dias_entrega_pedidos');
        
        return $this->db->insert_id();
    }

    public function delete($id) 
    {
        $this->db->where('id_dia_entrega', $id);
        $this->db->delete('dias_entrega_pedidos');

        return true;
    }

    public function getAllDiasByEstadoLogisticaNotCerrados()
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega, d.descripcion, d.id_estado_logistica, d.fecha_creacion, el.descripcion as estadoLogistica');
        $this->db->from('dias_entrega_pedidos as d');
        $this->db->join('estados_logistica as el', 'el.id_estado_logistica = d.id_estado_logistica', 'left');
        $this->db->where_not_in('d.id_estado_logistica',3);
        $this->db->order_by('d.fecha_creacion', 'DESC');
        return $this->db->get()->result();
    }

    public function getAllDiasLastMonth()
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega, d.descripcion,d.id_estado_logistica,d.fecha_creacion, el.descripcion as estadoLogistica');
        $this->db->from('dias_entrega_pedidos as d');
        $this->db->join('estados_logistica as el', 'el.id_estado_logistica = d.id_estado_logistica', 'left');
        $where = "d.fecha_creacion BETWEEN DATE_SUB(CURDATE(),INTERVAL 30 DAY) AND CURDATE()";
        $this->db->where($where);
        $this->db->order_by('d.fecha_creacion', 'DESC');
        return $this->db->get()->result();
    }

    public function setEstadoEnPreparacion($id)
    {
        $this->db->where('id_dia_entrega', $id);
        /*LO PASAMOS A ESTADO EN PREPARACION*/
        $this->db->set('id_estado_logistica', 2);
        $this->db->update('dias_entrega_pedidos');

        return true;
    }

    public function setEstadoSinPreparar($id)
    {
        $this->db->where('id_dia_entrega', $id);
        /*LO PASAMOS A ESTADO SIN PREPARAR*/
        $this->db->set('id_estado_logistica', 1);
        $this->db->update('dias_entrega_pedidos');

        return true;
    }

    public function setEstadoCerrado($id)
    {
        $this->db->where('id_dia_entrega', $id);
        /*LO PASAMOS A ESTADO CERRADO*/
        $this->db->set('id_estado_logistica', 3);
        $this->db->set('archivado', 1);
        $this->db->update('dias_entrega_pedidos');

        return true;
    }

    public function getLastDay()
    {
        $this->db->select_max('id_dia_entrega');
        $query =  $this->db->get('dias_entrega_pedidos');
        $id = $query->result()[0]->id_dia_entrega;
        $lastDiaEntrega = $this->getById($id);
        return $lastDiaEntrega;
    }

    public function getById($idDiaEntrega) 
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega as fechaEntrega, d.descripcion, d.id_estado_logistica, d.fecha_creacion, d.acepta_pedidos as aceptaPedidos, d.acepta_bolsones as aceptaBolsones, d.archivado, d.imagen, d.punto_de_retiro_enabled as puntoDeRetiroEnabled, d.delivery_enabled as deliveryEnabled');
        $this->db->from('dias_entrega_pedidos as d');
        $this->db->where('id_dia_entrega', $idDiaEntrega);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getAllActivos()
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega as fechaEntrega, d.descripcion, d.id_estado_logistica, d.fecha_creacion, d.acepta_pedidos as aceptaPedidos, d.acepta_bolsones as aceptaBolsones, d.archivado, d.imagen, d.punto_de_retiro_enabled as puntoDeRetiroEnabled, d.delivery_enabled as deliveryEnabled, el.descripcion as estadoLogistica');
        $this->db->from('dias_entrega_pedidos as d');
        $this->db->join('estados_logistica as el', 'el.id_estado_logistica = d.id_estado_logistica', 'left');
        $where = "d.archivado = 0 and d.id_estado_logistica in (1,2)";
        $this->db->where($where);
        $this->db->order_by('d.fecha_entrega', 'ASC');
        return $this->db->get()->result();
    }

    public function updateAceptaBolsonStatus($idDiaEntrega, $status) {
        $this->db->set('acepta_bolsones', $status);
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->update('dias_entrega_pedidos');
        
        return true;
    }

    public function updatePuntosDeRetiroEnabled($idDiaEntrega, $status) {
        $this->db->set('punto_de_retiro_enabled', $status);
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->update('dias_entrega_pedidos');
        
        return true;
    }

    public function updateDeliveryEnabled($idDiaEntrega, $status) {
        $this->db->set('delivery_enabled', $status);
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->update('dias_entrega_pedidos');
        
        return true;
    }

    public function updateAceptaPedidosStatus($idDiaEntrega, $status) {
        $this->db->set('acepta_pedidos', $status);
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->update('dias_entrega_pedidos');
        
        return true;
    }

    public function setImagen($id, $imagen)
    {
        $this->db->where('id_dia_entrega', $id);
        $this->db->set('imagen', $imagen);
        $this->db->update('dias_entrega_pedidos');

        return true;
    }
}