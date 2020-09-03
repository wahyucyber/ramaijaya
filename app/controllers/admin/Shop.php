<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Toko';
    	$params['view'] = 'admin/shop';
        $params['js'] = 'admin/shop';

        $this->load_view($params,$data);
	}

}

/* End of file Shops.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/AdminController/Shops.php */