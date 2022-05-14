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
        $this->db->where('deleted', 0);
        $this->db->order_by('nombre', 'ASC');

        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('id, nombre, observaciones, activo, deleted, costo_envio');
        $this->db->from('barrios');
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->set('deleted', 1);
        $this->db->update('barrios');

        return true;
    }

    public function update($id, $name, $observaciones, $costoEnvio) 
    {
        $this->db->where('id', $id);
        $this->db->set('nombre', $name);
        $this->db->set('observaciones', $observaciones);
        $this->db->set('costo_envio', $costoEnvio);
        $this->db->update('barrios');

        return true;
    }

    public function setActive($id, $active)
    {
        $this->db->where('id', $id);
        $this->db->set('activo', $active);
        $this->db->update('barrios');

        return true;
    }

    public function add($name, $observaciones, $costoEnvio) 
    {
        $this->db->set('nombre', $name);
        $this->db->set('observaciones', $observaciones);
        $this->db->set('costo_envio', $costoEnvio);
        $this->db->set('activo', 1);
        $this->db->insert('barrios');

        return $this->db->insert_id();
    }

    public function getAllBarriosSinAsociar() 
    {
        $this->db->select('o.id, o.nombre, o.activo, o.deleted, o.costo_envio');
        $this->db->from('barrios as o');
        $this->db->where("o.activo=1 and o.deleted = 0 and o.id not in (select cpcpb.id_barrio from camiones_preconfigurados_puntos_barrios as cpcpb where cpcpb.id_punto_retiro is null)");
        $this->db->order_by('o.nombre', 'ASC');

        return $this->db->get()->result();
    }    

    public function getActivos() 
    {
        $this->db->select('id, nombre, observaciones, activo, deleted, costo_envio');
        $this->db->from('barrios');
        $this->db->where('activo', 1);
        $this->db->where('deleted', 0);
        $this->db->order_by('nombre', 'ASC');

        return $this->db->get()->result();
    }

    public function getBarriosHabilitadosByDiaEntrega($idDiaEntrega) {
        $query = $this->db->query("SELECT b.* FROM barrios b LEFT JOIN dias_entrega_barrios deb ON (b.id = deb.id_barrio) WHERE deb.id_dia_entrega = " . $idDiaEntrega . " order by b.nombre asc");
        return $query->result();
    }

}
