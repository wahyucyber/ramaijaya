<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kurir extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Kurir', 'kurir');
	}

	function add_post()
	{
		$result = $this->kurir->add($this->post());
		$this->response($result);
	}

	function index_post()
	{
		$result = $this->kurir->index($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->kurir->delete($this->post());
		$this->response($result);
	}

}

/* End of file Kurir.php */
/* Location: ./application/controllers/Kurir.php */