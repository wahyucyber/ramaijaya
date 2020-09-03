<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq_Model extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/

	protected $tabel = 'faq';

	protected $tabel_detail = 'faq_detail';

    public function __construct()
    {
        parent::__construct();
    }

    function all($params)
    {
    	$faq = $this->db->query("SELECT
	    								id,
	    								menu
	    							FROM
	    								$this->tabel");
    	if ($faq->num_rows() == 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Faq tidak ditemukan";
    		goto output;
    	}

    	$no = 0;

    	foreach($faq->result_array() as $key){
    		$result['Error'] = false;
    		$result['Message'] = null;
    		$result['Data'][$no++] = $key;
    	}
    	goto output;
    	output:
    	return $result;
    }

    function detail($params)
    {
    	$start = isset($params['start'])? $params['start']  : 0;
		$length = isset($params['length'])? $params['length'] : 10;
		$draw = isset($params['draw'])? $params['draw'] : 1;
		$search = isset($params['search'])? $params['search']['value'] : '';

    	$id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
    	if (empty($id_menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_menu tidak diset";
    		goto output;
    	}

    	$where = empty($search)? "" : "AND (pertanyaan LIKE '%$search%' OR jawaban LIKE '%$search%')";

    	$data = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel
    								WHERE
    									id = '$id_menu'")->row_array();
    	if (!$data) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu tidak ditemukan";
    		goto output;
    	}

    	$jumlah_data = $this->db->query("SELECT
    									id,
    									faq_id,
    									pertanyaan,
    									jawaban
    								FROM
    									$this->tabel_detail
    								WHERE
    									faq_id = '$id_menu'
    									$where")->num_rows();
    	if ($jumlah_data > 0) {
    		
    		$no = 0;

    		$data = $this->db->query("SELECT
    									id,
    									faq_id,
    									pertanyaan,
    									jawaban
    								FROM
    									$this->tabel_detail
    								WHERE
    									faq_id = '$id_menu'
    									$where")->result_array();
    		foreach($data as $key){
    			$result['Error'] = false;
    			$result['Message'] = null;
    			$result['Data'][$no++] = $key;
    			$result['recordsTotal'] = $jumlah_data;
				$result['recordsFiltered'] = count($data);
				$result['draw'] = $draw;
    		}
    		goto output;

    	}
    	$result['Error'] = true;
        $result['Data'] = [];
    	$result['Message'] = "Data tidak ditemukan";
    	$result['recordsTotal'] = 0;
		$result['recordsFiltered'] = 0;
		$result['draw'] = $draw;
    	goto output;
    	output:
    	return $result;

    }

    function detail_single($params)
    {
        $id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
        $id_detail = isset($params['id_detail'])? $params['id_detail'] : '';
        /*if (empty($id_menu)) {
            $result['Error'] = true;
            $result['Message'] = "Parameter id_menu tidak diset";
            goto output;
        }else */if(empty($id_detail)){
            $result['Error'] = true;
            $result['Message'] = "Parameter id_detail tidak diset";
            goto output;
        }

        $data = $this->db->query("SELECT
                                        id,
                                        pertanyaan,
                                        jawaban
                                    FROM
                                        $this->tabel_detail
                                    WHERE
                                        id = '$id_detail'")->row_array();
        if (!$data) {
            $result['Error'] = true;
            $result['Message'] = "Pertanyaan tidak ditemukan";
            goto output;
        }

        $result['Error'] = false;
        $result['Message'] = null;
        $result['Data'] = $data;
        goto output;
        output:
        return $result;
    }

    function add_menu($params)
    {
    	$menu = isset($params['menu'])? $params['menu'] : '';
    	if (empty($menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu harus diisi";
    		goto output;
    	}

    	$cek_menu = $this->db->query("SELECT
    										id
    									FROM
    										$this->tabel
    									WHERE
    										menu = '$menu'")->num_rows();
    	if ($cek_menu > 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu sudah ada";
    		goto output;
    	}

    	$data = [
    		'menu' => $menu
    	];

    	$add = $this->db->insert($this->tabel,$data);
    	if ($add) {
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil menambahkan menu";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal menambahkan menu";
		goto output;
		output:
		return $result;

    }

    function edit_menu($params)
    {
    	$id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
    	$menu = isset($params['menu'])? $params['menu'] : '';
    	if (empty($id_menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_menu tidak diset";
    		goto output;
    	}else if(empty($menu)){
    		$result['Error'] = true;
    		$result['Message'] = "Menu harus diisi";
    		goto output;
    	}

    	$data = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel
    								WHERE
    									id = '$id_menu'")->row_array();
    	if (!$data) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu tidak ditemukan";
    		goto output;
    	}

    	$cek_menu = $this->db->query("SELECT
    										id
    									FROM
    										$this->tabel
    									WHERE
    										menu = '$menu'")->num_rows();
    	if ($cek_menu > 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu sudah ada";
    		goto output;
    	}

    	$data = [
    		'menu' => $menu
    	];

    	$up = $this->db->update($this->tabel,$data,['id' => $id_menu]);
    	if ($up) {
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil mengubah menu";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal mengubah menu";
		goto output;
		output:
		return $result;
    }

    function delete_menu($params)
    {
    	$id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
    	if (empty($id_menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_menu tidak diset";
    		goto output;
    	}

    	$data = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel
    								WHERE
    									id = '$id_menu'")->row_array();
    	if (!$data) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu tidak ditemukan";
    		goto output;
    	}

    	$delete = $this->db->delete($this->tabel,['id' => $id_menu]);
    	if ($delete) {
    		
    		$this->db->delete($this->tabel_detail,['faq_id' => $id_menu]);
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil menghapus menu";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal menghapus menu";
		goto output;
		output:
		return $result;

    }

    function add_detail($params)
    {
    	$id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
    	$pertanyaan = isset($params['pertanyaan'])? $params['pertanyaan'] : '';
    	$jawaban = isset($params['jawaban'])? $params['jawaban'] : '';
    	if (empty($id_menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_menu tidak diset";
    		goto output;
    	}else if(empty($pertanyaan)){
    		$result['Error'] = true;
    		$result['Message'] = "Pertanyaan harus diisi";
    		goto output;
    	}else if(empty($jawaban)){
    		$result['Error'] = true;
    		$result['Message'] = "Jawaban harus diisi";
    		goto output;
    	}

    	$data = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel
    								WHERE
    									id = '$id_menu'")->row_array();
    	if (!$data) {
    		$result['Error'] = true;
    		$result['Message'] = "Menu tidak ditemukan";
    		goto output;
    	}

    	$cek_pertanyaan = $this->db->query("SELECT
	    											id
	    										FROM
	    											$this->tabel_detail
	    										WHERE
	    											faq_id = '$id_menu'
	    											AND
	    											pertanyaan = '$pertanyaan'")->num_rows();
    	if ($cek_pertanyaan > 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Pertanyaan sudah ada";
    		goto output;
    	}

    	$data = [
    		'faq_id' => $id_menu,
    		'pertanyaan' => $pertanyaan,
    		'jawaban' => $jawaban
    	];

    	$add = $this->db->insert($this->tabel_detail,$data);
    	if ($add) {
    		
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil menambahkan pertanyaan";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal menambahkan pertanyaan";
		goto output;
		output:
		return $result;
    }

    function edit_detail($params)
    {
    	$id_menu = isset($params['id_menu'])? $params['id_menu'] : '';
    	$id_detail = isset($params['id_detail'])? $params['id_detail'] : '';
    	$pertanyaan = isset($params['pertanyaan'])? $params['pertanyaan'] : '';
    	$jawaban = isset($params['jawaban'])? $params['jawaban'] : '';
    	/*if (empty($id_menu)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_menu tidak diset";
    		goto output;
    	}else */if(empty($id_detail)){
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_detail tidak diset";
    		goto output;
    	}else if(empty($pertanyaan)){
    		$result['Error'] = true;
    		$result['Message'] = "Pertanyaan harus diisi";
    		goto output;
    	}else if(empty($jawaban)){
    		$result['Error'] = true;
    		$result['Message'] = "Jawaban harus diisi";
    		goto output;
    	}

    	// $data = $this->db->query("SELECT
    	// 								id
    	// 							FROM
    	// 								$this->tabel
    	// 							WHERE
    	// 								id = '$id_menu'")->row_array();
    	// if (!$data) {
    	// 	$result['Error'] = true;
    	// 	$result['Message'] = "Menu tidak ditemukan";
    	// 	goto output;
    	// }

    	$cek_pertanyaan = $this->db->query("SELECT
	    											id
	    										FROM
	    											$this->tabel_detail
	    										WHERE
	    											faq_id = '$id_menu'
	    											AND
	    											pertanyaan = '$pertanyaan'")->num_rows();
    	if ($cek_pertanyaan > 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Pertanyaan sudah ada";
    		goto output;
    	}

    	$data = [
    		'pertanyaan' => $pertanyaan,
    		'jawaban' => $jawaban
    	];

    	$upd = $this->db->update($this->tabel_detail,$data,['id' => $id_detail]);
    	if ($upd) {
    		
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil mengubah pertanyaan";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal mengubah pertanyaan";
		goto output;
		output:
		return $result;
    }

    function delete_detail($params)
    {
    	$id_detail = isset($params['id_detail'])? $params['id_detail'] : '';
    	if (empty($id_detail)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter id_detail tidak diset";
    		goto output;
    	}

    	$data = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel_detail
    								WHERE
    									id = '$id_detail'")->row_array();
    	if(!$data){
    		$result['Error'] = true;
    		$result['Message'] = "Pertanyaan tidak ditemukan";
    		goto output;
    	}

    	$del = $this->db->delete($this->tabel_detail,['id' => $id_detail]);
    	if ($del) {
    		
    		$result['Error'] = false;
    		$result['Message'] = "Berhasil menghapus pertanyaan";
    		goto output;
    	}
    	$result['Error'] = true;
		$result['Message'] = "Gagal menghapus pertanyaan";
		goto output;
		output:
		return $result;

    }

}