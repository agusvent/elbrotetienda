<?php

class Content extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function get($param) 
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', $param);

        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function set($name, $value) 
    {
        $this->db->where('param_name', $name);
        $this->db->set('param_value', $value);
        $this->db->update('form_parameters');

        return true;
    }

    public function getFormText() 
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'form_text');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getConfirmationLabel() 
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'confirmation_label');
        $result = $this->db->get();
        $result = $result->result()[0];

        return $result->param_value;
    }
    
    public function isFormEnabled()
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'form_enabled');
        $result = $this->db->get();
        $result = $result->result()[0];

        return $result->param_value == 1 ? true : false;
    }

    public function setConfirmationAndText($confirmationText, $formText) 
    {
        // Fecha de confirmación
        /*$this->db->set('param_value', $confirmationText);
        $this->db->where('param_name', 'confirmation_label');
        $this->db->update('form_parameters');*/

        // Texto del formulario
        $this->db->set('param_value', $formText);
        $this->db->where('param_name', 'form_text');
        $this->db->update('form_parameters');

        return true;
    }

    public function getDescripcionBolson() 
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'descripcionBolson');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getDescripcionTienda() 
    {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'descripcionTienda');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getDescripcionBolsonesFormCerrado() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'descripcionBolsonesFormCerrado');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }
    
    public function getDescripcionTiendaFormCerrado() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'descripcionTiendaFormCerrado');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getCostoEnvio() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'costoEnvioPedidos');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getNewsletterEnabled() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'newsletterEnabled');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getModuloCuponesEnabled() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'moduloCuponesEnabled');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }

    public function getRecetarioStatus() {
        $this->db->select('param_value');
        $this->db->from('form_parameters');
        $this->db->where('param_name', 'recetarioStatus');
        $result = $this->db->get();
        $result = $result->result()[0];
        return $result->param_value;
    }
}