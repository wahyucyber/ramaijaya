<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Manual_payment extends CI_Model {

	protected $tabel = 'mst_pembayaran_manual';

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$get_content = $this->db->query("
			SELECT
				id,
				content,
				created_at,
				updated_at
			FROM
				$this->tabel
			WHERE
				id = '1'
		")->result_array();
		$hasil['Error'] = false;
		$hasil['Message'] = "success.";
		$hasil['Data'] = array();
		$no = 0;
		foreach ($get_content as $key) {
			$hasil['Data'][$no++] = $key;
		}
		goto output;

		output:
		return $hasil;
	}

	public function add($params)
	{
		$content = $params['content'];

		if (empty($content) || $content == "<p></p>") {
			$hasil = array(
				'Error' => true,
				'Message' => "Content belum diisi."
			);
			goto output;
		}else{
			$cek_data = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel
			")->num_rows();
			if ($cek_data == 0) {
				$this->db->insert($this->tabel, array(
					'content' => $content
				));
			}else{
				$this->db->update($this->tabel, array(
					'content' => $content
				), array(
					'id' => 1
				));
			}

			$hasil = array(
				'Error' => false,
				'Message' => "Manual payment berhasil diperbarui."
			);
			goto output;
		}

		output:
		return $hasil;
	}

}

/* End of file M_Manual_payment.php */
/* Location: ./application/models/M_Manual_payment.php */