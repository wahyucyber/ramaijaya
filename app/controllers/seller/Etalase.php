<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Etalase extends MY_Seller {
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function index()
   {
      $data['title'] = 'Manajemen Etalase';
		$params['view'] = 'seller/etalase';
		$params['js'] = 'seller/etalase';

      $this->load_view($params,$data);
   }

}

/* End of file Etalase.php */
