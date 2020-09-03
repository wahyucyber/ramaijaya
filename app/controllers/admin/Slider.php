<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Slider';
        $params['view'] = 'admin/slider';
        $params['js'] = 'admin/slider';

        $this->load_view($params,$data);
	}

}

/* End of file Slider.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/Slider.php */