<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurir extends MY_Seller {

	public function index()
	{
		$data['title'] = 'Kurir';
        $params['view'] = 'seller/kurir';
        $params['js'] = 'seller/kurir';

        $this->load_view($params,$data);
	}

}

/* End of file Home.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Home.php */