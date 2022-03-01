<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cupones extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $this->db->select('c.id_cupon, c.codigo, c.descuento, c.activo, td.id_tipo_descuento, td.descripcion');
        $this->db->from('cupones as c');
        $this->db->join('tipos_descuento as td', 'td.id_tipo_descuento = c.id_tipo_descuento', 'left');
        $this->db->where('eliminado', 0);
        $this->db->order_by('c.codigo', 'ASC');
        $result = $this->db->get();
        return $result->result();
    } 

    public function getAllActivos() {
        $this->db->select('c.id_cupon, c.codigo, c.descuento, c.activo, td.id_tipo_descuento, td.descripcion');
        $this->db->from('cupones as c');
        $this->db->join('tipos_descuento as td', 'td.id_tipo_descuento = c.id_tipo_descuento', 'left');
        $this->db->where('eliminado', 0);
        $this->db->where('activo', 1);
        $this->db->order_by('c.codigo', 'ASC');
        $result = $this->db->get();
        return $result->result();
    } 

    public function getById($idCupon) {
        $this->db->select('c.id_cupon, c.codigo, c.descuento, c.activo, td.id_tipo_descuento, td.descripcion');
        $this->db->from('cupones as c');
        $this->db->join('tipos_descuento as td', 'td.id_tipo_descuento = c.id_tipo_descuento', 'left');
        $this->db->where('id_cupon', $idCupon);
        $result = $this->db->get();
        return $result->result()[0];
    } 

    public function add($codigoCupon,$idTipoDescuento,$descuento)
    {
        $this->db->set('codigo', $codigoCupon);
        $this->db->set('id_tipo_descuento', $idTipoDescuento);
        $this->db->set('descuento', $descuento);
        $this->db->set('activo', 1);
        $this->db->set('eliminado', 0);
        $this->db->insert('cupones');
        
        return $this->db->insert_id();
    }

    public function update($idCupon, $codigoCupon, $idTipoDescuento, $descuento)
    {
        $this->db->set('codigo', $codigoCupon);
        $this->db->set('id_tipo_descuento', $idTipoDescuento);
        $this->db->set('descuento', $descuento);
        $this->db->where('id_cupon', $idCupon);
        $this->db->update('cupones');
        
        return true;
    }

    public function delete($id) {
        $this->db->set('eliminado', 1);
        $this->db->where('id_cupon', $id);
        $this->db->update('cupones');

        return true;
    }

    public function updateStatus($idCupon, $status) {
        $this->db->set('activo', $status);
        $this->db->where('id_cupon', $idCupon);
        $this->db->update('cupones');
        
        return true;
    }

}