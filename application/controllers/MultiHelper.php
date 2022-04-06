<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MultiHelper extends CI_Controller{

    public function getPuntosDeRetiro(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('Office');

        $cPuntosDeRetiro = $this->Office->getAll();
        
        if(isset($cPuntosDeRetiro) && count($cPuntosDeRetiro)>0){
            $return['success'] = true;    
        }else{
            $return['success'] = false;    
        }
        $return['cPuntosDeRetiro'] = $cPuntosDeRetiro;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));        
    }

    public function getBarrios(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('Barrio');

        $cBarrios = $this->Barrio->getAll();
        
        if(isset($cBarrios) && count($cBarrios)>0){
            $return['success'] = true;    
        }else{
            $return['success'] = false;    
        }
        $return['cBarrios'] = $cBarrios;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getBolson(){
        $this->output->set_content_type('application/json');
        
        $this->load->model('Pocket');
        $oBolson = $this->Pocket->getById(1);

        if(isset($oBolson)){
            $return['success'] = true;    
        }else{
            $return['success'] = false;    
        }
        $return['oBolson'] = $oBolson;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getCostoDeEnvioByBarrio() {
        $this->output->set_content_type('application/json');
        $idBarrio = $this->input->post('idBarrio', true);
        
        $this->load->model('Barrio');
        $oBarrio = $this->Barrio->getById($idBarrio);

        if(isset($oBarrio) && isset($oBarrio->costo_envio)){
            $return['costoEnvio'] = $oBarrio->costo_envio;
            $return['success'] = true;    
        }else{
            $return['costoEnvio'] = 0;
            $return['success'] = false;    
        };
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getDiaEntrega() {
        $this->output->set_content_type('application/json');
        $return['diaEntrega'] = null;
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        
        $this->load->model('DiasEntregaPedidos');
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);

        $return['diaEntrega'] = $oDiaEntrega;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }
}

