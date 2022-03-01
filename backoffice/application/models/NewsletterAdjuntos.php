<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class NewsletterAdjuntos extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from('newsletter_adjuntos');
        $result = $this->db->get();
        $result = $result->result();
        return $result;
    }

    public function add($nombre, $nombreArchivo)
    {
        $this->db->set('nombre', $nombre);
        $this->db->set('archivo', $nombreArchivo);
        $this->db->insert('newsletter_adjuntos');
        
        return $this->db->insert_id();
    }

    public function setStatus($id, $status)
    {
        $this->db->set('estado', $status);
        $this->db->where('id_adjunto', $id);
        $this->db->update('newsletter_adjuntos');

        return true;
    }

    public function deleteAdjunto($id) {
        //return $this->db->query("delete from newsletter_adjuntos where id_adjunto='".$id."'");    
        $this->db->where("id_adjunto", $id);
        $this->db->delete("newsletter_adjuntos");
        return true;
    }

    public function getById($adjuntoId) {   
        $this->db->select('*');
        $this->db->from('newsletter_adjuntos');
        $this->db->where('id_adjunto', $adjuntoId);

        $result = $this->db->get();
        return $result->result()[0];
    }


}