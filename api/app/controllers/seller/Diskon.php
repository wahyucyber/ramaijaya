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
        $this->load->model('seller/M_Diskon','diskon');
    }

 	public function index_post()
 	{
 		$result = $this->diskon->all($this->post());
 		$this->response($result);
 	} 

 	public function get_kategori_post()
 	{
 		$result = $this->diskon->get_kategori($this->post());
 		$this->response($result);
 	}   

 	public function get_produk_post()
 	{
 		$result = $this->diskon->get_produk($this->post());
 		$this->response($result);
 	}   

 	public function add_kategori_post()
 	{
 		$result = $this->diskon->add_kategori($this->post());
 		$this->response($result);
 	}

 	public function kategori_delete_post()
 	{
 		$result = $this->diskon->kategori_delete($this->post());
 		$this->response($result);
 	}

 	public function add_produk_post()
 	{
 		$result = $this->diskon->add_produk($this->post());
 		$this->response($result);
 	}

 	public function produk_delete_post()
 	{
 		$result = $this->diskon->produk_delete($this->post());
 		$this->response($result);
 	}
}