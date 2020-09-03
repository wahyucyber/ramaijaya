<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resolution_center extends MY_Seller {

	public function index()
	{
		$data['title'] = 'Pusat Resolusi';
		$params['view'] = 'seller/resolution_center';
		$params['js'] = 'seller/resolution_center';

        $this->load_view($params,$data);
	}

}

/* End of file Resolution_center.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Resolution_center.php */