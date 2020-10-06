<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sinkron extends MY_Model {

   private $toko = "mst_toko";
   private $produk = "mst_produk";
   private $kategori = "mst_kategori";
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function kategori($params)
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
            id,
            kasier_id_sinkron_date AS terakhir_sinkron
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
            $this->kategori.id,
            $this->kategori.nama_kategori AS nama
         FROM
            $this->produk
            LEFT JOIN $this->kategori ON $this->kategori.id = $this->produk.kategori_id
         WHERE
            $this->produk.toko_id = '$toko_id'
         GROUP BY $this->produk.kategori_id
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

      if(empty($key)) {
         $output = array(
            'Error' => true,
            'Message' => "key is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            id,
            kasier_id_sinkron_date AS terakhir_sinkron
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
      $sinkron_date = $get_toko->row_array()['terakhir_sinkron'];

      // $this->db->update($this->toko, array(
      //    'kasier_id_sinkron_date' => date('Y-m-d')
      // ), array(
      //    'id' => $toko_id
      // ));

      $where = (!empty($sinkron_date)) ? " AND DATE(updated_at) > '$sinkron_date'" : "";

      $get_produk = $this->db->query("
         SELECT
            id,
            nama_produk,
            keterangan,
            harga,
            diskon,
            berat,
            stok,
            kategori_id
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
