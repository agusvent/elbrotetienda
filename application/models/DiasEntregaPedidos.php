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
        $this->db->select('id_dia_entrega, descripcion');
        $this->db->from('dias_entrega_pedidos');
        $this->db->where('id_dia_entrega', $idDiaEntrega);

        $result = $this->db->get();
        return $result->result()[0];
    }

}