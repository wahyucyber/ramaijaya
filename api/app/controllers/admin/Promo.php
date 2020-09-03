<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Promo','promo');
	}

	function index_post()
	{
		$result = $this->promo->all($this->post());
		return $this->response($result);
	}

	function add_post()
	{
		$result = $this->promo->add($this->post());
		return $this->response($result);
	}

	function edit_post()
	{
		$result = $this->promo->edit($this->post());
		return $this->response($result);
	}

	function delete_post()
	{
		$result = $this->promo->delete($this->post());
		return $this->response($result);
	}
}

/* End of file Promo.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/admin/Promo.php */