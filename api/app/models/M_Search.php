<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Search extends CI_Model {

	protected $tb_produk = 'mst_produk';

	protected $tb_toko = 'mst_toko';

	protected $tb_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'M_Kabupaten' => 'kabupaten',
		]);
	}

	function all($params)
	{
		$q = isset($params['q'])? $params['q'] : '';
		$search = isset($params['search'])? $params['search'] : '';

		if (empty($q)) {
			
			$no = 0;

			$like = $q?" AND nama_produk LIKE '%$search?$search : ($q? $q : )%'" : '';

			$produk = $this->db->query("
				SELECT 
					* 
				FROM 
					$this->tb_produk $like
				WHERE 
					status = 1 AND 
					verifikasi = 1 
				ORDER BY created_at DESC LIMIT 0,5
			");

			$data_produk = $produk->result_array();

			$result['status'] = true;
			$result['message'] = null;

			foreach ($data_produk as $key) {
				$result['data'][$no++] = [
					'label' => $key['nama_produk'],
					'slug' => $key['slug'],
					'kategori' => 'rekomendasi'
				];
			}


			goto output;

		}

		$produk = $this->db->query("SELECT * FROM $this->tb_produk 
									WHERE status = 1 AND verifikasi = 1 AND nama_produk LIKE '%$q%'
									ORDER BY created_at DESC LIMIT 0,10");

		$toko = $this->db->query("SELECT * FROM $this->tb_toko 
									WHERE status = 1 AND nama_toko LIKE '%$q%'
									ORDER BY created_at DESC LIMIT 0,10");

		$user = $this->db->query("SELECT * FROM $this->tb_user 
									WHERE status = 1 AND status_utama = 0 AND nama LIKE '%$q%'
									ORDER BY created_at DESC LIMIT 0,10");
			
		$data_produk = $produk->result_array();

		$data_toko = $toko->result_array();

		$data_user = $user->result_array();

		$result['status'] = true;
		$result['message'] = null;

		$no = 0;

		$produk_list = null;
		$toko_list = null;
		$user_list = null;

		$merge_produk = [];
		$merge_toko = [];
		$merge_user = [];

		if ($produk->num_rows() > 0) {
			
			foreach ($data_produk as $key) {
				$produk_list[$no++] = [
					'label' => $key['nama_produk'],
					'slug' => $key['slug'],
					'kategori' => ''
				];
			}

			$merge_produk = $produk_list;

		}

		if ($toko->num_rows() > 0) {
			foreach ($data_toko as $key) {
				$toko_list[$no++] = [
					'label' => $key['nama_toko'],
					'slug' => $key['slug'],
					'logo' => $key['logo'],
					'kabupaten' => $this->kabupaten->get($key['kabupaten_id'])['nama_kabupaten'], 
					'kategori' => 'toko'
				];
			}

			$merge_toko = $toko_list;
		}

// 		if ($user->num_rows() > 0) {
// 			foreach ($data_user as $key) {
// 				$user_list[$no++] = [
// 					'label' => $key['nama'],
// 					'slug' => $key['username'],
// 					'logo' => $key['foto'],
// 					'kategori' => 'profil'
// 				];
// 			}

// 			$merge_user = $user_list;
// 		}

		$result['data'] = array_merge(array_merge($merge_produk,$merge_toko),$merge_user);


		output:

		return $result;
	}

}

/* End of file M_Search.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/api/app/models/M_Search.php */