<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Seller {
    
    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$data['title'] = 'Dashboard';
        $params['view'] = 'seller/dashboard';
        $params['js'] = 'seller/dashboard';

        $this->load_view($params,$data);
	}

}

/* End of file Dashboard.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Dashboard.php */