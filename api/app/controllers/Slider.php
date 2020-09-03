<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Slider','slider');
	}

	function index_post()
	{
		$result = $this->slider->all($this->post());
		return $this->response($result);
	}

}

/* End of file Slider.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/controllers/Slider.php */