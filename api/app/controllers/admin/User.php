<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_User','user');
		$auth = $this->Authorize->check_auth_admin();
		if ($auth['Error']) {
			return $this->response($auth);
		}
	}

	function index_post()
	{
		$result = $this->user->all($this->post());
		return $this->response($result);
	}

	function add_post()
	{
		$result = $this->user->add($this->post());
		return $this->response($result);
	}

	function update_post()
	{
		$result = $this->user->update($this->post());
		return $this->response($result);
	}

	function reset_post()
	{
		$result = $this->user->reset($this->post());
		return $this->response($result);
	}
	
	function blokir_post()
	{
		$result = $this->user->blokir($this->post());
		return $this->response($result);
	}

	function buka_blokir_post()
	{
		$result = $this->user->buka_blokir($this->post());
		return $this->response($result);
	}

}

/* End of file User.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/admin/User.php */