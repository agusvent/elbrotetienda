<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Extra extends CI_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden');
        $this->db->from('extra_products');
        $this->db->where('active', 1);
        $this->db->where('id !=', '1');
        $this->db->order_by('orden', 'ASC');

        return $this->db->get()->result();
    }

    public function getById($id) 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, visible_domicilio, visible_sucursal');
        $this->db->from('extra_products');
        $this->db->where('active', 1);
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getAllVisiblesInSucursal() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden');
        $this->db->from('extra_products');
        /*$this->db->where('active', 1);
        $this->db->where('visible_sucursal', 1);
        $this->db->where('stock_disponible >', 0);
        $this->db->or_where('stock_ilimitado', 1);
        */
        $this->db->where("active=1 AND visible_sucursal=1 AND (stock_disponible>0 OR stock_ilimitado=1)");

        $this->db->order_by('orden', 'ASC');


        return $this->db->get()->result();
    }

    public function getAllVisiblesInDomicilio() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden');
        $this->db->from('extra_products as ep');
        /*$this->db->where('active', 1);
        $this->db->where('visible_domicilio', 1);
        $this->db->where('stock_disponible >', 0);
        $this->db->or_where('stock_ilimitado', 1);
        */
        $this->db->where("ep.active=1 AND ep.visible_domicilio=1 AND (ep.stock_disponible>0 OR ep.stock_ilimitado=1)");
        $this->db->order_by('orden', 'ASC');

        return $this->db->get()->result();
    }

    public function reducirStockExtra($extraId,$cant){
        $extra = $this->getById($extraId);
        if($extra->stock_ilimitado == 0){
            $stock = $extra->stock_disponible;
            $stock = $stock - $cant;
            $this->db->set('stock_disponible', $stock);
            $this->db->where('id', $extraId);
            $this->db->update('extra_products');
        }
 
        return true;
    }

    public function getAllWithStock() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden');
        $this->db->from('extra_products');
        //"id!=1" se pone para que no traiga a la parte de extras el bolson individual.
        $this->db->where("id!=1 AND active=1 AND (stock_disponible>0 OR stock_ilimitado=1)");
        $this->db->order_by('orden', 'ASC');

        return $this->db->get()->result();
    }

}