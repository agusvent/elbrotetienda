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

    public function getById($newsletterId) {   
        $this->db->select('*');
        $this->db->from('newsletter');
        $this->db->where('id_newsletter', $newsletterId);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getByMail($mail) {
        $this->db->select('*');
        $this->db->from('newsletter');
        $where = "mail = '$mail' AND activo = 1";
        $this->db->where($where);        
        $result = $this->db->get()->result()[0];
        return $result;
    }

    public function add($mail) {
        $this->db->set('mail', $mail);
        $this->db->insert('newsletter');
        
        return $this->db->insert_id();
    }    

    public function remove($id) {
        $this->db->set('activo', 0);
        $this->db->where('id', $id);
        $this->db->update('newsletter');
        return true;
    }    
}