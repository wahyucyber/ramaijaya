<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ppn extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Ppn','ppn');
    }

    public function index_post()
    {
    	$result = $this->ppn->cek();
    	$this->response($result);
    }

    public function set_post()
    {
    	$result = $this->ppn->set($this->post());
    	$this->response($result);
    }
    
}