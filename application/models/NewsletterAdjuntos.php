<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class NewsletterAdjuntos extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllActive() {
        $this->db->select('*');
        $this->db->from('newsletter_adjuntos');
        $this->db->where('estado',1);
        $result = $this->db->get();
        $result = $result->result();
        return $result;
    }
}