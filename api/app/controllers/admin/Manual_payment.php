<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manual_payment extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_Manual_payment', 'manual_payment');
	}

	function index_post()
	{
		$result = $this->manual_payment->index($this->post());
		$this->response($result);
	}

	function add_post()
	{
		$result = $this->manual_payment->add($this->post());
		$this->response($result);
	}

}

/* End of file Manual_payment.php */
/* Location: ./application/controllers/Manual_payment.php */