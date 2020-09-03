<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Content', 'content');
	}

	function index_post()
	{
		$result = $this->content->index($this->post());
		$this->response($result);
	}

}

/* End of file Content.php */
/* Location: ./application/controllers/Content.php */