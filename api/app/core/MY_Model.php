<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $table = 'mst_api';

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['MY_Email' => 'my_email','Hash' => 'hash']);
	}

	public function generate_token()
	{
		return sha1(md5(date("Y-m-d H:i:s").microtime()));
	}

	public function generate_slug($text)
	{
		$string =  str_replace(' ','-',strtolower(strtoupper($text)));
        $string = preg_replace('/[^A-Za-z0-9\-]/','',$string);

        return preg_replace('/-+/', '-', $string);
	}

	public function get_user_id($client_token)
	{
		$get_user = $this->db->query("
			SELECT
				id
			FROM
				mst_user
			WHERE
				api_token = '$client_token'
		");

		$user_id = null;
		foreach ($get_user->result_array() as $key) {
			$user_id = $key['id'];
		}

		return $user_id;
	}

	public function app_add($params)
	{
		$app = isset($params['app'])? $params['app'] : '';
		$url = isset($params['url'])? $params['url'] : '';

		if (empty($app)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'app' tidak diset";
			goto output;
		}else if(empty($url)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'url' tidak diset";
			goto output;
		}

		$data = $this->db->query("SELECT id FROM $this->table 
									WHERE app = '$app'")->num_rows();
		if ($data > 0) {
			$result['Error'] = true;
			$result['Message'] = "App sudah terdaftar";
			goto output;
		}else{
			$config_api_expired = $this->config->item("api_expired");
			$api_expired = date("Y-m-d", strtotime("+".env('API_EXPIRED')." days", strtotime(date("Y-m-d"))));

			$config['tabel'] = $this->table;
			$config['data'] = [
				'app' => $app,
				'url' => $url,
				'token' => $this->generate_token(),
				'expired' => $api_expired
			];
			$result = $this->query_add($config);
			goto output;
		}

		output:
		return $result;

	}

	public function query_pagination($params)
	{
		$jumlah_data = floatval($params['jumlah_data']);
		$limit = floatval($params['limit']);
		$page = $params['page']? $params['page'] : 1;
		$jumlah_halaman = @ceil($jumlah_data/$limit);

		$start = ($limit * $page) - $limit;

		if (empty($limit) || empty($page)) {
			$result = [
				"Status"  => false,
				"Data_ke"     => 0
			];

			goto output;
		}

		$result = [
			"Status"  		=> true,
			"Halaman"     	=> $page,
			"Limit"			=> $limit,
			"Data_ke"    	=> $start,
			"Jml_data"    	=> "$jumlah_data",
			"Jml_halaman" 	=> "$jumlah_halaman",
			"Info_paging" 	=> $limit." | ".$page." - ".$jumlah_halaman." halaman"
		];
		goto output;

		output:
		return $result;

	}

	// Query

	public function query_list($params)
	{
		$db 	= isset($params['db'])? $params['db'] : '';
		$tabel 	= isset($params['tabel'])? $params['tabel'] : '';
		$kolom 	= isset($params['kolom'])? $params['kolom'] : '';

		if (empty($db)) {
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($kolom)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'kolom' tidak diset";
				goto output;
			}
			$limit  = empty($params['limit']) ? "" : $params['limit'];

			$filter = empty($params['filter']) ? "" : " WHERE ".$params['filter'];

			$page   = empty($params['page']) ? 1 : $params['page'];

			$jumlah_data = $this->db->query("SELECT ".$kolom." FROM ".$tabel." ".$filter)->num_rows();


			$config['jumlah_data'] = $jumlah_data;
			$config['limit'] = $limit;
			$config['page']	= $page;

			$pagination = $this->query_pagination($config);

			$paging = (empty($limit) || empty($page)) ? "" : " LIMIT ".$pagination['Data_ke']." , ".$limit;

			$sort = empty($params['sort']) ? "" : " ORDER BY ".$params['sort'];

			$query = $this->db->query("SELECT ".$kolom." FROM ".$tabel." ".$filter." ".$sort." ".$paging);

			$no = 0;
			$a  = 0;

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $key) {
					$result['Error']			= false;
					$result['Message']		= null;
					$result['Data'][$no++]  	= $key;
					$result['Pagination'] 	= $pagination;
				}
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}else{
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($kolom)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'kolom' tidak diset";
				goto output;
			}
			$limit  = (empty($params['limit'])) ? "" : $params['limit'];

			$filter = (empty($params['filter'])) ? "" : " WHERE ".$params['filter'];

			$page   = (empty($params['page'])) ? null : $params['page'];

			$jumlah_data = $database->query("SELECT ".$kolom." FROM ".$tabel." ".$filter)->num_rows();

			$config['jumlah_data'] = $jumlah_data;
			$config['limit'] = $limit;
			$config['page']	= $page;

			$pagination = $this->query_pagination($config);

			$paging = (empty($limit) || empty($page)) ? "" : " LIMIT ".$pagination['Data_ke']." , ".$limit;

			$sort = (empty($params['sort'])) ? "" : " ORDER BY ".$params['sort'];

			$query = $database->query("SELECT ".$kolom." FROM ".$tabel." ".$filter." ".$sort." ".$paging);

			$no = 0;
			$a  = 0;

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $key) {
					$result['Error']			= false;
					$result['Message']		= null;
					$result['Data'][$no++]  	= $key;
					$result['Pagination'] 	= $pagination;
				}
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}

		output:
		return $result;

	}

	public function query_row($params)
	{
		$db 	= isset($params['db'])? $params['db'] : '';
		$tabel 	= isset($params['tabel'])? $params['tabel'] : '';
		$kolom 	= isset($params['kolom'])? $params['kolom'] : '';
		$filter 	= isset($params['filter'])? $params['filter'] : '';

		if (empty($db)) {
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($kolom)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'kolom' tidak diset";
				goto output;
			}else if(empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}

			$query = $this->db->query("SELECT ".$kolom." FROM ".$tabel." WHERE ".$filter)->row_array();

			if ($query) {
				$result['Error']		= false;
				$result['Message']		= null;
				$result['Data']			= $query;
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}else{
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($kolom)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'kolom' tidak diset";
				goto output;
			}else if(empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}

			$query = $database->query("SELECT ".$kolom." FROM ".$tabel." WHERE ".$filter);

			$no = 0;
			$a  = 0;

			if ($query->num_rows() > 0) {
				$result['Error']	= false;
				$result['Message']	= null;
				$result['Data'] 	= $query->row_array();
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}

		output:
		return $result;

	}

	public function query_add($params)
	{
		$db 	= isset($params['db'])? $params['db'] : '';
		$tabel 	= isset($params['tabel'])? $params['tabel'] : '';
		$data 	= isset($params['data'])? $params['data'] : '';

		if (empty($db)) {
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($data)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'data' tidak diset";
				goto output;
			}
			
			$query = $this->db->insert($tabel, $data);

			if ($query) {
				$result['Error']		= false;
				$result['Message']		= empty($params['pesan_sukses'])? "Berhasil menambahkan data" : $params['pesan_sukses'];
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = $this->db->error()['message'];
				goto output;
			}

		}else{
			if(empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}else if(empty($kolom)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'kolom' tidak diset";
				goto output;
			}
			$query = $database->insert($tabel, $data);

			if ($query) {
				$result['Error']  = false;
				$result['Message'] = empty($params['pesan_sukses'])? $params['pesan_sukses'] : "Berhasil menambahkan data";
				goto output;
			}
			else{
				$result['Error']  = true;
				$result['Message'] = $this->db->error()['message'];
				goto output;
			}
		}

		output:
		return $result;

	}

	public function query_update($params)
	{
		$database 	= isset($params['db'])? $params['db'] : '';
		$tabel 		= isset($params['tabel'])? $params['tabel'] : '';
		$data  		= isset($params['data'])? $params['data'] : '';
		$filter 	= isset($params['filter'])? $params['filter'] : '';

		if (empty($database)) {
			if (empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}
			else if (empty($data)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'data' tidak diset";
				goto output;
			}
			else if (empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}
			$cek_data = $this->db->get_where($tabel, $filter)->num_rows();

			if ($cek_data > 0) {
				$query = $this->db->update($tabel, $data, $filter);

				if ($query) {
					$result['Error'] = false;
					$result['Message'] = empty($params['pesan_sukses'])? "Data berhasil di ubah" : $params['pesan_sukses'];
					goto output;
				}
				else{
					$result['Error'] = true;
					$result['Message'] = $this->db->error()['message'];
					goto output;
				}
			}
			else{
				$result['Error'] = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}
		else{
			if (empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}
			else if (empty($data)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'data' tidak diset";
				goto output;
			}
			else if (empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}
			$cek_data = $database->get_where($tabel, $filter)->num_rows();

			if ($cek_data > 0) {
				$query = $database->update($tabel, $nilai, $filter);

				if ($query) {
					$result['Error'] = false;
					$result['Message'] = empty($params['pesan_sukses'])? "Data berhasil di ubah" : $params['pesan_sukses'];
					goto output;
				}
				else{
					$result['Error'] = true;
					$result['Message'] = $database->error()['message'];
					goto output;
				}
			}
			else{
				$result['Error'] = true;
				$result['Message'] = "Data tidak ditemukan";
				goto output;
			}
		}

		output:
		return $result;
	}

	public function query_delete($params)
	{
		$database = isset($params['db'])? $params['db'] : '';
		$tabel = isset($params['tabel'])? $params['tabel'] : '';
		$filter = isset($params['filter'])? $params['filter'] : '';

		if (empty($database)) {
			
		
			if (empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}
			else if (empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}
			else{
				$cek_id = $this->db->get_where($tabel, $filter)->num_rows();

				if ($cek_id > 0) {
					$query = $this->db->delete($tabel, $filter);

					if ($query) {
						$result['Error'] = false;
						$result['Message'] = empty($params['pesan_sukses'])? "Data berhasil di hapus" : $params['pesan_sukses'];
						goto output;
					}
					else{
						$result['Error'] = true;
						$result['Message'] = $this->db->error()['message'];
						goto output;
					}
				}
				else{
					$result['Error'] = true;
					$result['Message'] = "Data tidak ditemukan";
					goto output;
				}
			}

		}else{
			if (empty($tabel)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'tabel' tidak diset";
				goto output;
			}
			else if (empty($filter)) {
				$result['Error'] = true;
				$result['Message'] = "Parameter 'filter' tidak diset";
				goto output;
			}
			else{
				$cek_id = $database->get_where($tabel, $filter)->num_rows();

				if ($cek_id > 0) {
					$query = $database->delete($tabel, $filter);

					if ($query) {
						$result['Error'] = false;
						$result['Message'] = empty($params['pesan_sukses'])? "Data berhasil di hapus" : $params['pesan_sukses'];
						goto output;
					}
					else{
						$result['Error'] = true;
						$result['Message'] = $database->error()['message'];
						goto output;
					}
				}
				else{
					$result['Error'] = true;
					$result['Message'] = "Data tidak ditemukan";
					goto output;
				}
			}
		}

		output:
		return $result;
	}

	public function recordsTotal($table, $columns = 'id')
	{
		return $this->db->query("SELECT $columns FROM $table")->num_rows();
	}

	public function recordsFiltered($table, $columns = 'id', $where)
	{
		return $this->db->query("SELECT $columns FROM $table WHERE $where")->num_rows();
	}

	public function midtrans($params)
	{
		$midtrans_url = (env('MIDTRANS_ENV') == "production") ? "https://api.midtrans.com/v2/":"https://api.sandbox.midtrans.com/v2/";

		$url = $params['url'];
		$method = (empty($params['method'])) ? "GET" : $params['method'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $midtrans_url.$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    "accept: application/json",
		    "authorization:  ".base64_encode(env('MIDTRANS_SERVER_KEY')),
		    "content-type: application/json"
		));
		$result = curl_exec($ch);
		curl_close($ch);

		return json_decode($result, true);
	}

}

/* End of file MY_Model.php */
/* Location: .//F/xampp/htdocs/GitHub/Codeigniter-env/api/base/core/MY_Model.php */