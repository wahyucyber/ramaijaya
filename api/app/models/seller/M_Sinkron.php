<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sinkron extends MY_Model {

   private $toko = "mst_toko";
   private $user = "mst_user";
   private $etalase = "mst_etalase";
   private $produk = "mst_produk";
   private $kategori = "mst_kategori";

   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   private function _key($client_token)
   {
      $get_toko = $this->db->query("
         SELECT
            $this->toko.kasier_sync_key
         FROM
            $this->toko
            LEFT JOIN $this->user ON $this->user.id = $this->toko.user_id
         WHERE
            $this->user.api_token = '$client_token'
      ")->row_array();

      return $get_toko['kasier_sync_key'] ?? false;
   }

   private function _curl($params) {
      $key = $this->_key($params['client_key']);

      $sync = $params['sync'];
      $kasier_url = env('KASIER_URL');
      $date = $params['date'];
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => "$kasier_url/api/ramaijaya_sinkron/$sync?key=$key&date=$date",
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 30,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded"
         )
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      return json_decode($response, true);
   }

   public function sync_key($params)
   {
      $client_token = $params['client_token'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            $this->toko.id,
            $this->toko.kasier_sync_key
         FROM
            $this->toko
            LEFT JOIN $this->user ON $this->user.id = $this->toko.user_id
         WHERE
            $this->user.api_token = '$client_token'
      ")->result_array();

      $output = array(
         'Error' => false,
         'Message' => 'success.',
         'Data' => $get_toko
      );

      output:
      return $output;
   }

   public function sync_key_save($params)
   {
      $client_token = $params['client_token'];
      $key = $params['key'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }else if(empty($key)) {
         $output = array(
            'Error' => true,
            'Message' => "key is required."
         );
         goto output;
      }

      $toko_id = $this->db->query("
         SELECT
            $this->toko.id
         FROM
            $this->toko
            LEFT JOIN $this->user ON $this->user.id = $this->toko.user_id
         WHERE
            $this->user.api_token = '$client_token'
      ")->row_array()['id'];

      $this->db->update($this->toko, array(
         'kasier_sync_key' => $key
      ), array(
         'id' => $toko_id
      ));
      
      $output = array(
         'Error' => false,
         'Message' => "Kasier Sync Key berhasil disimpan."
      );

      output:
      return $output;
   }

   public function etalase($params)
   {
      $client_token = $params['client_token'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            $this->toko.id,
            $this->toko.kasier_last_sync
         FROM
            $this->toko
            LEFT JOIN $this->user ON $this->user.id = $this->toko.user_id
         WHERE
            $this->user.api_token = '$client_token'
      ")->row_array();

      $toko_id = $get_toko['id'];
      $last_sync = $get_toko['kasier_last_sync'];

      $get_etalase = $this->db->query("
         SELECT
            id,
            kasier_etalase_id
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id'
      ")->result_array();

      $sync_etalase = $this->_curl(array(
         'sync' => "etalase",
         'date' => ($last_sync != null) ? $last_sync : "",
         'client_key' => $client_token
      ));

      $etalase_add = [];
      $etalase_add_no = 0;
      $etalase_update = [];
      $etalase_update_no = 0;
      $etalase_update2 = [];
      $etalase_update2_no = 0;
      foreach ($sync_etalase['data'] as $key) {
         if(is_numeric(array_search($key['id'], array_column($get_etalase, 'kasier_etalase_id')))) {
            $etalase_update[$etalase_update_no++] = array(
               'kasier_etalase_id' => $key['id'],
               'toko_id' => $toko_id,
               'nama_etalase' => $key['nama']
            );
         }else if($key['ramaijaya_etalase_id'] != 0) {
            $etalase_update2[$etalase_update2_no++] = array(
               'id' => $key['ramaijaya_etalase_id'],
               'kasier_etalase_id' => $key['id'],
               'toko_id' => $toko_id,
               'nama_etalase' => $key['nama']
            );
         }else {
            $etalase_add[$etalase_add_no++] = array(
               'kasier_etalase_id' => $key['id'],
               'toko_id' => $toko_id,
               'nama_etalase' => $key['nama']
            );
         }
      }

      if(count($etalase_add) != 0) {
         $this->db->insert_batch($this->etalase, $etalase_add);
      }

      if(count($etalase_update) != 0) {
         $this->db->update_batch($this->etalase, $etalase_update, 'kasier_etalase_id');
      }

      if(count($etalase_update2) != 0) {
         $this->db->update_batch($this->etalase, $etalase_update2, 'id');
      }

      $output = array(
         'Error' => false,
         'Message' => "Etalase berhasil disinkronisasi."
      );

      output:
      return $output;
   }

   public function produk($params)
   {
      $client_token = $params['client_token'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $get_toko = $this->db->query("
         SELECT
            $this->toko.id,
            $this->toko.kasier_last_sync
         FROM
            $this->toko
            LEFT JOIN $this->user ON $this->user.id = $this->toko.user_id
         WHERE
            $this->user.api_token = '$client_token'
      ")->row_array();

      $toko_id = $get_toko['id'];
      $last_sync = $get_toko['kasier_last_sync'];

      $get_produk = $this->db->query("
         SELECT
            id,
            kasier_produk_id
         FROM
            $this->produk
         WHERE
            toko_id = '$toko_id'
      ")->result_array();

      $sync_produk = $this->_curl(array(
         'sync' => "produk",
         'date' => ($last_sync != null) ? $last_sync : "",
         'client_key' => $client_token
      ));

      $get_etalase = $this->db->query("
         SELECT
            id,
            kasier_etalase_id
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id'
      ")->result_array();

      $etalase = [];
      foreach ($get_etalase as $key) {
         $etalase[$key['kasier_etalase_id']] = $key['id'];
      }

      $kategori_id = $this->db->query("
         SELECT
            id
         FROM
            $this->kategori
         WHERE
            sync_default = '1'
      ")->row_array()['id'];

      $produk_add = [];
      $produk_add_no = 0;
      $produk_update = [];
      $produk_update_no = 0;
      $produk_update2 = [];
      $produk_update2_no = 0;
      $produk_id = $this->Func->generate_id($this->produk);
      foreach ($sync_produk['data'] as $key) {
         $diskon = $key['diskon']/$key['harga_jual']*100;
         if(is_numeric(array_search($key['id'], array_column($get_produk, 'kasier_produk_id')))) {
            $produk_update[$produk_update_no++] = array(
               'id' => $key['ramaijaya_barang_id'],
               'kasier_produk_id' => $key['id'],
               'toko_id' => $toko_id,
               'sku_produk' => $key['kode'],
               'nama_produk' => $key['nama'],
               'harga_beli' => $key['harga_beli'],
               'harga' => $key['harga_jual'],
               'diskon' => $diskon,
               'stok' => $key['stok'],
               'kondisi' => '1',
               'berat' => '1000',
               'min_beli' => '1',
               'etalase_id' => $etalase[$key['etalase_id']],
               'status' => $key['is_jual'],
               'verifikasi' => '1'
            );
         }else if($key['ramaijaya_barang_id'] != 0) {
            $produk_update2[$produk_update2_no++] = array(
               'id' => $key['ramaijaya_barang_id'],
               'kasier_produk_id' => $key['id'],
               'toko_id' => $toko_id,
               'sku_produk' => $key['kode'],
               'nama_produk' => $key['nama'],
               'harga_beli' => $key['harga_beli'],
               'harga' => $key['harga_jual'],
               'diskon' => $diskon,
               'stok' => $key['stok'],
               'kondisi' => '1',
               'berat' => '1000',
               'min_beli' => '1',
               'etalase_id' => $etalase[$key['etalase_id']],
               'status' => $key['is_jual'],
               'verifikasi' => '1'
            );
         }else {
            $produk_add[$produk_add_no++] = array(
               'id' => $produk_id++,
               'kasier_produk_id' => $key['id'],
               'toko_id' => $toko_id,
               'sku_produk' => $key['kode'],
               'nama_produk' => $key['nama'],
               'slug' => slugify($key['nama']),
               'keterangan' => $key['nama'],
               'harga_beli' => $key['harga_beli'],
               'harga' => $key['harga_jual'],
               'diskon' => $diskon,
               'stok' => $key['stok'],
               'kondisi' => '1',
               'berat' => '1000',
               'min_beli' => '1',
               'kategori_id' => $kategori_id,
               'etalase_id' => $etalase[$key['etalase_id']],
               'status' => $key['is_jual'],
               'verifikasi' => '1'
            );
         }
      }

      if(count($produk_add) != 0) {
         $this->db->insert_batch($this->produk, $produk_add);
      }

      if(count($produk_update) != 0) {
         $this->db->update_batch($this->produk, $produk_update, 'id');
      }

      if(count($produk_update2) != 0) {
         $this->db->update_batch($this->produk, $produk_update2, 'id');
      }

      $this->db->update($this->toko, array(
         'kasier_last_sync' => date('Y-m-d')
      ), array(
         'id' => $toko_id
      ));

      $output = array(
         'Error' => false,
         'Message' => "Produk berhasil disinkronisasi.",
         'produk' => $sync_produk['data']
      );

      output:
      return $output;
   }
   

}

/* End of file M_Sinkron.php */
