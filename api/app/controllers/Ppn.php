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

    function index_post()
    {
    	$result = $this->ppn->cek();
    	return $this->response($result);
    }


}