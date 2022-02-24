<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from('newsletter');
        $this->db->where('activo', 1);
        $result = $this->db->get();
        return $result->result();
    } 
}