<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kasier extends MY_Model {

   private $user = "mst_user";
   private $toko = "mst_toko";
   
   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function get($params)
   {
      $client_token = $params['client_token'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $client = $this->db->query("
         SELECT
            $this->toko.id AS toko_id,
            $this->toko.kasier_id_key
         FROM
            $this->user
            LEFT JOIN $this->toko ON $this->toko.user_id = $this->user.id
         WHERE
            $this->user.api_token = '$client_token'
      ");

      if($client->num_rows() == 0) {
         $output = array(
            'Error' => true,
            'Message' => "client tidak ditemukan."
         );
         goto output;
      }

      $kasier_key = $client->row_array()['kasier_id_key'];

      $data = [];

      if(!empty($kasier_key)) {
         $data[] = array(
            'key' => $kasier_key
         );
      }

      $output = array(
         'Error' => false,
         'Message' => 'success.',
         'Data' => $data
      );

      output:
      return $output;
   }

   public function post($params)
   {
      $client_token = $params['client_token'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $client = $this->db->query("
         SELECT
            $this->toko.id AS toko_id,
            $this->toko.kasier_id_key
         FROM
            $this->user
            LEFT JOIN $this->toko ON $this->toko.user_id = $this->user.id
         WHERE
            $this->user.api_token = '$client_token'
      ");

      if($client->num_rows() == 0) {
         $output = array(
            'Error' => true,
            'Message' => "client tidak ditemukan."
         );
         goto output;
      }

      generate_key:
      $kasier_key = $this->generate_uuid();

      $cek_key = $this->db->query("
         SELECT
            id
         FROM
            $this->toko
         WHERE
            kasier_id_key = '$kasier_key'
      ");

      if($cek_key->num_rows() != 0 && $cek_key->row_array()['id'] != $client->row_array()['toko_id']) {
         goto generate_key;
      }

      $this->db->update($this->toko, array(
         'kasier_id_key' => $kasier_key
      ), array(
         'id' => $client->row_array()['toko_id']
      ));

      $output = array(
         'Error' => false,
         'Message' => "Key berhasil digenerate ulang."
      );

      output:
      return $output;
   }

   private function generate_uuid() {
      return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
          mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
          mt_rand( 0, 0xffff ),
          mt_rand( 0, 0x0C2f ) | 0x4000,
          mt_rand( 0, 0x3fff ) | 0x8000,
          mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
      );
   }
   

}

/* End of file Kasir_model.php */
