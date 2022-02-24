<?php

class CamionesPreConfiguradosPuntosBarrios extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getAll()
    {
        $this->db->select('id, id_camion_preconfigurado, id_punto_retiro, id_barrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->order_by('id ASC');
        return $this->db->get()->result();
    }

    public function addPuntoRetiro($id_camion_preconfigurado, $id_punto_retiro)
    {
        $this->db->set('id_camion_preconfigurado', $id_camion_preconfigurado);
        $this->db->set('id_punto_retiro', $id_punto_retiro);
        $this->db->insert('camiones_preconfigurados_puntos_barrios');
        
        return $this->db->insert_id();
    }

    public function addBarrio($id_camion_preconfigurado, $id_barrio)
    {
        $this->db->set('id_camion_preconfigurado', $id_camion_preconfigurado);
        $this->db->set('id_barrio', $id_barrio);
        $this->db->insert('camiones_preconfigurados_puntos_barrios');
        
        return $this->db->insert_id();
    }

    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('camiones_preconfigurados_puntos_barrios');

        return true;
    }

    public function getById($id) 
    {
        $this->db->select('id, id_camion_preconfigurado, id_punto_retiro, id_barrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->where('id', $id);

        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getByIdCamionPreConfiguradoAndIdPuntoRetiro($idCamionPreConfigurado,$idPuntoRetiro) 
    {
        $this->db->select('id, id_camion_preconfigurado, id_punto_retiro, id_barrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->where("id_camion_preconfigurado",$idCamionPreConfigurado);
        $this->db->where("id_punto_retiro",$idPuntoRetiro);
        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getByIdCamionPreConfiguradoAndIdBarrio($idCamionPreConfigurado,$idBarrio) 
    {
        $this->db->select('id, id_camion_preconfigurado, id_punto_retiro, id_barrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->where("id_camion_preconfigurado",$idCamionPreConfigurado);
        $this->db->where("id_barrio",$idBarrio);
        $result = $this->db->get();
        return $result->result()[0];
    }

    public function getAllPuntosRetiroByIdCamionPreConfigurado($idCamionPreConfigurado) 
    {
        $this->db->select('id, id_camion_preconfigurado, id_punto_retiro as idPuntoRetiro');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->where("id_camion_preconfigurado",$idCamionPreConfigurado);
        $result = $this->db->get();
        return $result->result();
    }

    public function getAllBarriosByIdCamionPreConfigurado($idCamionPreConfigurado) 
    {
        $this->db->select('id, id_camion_preconfigurado, id_barrio AS idBarrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios');
        $this->db->where("id_camion_preconfigurado",$idCamionPreConfigurado);
        $result = $this->db->get();
        return $result->result();
    }

    public function getAllPuntosRetiroExcludingIdCamionPreConfigurado($idCamionPreConfigurado) 
    {
        $this->db->select('cpcpb.id, cpcpb.id_camion_preconfigurado, cpc.nombre as camionAsociado, cpcpb.id_punto_retiro as idPuntoRetiro');
        $this->db->from('camiones_preconfigurados_puntos_barrios as cpcpb');
        $this->db->join('camiones_preconfigurados as cpc', 'cpcpb.id_camion_preconfigurado = cpc.id_camion_preconfigurado', 'left');
        $this->db->where("cpcpb.id_camion_preconfigurado not in (".$idCamionPreConfigurado.")");
        $result = $this->db->get();
        return $result->result();
    }

    public function getAllBarriosExcludingIdCamionPreConfigurado($idCamionPreConfigurado){
        $this->db->select('cpcpb.id, cpcpb.id_camion_preconfigurado, cpc.nombre as camionAsociado, cpcpb.id_barrio as idBarrio');
        $this->db->from('camiones_preconfigurados_puntos_barrios as cpcpb');
        $this->db->join('camiones_preconfigurados as cpc', 'cpcpb.id_camion_preconfigurado = cpc.id_camion_preconfigurado', 'left');
        $this->db->where("cpcpb.id_camion_preconfigurado not in (".$idCamionPreConfigurado.")");
        $result = $this->db->get();
        return $result->result();
    }
}