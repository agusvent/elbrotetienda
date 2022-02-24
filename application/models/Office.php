<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Office extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function getAll() 
    {
        $this->db->select('id, name, address');
        $this->db->from('offices');
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->order_by('name', 'ASC');

        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('id, name, address');
        $this->db->from('offices');
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }
}
