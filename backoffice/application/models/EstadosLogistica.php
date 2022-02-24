<?php

class EstadosLogistica extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->select('id_estado_logistica, descripcion');
        $this->db->from('estados_logistica');

        return $this->db->get()->result();
    }

    public function getById($id) 
    {
        $this->db->select('id_estado_logistica, descripcion');
        $this->db->from('estados_logistica');
        $this->db->where('id_estado_logistica', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }

}