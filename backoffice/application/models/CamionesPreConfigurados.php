<?php

class CamionesPreConfigurados extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->select('id_camion_preconfigurado, nombre, activo');
        $this->db->from('camiones_preconfigurados');
        $this->db->where('activo', 1);
        $this->db->order_by('nombre ASC');
        return $this->db->get()->result();
    }

    public function add($nombre)
    {
        $this->db->set('nombre', $nombre);
        $this->db->set('activo', 1);
        $this->db->insert('camiones_preconfigurados');
        
        return $this->db->insert_id();
    }

    public function delete($id) 
    {
        $this->db->set('activo', 0);
        $this->db->where('id_camion_preconfigurado', $id);
        $this->db->update('camiones_preconfigurados');

        return true;
    }

    public function getById($id) 
    {
        $this->db->select('id_camion_preconfigurado, nombre');
        $this->db->from('camiones_preconfigurados');
        $this->db->where('id_camion_preconfigurado', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function update($id, $nombre)
    {
        $this->db->set('nombre', $nombre);
        $this->db->where('id_camion_preconfigurado', $id);
        $this->db->update('camiones_preconfigurados');

        return true;
    }

}