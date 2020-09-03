<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Promo','promo');
	}

	function index_post()
	{
		$result = $this->promo->all($this->post());
		return $this->response($result);
	}

}

/* End of file Promo.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Promo.php */