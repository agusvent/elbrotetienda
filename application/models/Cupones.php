<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cupones extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }

    public function getByCodigo($codigoCupon) {
        $this->db->select('c.id_cupon as idCupon, c.codigo, c.descuento, td.id_tipo_descuento as idTipoDescuento, td.descripcion as descripcionTipoDescuento');
        $this->db->from('cupones as c');
        $this->db->join('tipos_descuento as td', 'td.id_tipo_descuento = c.id_tipo_descuento', 'left');
        $where = "c.codigo = '$codigoCupon' AND c.activo = 1 AND c.eliminado = 0";
        $this->db->where($where);        
        $result = $this->db->get()->result()[0];    
        return $result;
    }
}