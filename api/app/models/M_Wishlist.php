<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Wishlist extends MY_Model {

	protected $tabel = 'mst_produk_favorit';

	protected $tabel_user = 'mst_user';

	protected $tabel_produk = 'mst_produk';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Product_favorit', 'product_favorit');
	}

	function add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'produk_id' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {

			$tabel_produk_favorit = $this->tabel.$user['user_id'];

			$this->product_favorit->create_table_produk_favorit($user['user_id']);

			$produk = $this->db->query("SELECT
											id as id_produk
										FROM
											$this->tabel_produk
										WHERE
											id = $produk_id")->row_array();
			if ($produk) {
				
				$favorit = $this->db->query("SELECT
												id as id_favorit_produk
											FROM
												$tabel_produk_favorit
											WHERE
												produk_id = $produk[id_produk]")->row_array();
				if ($favorit) {
					$config['tabel'] = $tabel_produk_favorit;
					$config['filter'] = "user_id = $user[id_user] AND produk_id = $produk[id_produk]";
					$result = $this->query_delete($config);
					goto output;
				}else{
					$config['tabel'] = $tabel_produk_favorit;
					$config['data'] = ['user_id' => $user['id_user'],'produk_id' => $produk['id_produk']];
					$result = $this->query_add($config);
					goto output;
				}

			}
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;

		output:
		return $result;

	}

	public function get($user_id, $produk_id)
	{
		$result = null;
		if (!empty($user_id) && !empty($produk_id)) {
			$tabel_produk_favorit = $this->tabel;

			$query = $this->db->query("SELECT
										id as id_wishlist
									FROM
										$tabel_produk_favorit
									WHERE
										produk_id = '$produk_id' AND
										user_id = '$user_id'
									")->row_array();
			$result = $query? true : null;
		}

		return $result;
	}

}

/* End of file M_Wishlist.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Wishlist.php */