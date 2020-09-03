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
        $this->load->model('cron/M_Tracking','tracking');
    }

    function index_get()
    {
    	$result = $this->tracking->index();
    	$this->response($result);
    }
}