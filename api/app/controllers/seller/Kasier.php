<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kasier extends MY_Controller {

   
   public function __construct()
   {
      parent::__construct();
      $this->load->model('seller/M_Kasier', 'kasier');
      
   }

   public function get_post()
   {
      $result = $this->kasier->get($this->post());

      $this->response($result);
   }

   public function post_post()
   {
      $result = $this->kasier->post($this->post());

      $this->response($result);
   }

}

/* End of file Kasier.php */
