<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorization extends MY_Model {

	protected $tabel = 'mst_api';

	protected $tabel_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();
	}

	public function check_auth()
	{
		$head = $this->input->request_headers();
		$app = isset($head['X-Api-App'])? $head['X-Api-App'] : '';
		$token = isset($head['X-Api-Token'])? $head['X-Api-Token'] : '';
		if (empty($app)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'X-Api-App' tidak diset";
			goto output;
		}else if(empty($token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'X-Api-App' tidak diset";
			goto output;
		}
		$data = $this->db->query("SELECT 
										id as app_id,
										token as access_token,
										app as application_id,
										expired as expired_in,
										created_at
									FROM 
										$this->tabel 
									WHERE 
										app = '$app'");
		if ($data->num_rows() > 0) {

			$app = $data->row_array();
			if ($token !== $app['access_token']) {
				$result['Error'] = true;
				$result['Message'] = "Token tidak terdaftar";
				goto output;
			}

				if (strtotime($app['expired_in']) <= strtotime(date("Y-m-d"))) {
					$expired = date("Y-m-d", strtotime("+".env('API_EXPIRED')." days", strtotime(date("Y-m-d"))));

					$this->db->update($this->tabel, array(
						'expired' => $expired
					), array(
						'id' => $app['app_id']
					));
				}
				$config['tabel'] = $this->tabel;
				$config['kolom'] = "
					token as access_token, 
					expired as expires_in
				";
				$config['filter'] = "app = '".$app['application_id']."'";
				$result = $this->query_row($config);
				goto output;
		}else{
			$result['Error'] = true;
			$result['Message'] = "App tidak terdaftar";
			goto output;
		}
		output:
		return $result;
	}

	public function check_auth_admin()
	{
		$head = $this->input->request_headers();
		$app = isset($head['X-Api-App'])? $head['X-Api-App'] : '';
		$token = isset($head['X-Api-Token'])? $head['X-Api-Token'] : '';
		$client_token = isset($head['X-Client-Token'])? $head['X-Client-Token'] : '';

		if(empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'X-Client-Token' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user,
										level as role
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token' ");
		if ($user->num_rows() == 1) {
			$user = $user->row_array();
			if ($user['role'] == 1) {
				$result['Error'] = false;
				$result['Message'] = null;
				goto output;
			}else{
				$result['Error'] = true;
				$result['Message'] = "Akses ditolak";
				goto output;
			}

		}
		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

}

/* End of file Authorization.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/Authorization.php */