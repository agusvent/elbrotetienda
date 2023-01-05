<?php

class FormasPago extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll() {
        $this->db->select('id, descripcion');
        $this->db->from('formas_pago');
        $this->db->order_by('descripcion', 'ASC');

        return $this->db->get()->result();
    }

    public function getById($id) {
        $this->db->select('id, descripcion');
        $this->db->from('formas_pago');
        $this->db->where('id', $id);

        return $this->db->get()->result();
    }
}