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
    }

    public function index()
    {
    	$data['title'] = 'Diskusi';
        $params['view'] = 'admin/diskusi';
        $params['js'] = 'admin/diskusi';

        $this->load_view($params,$data);
    }
}