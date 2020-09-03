<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komplain extends MY_Seller {

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$data['title'] = 'Komplain';
        $params['view'] = 'seller/komplain';
        $params['js'] = 'seller/komplain';

        $this->load_view($params,$data);
	}

}

/* End of file Komplain.php */
/* Location: .//F/Server/www/jpstore/app/controllers/seller/Komplain.php */