<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tab extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Tab', 'tab');
	}

	function add_post()
	{
		$result = $this->tab->add($this->post());
		$this->response($result);
	}

	function index_post()
	{
		$result = $this->tab->index($this->post());
		$this->response($result);
	}

	function update_post()
	{
		$result = $this->tab->update($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->tab->delete($this->post());
		$this->response($result);
	}

	function set_up_post()
	{
		$result = $this->tab->set_up($this->post());
		$this->response($result);
	}

	function set_down_post()
	{
		$result = $this->tab->set_down($this->post());
		$this->response($result);
	}

}

/* End of file Tab.php */
/* Location: ./application/controllers/Tab.php */