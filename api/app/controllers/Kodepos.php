<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kodepos extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Kodepos','kodepos');
	}

	function index_post()
	{	
		$result = $this->kodepos->all($this->post());
		return $this->response($result);
	}

}

/* End of file Kodepos.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Kodepos.php */