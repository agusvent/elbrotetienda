<?php

class Pocket extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('id, name, price, delivery_price, active, cant');
        $this->db->from('pockets');
        $this->db->where('active', 1);
        $result = $this->db->get();
        return $result->result();
    }

    public function getById($pocketId)
    {   
        $this->db->select('id, name, price, delivery_price, active, cant');
        $this->db->from('pockets');
        $this->db->where('id', $pocketId);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function add($name, $price, $deliverPrice)
    {
        $this->db->set('name', $name);
        $this->db->set('price', $price);
        $this->db->set('delivery_price', $deliverPrice);
        $this->db->insert('pockets');
        
        return $this->db->insert_id();
    }

    public function update($id, $name, $price, $deliverPrice)
    {
        $this->db->set('name', $name);
        $this->db->set('price', $price);
        $this->db->set('delivery_price', $deliverPrice);
        $this->db->where('id', $id);
        $this->db->update('pockets');

        return true;
    }

    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('pockets');

        return true;
    }

    public function setActive($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->set('active', $status);
        $this->db->update('pockets');

        return true;
    }
}