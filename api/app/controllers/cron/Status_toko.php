<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Status_toko extends MY_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('cron/M_Status_toko', 'status');
   }

   function index_get()
   {
      $result = $this->status->index();

      $this->response($result);
   }
   

}

/* End of file Status_toko.php */
