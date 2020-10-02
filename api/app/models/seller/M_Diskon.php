<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Diskon extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_kategori = 'mst_kategori';

	protected $tabel_produk = 'mst_produk';

	public function all($params)
	{
		$params = __hsp($params);
	 	$client_token = isset($params['client_token'])? $params['client_token'] : '';   
	 	$tipe = isset($params['tipe'])? $params['tipe'] : 'produk';
	 	$start = isset($params['start'])? $params['start'] : 0;
	 	$length = isset($params['length'])? $params['length'] : 10;
	 	$draw = isset($params['draw'])? $params['draw'] : '';
	 	$search = isset($params['search']['value'])? $params['search']['value'] : '';

	 	if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$limit = "$start,$length";

	 	$where = "";

	 	if ($tipe == 'produk') {
	 		$where = empty($search)? "" : "AND (nama_produk LIKE '%$search%' OR harga LIKE '%$search%' OR diskon LIKE '%$search%')";
	 		$result = $this->diskon_data_produk($toko_id,$where,$limit);
	 		goto output;
	 	}else if($tipe == 'kategori') {
	 		$where = empty($search)? "" : "AND ($this->tabel_kategori.nama_kategori LIKE '%$search%' OR $this->tabel_produk.diskon LIKE '%$search%')";
	 		$result = $this->diskon_data_kategori($toko_id,$where,$limit);
	 		goto output;
	 	}else{
	 		$result['Error'] = true;
	 		$result['Message'] = "Tipe tidak ditemukan";
	 		goto output;
	 	}

	 	output:
	 	return $result;
	}

	private function diskon_data_kategori($toko_id,$where = '',$limit = "0,10")
	{
		$jumlah_data = $this->db->query("SELECT
										$this->tabel_produk.id,
										$this->tabel_kategori.nama_kategori,
										$this->tabel_produk.diskon
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.diskon != '0'
									$where
									GROUP BY 
										$this->tabel_produk.kategori_id")->num_rows();
		if ($jumlah_data == 0) {
			$result['Error'] = true;
	 		$result['Message'] = "Tidak ada produk diskon";
	 		$result['Data'] = [];
	 		$result['recordsTotal'] = 0;
	        $result['recordsFiltered'] = 0;
	 		goto output;
		}

		$data = $this->db->query("SELECT
										$this->tabel_kategori.id,
										$this->tabel_kategori.nama_kategori,
										$this->tabel_produk.diskon
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.diskon != '0'
									$where
									GROUP BY 
										$this->tabel_produk.kategori_id
									LIMIT
										$limit")->result_array();
		$no = 0;
		$result['Error'] = false;
		$result['Message'] = null;
		$result['recordsTotal'] = $jumlah_data;
        $result['recordsFiltered'] = count($data);
        foreach($data as $key){
        	$result['Data'][$no++] = $key;
        }
        goto output;
        output:
        return $result;

	}

	private function diskon_data_produk($toko_id,$where = '',$limit = "0,10")
	{
		$jumlah_data = $this->db->query("SELECT
										$this->tabel_produk.id,
										$this->tabel_produk.diskon,
										$this->tabel_produk.nama_produk,
										$this->tabel_produk.harga
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.diskon != '0'")->num_rows();
		if ($jumlah_data == 0) {
			$result['Error'] = true;
	 		$result['Message'] = "Tidak ada produk diskon";
	 		$result['Data'] = [];
	 		$result['recordsTotal'] = 0;
	        $result['recordsFiltered'] = 0;
	 		goto output;
		}

		$data = $this->db->query("SELECT
										$this->tabel_produk.id,
										$this->tabel_produk.diskon,
										$this->tabel_produk.nama_produk,
										$this->tabel_kategori.nama_kategori,
										$this->tabel_produk.harga
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.diskon != '0' 
										AND
										$this->tabel_produk.toko_id = '$toko_id'
									LIMIT
										$limit")->result_array();
		$no = 0;
		$result['Error'] = false;
		$result['Message'] = null;
		$result['recordsTotal'] = $jumlah_data;
        $result['recordsFiltered'] = count($data);
        foreach($data as $key){
        	$result['Data'][$no++] = [
        		'id' => $key['id'],
        		'nama_produk' => $key['nama_produk'],
        		'nama_kategori' => $key['nama_kategori'],
        		'harga' => $key['harga'],
        		'diskon' => $key['diskon'],
        		'harga_diskon' => $key['harga'] - (($key['diskon']/100)*$key['harga'])
        	];
        }
        goto output;
        output:
        return $result;
	}

	function get_kategori($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$data = $this->db->query("SELECT
										$this->tabel_kategori.id,
										$this->tabel_kategori.nama_kategori
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.diskon = '0'
									GROUP BY 
										$this->tabel_produk.kategori_id");
	 	if ($data->num_rows() == 0) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Produk tidak ditemukan";
	 		goto output;
	 	}

	 	$no = 0;
	 	$result['Error'] = false;
	 	$result['Message'] = null;
	 	foreach($data->result_array() as $key){
	 		$result['Data'][$no++] = $key;
	 	}
	 	goto output;
	 	output:
	 	return $result;

	}

	function get_produk($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$data = $this->db->query("SELECT
										id,
										nama_produk,
										diskon,
										diskon_dari,
										diskon_ke
									FROM
										$this->tabel_produk
									WHERE
										toko_id = '$toko_id'
										AND
										diskon = '0'");
	 	if ($data->num_rows() == 0) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Produk tidak ditemukan";
	 		goto output;
	 	}

	 	$no = 0;
	 	$result['Error'] = false;
	 	$result['Message'] = null;
	 	foreach($data->result_array() as $key){
	 		$result['Data'][$no++] = $key;
	 	}
	 	goto output;
	 	output:
	 	return $result;

	}

	function add_kategori($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$diskon = isset($params['diskon'])? $params['diskon'] : '';
		$kategori_id = isset($params['kategori_id'])? $params['kategori_id'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}else if(empty($diskon)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Diskon tidak boleh kosong";
	 		goto output;
	 	}else if(empty($kategori_id)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Kategori tidak boleh kosong";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$data = $this->db->query("SELECT
										$this->tabel_kategori.nama_kategori
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.kategori_id = '$kategori_id'
									GROUP BY 
										$this->tabel_produk.kategori_id")->row_array();
	 	if (!$data) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Kategori tidak ditemukan";
	 		goto output;
	 	}

	 	$up = $this->db->update($this->tabel_produk,['diskon' => $diskon],['kategori_id' => $kategori_id]);
	 	if ($up) {
	 		$result['Error'] = false;
	 		$result['Message'] = "Berhasil menambahkan diskon pada kategori ".$data['nama_kategori'];
	 		goto output;
	 	}
	 	$result['Error'] = true;
 		$result['Message'] = "Gagal menambahkan diskon pada kategori ".$data['nama_kategori'];
 		goto output;
 		output:
 		return $result;


	}

	function kategori_delete($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$kategori_id = isset($params['kategori_id'])? $params['kategori_id'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}else if(empty($kategori_id)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter kategori_id tidak diset";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$data = $this->db->query("SELECT
										$this->tabel_kategori.nama_kategori
									FROM
										$this->tabel_produk
									LEFT JOIN
										$this->tabel_kategori
										ON $this->tabel_produk.kategori_id=$this->tabel_kategori.id
									WHERE
										$this->tabel_produk.toko_id = '$toko_id'
										AND
										$this->tabel_produk.kategori_id = '$kategori_id'
									GROUP BY 
										$this->tabel_produk.kategori_id")->row_array();
	 	if (!$data) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Kategori tidak ditemukan";
	 		goto output;
	 	}

	 	$del = $this->db->update($this->tabel_produk,['diskon' => 0],['kategori_id' => $kategori_id]);
	 	if ($del) {
	 		$result['Error'] = false;
	 		$result['Message'] = "Berhasil menghapus diskon pada kategori ".$data['nama_kategori'];
	 		goto output;
	 	}
	 	$result['Error'] = true;
 		$result['Message'] = "Gagal menghapus diskon pada kategori ".$data['nama_kategori'];
 		goto output;
 		output:
 		return $result;
	}

	function add_produk($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$diskon = isset($params['diskon'])? $params['diskon'] : '';
		$dari_tanggal = $params['dari_tanggal'];
		$ke_tanggal = $params['ke_tanggal'];
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}else if(empty($diskon)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Diskon tidak boleh kosong";
	 		goto output;
	 	}else if(empty($produk_id)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Produk tidak boleh kosong";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];


	 	if (is_array($produk_id)) {
	 		foreach ($produk_id as $value) {
			 	$data = $this->db->query("SELECT
												$this->tabel_produk.nama_produk
											FROM
												$this->tabel_produk
											WHERE
												toko_id = '$toko_id'
												AND
												id = '$value'")->row_array();
			 	if (!$data) {
			 		$result['Error'] = true;
			 		$result['Message'] = "Produk tidak ditemukan";
			 		goto output;
			 	}
			 	$this->db->update($this->tabel_produk,['diskon' => $diskon, 'diskon_dari' => $dari_tanggal, 'diskon_ke' => $ke_tanggal],['id' => $value]);
	 			
	 		}
	 	}else{
		 	$this->db->update($this->tabel_produk,['diskon' => $diskon, 'diskon_dari' => $dari_tanggal, 'diskon_ke' => $ke_tanggal],['id' => $produk_id]);

	 	}
 		$result['Error'] = false;
 		$result['Message'] = "Berhasil menambahkan diskon";
 		goto output;
 		output:
 		return $result;


	}

	function produk_delete($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		if (empty($client_token)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter client_token tidak diset";
	 		goto output;
	 	}else if(empty($produk_id)) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Parameter produk_id tidak diset";
	 		goto output;
	 	}

	 	$user = $this->db->query("SELECT
	 								$this->tabel_toko.id
	 								FROM
	 									$this->tabel_toko
	 								LEFT JOIN
	 									$this->tabel_user
	 									ON
	 									$this->tabel_toko.user_id=$this->tabel_user.id
	 								WHERE
	 									$this->tabel_user.api_token = '$client_token'")->row_array();
	 	if (!$user) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Pengguna tidak ditemukan";
	 		goto output;
	 	}

	 	$toko_id = $user['id'];

	 	$data = $this->db->query("SELECT
										nama_produk
									FROM
										$this->tabel_produk
									WHERE
										toko_id = '$toko_id'
										AND
										id = '$produk_id'")->row_array();
	 	if (!$data) {
	 		$result['Error'] = true;
	 		$result['Message'] = "Produk tidak ditemukan";
	 		goto output;
	 	}

	 	$del = $this->db->update($this->tabel_produk,['diskon' => 0],['id' => $produk_id]);
	 	if ($del) {
	 		$result['Error'] = false;
	 		$result['Message'] = "Berhasil menghapus diskon";
	 		goto output;
	 	}
	 	$result['Error'] = true;
 		$result['Message'] = "Gagal menghapus diskon";
 		goto output;
 		output:
 		return $result;
	}

}