<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Footer extends MY_Model {

	protected $tabel = "mst_tab";

	protected $tabel_content = "mst_tab_content";

	public function __construct()
	{
		parent::__construct();
	}

	private function content($params)
	{
		$tab_id = $params['tab_id'];

		$get_tab_content = $this->db->query("
			SELECT
				id,
				title,
				created_at,
				updated_at
			FROM
				$this->tabel_content
			WHERE
				tab_id = '$tab_id'
		")->result_array();
		$no = 0;
		$hasil = array();
		foreach ($get_tab_content as $key) {
			$hasil[$no++] = $key;
		}
		goto output;

		output:
		return $hasil;
	}

	public function index()
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
			$hasil['Data'][$no++] = array(
				'id' => $key['id'],
				'nama' => $key['nama'],
				'tab_content' => $this->content(array(
					'tab_id' => $key['id']
				)),
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}
		goto output;

		output:
		return $hasil;
	}

}

/* End of file M_Footer.php */
/* Location: ./application/models/M_Footer.php */