<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function add($message, $file, $line, $extra)
    {
        $this->db->set('message', $message);
        $this->db->set('file', $file);
        $this->db->set('line', $line);
        $this->db->set('extra', $extra);

        $this->db->insert('errors');
    }
}
