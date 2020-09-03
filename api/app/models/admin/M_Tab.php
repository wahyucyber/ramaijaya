<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Tab extends MY_Model {

	protected $tabel = 'mst_tab';

	protected $tabel_content = 'mst_tab_content';

	public function __construct()
	{
		parent::__construct();
	}

	public function add($params)
	{
		$nama = $params['nama'];

		if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama belum diisi."
			);
			goto output;
		}else{
			$cek_nama = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					nama = '$nama'
			")->num_rows();

			if ($cek_nama > 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Nama tab sudah terdaftar."
				);
				goto output;
			}

			$get_tab_terakhir = $this->db->query("
				SELECT
					urutan
				FROM
					$this->tabel
				ORDER BY urutan DESC
				LIMIT 0, 1
			");

			if ($get_tab_terakhir->num_rows() == 0) {
				$tab_terkahir = 1;
			}else{
				$tab_terkahir = $get_tab_terakhir->row_array()['urutan'] + 1;
			}

			$this->db->insert($this->tabel, array(
				'nama' => $nama,
				'urutan' => $tab_terkahir
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab berhasil disimpan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function index($params)
	{
		$get_tab = $this->db->query("
			SELECT
				id,
				nama,
				created_at,
				updated_at
			FROM
				$this->tabel
			ORDER BY urutan ASC
		")->result_array();
		$no = 0;
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		foreach ($get_tab as $key) {
			$hasil['Data'][$no++] = $key;
		}
		goto output;

		output:
		return $hasil;
	}

	public function update($params)
	{
		$id = $params['id'];
		$nama = $params['nama'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else if (empty($nama)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Nama belum diisi."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_tab == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$cek_nama = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					nama = '$nama'
			");

			if ($cek_nama->num_rows() > 0) {
				foreach ($cek_nama->result_array() as $key) {
					if ($key['id'] != $id) {
						$hasil = array(
							'Error' => true,
							'Message' => "Tab sudah terdaftar."
						);
						goto output;
					}
				}
			}

			$this->db->update($this->tabel, array(
				'nama' => $nama
			), array(
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function delete($params)
	{
		$id = $params['id'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_tab == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$this->db->delete($this->tabel, array(
				'id' => $id
			));

			$this->db->delete($this->tabel_content, array(
				'tab_id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab berhasil dihapus."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_up($params)
	{
		$id = $params['id'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					urutan
				FROM
					$this->tabel
				WHERE
					id = '$id'
			");

			if ($cek_tab->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$tab = $cek_tab->row_array();

			$tab_up = $tab['urutan'] - 1;

			$get_up = $this->db->query("
				SELECT
					id,
					urutan
				FROM
					$this->tabel
				WHERE
					urutan = '$tab_up'
			")->row_array();

			if ($get_up['urutan'] != 0) {
				$this->db->update($this->tabel, array(
					'urutan' => $tab['urutan']
				), array(
					'id' => $get_up['id']
				));

				$this->db->update($this->tabel, array(
					'urutan' => $get_up['urutan']
				), array(
					'id' => $id
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => 'Tab berhasil disetup.'
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function set_down($params)
	{
		$id = $params['id'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					urutan
				FROM
					$this->tabel
				WHERE
					id = '$id'
			");

			if ($cek_tab->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$tab = $cek_tab->row_array();

			$tab_down = $tab['urutan'] + 1;

			$get_down = $this->db->query("
				SELECT
					id,
					urutan
				FROM
					$this->tabel
				WHERE
					urutan = '$tab_down'
			")->row_array();

			if ($get_down['urutan'] != null) {
				$this->db->update($this->tabel, array(
					'urutan' => $tab['urutan']
				), array(
					'id' => $get_down['id']
				));

				$this->db->update($this->tabel, array(
					'urutan' => $get_down['urutan']
				), array(
					'id' => $id
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => 'Tab berhasil disetdown.'.$get_down['urutan']
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Tab.php */
/* Location: ./application/models/M_Tab.php */