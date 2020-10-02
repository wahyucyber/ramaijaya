<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Diskon extends MY_Model {

   protected $produk = "mst_produk";
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function index()
   {
      $produk = $this->db->query("
         SELECT
            id,
            diskon_ke
         FROM
            $this->produk
         WHERE
            diskon != 0 AND
            diskon_dari IS NOT NULL AND
            diskon_ke IS NOT NULL
      ")->result_array();

      $update = [];
      $update_no = 0;
      foreach ($produk as $key) {
         if(strtotime($key['diskon_ke']) < strtotime(date('Y-m-d'))) {
            $update[$update_no++] = array(
               'id' => $key['id'],
               'diskon' => 0,
               'diskon_dari' => null,
               'diskon_ke' => null
            );
         }
      }

      if(count($update) > 0) {
         $this->db->update_batch($this->produk, $update, 'id');
      }

      return array(
         'Error' => false,
         'Message' => "success.";
      );
   }
   

}

/* End of file M_Diskon.php */
