<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Func extends MY_Model {

	protected $table = 'mst_api';

	protected $table_user = 'mst_user';
	
	protected $table_toko = 'mst_toko';

	protected $table_provinsi = 'mst_provinsi';

	protected $table_kabupaten = 'mst_kabupaten';

	protected $table_kecamatan = 'mst_kecamatan';

	public function get_token()
	{
		$app_id = env('API_APP');
		$query = $this->db->query("SELECT
									id  as id_app,
									token as access_token,
									app as application_id,
									expired as expired_in
								FROM
									$this->table
								WHERE
									app = '$app_id'");
		$result = null;
		if ($query->num_rows() > 0) {
			$app = $query->row_array();
			if (strtotime($app['expired_in']) <= strtotime(date("Y-m-d"))) {
				$expired = date("Y-m-d", strtotime("+".env('API_EXPIRED')." days", strtotime(date("Y-m-d"))));

				$data = [
					'token' => $this->generate_token(),
					'expired' => $expired
				];

				$this->db->update($this->table, $data, array(
					'id' => $app['id_app']
				));
				$app = [
					'access_token' => $data['token'],
					'application_id' => $app['application_id'],
					'expired_in' => strtotime($data['expired'])
				];
			}
			$result = [
				'access_token' => $app['access_token'],
				'application_id' => $app['application_id'],
				'expired_in' => strtotime($app['expired_in'])
			];
		}

		return $result;
	}

	function cek_auth()
	{
		$this->load->helper('cookie');
		$token = get_cookie('role');
		$user = $this->db->query("SELECT
										id as id_user,
										level as role,
										nama
									FROM
										$this->table_user
									WHERE
										api_token = '$token'
										AND
										status = '1'
										AND
										diblokir = '0'")->row_array();
		if ($user) {
		    $toko = $this->db->query("SELECT
										 id
										FROM
											$this->table_toko
										WHERE
											user_id = '$user[id_user]'
											AND
											diblokir = '0'")->num_rows();
			
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Toko'] = $toko;
			$result['Rules'] = $user['role'];
			$result['User_id'] = $user['id_user'];
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;

	}

	public function verifikasi_member($params)
	{
		$kode_verifikasi = isset($params['kode_verifikasi'])? $params['kode_verifikasi'] : '';
		$token = isset($params['token'])? $params['token'] : '';
		if (empty($kode_verifikasi)) {
			$result['Error'] = true;
			$result['Message'] = "Data tidak ditemukan";
			goto output;
		}else if(empty($token)) {
			$result['Error'] = true;
			$result['Message'] = "Data tidak ditemukan";
			goto output;
		}

		$query = $this->db->query("SELECT
										$this->table_user.id as id_user,
									    $this->table_user.foto as foto_user,
									    $this->table_user.nama as nama_user,
									    $this->table_user.username as slug,
									    $this->table_user.email,
									    $this->table_user.level as role,
									    $this->table_user.no_telepon as telepon,
									    $this->table_user.provinsi_id,
									    $this->table_provinsi.nama as nama_provinsi,
									    $this->table_user.kabupaten_id,
									    $this->table_kabupaten.nama as nama_kabupaten,
									    $this->table_user.kecamatan_id,
									    $this->table_kecamatan.nama as nama_kecamatan,
									    $this->table_kabupaten.kode_pos,
									    $this->table_user.alamat,
									    $this->table_user.jenis_kelamin,
									    $this->table_user.tanggal_lahir,
									    $this->table_user.tempat_lahir,
									    $this->table_user.status_utama,
									    $this->table_user.status
									FROM 
								    	$this->table_user
								    LEFT JOIN
								    	$this->table_provinsi
								        ON
								        $this->table_user.provinsi_id=$this->table_provinsi.id
								    LEFT JOIN 
								    	$this->table_kabupaten
								        ON 
								        $this->table_user.kabupaten_id=$this->table_kabupaten.id
								    LEFT JOIN 
								    	$this->table_kecamatan
								        ON
								        $this->table_user.kecamatan_id=$this->table_kecamatan.id
								    WHERE 
								    	api_token = '$token'
								    AND 
								    	status = '0'")->row_array();
		if ($query) {
		    $data = [
		       'status' => 1  
		    ];
		    
		    $update = $this->db->update($this->table_user,$data,['api_token' => $token]);
			if($update){
			    $result['Error'] = false;
                $result['Message'] = "Berhasil memverifikasi email";
    			goto output;
			}
            $result['Error'] = true;
		    $result['Message'] = "Gagal memverifikasi email";
		    goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;

		output:
		return $result;
	}

}

/* End of file M_Func.php */
/* Location: .//F/xampp/htdocs/com/JPStore/base/models/M_Func.php */