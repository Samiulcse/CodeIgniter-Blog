<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index(){

        $data['title']="Admin Panel";

       $this->load->view('backend/template/header',$data);
       $this->load->view('backend/dashboard');
       $this->load->view('backend/template/footer');
    }
}