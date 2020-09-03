<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Api extends MY_Model {

	protected $tabel = 'mst_api';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	function add($params)
	{
		$result = $this->app_add($params);

		return $result;

	}

	function bearer_token($params)
	{
		$app_id = isset($params['app_id'])? $params['app_id'] : '';
		$auth_token = isset($params['auth_token'])? $params['auth_token'] : '';
		if (empty($app_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'app_id' tidak diset";
			goto output;
		}else if(empty($auth_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'auth_token' tidak diset";
			goto output;
		}

		if ($auth_token !== 'Bearer') {
			$result['Error'] = true;
			$result['Message'] = "Token ditolak";
			goto output;
		}

		$config['tabel'] = $this->tabel;
		$config['kolom'] = "
			token as access_token,
			app as aplication_id,
			expired as expired_in,
			id as app_id
		";
		$config['filter'] = "app = '$app_id'";
		$apps = $this->query_row($config);

		if ($apps) {

			$apps = $apps['Data'];

			$expired_id = $apps['expired_in'];
			
			if (strtotime($expired_id) <= strtotime(date("Y-m-d"))) {
				$expired = date("Y-m-d", strtotime("+".env('API_EXPIRED')." days", strtotime(date("Y-m-d"))));

				$this->db->update($this->tabel, array(
					'expired' => $expired
				), array(
					'id' => $apps['app_id']
				));
			}
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Data'] = [
				'application_id' => $apps['aplication_id'],
				'access_token' => $apps['access_token'],
				'expired_in' => strtotime($apps['expired_in']),
				'token_type' => "Bearer"
			];
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "App tidak terdaftar";
		goto output;

		output:
		return $result;

	}

	function get_token($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset ";
			goto output;
		}

		$query = $this->db->query("SELECT
										$this->tabel_user.id as id_user,
									    CONCAT('".base_url()."', $this->tabel_user.foto) as foto_user,
									    $this->tabel_user.nama as nama_user,
									    $this->tabel_user.username as slug,
									    $this->tabel_user.email,
									    $this->tabel_user.level as role,
									    $this->tabel_user.no_telepon as telepon,
									    $this->tabel_user.provinsi_id,
									    $this->tabel_provinsi.nama as nama_provinsi,
									    $this->tabel_user.kabupaten_id,
									    $this->tabel_kabupaten.nama as nama_kabupaten,
									    $this->tabel_user.kecamatan_id,
									    $this->tabel_kecamatan.nama as nama_kecamatan,
									    $this->tabel_kabupaten.kode_pos,
									    $this->tabel_user.alamat,
									    $this->tabel_user.jenis_kelamin,
									    $this->tabel_user.tanggal_lahir,
									    $this->tabel_user.tempat_lahir,
									    $this->tabel_user.status_utama,
									    $this->tabel_user.status,
									    $this->tabel_user.diblokir,
									    $this->tabel_user.catatan_diblokir,
									    $this->tabel_toko.status as toko
								    FROM 
								    	$this->tabel_user
								    LEFT JOIN
								    	$this->tabel_provinsi
								        ON
								        $this->tabel_user.provinsi_id=$this->tabel_provinsi.id
								    LEFT JOIN 
								    	$this->tabel_kabupaten
								        ON 
								        $this->tabel_user.kabupaten_id=$this->tabel_kabupaten.id
								    LEFT JOIN 
								    	$this->tabel_kecamatan
								        ON
								        $this->tabel_user.kecamatan_id=$this->tabel_kecamatan.id
								    LEFT JOIN 
								    	$this->tabel_toko
								        ON
								        $this->tabel_user.id=$this->tabel_toko.user_id
								    WHERE 
								    	$this->tabel_user.api_token = '$client_token'")->row_array();
		if ($query) {
			$result['Error']		= false;
			$result['Message']		= null;
			$result['Data']			= $query;
			goto output;
		}
		$result['Error']		= true;
		$result['Message']		= "Data tidak ditemukan";
		goto output;
		output:
		return $result;
	}

}

/* End of file M_Api.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Api.php */