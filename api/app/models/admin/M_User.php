<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends MY_Model {

	protected $tabel = 'mst_user';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	function all($params)
	{

		$keyword = isset($params['search']['value'])? $params['search']['value'] : '';

		// $limit = isset($params['limit'])? $params['limit'] : 10;
		$draw = $params['draw'];
		$start = $params['start'];
		$length = $params['length'];

		$paging = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";

		$filter_data = empty($keyword)? "" : " AND $this->tabel.nama LIKE '%$keyword%'"; 

		$query = $this->db->query("SELECT
										$this->tabel.id as id_user,
									    CONCAT('".base_url('')."', $this->tabel.foto) as foto_user,
									    $this->tabel.nama as nama_user,
									    $this->tabel.username as slug,
									    $this->tabel.email,
									    $this->tabel.level as role,
									    $this->tabel.no_telepon as telepon,
									    $this->tabel.provinsi_id,
									    $this->tabel_provinsi.nama as nama_provinsi,
									    $this->tabel.kabupaten_id,
									    $this->tabel_kabupaten.nama as nama_kabupaten,
									    $this->tabel.kecamatan_id,
									    $this->tabel_kecamatan.nama as nama_kecamatan,
									    $this->tabel_kabupaten.kode_pos,
									    $this->tabel.alamat,
									    $this->tabel.jenis_kelamin,
									    $this->tabel.tanggal_lahir,
									    $this->tabel.tempat_lahir,
									    $this->tabel.status_utama,
									    $this->tabel.diblokir,
									    $this->tabel.catatan_diblokir,
									    $this->tabel.status
								    FROM 
								    	$this->tabel
								    LEFT JOIN
								    	$this->tabel_provinsi
								        ON
								        $this->tabel.provinsi_id=$this->tabel_provinsi.id
								    LEFT JOIN 
								    	$this->tabel_kabupaten
								        ON 
								        $this->tabel.kabupaten_id=$this->tabel_kabupaten.id
								    LEFT JOIN 
								    	$this->tabel_kecamatan
								        ON
								        $this->tabel.kecamatan_id=$this->tabel_kecamatan.id
								    WHERE 
								    	status_utama = 0
								       	$filter_data");

		$recordsTotal = $this->db->query("SELECT
										$this->tabel.id as id_user,
									    CONCAT('".base_url('')."', $this->tabel.foto) as foto_user,
									    $this->tabel.nama as nama_user,
									    $this->tabel.username as slug,
									    $this->tabel.email,
									    $this->tabel.level as role,
									    $this->tabel.no_telepon as telepon,
									    $this->tabel.provinsi_id,
									    $this->tabel_provinsi.nama as nama_provinsi,
									    $this->tabel.kabupaten_id,
									    $this->tabel_kabupaten.nama as nama_kabupaten,
									    $this->tabel.kecamatan_id,
									    $this->tabel_kecamatan.nama as nama_kecamatan,
									    $this->tabel_kabupaten.kode_pos,
									    $this->tabel.alamat,
									    $this->tabel.jenis_kelamin,
									    $this->tabel.tanggal_lahir,
									    $this->tabel.tempat_lahir,
									    $this->tabel.status_utama,
									    $this->tabel.diblokir,
									    $this->tabel.catatan_diblokir,
									    $this->tabel.status
								    FROM 
								    	$this->tabel
								    LEFT JOIN
								    	$this->tabel_provinsi
								        ON
								        $this->tabel.provinsi_id=$this->tabel_provinsi.id
								    LEFT JOIN 
								    	$this->tabel_kabupaten
								        ON 
								        $this->tabel.kabupaten_id=$this->tabel_kabupaten.id
								    LEFT JOIN 
								    	$this->tabel_kecamatan
								        ON
								        $this->tabel.kecamatan_id=$this->tabel_kecamatan.id
								    WHERE 
								    	status_utama = 0
								    ")->num_rows();

		$recordsFiltered = $this->db->query("SELECT
										$this->tabel.id as id_user,
									    CONCAT('".base_url('')."', $this->tabel.foto) as foto_user,
									    $this->tabel.nama as nama_user,
									    $this->tabel.username as slug,
									    $this->tabel.email,
									    $this->tabel.level as role,
									    $this->tabel.no_telepon as telepon,
									    $this->tabel.provinsi_id,
									    $this->tabel_provinsi.nama as nama_provinsi,
									    $this->tabel.kabupaten_id,
									    $this->tabel_kabupaten.nama as nama_kabupaten,
									    $this->tabel.kecamatan_id,
									    $this->tabel_kecamatan.nama as nama_kecamatan,
									    $this->tabel_kabupaten.kode_pos,
									    $this->tabel.alamat,
									    $this->tabel.jenis_kelamin,
									    $this->tabel.tanggal_lahir,
									    $this->tabel.tempat_lahir,
									    $this->tabel.status_utama,
									    $this->tabel.diblokir,
									    $this->tabel.catatan_diblokir,
									    $this->tabel.status
								    FROM 
								    	$this->tabel
								    LEFT JOIN
								    	$this->tabel_provinsi
								        ON
								        $this->tabel.provinsi_id=$this->tabel_provinsi.id
								    LEFT JOIN 
								    	$this->tabel_kabupaten
								        ON 
								        $this->tabel.kabupaten_id=$this->tabel_kabupaten.id
								    LEFT JOIN 
								    	$this->tabel_kecamatan
								        ON
								        $this->tabel.kecamatan_id=$this->tabel_kecamatan.id
								    WHERE 
								    	status_utama = 0
								       	$filter_data
								    ")->num_rows();

		if ($query->num_rows() > 0) {
			
			$no = 0;

			// $config['jumlah_data'] = $query->num_rows();
			// $config['limit'] = $limit;
			// $config['page']	= empty($params['page'])? null : $params['page'];

			// $pagination = $this->query_pagination($config);

			$query = $this->db->query("SELECT
										$this->tabel.id as id_user,
									    CONCAT('".base_url('')."', $this->tabel.foto) as foto_user,
									    $this->tabel.nama as nama_user,
									    $this->tabel.username as slug,
									    $this->tabel.email,
									    $this->tabel.level as role,
									    $this->tabel.no_telepon as telepon,
									    $this->tabel.provinsi_id,
									    $this->tabel_provinsi.nama as nama_provinsi,
									    $this->tabel.kabupaten_id,
									    $this->tabel_kabupaten.nama as nama_kabupaten,
									    $this->tabel.kecamatan_id,
									    $this->tabel_kecamatan.nama as nama_kecamatan,
									    $this->tabel_kabupaten.kode_pos,
									    $this->tabel.alamat,
									    $this->tabel.jenis_kelamin,
									    $this->tabel.tanggal_lahir,
									    $this->tabel.tempat_lahir,
									    $this->tabel.status_utama,
									    $this->tabel.diblokir,
									    $this->tabel.catatan_diblokir,
									    $this->tabel.status
								    FROM 
								    	$this->tabel
								    LEFT JOIN
								    	$this->tabel_provinsi
								        ON
								        $this->tabel.provinsi_id=$this->tabel_provinsi.id
								    LEFT JOIN 
								    	$this->tabel_kabupaten
								        ON 
								        $this->tabel.kabupaten_id=$this->tabel_kabupaten.id
								    LEFT JOIN 
								    	$this->tabel_kecamatan
								        ON
								        $this->tabel.kecamatan_id=$this->tabel_kecamatan.id
								    WHERE
								    	status_utama = 0
								        $filter_data
								    ORDER BY $this->tabel.id DESC
								    $paging
								    ");

			foreach ($query->result_array() as $key) {
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = $key;
				// $result['Pagination'] = $pagination;
			}
			$result['draw'] = $draw;
			$result['recordsFiltered'] = $recordsFiltered;
			$result['recordsTotal'] = $recordsTotal;
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		$result['draw'] = $draw;
		$result['Data'] = array();
		$result['recordsFiltered'] = $recordsFiltered;
		$result['recordsTotal'] = $recordsTotal;
		goto output;

		output:
		return $result;


	}

	function add($params)
	{
		$kirim_email = isset($params['kirim_email'])? $params['kirim_email'] : 1;
		$nama = isset($params['nama'])? $params['nama'] : '';
		$email = isset($params['email'])? $params['email'] : '';
		$password = isset($params['password'])? $params['password'] : '';
		$konfirmasi_password = isset($params['konfirmasi_password'])? $params['konfirmasi_password'] : '';
		$provinsi = isset($params['provinsi'])? $params['provinsi'] : '';
		$kabupaten = isset($params['kabupaten'])? $params['kabupaten'] : '';
		$kecamatan = isset($params['kecamatan'])? $params['kecamatan'] : '';
		$alamat = isset($params['alamat'])? $params['alamat'] : '';
		$kode_pos = isset($params['kode_pos'])? $params['kode_pos'] : '';
		$telepon = isset($params['telepon'])? $params['telepon'] : '';
		$role = isset($params['role'])? $params['role'] : 2;

		if (empty($nama)) {
			$result['Error'] = true;
			$result['Message'] = "Nama tidak boleh kosong";

			goto output;
		}else if(empty($email)) {
			$result['Error'] = true;
			$result['Message'] = "Email tidak boleh kosong";

			goto output;
		}else if(empty($password)) {
			$result['Error'] = true;
			$result['Message'] = "Password tidak boleh kosong";

			goto output;
		}else if(empty($konfirmasi_password)) {
			$result['Error'] = true;
			$result['Message'] = "Konfirmasi Password tidak boleh kosong";

			goto output;
		}else if(empty($role)) {
			$result['Error'] = true;
			$result['Message'] = "Pilih role penggguna";

			goto output;
		}

		$pass_length = strlen($password);
		$konfirmasi_pass_length = strlen($konfirmasi_password);

		if ($pass_length < 5) {
			$result['Error'] = true;
			$result['Message'] = "Password minimal 5 karakter";

			goto output;
		}else if(($konfirmasi_pass_length) < 5) {
			$result['Error'] = true;
			$result['Message'] = "Password minimal 5 karakter";

			goto output;
		}

		if ($password !== $konfirmasi_password) {

			$result['Error'] = true;
			$result['Message'] = "Password tidak sama";

			goto output;
			
		}

		$cek_email = $this->db->query("SELECT
											id
										FROM
											$this->tabel
										WHERE
											email = '$email'")->num_rows();

		if ($cek_email > 0) {

			$result['Error'] = true;
			$result['Message'] = "Email tidak tersedia";
			goto output;
		
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel")->num_rows();

		$kirim_email = ($kirim_email == 0)? true : false;

		$cost = $user < 1? 12 : 10;

		$username = uniqid(strtolower(explode(' ',$nama)[0]),false);

		if ($level == 1) {
			$kode_verifikasi = null;
			$kirim_email = false;
			$status = 1;
			$username = $this->Func->str_random(15,'sha1');
		}else{
			$kode_verifikasi = $this->Func->generate_code();
			$status = 0;
		}

		$token = $this->generate_token();

		$data = [
			'nama' => $nama,
			'username' => $username,
			'email' => $email,
			'password' => $this->hash->make($password),
			'provinsi_id' => $provinsi,
			'kabupaten_id' => $kabupaten,
			'kecamatan_id' => $kecamatan,
			'alamat' => $alamat,
			'kode_pos' => $kode_pos,
			'no_telepon' => $telepon,
			'api_token' => $token,
			'kode_verifikasi' => $kode_verifikasi,
			'status' => $status,
			'level' => $role
		];

		$config['tabel'] = $this->tabel;
		$config['data'] = $data;

		$query = $this->query_add($config);

		$kode = strtolower($kode_verifikasi);

		$url = "?member=$kode=$token";

		if ($query['Error']) {
			
			$result['Error'] = true;
			$result['Message'] = "Gagal menambahkan pengguna ";
			goto output;

		}else{

			if ($kirim_email) {
				
				$html = $this->my_email->template_email('Konfirmasi Email',$nama,$url);

				$result = $this->my_email->send_email($email,'Verifikasi email',$html);

				goto output;

			}

			$result['Error'] = false;
			$result['Message'] = "Berhasil menambahkan pengguna $nama";
			goto output;

		}

		output:
		return $result;
	}

	function update($params)
	{
		$id_user = isset($params['id_user'])? $params['id_user'] : '';
		$kirim_email = isset($params['kirim_email'])? $params['kirim_email'] : '';
		$nama = isset($params['nama'])? $params['nama'] : '';
		$email = isset($params['email'])? $params['email'] : '';
		$provinsi = isset($params['provinsi'])? $params['provinsi'] : '';
		$kabupaten = isset($params['kabupaten'])? $params['kabupaten'] : '';
		$kecamatan = isset($params['kecamatan'])? $params['kecamatan'] : '';
		$alamat = isset($params['alamat'])? $params['alamat'] : '';
		$kode_pos = isset($params['kode_pos'])? $params['kode_pos'] : '';
		$telepon = isset($params['telepon'])? $params['telepon'] : '';
		$role = isset($params['role'])? $params['role'] : 2;

		if (empty($id_user)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_user' tidak diset";

			goto output;
		}else if (empty($nama)) {
			$result['Error'] = true;
			$result['Message'] = "Nama tidak boleh kosong";

			goto output;
		}else if(empty($email)) {
			$result['Error'] = true;
			$result['Message'] = "Email tidak boleh kosong";

			goto output;
		}else if(empty($role)) {
			$result['Error'] = true;
			$result['Message'] = "Pilih role penggguna";

			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_user,
										email
									FROM
										$this->tabel
									WHERE
										id = $id_user")->row_array();
		if ($query) {
			$send_mail = false;
			if ($email !== $query['email']) {
				if ($kirim_email == 1) {
					$send_mail = true;
				}else if($kirim_email == 0) {
					$send_email = false;
				}

			}

			$data = [
				'nama' => $nama,
				'provinsi_id' => $provinsi,
				'kabupaten_id' => $kabupaten,
				'kecamatan_id' => $kecamatan,
				'alamat' => $alamat,
				'kode_pos' => $kode_pos,
				'no_telepon' => $telepon,
				'level' => $role,
				'status' => $kirim_email
			];

			$config['tabel'] = $this->tabel;
			$config['data'] = $data;
			$config['filter'] = "id = $id_user";

			$result = $this->query_update($config);
			if ($result['Error'] == false) {
				if ($send_mail) {
				
					$html = $this->my_email->template_email('Konfirmasi Email',$nama,$url);

					$result = $this->my_email->send_email($email,'Verifikasi email',$html);

					goto output;

				}
			}
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		output:
		return $result;

	}

	function reset($params)
	{
		$id_user = isset($params['id_user'])? $params['id_user'] : '';
		$password = isset($params['password'])? $params['password'] : '';
		$konfirmasi_password = isset($params['konfirmasi_password'])? $params['konfirmasi_password'] : '';
		if (empty($id_user)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_user' tidak diset";
			goto output;
		}else if(empty($password)) {
			$result['Error'] = true;
			$result['Message'] = "Password tidak boleh kosong";
			goto output;
		}else if(empty($konfirmasi_password)) {
			$result['Error'] = true;
			$result['Message'] = "Konfirmasi Password tidak boleh kosong";
			goto output;
		}

		if ($password !== $konfirmasi_password) {
			$result['Error'] = true;
			$result['Message'] = "Password tidak sama";
			goto output;
		}

		$query = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel
									WHERE
										id = $id_user")->row_array();
		if ($query) {
			
			$data = [
				'password' => $this->hash->make($password)	
			];

			$config['tabel'] = $this->tabel;
			$config['data'] = $data;
			$config['filter'] = "id = $id_user";

			$result = $this->query_update($config);
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function blokir($params)
	{
		$user_id = isset($params['user_id'])? $params['user_id'] : '';
		$catatan = isset($params['catatan'])? $params['catatan'] : '';
		if (empty($user_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter user_id tidak diset";
			goto output;
		}else if(empty($catatan)) {
			$result['Error'] = true;
			$result['Message'] = "Catatan tidak boleh kosong";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										id = '$user_id'
										AND
										diblokir = '0'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$up = $this->db->update($this->tabel,['diblokir' => 1,'catatan_diblokir' => $catatan],['id' => $user_id]);
		if ($up) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil memblokir akun";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal memblokir akun";
		goto output;
		output:
		return $result;

	}

	function buka_blokir($params)
	{
		$user_id = isset($params['user_id'])? $params['user_id'] : '';
		if (empty($user_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter user_id tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										id = '$user_id'
										AND
										diblokir = '1'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$up = $this->db->update($this->tabel,['diblokir' => 0,'catatan_diblokir' => null],['id' => $user_id]);
		if ($up) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil membuka blokir akun";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal membuka blokir akun";
		goto output;
		output:
		return $result;

	}

}

/* End of file M_User.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/admin/M_User.php */