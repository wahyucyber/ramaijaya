<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manual_payment extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Manual Payment Content';
    	$params['view'] = 'admin/manual_payment';
        $params['js'] = 'admin/manual_payment';

        $this->load_view($params,$data);
	}

}

/* End of file Dashboard.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/Dashboard.php */