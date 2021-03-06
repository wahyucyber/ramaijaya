<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sinkron extends MY_Model {

   private $toko = "mst_toko";
   private $produk = "mst_produk";
   private $etalase = "mst_etalase";
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function etalase($params)
   {
      $key = $params['key'];

      if(empty($key)) {
         $output = array(
            'Error' => true,
            'Message' => "key is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            id
         FROM
            $this->toko
         WHERE
            kasier_id_key = '$key'
      ");

      if($get_toko->num_rows() == 0) {
         $output = array(
            'Error' => true,
            'Message' => "toko tidak ditemukan."
         );
         goto output;
      }

      $toko_id = $get_toko->row_array()['id'];

      $get_produk = $this->db->query("
         SELECT
            $this->etalase.id,
            $this->etalase.kasier_etalase_id,
            $this->etalase.nama_etalase AS nama
         FROM
            $this->etalase
         WHERE
            $this->etalase.toko_id = '$toko_id'
      ")->result_array();

      $output['Error'] = false;
      $output['Message'] = "success.";
      $output['Data'] = [];
      $no = 0;
      foreach ($get_produk as $key) {
         $output['Data'][$no++] = $key;
      }

      output:
      return $output;
   }

   public function produk($params)
   {
      $key = $params['key'];
      $date = $params['date'] ?? "";

      if(empty($key)) {
         $output = array(
            'Error' => true,
            'Message' => "key is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            id
         FROM
            $this->toko
         WHERE
            kasier_id_key = '$key'
      ");

      if($get_toko->num_rows() == 0) {
         $output = array(
            'Error' => true,
            'Message' => "toko tidak ditemukan."
         );
         goto output;
      }

      $toko_id = $get_toko->row_array()['id'];
      $sinkron_date = $date;

      $where = (!empty($sinkron_date)) ? " AND DATE(updated_at) >= '$sinkron_date'" : "";

      $get_produk = $this->db->query("
         SELECT
            id,
            kasier_produk_id,
            nama_produk,
            keterangan,
            harga_beli,
            harga,
            diskon,
            berat,
            stok,
            etalase_id,
            status
         FROM
            $this->produk
         WHERE
            toko_id = '$toko_id'
            $where
      ")->result_array();

      $output['Error'] = false;
      $output['Message'] = "success.";
      $output['Data'] = [];
      $no = 0;
      foreach ($get_produk as $key) {
         $output['Data'][$no++] = $key;
      }

      output:
      return $output;
   }
   

}

/* End of file M_Sinkron.php */
