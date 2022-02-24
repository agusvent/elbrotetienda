<?php
if(!defined('BASEPATH')) exit('No direct script access allowed aa');

if(!function_exists('assets')) {
    function assets() 
    {
        return base_url() . 'assets/';
    }
}

if(!function_exists('uploads')) {
    function uploads() 
    {
        return base_url() . 'uploads/';
    }
}

if(!function_exists('valid_session')) {
    function valid_session() 
    {
        $session_vars = ['uid', 'firstname', 'lastname', 'email', 'username'];
        foreach($session_vars as $sv) {
            if(!isset($_SESSION[$sv]) || empty($_SESSION[$sv])) {
                return false;
            }
        }
        return true;
    }
}

if(!function_exists('hashed')) {
    function hashed($input) 
    {
        return password_hash($input, PASSWORD_DEFAULT);
    }
}
