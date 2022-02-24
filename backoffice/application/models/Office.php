<?php

class Office extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('id, name, address, active');
        $this->db->from('offices');
        $this->db->where('deleted', 0);
        $this->db->order_by('name', 'ASC');

        $result = $this->db->get();
        return $result->result();
    }

    public function getAllOrderesByNameASC()
    {
        $this->db->select('id, name, address, active');
        $this->db->from('offices');
        $this->db->where('deleted', 0);
        $this->db->order_by('name', 'ASC');

        $result = $this->db->get();
        return $result->result();
    }

    public function getById($officeId)
    {
        $this->db->select('id, name, address, active');
        $this->db->from('offices');
        $this->db->where('id', $officeId);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->set('deleted', 1);
        $this->db->update('offices');

        return true;
    }

    public function update($id, $name, $address) 
    {
        $this->db->where('id', $id);
        $this->db->set('name', $name);
        $this->db->set('address', $address);
        $this->db->update('offices');

        return true;
    }

    public function setActive($id, $active)
    {
        $this->db->where('id', $id);
        $this->db->set('active', $active);
        $this->db->update('offices');

        return true;
    }

    public function add($name, $address) 
    {
        $this->db->set('name', $name);
        $this->db->set('address', $address);
        $this->db->set('active', 1);
        $this->db->insert('offices');

        return $this->db->insert_id();
    }
    
    public function getAllPuntosDeRetiroSinAsociar() 
    {
        $this->db->select('o.id, o.name, o.active, o.deleted');
        $this->db->from('offices as o');
        $this->db->where("o.active=1 and o.deleted = 0 and o.id not in (select cpcpb.id_punto_retiro from camiones_preconfigurados_puntos_barrios as cpcpb where cpcpb.id_barrio is null)");
        $this->db->order_by('o.name', 'ASC');

        return $this->db->get()->result();
    }
    
}
