<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ongkir extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Ongkir', 'ongkir');
	}

	function index_post()
	{
		$result = $this->ongkir->index($this->post());
		$this->response($result);
	}

	function kurir_post()
	{
		$result = $this->ongkir->kurir($this->post());
		$this->response($result);
	}

}

/* End of file Ongkir.php */
/* Location: ./application/controllers/Ongkir.php */