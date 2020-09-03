<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($tab_content_id = null)
	{
		if ($tab_content_id == null) {
			header('location: '.base_url('404'));
		}

		$data['title'] = 'Content';
		$data['id'] = $tab_content_id;
		$params['view'] = 'content';
        $params['js'] = 'content';

        $this->load_view($params,$data);
	}

}

/* End of file Content.php */
/* Location: ./application/controllers/Content.php */