<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ulasan extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user/M_Ulasan','ulasan');
    }

 	function index_post()
 	{
 		$result = $this->ulasan->all($this->post());
 		$this->response($result);
 	}  

 	public function detail_post()
    {
        $result = $this->ulasan->detail($this->post());
        $this->response($result);
    }
}