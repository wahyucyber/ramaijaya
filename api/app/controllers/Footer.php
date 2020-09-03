<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Footer', 'footer');
	}

	function index_post()
	{
		$result = $this->footer->index();
		$this->response($result);
	}

}

/* End of file Footer.php */
/* Location: ./application/controllers/Footer.php */