<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }
   
   public function index($slug = null)
   {
      if(empty($slug) || !$slug) {
         redirect(base_url(''));
      }

      $params['view'] = "blog";
      $params['js'] = "blog";
      $data['title'] = $slug;
      $data['slug'] = $slug;
      $this->load_view($params, $data);
   }

}

/* End of file Blog.php */
