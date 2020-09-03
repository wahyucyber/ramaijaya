<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_User extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
        if ($this->cek_auth['Error']) {
			show_404();
		}
    }

    
}