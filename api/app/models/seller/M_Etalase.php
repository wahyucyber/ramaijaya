<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Etalase extends MY_Model {

   private $etalase = "mst_etalase";
   private $user = "mst_user";
   private $toko = "mst_toko";

   public function __construct()
   {
      parent::__construct();
      //Do your magic here
   }

   public function add($params)
   {
      $client_token = $params['client_token'];
      $nama = $params['nama'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => 'client_token is required.'
         );
         goto output;
      }else if(empty($nama)) {
         $output = array(
            'Error' => true,
            'Message' => "nama is required."
         );
         goto output;
      }

      $this->db->insert($this->etalase, array(
         'nama_etalase' => $nama,
         'toko_id' => $this->_user($client_token)['toko_id']
      ));
      
      $output = array(
         'Error' => false,
         'Message' => "Etalase berhasil disimpan."
      );

      output:
      return $output;
   }

   public function get($params)
   {
      $client_token = $params['client_token'];
      $start = $params['start'];
      $length = $params['length'];
      $draw = $params['draw'];
      $search = $params['search']['value'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }

      $toko_id = $this->_user($client_token)['toko_id'];

      $limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";

      $where = (!empty($search)) ? " AND nama_etalase LIKE '%$search%'":"";

      $recordsTotal = $this->db->query("
         SELECT
            id
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id'
      ")->num_rows();

      $recordsFiltered = $this->db->query("
         SELECT
            id
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id'
            $where
      ")->num_rows();

      $etalase = $this->db->query("
         SELECT
            id,
            nama_etalase AS nama,
            created_at,
            updated_at
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id'
            $where
         $limit
      ")->result_array();

      $output['Error'] = false;
      $output['Message'] = "success.";
      $output['Data'] = $etalase;
      $output['recordsTotal'] = $recordsTotal;
      $output['recordsFiltered'] = $recordsFiltered;
      $output['draw'] = $draw;

      output:
      return $output;
   }

   public function update($params)
   {
      $client_token = $params['client_token'];
      $id = $params['id'];
      $nama = $params['nama'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }else if(empty($id)) {
         $output = array(
            'Error' => true,
            'Message' => "id is required."
         );
         goto output;
      }else if(empty($nama)) {
         $output = array(
            'Error' => true,
            'Message' => "nama is required."
         );
         goto output;
      }

      $toko_id = $this->_user($client_token)['toko_id'];

      $cek_data = $this->db->query("
         SELECT
            id
         FROM
            $this->etalase
         WHERE
            id = '$id' AND
            toko_id = '$toko_id'
      ")->num_rows();

      if($cek_data == 0) {
         $output = array(
            'Error' => true,
            'Message' => "etalase tidak ditemukan."
         );
         goto output;
      }

      $this->db->update($this->etalase, array(
         'nama_etalase' => $nama
      ), array(
         'id' => $id,
         'toko_id' => $toko_id
      ));

      $output = array(
         'Error' => false,
         'Message' => "etalase berhasil diperbarui."
      );

      output:
      return $output;
   }

   public function delete($params)
   {
      $client_token = $params['client_token'];
      $id = $params['id'];

      if(empty($client_token)) {
         $output = array(
            'Error' => true,
            'Message' => "client_token is required."
         );
         goto output;
      }else if(empty($id)) {
         $output = array(
            'Error' => true,
            'Message' => "id is required."
         );
         goto output;
      }

      $toko_id = $this->_user($client_token)['toko_id'];

      $cek_data = $this->db->query("
         SELECT
            id
         FROM
            $this->etalase
         WHERE
            toko_id = '$toko_id' AND
            id = '$id'
      ")->num_rows();

      if($cek_data == 0) {
         $output = array(
            'Error' => true,
            'Message' => "etalase tidak ditemukan."
         );
         goto output;
      }

      $this->db->delete($this->etalase, array(
         'toko_id' => $toko_id,
         'id' => $id,
      ));
      
      $output = array(
         'Error' => false,
         'Message' => "etalase berhasil dihapus."
      );

      output:
      return $output;
   }

   private function _user($client_token) {
      $user = $this->db->query("
         SELECT
            $this->user.id AS user_id,
            $this->toko.id AS toko_id
         FROM
            $this->user
            LEFT JOIN $this->toko ON $this->toko.user_id = $this->user.id
         WHERE
            $this->user.api_token = '$client_token'
      ")->row_array();

      return $user;
   }
   

}

/* End of file M_Etalase.php */
