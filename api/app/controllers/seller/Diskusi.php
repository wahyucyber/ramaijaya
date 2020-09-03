<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Diskusi extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('seller/M_Diskusi','diskusi');
    }

    function index_post()
    {
    	$result = $this->diskusi->all($this->post());
    	$this->response($result);
    }

    function balas_post()
    {
    	$result = $this->diskusi->balas($this->post());
    	$this->response($result);
    }
}