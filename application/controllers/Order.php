<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
  public function guest(){
    $data = [
      'after_order_url' => site_url('order/thanks') // opsional
    ];
    $this->load->view('order_guest', $data);
  }
  public function thanks(){
    $this->load->view('order_thanks'); // buat nanti (bukti/QR/konfirmasi)
  }
}
