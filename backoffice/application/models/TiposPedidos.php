<?php

class TiposPedidos extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->select('id_tipo_pedido as "idTipoPedido", descripcion, codigo');
        $this->db->from('tipos_pedidos');
        $this->db->order_by('descripcion', 'DESC');

        $result = $this->db->get();
        return $result->result();
    }

    public function getById($idTipoPedido)
    {
        $this->db->select('id_tipo_pedido as "idTipoPedido", descripcion, codigo');
        $this->db->from('tipos_pedidos');
        $this->db->where('id_tipo_pedido', $idTipoPedido);

        $result = $this->db->get();
        return $result->result()[0];
    }
}
