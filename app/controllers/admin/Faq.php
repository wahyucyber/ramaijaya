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
    }

    public function index()
    {
    	$data['title'] = 'FAQ';
        $params['view'] = 'admin/faq';
        $params['js'] = 'admin/faq';

        $this->load_view($params,$data);
    }
    
}