<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Tab_content extends MY_Model {

	protected $tabel = 'mst_tab_content';

	protected $tabel_tab = 'mst_tab';

	public function __construct()
	{
		parent::__construct();
	}

	public function add($params)
	{
		$tab_id = $params['tab_id'];
		$title = $params['title'];
		$content = $params['content'];

		if (empty($tab_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'tab_id' tidak diset."
			);
			goto output;
		}else if (empty($title)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Judul belum diisi."
			);
			goto output;
		}else if (empty($content)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Isi belum diisi."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_tab
				WHERE
					id = '$tab_id'
			")->num_rows();

			if ($cek_tab == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$this->db->insert($this->tabel, array(
				'tab_id' => $tab_id,
				'title' => $title,
				'content' => $content
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab content berhasil disimpan."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function index($params)
	{
		$tab_id = $params['tab_id'];
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];

		if (empty($tab_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'tab_id' tidak diset."
			);
			goto output;
		}else{

			$limit = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";
			$where = " AND title LIKE '%$search%'";

			$get_tab_content = $this->db->query("
				SELECT
					id,
					tab_id,
					title,
					content,
					created_at,
					updated_at
				FROM
					$this->tabel
				WHERE
					tab_id = '$tab_id'
				$where
				$limit
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_tab_content as $key) {
				$hasil['Data'][$no++] = $key;
			}
			$hasil['recordsTotal'] = $this->recordsTotal($this->tabel." WHERE tab_id = '$tab_id'");
			$hasil['recordsFiltered'] = $this->recordsFiltered($this->tabel, 'id', " tab_id = '$tab_id' AND title LIKE '%$search%'");
			$hasil['draw'] = $draw;
			goto output;
		}

		output:
		return $hasil;
	}

	public function update($params)
	{
		$tab_id = $params['tab_id'];
		$id = $params['id'];
		$title = $params['title'];
		$content = $params['content'];

		if (empty($tab_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'tab_id' tidak diset."
			);
			goto output;
		}else if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else if (empty($title)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Judul belum diisi."
			);
			goto output;
		}else if (empty($content)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Isi belum diisi."
			);
			goto output;
		}else{
			$cek_tab = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_tab
				WHERE
					id = '$tab_id'
			")->num_rows();

			if ($cek_tab == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$cek_tab_content = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_tab_content == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab content tidak ditemukan."
				);
				goto output;
			}

			$this->db->update($this->tabel, array(
				'title' => $title,
				'content' => $content
			), array(
				'tab_id' => $tab_id,
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab content berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

	public function delete($params)
	{
		$tab_id = $params['tab_id'];
		$id = $params['id'];

		if (empty($tab_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'tab_id' tidak diset."
			);
			goto output;
		}else if (empty($id)) {
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
					$this->tabel_tab
				WHERE
					id = '$tab_id'
			")->num_rows();

			if ($cek_tab == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab tidak ditemukan."
				);
				goto output;
			}

			$cek_tab_content = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_tab_content == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Tab content tidak ditemukan."
				);
				goto output;
			}

			$this->db->delete($this->tabel, array(
				'tab_id' => $tab_id,
				'id' => $id
			));

			$hasil = array(
				'Error' => false,
				'Message' => "Tab content berhasil dihapus."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Tab_content.php */
/* Location: ./application/models/M_Tab_content.php */