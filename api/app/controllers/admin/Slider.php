<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$auth = $this->Authorize->check_auth_admin();
		if ($auth['Error']) {
			return $this->response($auth);
		}
		$this->load->model('admin/M_Slider','slider');
	}

	function index_post()
	{
		$result = $this->slider->all($this->post());
		return $this->response($result);
	}

	function add_post()
	{
		$result = $this->slider->add($this->post());
		return $this->response($result);
	}

	function update_post()
	{
		$result = $this->slider->update($this->post());
		return $this->response($result);
	}

	function delete_post()
	{
		$result = $this->slider->delete($this->post());
		return $this->response($result);
	}

}

/* End of file Slider.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/admin/Slider.php */