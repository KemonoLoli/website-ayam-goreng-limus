<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
/*  public function __construct(){
    parent::__construct();
    $this->load->library('session');
  }

  public function index(){
    $allowedRoles = array('master', 'owner', 'admin');
    $role = $this->session->userdata('role');
    $role = is_string($role) ? strtolower($role) : NULL;

    if (!in_array($role, $allowedRoles, TRUE)) {
      show_error('Forbidden: insufficient privileges', 403, 'Forbidden');
      return;
    }*/
  public function index(){

    $this->load->view('master_home');
  }
}
