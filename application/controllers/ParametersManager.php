<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ParametersManager extends CI_Controller{

    public function getMontoMinimoPedidoExtras(){
        $this->output->set_content_type('application/json');

        $this->load->model('Parameter');
        $montoMinimoPedidoExtras = $this->Parameter->get('montoMinimoPedidosExtras');

        if( isset($montoMinimoPedidoExtras)){
            $return['success'] = true;
        }else{
            $return['success'] = false;
        }
        $return['montoMinimoPedidoExtras'] = $montoMinimoPedidoExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getMontoMinimoEnvioSinCargoPedidoExtras(){
        $this->output->set_content_type('application/json');

        $this->load->model('Parameter');
        $montoMinimoEnvioSinCargoPedidoExtras = $this->Parameter->get('montoMinimoPedidosExtrasEnvioSinCargo');

        if( isset($montoMinimoEnvioSinCargoPedidoExtras)){
            $return['success'] = true;
        }else{
            $return['success'] = false;
        }
        $return['montoMinimoEnvioSinCargoPedidoExtras'] = $montoMinimoEnvioSinCargoPedidoExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }


    public function getCostoDeEnvioPedidoConBolson(){
        $this->output->set_content_type('application/json');

        $this->load->model('Parameter');
        $costoEnvioPedidosConBolson = $this->Parameter->get('costoEnvioPedidos');

        if( isset($costoEnvioPedidosConBolson)){
            $return['success'] = true;
        }else{
            $return['success'] = false;
        }
        $return['costoEnvioPedidosConBolson'] = $costoEnvioPedidosConBolson;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getCostoEnvioPedidoExtras(){
        $this->output->set_content_type('application/json');

        $this->load->model('Parameter');
        $costoEnvioPedidoExtras = $this->Parameter->get('costoEnvioPedidosExtras');

        if( isset($costoEnvioPedidoExtras)){
            $return['success'] = true;
        }else{
            $return['success'] = false;
        }
        $return['costoEnvioPedidoExtras'] = $costoEnvioPedidoExtras;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getTipoPedidoHasPedidosExtrasHabilitado(){
        $this->output->set_content_type('application/json');
        
        $return['success'] = false;
        $tipoPedidoHasPedidosExtrasHabilitado = 0; //ESTE SE VA A DEVOLVER

        $currentForm = $this->input->post('currentForm', true);

        $this->load->model('Parameter');
        
        if($currentForm==1){
            $tipoPedidoHasPedidosExtrasHabilitado = (int)$this->Parameter->get('pedidoExtrasPuntoDeRetiroHabilitado');
            $return['success'] = true;
        }else if($currentForm==2){
            $tipoPedidoHasPedidosExtrasHabilitado = (int)$this->Parameter->get('pedidoExtrasDomicilioHabilitado');
            $return['success'] = true;
        }
        
        $return['tipoPedidoHasPedidosExtrasHabilitado'] = $tipoPedidoHasPedidosExtrasHabilitado;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getValorReservaByValorInRango(){
        
        $this->output->set_content_type('application/json');
        
        $return['success'] = false;
        $valorReserva = 0; //ESTE SE VA A DEVOLVER
        
        $monto = $this->input->post('monto', true);
        $monto = (int)$monto;
        $this->load->model('Parameter');
        //$valorReserva = (int)$this->Parameter->get('valorReservaRango3');
        if($monto >= 0 && $monto <= 2500){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango1');
            $return['success'] = true;
        }else if($monto >= 2501 && $monto <= 3999){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango2');
            $return['success'] = true;
        }else if($monto >= 4000){
            $valorReserva = (int)$this->Parameter->get('valorReservaRango3');
            $return['success'] = true;
        }
                
        $return['valorReserva'] = $valorReserva;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getFormStatus() {
        
        $this->output->set_content_type('application/json');
        
        $this->load->model('Parameter');
        
        $formEnabled = (int)$this->Parameter->get('form_enabled');
        $return['formEnabled'] = $formEnabled;
        
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getNewsletterEnabled() {
        $this->output->set_content_type('application/json');
        $this->load->model('Parameter');

        $newsletterEnabled = false;
        
        $idNewsletterEnabled = (int)$this->Parameter->get('newsletterEnabled');
        if($idNewsletterEnabled==1) {
            $newsletterEnabled = true;
        }
        $return['newsletterEnabled'] = $newsletterEnabled;
        
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }

    public function getModuloCuponesEnabled() {
        $this->output->set_content_type('application/json');
        $this->load->model('Parameter');

        $moduloCuponesEnabled = false;
        
        $moduloCuponesEnabled = (int)$this->Parameter->get('moduloCuponesEnabled');
        if($moduloCuponesEnabled==1) {
            $moduloCuponesEnabled = true;
        }
        $return['moduloCuponesEnabled'] = $moduloCuponesEnabled;
        
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));           
    }
}

