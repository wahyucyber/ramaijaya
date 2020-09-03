<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$auth = $this->Authorize->check_auth_admin();
		if ($auth['Error']) {
			return $this->response($auth);
		}
		$this->load->model('admin/M_Category','category');
	}

	function index_post()
	{
		$result = $this->category->all($this->post());
		return $this->response($result);
	}

	function list_post()
	{
		$result = $this->category->list($this->post());
		return $this->response($result);
	}

	function add_post()
	{
		$result = $this->category->add($this->post());
		return $this->response($result);
	}

	function update_post()
	{
		$result = $this->category->update($this->post());
		return $this->response($result);
	}

	function delete_post()
	{
		$result = $this->category->delete($this->post());
		return $this->response($result);
	}

	function set_up_post()
	{
		$result = $this->category->set_up($this->post());
		$this->response($result);
	}

	function set_down_post()
	{
		$result = $this->category->set_down($this->post());
		$this->response($result);
	}

}

/* End of file Category.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/admin/Category.php */