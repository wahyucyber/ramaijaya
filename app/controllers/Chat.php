<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->cek_auth['Error']) {
            redirect('login?continue='.base_url('chat'));
        }
	}

	public function index()
	{
		$data['title'] = 'Percakapan Pribadi Anda';
		$params['view'] = 'chat';
        $params['js'] = 'chat';

        $this->load_view($params,$data);
	}	

}

/* End of file Chats.php */
/* Location: .//F/Server/www/jpstore/app/controllers/Chats.php */