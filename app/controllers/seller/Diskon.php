<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Diskon extends MY_Controller
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
    }

    public function kategori()
    {
    	$data['title'] = 'Diskon Kategori';
        $params['view'] = 'seller/diskon/kategori';
        $params['js'] = 'seller/diskon/kategori';

        $this->load_view($params,$data);
    }

    public function produk()
    {
    	$data['title'] = 'Diskon Kategori';
        $params['view'] = 'seller/diskon/produk';
        $params['js'] = 'seller/diskon/produk';

        $this->load_view($params,$data);
    }
}