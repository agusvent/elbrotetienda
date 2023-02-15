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

    public function getBarriosHabilitados(){
        $this->output->set_content_type('application/json');
        $this->load->model('Barrio');

        $idDiaEntrega = $this->input->post('idDiaEntrega', true);

        $cBarriosHabilitados = $this->Barrio->getBarriosHabilitadosByDiaEntrega($idDiaEntrega);
        
        if(isset($cBarriosHabilitados) && count($cBarriosHabilitados)>0){
            $return['success'] = true;    
        }else{
            $return['success'] = false;    
        }
        $return['cBarriosHabilitados'] = $cBarriosHabilitados;
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
        $this->load->model('DiasEntregaPedidos');
        $oDiaEntrega = $this->DiasEntregaPedidos->getDiaGenerico();

        $return['diaEntrega'] = $oDiaEntrega;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getDiaEntregaEnabled() {
        $this->output->set_content_type('application/json');
        $return['diaEntregaEnabled'] = false;
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
        
        $this->load->model('DiasEntregaPedidos');
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        
        if($oDiaEntrega->acepta_pedidos == 1) {
            $return['dia_entrega_enabled'] = true;
        }
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getFormasPagoByImporte() {
        $this->output->set_content_type('application/json');
        $this->load->model('FormasPago');
        $this->load->model('Parameter');

        $importe = intval($this->input->post('importe_total', true));
        $limiteImporte = intval($this->Parameter->get('limite_pago_efectivo'));
        $cFormasPago = null;
        
        if($importe > $limiteImporte) {
            //ID=2 ==> Mercado Pago
            $cFormasPago = $this->FormasPago->getById(2);
        } else {
            $cFormasPago = $this->FormasPago->getAll();

        }

        $return['cFormasPago'] = $cFormasPago;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
    }

    public function getTiendaAbierta() {
        $this->output->set_content_type('application/json');
        $this->load->model('Parameter');

        $tiendaOpen = intval($this->Parameter->get('form_enabled'));
        if($tiendaOpen == 1) {
            $tiendaOpen = true;
        } else {
            $tiendaOpen = false;
        } 
        $return['tienda_open'] = $tiendaOpen;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));       
    }

    public function getTiendaFueraDeHorario() {
        $this->output->set_content_type('application/json');
        $this->load->model('Parameter');

        $pedidosFueraDeHorario = intval($this->Parameter->get('pedidos_fuera_de_hora_enabled'));
        if($pedidosFueraDeHorario == 1) {
            $pedidosFueraDeHorario = true;
        } else {
            $pedidosFueraDeHorario = false;
        } 
        $return['fuera_horario'] = $pedidosFueraDeHorario;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));       
    }
}