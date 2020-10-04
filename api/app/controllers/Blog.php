<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller {

   
   public function __construct()
   {
      parent::__construct();
      $this->load->model('Blog_model', 'blog');
   }
   

   function index_post()
   {
      $result = $this->blog->index($this->post());

      $this->response($result);
   }

}

/* End of file Blog.php */
