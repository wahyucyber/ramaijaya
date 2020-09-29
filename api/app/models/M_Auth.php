<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends MY_Model {

	protected $tabel = 'mst_user';

	protected $fillable = "
		foto,
		nama,
		username,
		email,
		level as role,
		api_token as token,
		no_telepon,
		provinsi_id,
		kabupaten_id,
		kecamatan_id,
		kode_pos,
		alamat,
		jenis_kelamin,
		tanggal_lahir,
		tempat_lahir,
		status_utama,
		status
	";

	protected $filter = "status = 1";

	public function register($params)
	{
		$params = __hsp($params);
		$nama = isset($params['nama'])? htmlspecialchars($params['nama']) : '';
		$email = isset($params['email'])? htmlspecialchars(trim($params['email'])) : '';
		$password = isset($params['password'])? htmlspecialchars($params['password']) : '';
		$google_id = isset($params['google_id'])? htmlspecialchars($params['google_id']) : '';
		$konfirmasi_password = isset($params['konfirmasi_password'])? htmlspecialchars($params['konfirmasi_password']) : '';

		if (empty($nama)) {

			$result['Error'] = true;
			$result['Message'] = "Nama tidak boleh kosong";

			goto output;
		}else if(empty($email)) {
			$result['Error'] = true;
			$result['Message'] = "Email tidak boleh kosong";

			goto output;
		}/*else if (!$this->validate->is_email($email)) {
			$result['Error'] = true;
			$result['Message'] = 'Masukkan email dengan benar';

			goto output;
		}*/else if(empty($password)) {
			$result['Error'] = true;
			$result['Message'] = "Password tidak boleh kosong";

			goto output;
		}else if(empty($konfirmasi_password)) {
			$result['Error'] = true;
			$result['Message'] = "Konfirmasi Password tidak boleh kosong";

			goto output;
		}

		// if (!$this->validate->password_strength($password)) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = 'Password tidak kuat';

		// 	goto output;
		// }

		$pass_length = strlen($password);
		$konfirmasi_pass_length = strlen($konfirmasi_password);

		if ($pass_length < 5) {
			$result['Error'] = true;
			$result['Message'] = "Password minimal 5 karakter";

			goto output;
		}else if($konfirmasi_pass_length < 5) {
			$result['Error'] = true;
			$result['Message'] = "Password minimal 5 karakter";

			goto output;
		}

		if ($password !== $konfirmasi_password) {

			$result['Error'] = true;
			$result['Message'] = "Password tidak sama";

			goto output;
			
		}

		$data = $this->db->query("SELECT 
									id
									FROM $this->tabel
									WHERE email = '$email'")->num_rows();

		if ($data > 0) {

			$result['Error'] = true;
			$result['Message'] = "Email tidak tersedia";

			goto output;
			
		}

		$user = $this->db->query("SELECT 
									id
									FROM $this->tabel")->num_rows();

		$level = ($user > 0)? 2 : 1;

		$kirim_email = true;

		$cost = $user < 1? 12 : 10;

		generate_username:

		$username = uniqid(strtolower(explode(' ',$nama)[0]),false);

		if ($level == 1 || !empty($google_id)) {
			$kode_verifikasi = null;
			$kirim_email = false;
			$status = 1;
			$username = $this->Func->str_random(15,'sha1');
		}else{
			$kode_verifikasi = $this->Func->generate_code();
			$status = 0;
		}

		$token = $this->generate_token();
			
		if ($kirim_email) {
			$data = [
				'google_id' => $google_id,
				'nama' => $nama,
				'email' => $email,
				'username' => $username,
				'password' => $this->hash->make($password,$cost),
				'api_token' => $token,
				'kode_verifikasi' => $kode_verifikasi,
				'status' => $status,
				'status_utama' => $status,
				'level' => $level
			];

			$create = $this->db->insert($this->tabel,$data);

			$user_id = $this->db->insert_id();

			$kode = strtolower($kode_verifikasi);

			if ($create) {
			}else{
				$result['Error'] = true;
				$result['Message'] = "Gagal mendaftar mohon cek data diri anda";
				$result['Data'] = null;

				goto output;
			}
			
			$conf['kode'] = $kode;
			$conf['token'] = $token;
			$conf['nama'] = $nama;
			
			$html = $this->load->view('template_email/verifikasi_email',$conf,true);
            
            $config['to'] = $email;
            $config['subject'] = 'Verifikasi Email';
            $config['message'] = $html;
            $this->my_email->initialize($config);
            
			$result = $this->my_email->send();

			if ($result['Error']) {
				$this->db->delete($this->tabel,['email' => $email]);
			}

			goto output;

		}

		$result['Error'] = false;
		$result['Message'] = "Berhasil mendaftar";
		goto output;

		output:
		return $result;
	}

	function login($params)
	{
		$params = __hsp($params);
		$email = isset($params['email'])? $params['email'] : '';
		$password = isset($params['password'])? $params['password'] : '';
		if (empty($email)) {
			$result['Error'] = true;
			$result['Message'] = "Email tidak boleh kosong";
			goto output;
		}else if(empty($password)) {
			$result['Error'] = true;
			$result['Message'] = "Password tidak boleh kosong";
			goto output;
		}
		$data = $this->db->query("SELECT
									id as id_user,
									api_token as client_token,
									password,
									level as role,
									status,
									diblokir,
									catatan_diblokir
									FROM 
									$this->tabel
									WHERE email = '$email'
									");
		if ($data->num_rows() == 1) {
			
			$user = $data->row_array();


			if ($user['status'] == 0) {
				$result['Error'] = true;
				$result['Message'] = "Akun anda belum diverifikasi";
				goto output;
			}

			if ($user['diblokir'] == 1) {
				$result['Error'] = true;
				$result['Message'] = "Akun anda di blokir Admin, karena Alasan : '".($user['catatan_diblokir']? $user['catatan_diblokir'] : 'diBlokir')."', silahkan hubungi Customer Center untuk info lebih lanjut";
				goto output;
			}

// 			$token = substr($this->encryption->encrypt($user['client_token']),0,100);
			if ($this->hash->check($password,$user['password'])) {
				$result['Error'] = false;
				$result['Message'] = 'Berhasil login';
				$result['Data'] = [
					'name' => 'role',
					'value' => $user['client_token'],
				];
				// $data = [
				// 	'api_token' => $token
				// ];
				// $this->db->update($this->tabel,$data,['id' => $user['id_user']]);
				goto output;
			}

		}

		$result['Error'] = true;
		$result['Message'] = "Email atau Password anda salah";
		goto output;

		output:
		return $result;
	}
	

	function send_forgot($params)
	{
		$params = __hsp($params);
		$email = isset($params['email'])? $params['email'] : "";
		if (empty($email)) {
			$result['Error'] = true;
			$result['Message'] = "Email harus diisi";
			goto output;
		}

		$user = $this->db->query("SELECT
										id,
										nama,
										api_token as token,
										email,
										status
									FROM
										$this->tabel
									WHERE
										email = '$email'")->row_array();
		if ($user) {
		    
            if ($user['status'] == 0) {
                $result['Error'] = true;
                $result['Message'] = "Akun belum diverifikasi";
                goto output;
            }

			
			$data['token'] = $user['token'];
			$data['name'] = $user['nama'];
			$data['email'] = $user['email'];

			$html = $this->load->view('template_email/forgot',$data,true);
			$config['to'] = $email;
			$config['subject'] = "Reset Password";
			$config['message'] = $html;

			$this->my_email->initialize($config);

			$mail_send = $this->my_email->send();

			if ($mail_send['Error']) {
				$result['Error'] = true;
				$result['Message'] = "Gagal mengirim email ke $email";
				goto output;
			}

			$result['Error'] = false;
			$result['Message'] = "Kami berhasil mengirim link ubah password ke email ke $email";
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Email tidak terdaftar";
		goto output;

		output:
		return $result;
	}
	
	function reset_password($params)
	{
		$params = __hsp($params);
	    $token = isset($params['token'])? $params['token'] : '';
	    $password = isset($params['password'])? $params['password'] : '';
       if(empty($token)){
           $result['Error'] = true;
           $result['Message'] = "Parameter 'token' tidak diset";
           goto output;
       }else if(empty($password)){
           $result['Error'] = true;
           $result['Message'] = "Password harus diisi";
           goto output;
       }
       
       if(strlen($password) < 5){
		$result['Error'] = true;
		$result['Message'] = 'Password minimal 5 karakter';
		goto output;
       }
       
       $user = $this->db->query("SELECT
                                        id
                                    FROM
                                        $this->tabel
                                    WHERE
                                        api_token = '$token'")->row_array();
        if($user){
            
            $data = [
                'password' =>   $this->hash->make($password,10)
            ];
            
            $up = $this->db->update($this->tabel,$data,['id' => $user['id']]);
            if($up){
                $result['Error'] = false;
               $result['Message'] = "Berhasil mengubah password";
               goto output;
            }
            $result['Error'] = true;
            $result['Message'] = "Gagal mengubah password";
            goto output;
            
        }
        $result['Error'] = true;
       $result['Message'] = "Pengguna tidak ditemukan";
       goto output;
       output:
       return $result;
	    
	}

	public function loginWithGoogle($params)
	{
		$id = $params['id'];
		$email = $params['email'];
		$name = $params['name'];

		if(empty($id) || empty($email) || empty($name)) {
			$output = array(
				'Error' => true,
				'Message' => 'Akun tidak ditemukan.'
			);
			goto output;
		}

		$get_akun = $this->db->query("
			SELECT
				id
			FROM
				$this->tabel
			WHERE
				email = '$email'
		");

		if($get_akun->num_rows() == 0) {
			$password = "PSWD-".date('YmdHis');

			$cost = $get_akun->num_rows() < 1? 12 : 10;

			$username = uniqid(strtolower(explode(' ',$nama)[0]),false);

			$data = [
				'google_id' => $id,
				'nama' => $name,
				'email' => $email,
				'username' => $username,
				'password' => $this->hash->make($password,$cost),
				'api_token' => $this->generate_token(),
				'status' => '1',
				'status_utama' => '0',
				'level' => '2'
			];

			$this->db->insert($this->tabel,$data);
		}else {
			$this->db->update($this->tabel, array(
				'google_id' => $id
			), array(
				'email' => $email
			));
		}

		$akun = $this->db->query("
			SELECT
				api_token AS client_token
			FROM
				$this->tabel
			WHERE
				google_id = '$id' AND
				email = '$email'
		")->row_array();

		$output = array(
			'Error' => false,
			'Message' => 'success.',
			'Data' => array(
				'name' => 'role',
				'value' => $akun['client_token']
			)
		);

		output:
		return $output;
	}

}

/* End of file M_Auth.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Auth.php */