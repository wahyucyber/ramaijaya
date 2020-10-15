<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Etalase extends MY_Controller {
   
   public function __construct()
   {
      parent::__construct();
      $this->load->model('seller/M_Etalase', 'etalase');
   }

   function add_post()
   {
      $result = $this->etalase->add($this->post());

      $this->response($result);
   }

   function get_post()
   {
      $result = $this->etalase->get($this->post());

      $this->response($result);
   }

   function update_post()
   {
      $result = $this->etalase->update($this->post());

      $this->response($result);
   }

   function delete_post()
   {
      $result = $this->etalase->delete($this->post());

      $this->response($result);
   }

}

/* End of file Etalase.php */
