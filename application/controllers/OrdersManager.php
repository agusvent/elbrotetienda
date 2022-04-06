<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class OrdersManager extends CI_Controller{

    public function searchOrdersByDiaActualBolsonAndMailAndPhone(){
        $this->output->set_content_type('application/json');
        
        $mail = $this->input->post('mail', true);
        $telefono = $this->input->post('telefono', true);
        $idDiaEntrega = $this->input->post('idDiaEntrega', true);
                
        $this->load->model('Order');
        $this->load->model('DiasEntregaPedidos');
        
        $oDiaEntrega = $this->DiasEntregaPedidos->getById($idDiaEntrega);
        
        $cOrders = $this->Order->getOrdersByDiaBolsonAndMail($idDiaEntrega,$mail,$telefono);

        if(isset($cOrders) && count($cOrders)>0){
            $return['existePedidoCargado'] = true;    
        }else{
            $return['existePedidoCargado'] = false;    
        }
        $return['status'] = "ok";
        $return['diaBolson'] = $oDiaEntrega->descripcion;
        $this->output->set_status_header(200);
        return $this->output->set_output(json_encode($return));
        
        
    }


}

