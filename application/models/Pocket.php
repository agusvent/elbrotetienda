<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pocket extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll() 
    {
        $this->db->select('id, name, price, delivery_price,cant');
        $this->db->from('pockets');
        $this->db->where('active', 1);

        return $this->db->get()->result();
    }

    public function getById($id) 
    {
        $this->db->select('id, name, price, delivery_price,cant');
        $this->db->from('pockets');
        //$this->db->where('active', 1);
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }
}