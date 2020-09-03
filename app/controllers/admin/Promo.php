<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Promo';
        $params['view'] = 'admin/promo';
        $params['js'] = 'admin/promo';

        $this->load_view($params,$data);
	}

}

/* End of file Promo.php */
/* Location: .//F/xampp/htdocs/com/JPStore/base/controllers/admin/Promo.php */