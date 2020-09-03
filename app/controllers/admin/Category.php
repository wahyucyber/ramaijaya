<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Kategori';
        $params['view'] = 'admin/category';
        $params['js'] = 'admin/category';

        $this->load_view($params,$data);
	}

}

/* End of file Category.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/Category.php */