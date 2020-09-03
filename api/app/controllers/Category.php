<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Category','category');
	}

	function index_post()
	{
		$result = $this->category->all($this->post());
		return $this->response($result);
	}

	function sub_post()
	{
		$result = $this->category->sub($this->post());
		return $this->response($result);
	}

	function list_post()
	{
		$result = $this->category->list($this->post());
		return $this->response($result);
	}

	function subKategori_post()
	{
		$result = $this->category->subKategori($this->post());
		$this->response($result);
	}

}

/* End of file Category.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Category.php */