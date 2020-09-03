<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toko extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Toko', 'toko');
	}

	function index_post()
	{
		$result = $this->toko->index($this->post());
		$this->response($result);
	}

	function set_aktif_post()
	{
		$result = $this->toko->set_aktif($this->post());
		$this->response($result);
	}

	function set_nonaktif_post()
	{
		$result = $this->toko->set_nonaktif($this->post());
		$this->response($result);
	}
	
	function blokir_post()
	{
		$result = $this->toko->blokir($this->post());
		$this->response($result);
	}

	function buka_blokir_post()
	{
		$result = $this->toko->buka_blokir($this->post());
		$this->response($result);
	}

}

/* End of file Toko.php */
/* Location: ./application/controllers/Toko.php */