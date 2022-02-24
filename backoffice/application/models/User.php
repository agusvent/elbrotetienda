<?php

class User extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function findByUsername(string $username) 
    {
        $this->db->select('id, firstname, lastname, username, email, password, active, created_at, updated_at');
        $this->db->from('users');
        $this->db->where('username', $username);
        $result = $this->db->get();

        return $result->result()[0];
    }
}