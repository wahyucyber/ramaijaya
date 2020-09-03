<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tab extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
    	$params['view'] = 'admin/tab';
        $params['js'] = 'admin/tab';

        $this->load_view($params,$data);
	}

}

/* End of file Tab.php */
/* Location: ./application/controllers/Tab.php */