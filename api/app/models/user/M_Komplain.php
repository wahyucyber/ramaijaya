<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Komplain extends MY_Model {

	protected $tabel = 'mst_produk_komplain';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_transaksi = 'mst_transaksi';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail_';

	protected $tabel_komplain_komentar = 'mst_produk_komplain_komentar';

	function all($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$start = $params['start']? $params['start'] : 0;
		$length = $params['length']? $params['length'] : 10;
		$draw = $params['draw'];
		$search = $params['search']['value'];
		if(empty($client_token)){
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}

		$keyword = empty($search)? "" : " AND ($this->tabel_user.nama LIKE '%$search%'
											OR $this->tabel_produk.nama_produk LIKE '%$search%'
											OR $this->tabel.no_invoice LIKE '%$search%'
											OR $this->tabel.komplain LIKE '%$search%')";

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		// $toko = $this->db->query("SELECT
		// 								id
		// 							FROM
		// 								$this->tabel_toko
		// 							WHERE
		// 								user_id = '$user[id]'")->row_array();
		// if (!$toko) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Toko tidak ditemukan";
		// 	goto output;
		// }

		$jumlah_data = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel.user_id,
										$this->tabel_user.nama,
										$this->tabel.produk_id,
										$this->tabel_produk.nama_produk,
										$this->tabel.no_invoice,
										$this->tabel.transaksi_id,
										$this->tabel.komplain
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN 
										$this->tabel_produk
										ON
										$this->tabel.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_transaksi
										ON
										$this->tabel.transaksi_id=$this->tabel_transaksi.id
									WHERE
										$this->tabel.user_id='$user[id]'
										$keyword
									ORDER BY $this->tabel.created_at DESC")->num_rows();
		if ($jumlah_data > 0) {

			$no = 0;

			$data = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel.user_id,
										$this->tabel_toko.id as toko_id,
										$this->tabel_toko.nama_toko,
										$this->tabel_toko.logo as logo_toko,
										$this->tabel.produk_id,
										$this->tabel_produk.nama_produk,
										$this->tabel.no_invoice,
										$this->tabel.transaksi_id,
										$this->tabel.komplain,
										$this->tabel.status,
										$this->tabel.created_at
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN 
										$this->tabel_produk
										ON
										$this->tabel.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel_produk.toko_id=$this->tabel_toko.id
									LEFT JOIN
										$this->tabel_transaksi
										ON
										$this->tabel.transaksi_id=$this->tabel_transaksi.id
									WHERE
										$this->tabel.user_id='$user[id]'
										$keyword
									ORDER BY $this->tabel.created_at DESC
									LIMIT $start,$length")->result_array();
			foreach($data as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id' => $key['id'],
					'toko_id' => $key['toko_id'],
					'nama_toko' => $key['nama_toko'],
					'logo_toko' => $key['logo_toko'],
					'produk_id' => $key['produk_id'],
					'nama_produk' => $key['nama_produk'],
					'no_invoice' => $key['no_invoice'],
					'komplain' => $key['komplain'],
					'status' => $key['status'],
					'tanggal' => date('d M Y H:i',strtotime($key['created_at']))
				]; 
			}
			$result['recordsTotal'] = $jumlah_data;
			$result['recordsFiltered'] = count($data);
			$result['draw'] = $draw;
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Tidak ada komplain";
		$result['Data'] = [];
		$result['recordsTotal'] =0;
		$result['recordsFiltered'] = 0;
		$result['draw'] = 0;
		goto output;
		output:
		return $result;
	}

	function komentar($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$komplain_id = isset($params['komplain_id'])? $params['komplain_id'] : '';
		if(empty($client_token)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter client_token tidak diset"
			];
			goto output;
		}else if (empty($komplain_id)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter komplain_id tidak diset"
			];
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result = [
				'Error' => true,
				'Message' => "Pengguna tidak ditemukan"
			];
			goto output;
		}

		$komplain = $this->db->query("SELECT
											id,
											komplain,
											created_at
										FROM
											$this->tabel
										WHERE
											id = '$komplain_id'")->row_array();
		if (!$komplain) {
			$result = [
				'Error' => true,
				'Message' => "Komplain tidak ditemukan"
			];
			goto output;
		}

		$komentar = $this->db->query("SELECT
											komplain_id,
											user_id,
											komentar,
											created_at
										FROM
											$this->tabel_komplain_komentar
										WHERE
											komplain_id = '$komplain_id'
										ORDER BY 
											created_at ASC");
		if ($komentar->num_rows() > 0) {
			
			$no = 0;

			foreach($komentar->result_array() as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Komplain'] = [
					'komplain' => $komplain['komplain'],
					'waktu' => date('H:i',strtotime($komplain['created_at']))
				];
				$result['Data'][$no++] = [
					'komplain_id' => $key['komplain_id'],
					'reply' => $key['user_id'] == $user['id']? false : true,
					'komentar' => $key['komentar'],
					'waktu' => date('H:i',strtotime($key['created_at']))
				];
			}
			goto output;

		}
		$result = [
			'Error' => true,
			'Message' => "Komentar tidak ditemukan"
		];
		$result['Komplain'] = [
			'komplain' => $komplain['komplain'],
			'waktu' => date('H:i',strtotime($komplain['created_at']))
		];
		goto output;
		output:
		return $result;

	}

	function komentar_add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$komplain_id = isset($params['komplain_id'])? $params['komplain_id'] : '';
		$user_id = isset($params['user_id'])? $params['user_id'] : '';
		$komentar = isset($params['komentar'])? $params['komentar'] : '';
		if(empty($client_token)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter client_token tidak diset"
			];
			goto output;
		}else if(empty($komplain_id)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter komplain_id tidak diset"
			];
			goto output;
		}else if(empty($user_id)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter user_id tidak diset"
			];
			goto output;
		}else if(empty($komentar)) {
			$result = [
				'Error' => true,
				'Message' => "Komentar harus diisi"
			];
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result = [
				'Error' => true,
				'Message' => "Pengguna tidak ditemukan"
			];
			goto output;
		}

		$toko = $this->db->query("SELECT
										$this->tabel_toko.id
									FROM
										$this->tabel_toko
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_toko.user_id=$this->tabel_user.id
									WHERE
										$this->tabel_toko.id = '$user_id'")->row_array();
		if (!$toko) {
			$result = [
				'Error' => true,
				'Message' => "Penjual tidak ditemukan"
			];
			goto output;
		}

		$komplain = $this->db->query("SELECT
											id,
											status
										FROM
											$this->tabel
										WHERE
											id = '$komplain_id'")->row_array();
		if (!$komplain) {
			$result = [
				'Error' => true,
				'Message' => "Komplain tidak ditemukan"
			];
			goto output;
		}
			
		$data = [
			'komplain_id' => $komplain_id,
			'user_id' => $user['id'],
			'komentar' => $komentar
		];

		$add = $this->db->insert($this->tabel_komplain_komentar,$data);
		if($add){
			if ($komplain['status'] == 0) {
				$this->db->update($this->tabel,['status' => 1],['id' => $komplain_id]);
				$result['reload'] = true;
			}else{
				$result['reload'] = false;
			}
			$result = [
				'Error' => false,
				'Message' => "Berhasil menambahkan komentar"
			];
			goto output;
		}

		$result = [
			'Error' => true,
			'Message' => "Gagal menambahkan komentar"
		];
		goto output;
		output:
		return $result;

	}

	function open($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$komplain_id = isset($params['komplain_id'])? $params['komplain_id'] : '';
		if(empty($client_token)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter client_token tidak diset"
			];
			goto output;
		}else if (empty($komplain_id)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter komplain_id tidak diset"
			];
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result = [
				'Error' => true,
				'Message' => "Pengguna tidak ditemukan"
			];
			goto output;
		}

		$komplain = $this->db->query("SELECT
											id,
											status
										FROM
											$this->tabel
										WHERE
											id = '$komplain_id'
											AND
											status = '2'")->row_array();
		if (!$komplain) {
			$result = [
				'Error' => true,
				'Message' => "Komplain tidak ditemukan"
			];
			goto output;
		}

		$up = $this->db->update($this->tabel,['status' => 0],['id' => $komplain_id]);
		if ($up) {
			$result = [
				'Error' => false,
				'Message' => "Berhasil membuka komplain"
			];
			goto output;
		}
		$result = [
			'Error' => true,
			'Message' => "Gagal membuka komplain"
		];
		goto output;
		output:
		return $result;

	}

	function close($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$komplain_id = isset($params['komplain_id'])? $params['komplain_id'] : '';
		if(empty($client_token)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter client_token tidak diset"
			];
			goto output;
		}else if (empty($komplain_id)) {
			$result = [
				'Error' => true,
				'Message' => "Parameter komplain_id tidak diset"
			];
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result = [
				'Error' => true,
				'Message' => "Pengguna tidak ditemukan"
			];
			goto output;
		}

		$komplain = $this->db->query("SELECT
											id,
											status
										FROM
											$this->tabel
										WHERE
											id = '$komplain_id'
											AND
											status = '1'")->row_array();
		if (!$komplain) {
			$result = [
				'Error' => true,
				'Message' => "Komplain tidak ditemukan"
			];
			goto output;
		}

		$up = $this->db->update($this->tabel,['status' => 2],['id' => $komplain_id]);
		if ($up) {
			$result = [
				'Error' => false,
				'Message' => "Berhasil menutup komplain"
			];
			goto output;
		}
		$result = [
			'Error' => true,
			'Message' => "Gagal menutup komplain"
		];
		goto output;
		output:
		return $result;

	}

}
