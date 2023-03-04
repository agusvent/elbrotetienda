<?php

class Extra extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->select('id, name, price, active, visible_domicilio, visible_sucursal, imagen, stock_disponible, stock_ilimitado, orden, orden_listados, eliminado');
        $this->db->from('extra_products');
        $this->db->where('eliminado', 0);
        $this->db->order_by('active DESC');
        $this->db->order_by('orden ASC');
        return $this->db->get()->result();
    }

    public function getActive()
    {
        $this->db->select('id, name, nombre_corto, price, active, visible_domicilio, visible_sucursal, imagen, stock_disponible, stock_ilimitado, orden, orden_listados');
        $this->db->from('extra_products');
        $this->db->where('active', 1);
        $this->db->order_by('orden_listados ASC');
        return $this->db->get()->result();
    }

    public function getById($extraId) 
    {
        $this->db->select('id, name, nombre_corto, price, active, visible_domicilio, visible_sucursal, imagen, stock_disponible, stock_ilimitado, orden, orden_listados');
        $this->db->from('extra_products');
        $this->db->where('id', $extraId);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function add($name, $nombreCorto, $price)
    {
        $this->db->set('name', $name);
        if(isset($nombreCorto) && $nombreCorto!=""){
            $this->db->set('nombre_corto', $nombreCorto);
        }
        $this->db->set('price', $price);
        $this->db->insert('extra_products');
        
        return $this->db->insert_id();
    }

    public function update($id, $name, $nombreCorto, $price,$extraStockDisponible, $orden, $ordenListados)
    {
        $this->db->set('name', $name);
        if(isset($nombreCorto) && $nombreCorto!=""){
            $this->db->set('nombre_corto', $nombreCorto);
        }
        $this->db->set('price', $price);
        $this->db->set('stock_disponible', $extraStockDisponible);
        $this->db->set('orden', $orden);
        $this->db->set('orden_listados', $ordenListados);
        $this->db->where('id', $id);
        $this->db->update('extra_products');

        return true;
    }

    public function updateImage($id, $imageFile)
    {
        $this->db->set('imagen', $imageFile);
        $this->db->where('id', $id);
        $this->db->update('extra_products');

        return true;
    }

    public function delete($id) 
    {
        $this->db->set('eliminado', 1);
        $this->db->set('active', 0);
        $this->db->where('id', $id);
        $this->db->update('extra_products');
        return true;
    }

    public function setActive($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->set('active', $status);
        $this->db->update('extra_products');

        return true;
    }

    public function setVisibleSucursal($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->set('visible_sucursal', $status);
        $this->db->update('extra_products');

        return true;
    }

    public function setVisibleDomicilio($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->set('visible_domicilio', $status);
        $this->db->update('extra_products');

        return true;
    }

    public function getAllVisiblesInSucursal() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden, orden_listados, nombre_corto');
        $this->db->from('extra_products');
        /*$this->db->where('active', 1);
        $this->db->where('visible_sucursal', 1);
        $this->db->where('stock_disponible >', 0);
        $this->db->or_where('stock_ilimitado', 1);
        */
        $this->db->where("active=1 AND visible_sucursal=1 AND (stock_disponible>0 OR stock_ilimitado=1)");

        $this->db->order_by('orden_listados', 'ASC');


        return $this->db->get()->result();
    }

    public function getAllVisiblesInDomicilio() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden, orden_listados, nombre_corto');
        $this->db->from('extra_products as ep');
        /*$this->db->where('active', 1);
        $this->db->where('visible_domicilio', 1);
        $this->db->where('stock_disponible >', 0);
        $this->db->or_where('stock_ilimitado', 1);
        */
        $this->db->where("ep.active=1 AND ep.visible_domicilio=1 AND (ep.stock_disponible>0 OR ep.stock_ilimitado=1)");
        $this->db->order_by('orden_listados', 'ASC');

        return $this->db->get()->result();
    }

    public function getAllVisiblesInSucursalConSinStock() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden, orden_listados, nombre_corto');
        $this->db->from('extra_products');
        /*
        No filtro por los que tengan stock o sean ilimitados porque en el editar pedido, puedo estar teniendo
        un extra en el pedido que ya no tenga stock. Si es así, ese extra no se va a mostrar y necesito verlo 
        porque es parte del pedido. Lo controlo en los js para ocultar el que no tenga que ir
        */
        $this->db->where("active=1 AND visible_sucursal=1");

        $this->db->order_by('orden_listados', 'ASC');


        return $this->db->get()->result();
    }

    public function getAllVisiblesInDomicilioConSinStock() 
    {
        $this->db->select('id, name, price, imagen, stock_disponible, stock_ilimitado, orden, orden_listados, nombre_corto');
        $this->db->from('extra_products as ep');
        /*
        No filtro por los que tengan stock o sean ilimitados porque en el editar pedido, puedo estar teniendo
        un extra en el pedido que ya no tenga stock. Si es así, ese extra no se va a mostrar y necesito verlo 
        porque es parte del pedido. Lo controlo en los js para ocultar el que no tenga que ir
        */
        $this->db->where("ep.active=1 AND ep.visible_domicilio=1");
        $this->db->order_by('orden_listados', 'ASC');

        return $this->db->get()->result();
    }

    public function setStockIlimitado($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->set('stock_ilimitado', $status);
        $this->db->update('extra_products');

        return true;
    }

    public function resetStockDisponible($id)
    {
        $this->db->where('id', $id);
        $this->db->set('stock_disponible', 0);
        $this->db->update('extra_products');

        return true;
    }

    public function aumentarStockExtra($extraId){
        $extra = $this->getById($extraId);
        if($extra->stock_ilimitado == 0){
            $stock = $extra->stock_disponible;
            $stock = $stock + 1;
            $this->db->set('stock_disponible', $stock);
            $this->db->where('id', $extraId);
            $this->db->update('extra_products');
        }
 
        return true;
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

}