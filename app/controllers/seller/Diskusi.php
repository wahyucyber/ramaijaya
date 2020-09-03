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
        $params['view'] = 'seller/diskusi';
        $params['js'] = 'seller/diskusi';

        $this->load_view($params,$data);
	}
}