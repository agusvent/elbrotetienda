<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class OrdersManager extends CI_Controller{

    public function searchOrdersByDiaActualBolsonAndMailAndPhone(){
        $this->output->set_content_type('application/json');
        
        $mail = $this->input->post('mail', true);
        $telefono = $this->input->post('telefono', true);
        
        $this->load->model('Parameter');

        $diaBolsonActual = $this->Parameter->get('confirmation_label');
        
        $this->load->model('Order');
        $cOrders = $this->Order->getOrdersByDiaBolsonAndMail($diaBolsonActual,$mail,$telefono);

        if(isset($cOrders) && count($cOrders)>0){
            $return['existePedidoCargado'] = true;    
        }else{
            $return['existePedidoCargado'] = false;    
        }
        $return['status'] = "ok";
        $return['diaBolson'] = $diaBolsonActual;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
        
        
    }


}

