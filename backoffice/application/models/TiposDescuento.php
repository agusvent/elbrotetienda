<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class TiposDescuento extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from('tipos_descuento');
        $result = $this->db->get();
        return $result->result();
    } 
}