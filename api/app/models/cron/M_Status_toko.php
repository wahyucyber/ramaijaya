<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Status_toko extends MY_Model {

   private $toko = 'mst_toko';

   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function index()
   {
      $get_toko = $this->db->query("
         SELECT
            id,
            awal_tutup,
            akhir_tutup
         FROM
            $this->toko
         WHERE
            awal_tutup IS NOT NULL AND
            akhir_tutup IS NOT NULL
      ")->result_array();

      $update = [];
      $update_no = 0;

      $update2 = [];
      $update2_no = 0;
      foreach ($get_toko as $key) {
         if(strtotime($key['awal_tutup']) == strtotime(date('Y-m-d'))) {
            $update[$update_no++] = [
               'id' => $key['id'],
               'buka' => '0'
            ];
         }

         if(strtotime($key['akhir_tutup']) < strtotime(date('Y-m-d'))) {
            $update2[$update2_no++] = [
               'id' => $key['id'],
               'buka' => '1',
               'awal_tutup' => null,
               'akhir_tutup' => null,
               'catatan_tutup' => null
            ];
         }
      }

      $this->db->update_batch($this->toko, $update, 'id');
      $this->db->update_batch($this->toko, $update2, 'id');

      $output = array(
         'Error' => false,
         'Message' => "status toko berhasil diperbarui."
      );

      return $output;
   }
   

}

/* End of file M_Status_toko.php */
