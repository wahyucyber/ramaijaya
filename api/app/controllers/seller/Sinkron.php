<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sinkron extends MY_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('seller/M_Sinkron', 'sinkron');
   }

   function sync_key_post()
   {
      $result = $this->sinkron->sync_key($this->post());

      $this->response($result);
   }

   function sync_key_save_post()
   {
      $result = $this->sinkron->sync_key_save($this->post());

      $this->response($result);
   }

   function etalase_post()
   {
      $result = $this->sinkron->etalase($this->post());

      $this->response($result);
   }

   function produk_post()
   {
      $result = $this->sinkron->produk($this->post());

      $this->response($result);
   }
   

}

/* End of file Sinkron.php */
