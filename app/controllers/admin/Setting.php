<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
    }

    public function ppn()
    {
    	$data['title'] = 'PPN';
        $params['view'] = 'admin/ppn';
        $params['js'] = 'admin/ppn';

        $this->load_view($params,$data);
    }
    
}