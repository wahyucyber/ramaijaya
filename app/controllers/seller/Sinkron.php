<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sinkron extends MY_Seller {
    
    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$data['title'] = 'Sinkron';
        $params['view'] = 'seller/sinkron';
        $params['js'] = 'seller/sinkron';

        $this->load_view($params,$data);
	}

}

/* End of file Sinkron.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Sinkron.php */