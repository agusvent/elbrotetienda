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

    public function verifyExtrasQuantitiesToSubmit() {
        $this->output->set_content_type('application/json');
        $this->load->model('Extra');
        $errores = [];

        $aExtras = json_decode($this->input->post('extras', true));
        foreach($aExtras as $extra){
            $oExtra = $this->Extra->getById($extra->idExtra);
            if($oExtra->stock_ilimitado==0) {
                if(intval($oExtra->stock_disponible) < intval($extra->cantExtra)) {
                    array_push($errores,array(
                        'id_extra' => $oExtra->id,
                        'name' => $oExtra->name,
                        'stock_left' => $oExtra->stock_disponible
                    ));
                }
            }
        }
        $return['continue'] = count($errores)>0 ? false : true;
        $return['error'] = $errores;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function verifyExtrasEnabledByTipoPedido() {
        $this->output->set_content_type('application/json');
        $this->load->model('Extra');
        $errores = [];
        $id_tipo_pedido = $this->input->post('id_tipo_pedido', true);
        $aExtras = json_decode($this->input->post('extras', true));
        
        foreach($aExtras as $extra){
            $oExtra = $this->Extra->getById($extra->idExtra);
            if($id_tipo_pedido == 1) {
                if($oExtra->visible_sucursal == 0) {
                    array_push($errores,array(
                        'id_extra' => $oExtra->id,
                        'name' => $oExtra->name
                    ));
                }
            } else {
                if($oExtra->visible_domicilio == 0) {
                    array_push($errores,array(
                        'id_extra' => $oExtra->id,
                        'name' => $oExtra->name
                    ));
                }                
            }
        }

        $return['extras_enabled'] = count($errores)>0 ? false : true;
        $return['errores'] = $errores;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function validateExtraRequestedCant() {
        $this->output->set_content_type('application/json');
        $this->load->model('Extra');

        $idExtra = intval($this->input->post('idExtra', true));
        $cantRequested = intval($this->input->post('cantRequested', true));

        $oExtra = $this->Extra->getById($idExtra);
        $return['have_stock'] = true;
        $return['stock_disponible'] = 0;
        $this->output->set_status_header(200);

        if ($oExtra->stock_ilimitado==1) {
            return $this->output->set_output(json_encode($return));    
        } else {
            if ($oExtra->stock_disponible<$cantRequested) {
                $return['have_stock'] = false;
                $return['stock_disponible'] = $oExtra->stock_disponible;
            }
        }
        return $this->output->set_output(json_encode($return));
    }

}

