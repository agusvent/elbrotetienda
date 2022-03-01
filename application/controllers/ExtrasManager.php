<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ExtrasManager extends CI_Controller{

    public function getExtrasByTipoPedido(){
        $this->output->set_content_type('application/json');
        
        $idTipoPedido = $this->input->post('idTipoPedido', true);
        $cExtras = [];
        
        $this->load->model('Extra');
        if($idTipoPedido==1){
            $cExtras = $this->Extra->getAllVisiblesInSucursal();
        }else{
            $cExtras = $this->Extra->getAllVisiblesInDomicilio();
        }

        $return['cExtras'] = $cExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getExtrasActivos(){
        $this->output->set_content_type('application/json');
                
        $this->load->model('Extra');
        $cExtras = $this->Extra->getAllWithStock();

        $return['cExtras'] = $cExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

}

