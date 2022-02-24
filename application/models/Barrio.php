<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barrio extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getAll() 
    {
        $this->db->select('id, nombre, observaciones, activo, deleted, costo_envio');
        $this->db->from('barrios');
        $this->db->where('activo', 1);
        $this->db->where('deleted', 0);
        $this->db->order_by('nombre', 'ASC');

        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('id, nombre, observaciones, activo, costo_envio');
        $this->db->from('barrios');
        $this->db->where('activo', 1);
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }
}
