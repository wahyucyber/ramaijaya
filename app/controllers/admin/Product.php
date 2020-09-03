<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Produk';
    	$params['view'] = 'admin/product';
        $params['js'] = 'admin/product';

        $this->load_view($params,$data);
	}

}

/* End of file Product.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/Product.php */