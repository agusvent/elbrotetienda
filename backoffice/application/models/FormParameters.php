<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parameter extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function get($name) {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', $name);
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }
}