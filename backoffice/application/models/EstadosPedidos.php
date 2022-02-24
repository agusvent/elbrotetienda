<?php

class EstadosPedidos extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('id_estado_pedido as "idEstadoPedido", descripcion');
        $this->db->from('estados_pedidos');
        $this->db->order_by('descripcion', 'ASC');

        $result = $this->db->get();
        return $result->result();
    }

    public function getById($idEstadoPedido)
    {
        $this->db->select('id_estado_pedido as "idEstadoPedido", descripcion');
        $this->db->from('estados_pedidos');
        $this->db->where('id_estado_pedido', $idEstadoPedido);

        $result = $this->db->get();
        return $result->result()[0];
    }
}
