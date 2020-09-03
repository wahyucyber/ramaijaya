<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Ppn extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
	protected $tabel = 'mst_ppn';
	public function cek()
	{
		$ppn = $this->cek_status();
	    if ($ppn == 0) {
	    	$result['Error'] = true;
	    	$result['Message'] = "PPN telah dinonaktifkan";
	    	goto output;
	    }
	    $result['Error'] = false;
    	$result['Message'] = null;
    	$result['Data'] = compact('ppn');
    	goto output;
	    output:
	    return $result;
	}

	public function cek_status()
	{
		$ppn = $this->db->query("SELECT
										ppn
									FROM
										$this->tabel
									ORDER BY id DESC
									LIMIT 0,1");
		$result['Error'] = false;
		$result['Message'] = null;
		if ($ppn->num_rows() == 0) {
			
			$data = [
				'ppn' => 0
			];

			$this->db->insert($this->tabel,$data);
			return $data;
		}
		return $ppn->row_array()['ppn'];
	}

	function set($params)
	{
		$status = isset($params['status'])? $params['status'] : 0;
		$ppn = isset($params['ppn'])? $params['ppn'] : 0;

		if ($status == 1) {
			
			if (empty($ppn)) {
				$result['Error'] = true;
				$result['Message'] = "PPN harus diisi";
				goto output;
			}

			if ($ppn > 100) {
				$result['Error'] = true;
				$result['Message'] = "PPN maksimal 100%";
				goto output;
			}
			
			$result = $this->set_aktif($ppn);
			goto output;

		}else{
			$result = $this->set_nonaktif();
			goto output;
		}
		output:
		return $result;
	}

	private function set_aktif($ppn)
	{
		$data = $this->db->query("SELECT
										id,
										ppn
									FROM
										$this->tabel
									ORDER BY id DESC
									LIMIT 0,1")->row_array();
		$update = $this->db->update($this->tabel,['ppn' => $ppn],['id' => $data['id']]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil mengaktifkan ppn";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal mengaktifkan ppn";
		goto output;
		output:
		return $result;

	}

	private function set_nonaktif()
	{
		$data = $this->db->query("SELECT
										id,
										ppn
									FROM
										$this->tabel
									ORDER BY id DESC
									LIMIT 0,1")->row_array();
		$update = $this->db->update($this->tabel,['ppn' => 0],['id' => $data['id']]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil menonaktifkan ppn";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal menonaktifkan ppn";
		goto output;
		output:
		return $result;

	}

}