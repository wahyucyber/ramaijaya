<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faq_Model','faq');
    }

    function index_post()
    {
    	$result = $this->faq->all($this->post());
    	$this->response($result);
    }

    function detail_post()
    {
    	$result = $this->faq->detail($this->post());
    	$this->response($result);
    }

    function detail_single_post()
    {
        $result = $this->faq->detail_single($this->post());
        $this->response($result);
    }
    
    function add_menu_post()
    {
    	$result = $this->faq->add_menu($this->post());
    	$this->response($result);
    }
    
    function edit_menu_post()
    {
    	$result = $this->faq->edit_menu($this->post());
    	$this->response($result);
    }
    
    function delete_menu_post()
    {
    	$result = $this->faq->delete_menu($this->post());
    	$this->response($result);
    }
    

    function add_detail_post()
    {
    	$result = $this->faq->add_detail($this->post());
    	$this->response($result);
    }
    
    function edit_detail_post()
    {
    	$result = $this->faq->edit_detail($this->post());
    	$this->response($result);
    }
    
    function delete_detail_post()
    {
    	$result = $this->faq->delete_detail($this->post());
    	$this->response($result);
    }
}