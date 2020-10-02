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
            id
         FROM
            $this->produk
         WHERE
            diskon != 0 AND
            diskon_dari IS NOT NULL AND
            diskon_ke IS NOT NULL
      ")->result_array();

      return $produk;
   }
   

}

/* End of file M_Diskon.php */
