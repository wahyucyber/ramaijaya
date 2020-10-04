<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends MY_Model {

   private $slider = "mst_slider";
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function index($params)
   {
      $slug = $params['slug'];

      if(empty($slug)) {
         $output = array(
            'Error' => true,
            'Message' => 'slug is required.'
         );
         goto output;
      }

      $get_slider = $this->db->query("
         SELECT
            id,
            title,
            CONCAT('".base_url()."', banner) AS banner,
            title,
            slug,
            body,
            created_at
         FROM
            $this->slider
         WHERE
            slug = '$slug'
         LIMIT 0, 1
      ")->result_array();

      $output['Error'] = false;
      $output['Message'] = "success.";
      $output['Data'] = [];
      $no = 0;
      foreach ($get_slider as $key) {
         $output['Data'][$no++] = $key;
      }

      output:
      return $output;
   }
   

}

/* End of file Blog_model.php */
