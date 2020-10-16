<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sinkron extends MY_Controller {

   
   public function __construct()
   {
      parent::__construct();
      $this->load->model('M_Sinkron', 'sinkron');
   }

   public function etalase_get()
   {
      $result = $this->sinkron->etalase($this->get());

      $this->response($result);
   }

   public function produk_get()
   {
      $result = $this->sinkron->produk($this->get());

      $this->response($result);
   }

}

/* End of file Singkron.php */
