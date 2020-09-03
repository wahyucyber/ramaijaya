<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tab_content extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Tab_content', 'tab_content');
	}

	function add_post()
	{
		$result = $this->tab_content->add($this->post());
		$this->response($result);
	}

	function index_post()
	{
		$result = $this->tab_content->index($this->post());
		$this->response($result);
	}

	function update_post()
	{
		$result = $this->tab_content->update($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->tab_content->delete($this->post());
		$this->response($result);
	}

}

/* End of file Tab_content.php */
/* Location: ./application/controllers/Tab_content.php */