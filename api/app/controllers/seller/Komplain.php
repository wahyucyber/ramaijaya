<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komplain extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('seller/M_Komplain','komplain');
	}

	function index_post()
	{
		$result = $this->komplain->all($this->post());
		$this->response($result);
	}

    function komentar_post()
    {
        $result = $this->komplain->komentar($this->post());
		$this->response($result);
    }
    
    function komentar_close_post()
    {
        $result = $this->komplain->close($this->post());
		$this->response($result);
    }
    
    function komentar_add_post()
    {
        $result = $this->komplain->komentar_add($this->post());
		$this->response($result);
    }

}

/* End of file Komplain.php */
/* Location: .//F/Server/www/jpstore/api/app/controllers/seller/Komplain.php */