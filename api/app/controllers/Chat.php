<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Chat_Model','chat');
	}

	function single_post()
	{
		$result = $this->chat->single($this->post());
		$this->response($result);
	}

	function list_post()
	{
		$result = $this->chat->list($this->post());
		$this->response($result);
	}
	
	function send_post()
	{
		$result = $this->chat->send($this->post());
		$this->response($result);
	}
	
	function send_meta_post()
	{
		$result = $this->chat->send_meta($this->post());
		$this->response($result);
	}

}

/* End of file Chat.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/Chat.php */