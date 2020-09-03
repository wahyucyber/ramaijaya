<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Profil extends MY_Model {

	protected $tabel = 'mst_user';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

	public function get($params)
	{
		$client_token = $params['client_token'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}

		$cek_user = $this->db->query("
			SELECT
				$this->tabel.id,
				CONCAT('".base_url('')."', '', $this->tabel.foto) AS foto,
				$this->tabel.nama,
				$this->tabel.email,
				$this->tabel.no_telepon,
				$this->tabel.provinsi_id,
				$this->tabel_provinsi.nama AS provinsi_nama,
				$this->tabel.kabupaten_id,
				CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS kabupaten_nama,
				$this->tabel.kecamatan_id,
				$this->tabel.kode_pos,
				$this->tabel_kecamatan.nama AS kecamatan_nama,
				$this->tabel.alamat,
				$this->tabel.jenis_kelamin,
				$this->tabel.tanggal_lahir,
				$this->tabel.tempat_lahir,
				$this->tabel.created_at,
				$this->tabel.updated_at
			FROM
				$this->tabel
				LEFT JOIN $this->tabel_provinsi ON $this->tabel_provinsi.id = $this->tabel.provinsi_id
				LEFT JOIN $this->tabel_kabupaten ON $this->tabel_kabupaten.id = $this->tabel.kabupaten_id
				LEFT JOIN $this->tabel_kecamatan ON $this->tabel_kecamatan.id = $this->tabel.kecamatan_id
			WHERE
				$this->tabel.api_token = '$client_token'
		");
		if ($cek_user->num_rows() == 0) {
			$hasil = array(
				'Error' => true,
				'Message' => "User tidak ditemukan."
			);
			goto output;
		}

		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		foreach ($cek_user->result_array() as $key) {
			$hasil['Data'][$no++] = $key;
		}
		goto output;

		output:
		return $hasil;
	}

	public function update($params)
	{
		$client_token = $params['client_token'];
		$nama = $params['nama'];
		$jenis_kelamin = $params['jenis_kelamin'];
		$tempat_lahir = $params['tempat_lahir'];
		$tanggal_lahir = $params['tanggal_lahir'];
		$provinsi = $params['provinsi'];
		$kabupaten = $params['kabupaten'];
		$kecamatan = $params['kecamatan'];
		$alamat = $params['alamat'];
		$kode_pos = $params['kode_pos'];
		$no_telepon = $params['no_telepon'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama belum diisi."
			);
			goto output;
		}else if (empty($jenis_kelamin)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Jenis kelamin belum dipilih."
			);
			goto output;
		}else if (empty($tempat_lahir)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Tempat lahir belum diisi."
			);
			goto output;
		}else if (empty($tanggal_lahir)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Tanggal lahir belum dipilih."
			);
			goto output;
		}else if (empty($provinsi)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Provinsi belum dipilih."
			);
			goto output;
		}else if (empty($kabupaten)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kabupaten/Kota belum dipilih."
			);
			goto output;
		}else if (empty($kecamatan)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kecamatan belum dipilih."
			);
			goto output;
		}else if (empty($alamat)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Alamat belum diisi."
			);
			goto output;
		}else if (empty($kode_pos)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kode POS belum diisi."
			);
			goto output;
		}else if (empty($no_telepon)) {
			$hasil = array(
				'Error' => true,
				'Message' => "No. Telepon belum diisi."
			);
			goto output;
		}else{
			$cek_user = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					api_token = '$client_token'
			")->num_rows();
			if ($cek_user == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak terdaftar."
				);
				goto output;
			}

			if ($jenis_kelamin != "Laki-Laki") {
				if ($jenis_kelamin != "Perempuan") {
					$hasil = array(
						'Error' => true,
						'Message'  => "Parameter 'jenis_kelamin' herus berformat 'Laki-Laki' atau 'Perempuan'"
					);
					goto output;
				}
			}

			$this->db->update('mst_user', array(
				'nama' => $nama,
				'no_telepon' => $no_telepon,
				'provinsi_id' => $provinsi,
				'kabupaten_id' => $kabupaten,
				'kecamatan_id' => $kecamatan,
				'kode_pos' => $kode_pos,
				'alamat' => $alamat,
				'jenis_kelamin' => $jenis_kelamin,
				'tanggal_lahir' => $tanggal_lahir,
				'tempat_lahir' => $tempat_lahir
			), array(
				'api_token' => $client_token
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Profil berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function uploadImage($params)
	{
		$client_token = $params['client_token'];
		$img = $params['img'];

		if (empty($client_token)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($img)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Foto belum dipilih."
			);
			goto output;
		}else{

			$get_user = $this->db->query("
				SELECT
					foto
				FROM
					$this->tabel
				WHERE
					api_token = '$client_token'
			");

			if ($get_user->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "User tidak terdaftar."
				);
				goto output;
			}

			foreach ($get_user->result_array() as $key) {
				// if (empty($key['foto'])) {
				// 	$new_image = $this->upload_image->upload($img, "Foto-user", 'user');
				// }else{
					$new_image = $this->upload_image->upload($img, "Foto-user", 'user', (empty($key['foto'])) ? "":$key['foto']);
				// }
			}

			$this->db->update($this->tabel, array(
				'foto' => $new_image['Url']
			), array(
				'api_token' => $client_token
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Foto berhasil diperbarui."
			);
			goto output;

		}

		output:
		return $hasil;
	}
	
	public function ubah_password($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$password_lama = isset($params['password_lama'])? $params['password_lama'] : '';
		$password_baru = isset($params['password_baru'])? $params['password_baru'] : '';
		$konfirmasi_password_baru = isset($params['konfirmasi_password_baru'])? $params['konfirmasi_password_baru'] : '';

		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = 'Parameter client_token tidak diset';
			goto output;
		}else if(empty($password_lama)){
			$result['Error'] = true;
			$result['Message'] = 'Password lama harus di isi';
			goto output;
		}else if(empty($password_baru)){
			$result['Error'] = true;
			$result['Message'] = 'Password baru harus di isi';
			goto output;
		}else if(empty($konfirmasi_password_baru)){
			$result['Error'] = true;
			$result['Message'] = 'Konfirmasi password baru harus di isi';
			goto output;
		}

		if($password_baru !== $konfirmasi_password_baru){
			$result['Error'] = true;
			$result['Message'] = 'Password tidak sama';
			goto output;
		}
		
		if (strlen($password_baru) < 5) {
			$result['Error'] = true;
			$result['Message'] = 'Password minimal 5 karakter';
			goto output;
		}

		$user = $this->db->query("SELECT
									id,
									password
								FROM
									$this->tabel
								WHERE
									api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = 'Pengguna tidak ditemukan';
			goto output;
		}

		if ($this->hash->check($password_lama,$user['password'])) {
			
			$password = $this->hash->make($password_baru,10);

			$up = $this->db->update($this->tabel,['password' => $password],['id' => $user['id']]);
			if ($up) {
				$result['Error'] = false;
				$result['Message'] = 'Berhasil mengubah password';
				goto output;
			}
			$result['Error'] = true;
			$result['Message'] = 'Gagal mengubah password';
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = 'Password lama yg anda masukkan salah';
		goto output;
		output:
		return $result;
	}

}

/* End of file M_Profil.php */
/* Location: ./application/models/M_Profil.php */