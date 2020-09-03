<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Kurir extends MY_Model {

	protected $tabel = 'mst_kurir';

	protected $tabel_toko = 'mst_toko';

	public function __construct()
	{
		parent::__construct();
	}

	public function add($params)
	{
		$client_token = $params['client_token'];
		$code = $params['code'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($code)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kurir belum dipilih."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$get_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_toko
				WHERE
					user_id = '$user_id'
			")->row_array();
			$toko_id = $get_toko['id'];

			$cek_kurir = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					toko_id = '$toko_id' AND
					code = '$code'
			")->num_rows();

			if ($cek_kurir == 1) {
				$hasil = array(
					'Error' => true,
					'Message' => "Kurir sudah diaktifkan."
				);
				goto output;
			}

			$this->db->insert($this->tabel, array(
				'toko_id' => $toko_id,
				'code' => $code
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Kurir berhasil diaktifkan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function index($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$get_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_toko
				WHERE
					user_id = '$user_id'
			")->row_array();
			$toko_id = $get_toko['id'];

			$get_kurir = $this->db->query("
				SELECT
					id,
					code,
					created_at,
					updated_at
				FROM
					$this->tabel
				WHERE
					$this->tabel.toko_id = '$toko_id'
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_kurir as $key) {
				$hasil['Data'][$no++] = $key;
			}
			goto output;
		}

		output:
		return $hasil;
	}

	public function delete($params)
	{
		$client_token = $params['client_token'];
		$code = $params['code'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if(empty($code)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kurir belum dipilih."
			);
			goto output;
		}else{
			$user_id = $this->get_user_id($client_token);

			if ($user_id == null) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak ditemukan."
				);
				goto output;
			}

			$get_toko = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_toko
				WHERE
					user_id = '$user_id'
			")->row_array();
			$toko_id = $get_toko['id'];

			$cek_data = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					code = '$code' AND
					toko_id = '$toko_id'
			")->num_rows();
			if ($cek_data == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Data tidak ditemukan."
				);
				goto output;
			}

			$this->db->delete($this->tabel, array(
				'toko_id' => $toko_id,
				'code' => $code
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Kurir berhasil dihapus."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Kurir.php */
/* Location: ./application/models/M_Kurir.php */