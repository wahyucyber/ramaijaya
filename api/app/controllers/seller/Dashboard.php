<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('seller/M_Dashboard','dashboard');
    }

    function index_post()
    {
    	$result = $this->dashboard->all($this->post());
    	$this->response($result);
    }
    
    function pesanan_post()
    {
    	$result = $this->dashboard->pesanan($this->post());
    	$this->response($result);
    }

    function chart_post()
    {
    	$result = $this->dashboard->chart($this->post());
    	$this->response($result);
    }

}