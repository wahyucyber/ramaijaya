<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
    	$params['view'] = 'admin/dashboard';
        $params['js'] = 'admin/dashboard';

        $this->load_view($params,$data);
	}

}

/* End of file Dashboard.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/Dashboard.php */