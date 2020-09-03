<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notifikasi_Model','notif');
	}

	function index_post()
	{
		$result = $this->notif->all($this->post());
		$this->response($result);
	}
	
	function set_baca_post()
	{
	    $result = $this->notif->dibaca($this->post());
		$this->response($result);
	}
	
	function chat_post()
	{
		$result = $this->notif->all_chat($this->post());
		$this->response($result);
	}
	
	function set_baca_chat_post()
	{
	    $result = $this->notif->dibaca_chat($this->post());
		$this->response($result);
	}

}

/* End of file Notifikasi.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/Notifikasi.php */