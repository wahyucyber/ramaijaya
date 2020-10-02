<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diskon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cron/M_Diskon','diskon');
    }

    function index_get()
    {
         $result = $this->diskon->index();
       
    	   $this->response($result);
    }
}