<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function index()
    {
        if(valid_session()) {
            redirect('/overview');
        }
        $this->load->view('visitor/head');
        $loginData = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash() 
        ];
        if(isset($this->session->login_error)) {
            $loginData['error'] = $this->session->login_error;
            unset($_SESSION['login_error']);
        }
        $this->load->view('visitor/login', $loginData);
        $this->load->view('visitor/footer');
    }

    public function process() 
    {
        if(valid_session()) {
            redirect('/overview');
        }
        $username = $this->input->post('username', true);
        $password = $this->input->post('password');

        if(empty($username) || empty($password)) {
            $error = "El nombre de usuario y la contraseña son obligatorios.";
        }else{
            $this->load->model('user');
            $userResult = $this->user->findByUsername($username);
            if(!is_object($userResult)) {
                $error = "Usuario inexistente.";
            }else{
                if(password_verify($password, $userResult->password)) {
                    $this->session->set_userdata([
                        'uid'       => $userResult->id,
                        'firstname' => $userResult->firstname,
                        'lastname'  => $userResult->lastname,
                        'email'     => $userResult->email,
                        'username'  => $userResult->username
                    ]);
                }else{
                    $error = "Datos incorrectos.";
                }
            }
        }
        
        if(isset($error)) {
            $this->session->login_error = $error;
            redirect('/');
        }else{
            redirect('/overview');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}