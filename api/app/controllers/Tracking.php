<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tracking extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Ongkir','ongkir');
    }

    function index_post()
    {
    	$result = $this->ongkir->get_tracking($this->post());
    	$this->response($result);
    }
}