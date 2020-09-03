<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Seller {

    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$data['title'] = 'Halaman Utama';
        $params['view'] = 'seller/home';
        $params['js'] = 'seller/home';

        $this->load_view($params,$data);
	}

}

/* End of file Home.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Home.php */