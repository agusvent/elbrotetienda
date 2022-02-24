<?php

class LogisticaDiasEntregaCamiones extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getById($idLogisticaDiaEntregaCamion) 
    {
        $this->db->select('id, id_dia_entrega, camion, id_camion_pre_configurado');
        $this->db->from('logistica_dias_entrega_camiones');
        $this->db->where('id', $idLogisticaDiaEntregaCamion);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getByDiaEntrega($idDiaEntrega) 
    {
        $this->db->select('id, id_dia_entrega, camion, id_camion_pre_configurado');
        $this->db->from('logistica_dias_entrega_camiones');
        $this->db->where('id_dia_entrega', $idDiaEntrega);

        $result = $this->db->get();
        return $result->result();
    }

    public function addCamion($idDiaEntrega, $camion, $idCamionPreConfigurado)
    {
        if(isset($idDiaEntrega) && $idDiaEntrega > 0){
            $this->db->set('id_dia_entrega', $idDiaEntrega);
        }
        if(isset($camion)){
            $this->db->set('camion', $camion);
        }
        if(isset($idCamionPreConfigurado) && $idCamionPreConfigurado > 0){
            $this->db->set('id_camion_pre_configurado', $idCamionPreConfigurado);
        }

        $this->db->insert('logistica_dias_entrega_camiones');
        
        return $this->db->insert_id();
    }

    public function getCamionesPreConfiguradosDisponibles($idDiaEntrega){
        $this->db->select('cpc2.id_camion_preconfigurado, cpc2.nombre');
        $this->db->from('camiones_preconfigurados as cpc2');
        $where = "cpc2.id_camion_preconfigurado not in (select cpc.id_camion_preconfigurado from camiones_preconfigurados as cpc left join logistica_dias_entrega_camiones as ldec on cpc.id_camion_preconfigurado = ldec.id_camion_pre_configurado where ldec.id_dia_entrega  = $idDiaEntrega ) AND cpc2.activo=1";
        $this->db->where($where);        
        $this->db->order_by('cpc2.nombre ASC');
        $cCamionesPreConfiguradosDisponibles = $this->db->get()->result();      
        return $cCamionesPreConfiguradosDisponibles;
    }

    public function deleteCamionesByDia($idDiaEntrega){
        $this->db->where('id_dia_entrega', $idDiaEntrega);
        $this->db->delete('logistica_dias_entrega_camiones');

        return true;        
    }

    public function deleteCamionById($idLogisticaCamion){
        $this->db->where('id', $idLogisticaCamion);
        $this->db->delete('logistica_dias_entrega_camiones');

        return true;                
    }
    
}