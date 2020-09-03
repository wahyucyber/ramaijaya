<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Product_favorit extends MY_Model {

	protected $tabel = 'mst_produk_favorit';

	public function __construct()
	{
		parent::__construct();
	}

	public function add($params)
	{
		$client_token = $params['client_token'];
		$produk_id = $params['produk_id'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($produk_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'produk_id' tidak diset."
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

			$tabel_produk_favorit = $this->tabel;

			$cek_produk = $this->db->query("
				SELECT
					id
				FROM
					$tabel_produk_favorit
				WHERE
					user_id = '$user_id' AND
					produk_id = '$produk_id'
			")->num_rows();
			if ($cek_produk > 0) {

				$this->db->delete($tabel_produk_favorit, array(
					'user_id' => $user_id,
					'produk_id' => $produk_id
				));

				$hasil = array(
					'Error' => false,
					'Message' => "Produk dihapus dari daftar produk favorit."
				);
				goto output;
			}

			$this->db->insert($tabel_produk_favorit, array(
				'user_id' => $user_id,
				'produk_id' => $produk_id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Produk berhasil disimpan sebagai daftar produk favorit."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Product_favorit.php */
/* Location: ./application/models/M_Product_favorit.php */