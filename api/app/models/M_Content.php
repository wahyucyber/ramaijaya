<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Content extends CI_Model {

	protected $tabel_tab = 'mst_tab';

	protected $tabel_tab_content = 'mst_tab_content';

	public function __construct()
	{
		parent::__construct();
	}

	public function index($params)
	{
		$id = $params['id'];

		if (empty($id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Parameter 'id' tidak diset."
			);
			goto output;
		}else{
			$cek_content = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_tab_content
				WHERE
					id = '$id'
			")->num_rows();

			if ($cek_content == 0) {
				$hasil = array(
					'Error' => true,
					'Message' => "Content tidak ditemukan."
				);
				goto output;
			}

			$get_content = $this->db->query("
				SELECT
					id,
					title,
					content,
					created_at,
					updated_at
				FROM
					$this->tabel_tab_content
				WHERE
					id = '$id'
			")->result_array();
			$no = 0;
			$hasil['Error'] = false;
			$hasil['Message'] = "success.";
			$hasil['Data'] = array();
			foreach ($get_content as $key) {
				$hasil['Data'][$no++] = $key;
			}
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Content.php */
/* Location: ./application/models/M_Content.php */