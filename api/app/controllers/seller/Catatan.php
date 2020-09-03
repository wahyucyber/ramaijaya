<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Catatan','catatan');
	}

	function index_post()
	{
		$result = $this->catatan->all($this->post());
		$this->response($result);
	}

	function add_post()
	{
		$result = $this->catatan->add($this->post());
		$this->response($result);
	}

	function update_post()
	{
		$result = $this->catatan->update($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->catatan->delete($this->post());
		$this->response($result);
	}

}

/* End of file Catatan.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/seller/Catatan.php */