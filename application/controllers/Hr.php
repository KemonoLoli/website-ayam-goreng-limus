<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends CI_Controller {
  public function attendance(){
    // TODO: terapkan RBAC — master/owner/admin: bebas pilih karyawan, staf biasa: lock ke sesi user
    $this->load->view('hr_attendance');
  }
}
