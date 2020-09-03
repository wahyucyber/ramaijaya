<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Manajemen Pengguna';
        $params['view'] = 'admin/user';
        $params['js'] = 'admin/user';

        $this->load_view($params,$data);
	}

}

/* End of file User.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/admin/User.php */