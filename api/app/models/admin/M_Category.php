<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Category extends MY_Model {

	protected $table = 'mst_kategori';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

	function all($params)
	{
		
		// $keyword = isset($params['keyword'])? $params['keyword'] : '';
		$keyword = isset($params['search']['value'])? $params['search']['value'] : '';

		// $limit = isset($params['limit'])? $params['limit'] : 10;
		$start = $params['start'];
		$length = $params['length'];

		$filter_data = empty($keyword)? "" : " WHERE nama_kategori LIKE '%$keyword%'"; 

		$paging = ($start != "" && !empty($length)) ? "LIMIT $start, $length":"";

		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
										$filter_data");

		$recordsFiltered = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
										$filter_data")->num_rows();

		$recordsTotal = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
								")->num_rows();

		if ($query->num_rows() > 0) {
			
			// $config['jumlah_data'] = $query->num_rows();
			// $config['limit'] = $limit;
			// $config['page']	= empty($params['page'])? null : $params['page'];

			// $pagination = $this->query_pagination($config);

			$data = $this->db->query("SELECT
										id as id_kategori,
										CONCAT('".base_url()."', icon) as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table 
										$filter_data
									ORDER BY
										urutan ASC
									$paging
									");
			if ($data->num_rows() < 1) {
				$result['Error'] = true;
				$result['Message'] = "Data tidak ditemukan";
				$result['Data'] = array();
				goto output;
			}

			$no = 0;
			foreach ($data->result_array() as $key) {
				$result['Error']		= false;
				$result['Message']		= null;
				$result['Data'][$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'kategori_id' => $key['kategori_id'],
					'kategori' => $this->induk_kategori($key['kategori_id']),
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}
			$result['draw'] = $params['draw'];
			$result['recordsFiltered'] = $recordsFiltered;
			$result['recordsTotal'] = $recordsTotal;
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Data tidak ditemukan";
		$result['draw'] = $params['draw'];
		$result['recordsFiltered'] = $recordsFiltered;
		$result['recordsTotal'] = $recordsTotal;
		$result['Data'] = array();
		goto output;
		output:
		return $result;
	}

	private function induk_kategori($kategori_id)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
									WHERE 
										id = $kategori_id")->row_array();
		$result = $query? $query : null;
		return $result;
	}

	function list()
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
									WHERE
										kategori_id = 0
									OR
										kategori_id = null");
		if ($query->num_rows() > 0) {
			
			$no = 0;

			foreach ($query->result_array() as $key) {
				$result['Error']		= false;
				$result['Message']		= null;
				$result['Data'][$no++]  = [
					'id_kategori' => $key['id_kategori'],
					'icon_kategori' => $key['icon_kategori'],
					'nama_kategori' => $key['nama_kategori'],
					'slug' => $key['slug']
				];
			}

			goto output;

		}

		$result['Error']	= true;
		$result['Message']	= "Data tidak ditemukan";
		goto output;

		output:
		return $result;
	}

	function add($params)
	{

		$nama = isset($params['nama'])? htmlspecialchars($params['nama']) : null;
		$kategori = isset($params['kategori'])? htmlspecialchars($params['kategori']) : 0;
		$icon = isset($params['icon'])? htmlspecialchars($params['icon']) : null;

		if (empty($nama)) {
			
			$result['Error'] = true;
			$result['Message'] = "Nama Kategori tidak boleh kosong";

			goto output;

		}

		$query = $this->db->query("SELECT 
										id
									FROM
										$this->table
									WHERE
										nama_kategori = '$nama'");
		if ($query->num_rows() > 0) {
			$result['Error'] = true;
			$result['Message'] = "Nama Kategori tidak tersedia";

			goto output;
		}

		if (!empty($kategori)) {
			if (empty($icon)) {
				$result['Error'] = true;
				$result['Message'] = "Icon tidak boleh kosong";

				goto output;
			}
		}

		$upload = [
			'Url' => null
		];

		if (!empty($icon)) {
			$upload = $this->upload_image->upload($icon,'icon_kategori','kategori');
			if ($upload['Error']) {
				$result['Error'] = true;
				$result['Message'] = $upload['Message'];

				goto output;
			}
		}

		$data = [
			'icon' => $upload['Url'],
			'nama_kategori' => $nama,
			'kategori_id' => $kategori,
			'slug' => $this->generate_slug($nama)
		];

		$config['tabel'] = $this->table;
		$config['data'] = $data;

		$result = $this->query_add($config);

		output:

		return $result;

	}

	function update($params)
	{
		$id_kategori = isset($params['id_kategori'])? $params['id_kategori'] : '';
		$nama = isset($params['nama'])? htmlspecialchars($params['nama']) : null;
		$kategori = isset($params['kategori'])? htmlspecialchars($params['kategori']) : 0;
		$icon = isset($params['icon'])? htmlspecialchars($params['icon']) : null;

		if(empty($id_kategori)){
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_kategori' tidak diset";

			goto output;
		}
		else if (empty($nama)) {
			
			$result['Error'] = true;
			$result['Message'] = "Nama Kategori tidak boleh kosong";

			goto output;

		}

		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->table
									WHERE
										id = $id_kategori");

		if ($query->num_rows() < 1) {
			$result['Error'] = true;
			$result['Message'] = "Kategori tidak ditemukan";

			goto output;
		}

		$data = $query->row_array();

		if ($nama != $data['nama_kategori']) {
			$query = $this->db->query("SELECT 
											id as id_kategori,
											icon as icon_kategori,
											kategori_id,
											nama_kategori,
											slug
										FROM
											$this->table
										WHERE
											nama_kategori = '$nama'");
			if ($query->num_rows() > 0) {
				$result['Error'] = true;
				$result['Message'] = "Nama Kategori tidak tersedia";

				goto output;
			}
		}


		if (!empty($kategori)) {
			if ($kategori == $data['id_kategori']) {
				$result['Error'] = true;
				$result['Message'] = "Tidak dapat menginduk ke kategori yang sama";

				goto output;
			}
		}

		if (!empty($kategori)) {
			if (empty($icon)) {
				$result['Error'] = true;
				$result['Message'] = "Icon tidak boleh kosong";

				goto output;
			}
		}

		$upload = [
			'Url' => $data['icon_kategori']
		];

		if (!empty($icon)) {
			$upload = $this->upload_image->upload($icon,'icon_kategori','kategori',$data['icon_kategori']);
			if ($upload['Error']) {
				$result['Error'] = true;
				$result['Message'] = $upload['Message'];

				goto output;
			}
		}

		$val_data = [
			'icon' => $upload['Url'],
			'nama_kategori' => $nama,
			'kategori_id' => $kategori,
			'slug' => $this->generate_slug($nama)
		];

		$config['tabel'] = $this->table;
		$config['data'] = $val_data;
		$config['filter'] = "id = $id_kategori";

		$result = $this->query_update($config);
		goto output;
		output:
		return $result;

	}

	function delete($params)
	{
		$id_kategori = isset($params['id_kategori'])? htmlspecialchars($params['id_kategori']) : '';

		if (empty($id_kategori)) {
			
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_kategori' tidak diset";
			goto output;
		}

		$induk = $this->db->query("SELECT
										id
									FROM
										$this->table
									WHERE
										kategori_id = $id_kategori")->num_rows();
		
		$query = $this->db->query("SELECT
										icon as icon_kategori,
										nama_kategori
									FROM
										$this->table
									WHERE
										id = $id_kategori")->row_array();

		if ($query) {
			if ($induk > 0) {
				$result['Error'] = true;
				$result['Message'] = "Kategori $query[nama_kategori] tidak dapat dihapus";
				goto output;
			}

			$this->upload_image->remove($query['icon_kategori']);
		}

		$config['tabel'] = $this->table;
		$config['filter'] = "id = $id_kategori";

		$result = $this->query_delete($config);
		goto output;

		output:
		return $result;
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
			$cek_kategori = $this->db->query("
				SELECT
					urutan
				FROM
					$this->table
				WHERE
					id = '$id' AND
					kategori_id = '0'
			");

			if ($cek_kategori->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Kategori tidak ditemukan."
				);
				goto output;
			}

			$kategori = $cek_kategori->row_array();

			$kategori_up = $kategori['urutan'] - 1;

			$get_up = $this->db->query("
				SELECT
					id,
					urutan
				FROM
					$this->table
				WHERE
					urutan = '$kategori_up'
			")->row_array();

			if ($get_up['urutan'] != 0) {
				$this->db->update($this->table, array(
					'urutan' => $kategori['urutan']
				), array(
					'id' => $get_up['id']
				));

				$this->db->update($this->table, array(
					'urutan' => $get_up['urutan']
				), array(
					'id' => $id
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => 'Kategori berhasil disetup.'
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
			$cek_kategori = $this->db->query("
				SELECT
					urutan
				FROM
					$this->table
				WHERE
					id = '$id' AND
					kategori_id = '0'
			");

			if ($cek_kategori->num_rows() == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Kategori tidak ditemukan."
				);
				goto output;
			}

			$kategori = $cek_kategori->row_array();

			$kategori_down = $kategori['urutan'] + 1;

			$get_down = $this->db->query("
				SELECT
					id,
					urutan
				FROM
					$this->table
				WHERE
					urutan = '$kategori_down'
			")->row_array();

			if ($get_down['urutan'] != null) {
				$this->db->update($this->table, array(
					'urutan' => $kategori['urutan']
				), array(
					'id' => $get_down['id']
				));

				$this->db->update($this->table, array(
					'urutan' => $get_down['urutan']
				), array(
					'id' => $id
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => 'Kategori berhasil disetdown.'
			);
			goto output;
		}

		output:
		return $hasil;
	}


}

/* End of file M_Category.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/admin/M_Category.php */