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

    public function getBarriosHabilitadosByDiaEntrega($idDiaEntrega) {
        $query = $this->db->query("SELECT b.* FROM barrios b LEFT JOIN dias_entrega_barrios deb ON (b.id = deb.id_barrio) WHERE deb.id_dia_entrega = " . $idDiaEntrega . " order by b.nombre asc");
        return $query->result();
    }
}
