<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Kecamatan','kecamatan');
	}

	function index_post()
	{
		$result = $this->kecamatan->all($this->post());
		return $this->response($result);	
	}

}

/* End of file Kabupaten.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Kabupaten.php */