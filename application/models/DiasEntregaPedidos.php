<?php

class DiasEntregaPedidos extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
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
        $this->db->select('d.id_dia_entrega, d.fecha_entrega as fechaEntrega, d.descripcion, d.acepta_bolsones as aceptaBolsones, d.punto_de_retiro_enabled as puntoDeRetiroEnabled, d.delivery_enabled as deliveryEnabled, d.imagen');
        $this->db->from('dias_entrega_pedidos as d');
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getAllActivos()
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega as fechaEntrega, d.descripcion, d.acepta_bolsones as aceptaBolsones, d.punto_de_retiro_enabled as puntoDeRetiroEnabled, d.delivery_enabled as deliveryEnabled');
        $this->db->from('dias_entrega_pedidos as d');
        $where = "d.acepta_pedidos = 1 AND d.archivado = 0";
        $this->db->where($where);
        $this->db->order_by('d.fecha_entrega', 'ASC');
        return $this->db->get()->result();
    }

    public function getLastDayWithAceptaBolsones()
    {
        $this->db->select('d.id_dia_entrega, d.fecha_entrega as fechaEntrega, d.descripcion, d.acepta_bolsones as aceptaBolsones, d.punto_de_retiro_enabled as puntoDeRetiroEnabled, d.delivery_enabled as deliveryEnabled, imagen');
        $this->db->from('dias_entrega_pedidos as d');
        $where = "d.acepta_pedidos = 1 AND d.acepta_bolsones = 1 AND d.archivado = 0";
        $this->db->where($where);
        $this->db->order_by('d.id_dia_entrega', 'DESC');
        return $this->db->get()->result()[0];
    }

}