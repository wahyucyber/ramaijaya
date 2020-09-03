<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Seller {

	public function index()
	{
		$data['title'] = 'Manajemen Produk';
		$params['view'] = 'seller/product/index';
		$params['js'] = 'seller/product/index';

        $this->load_view($params,$data);
	}

	public function add()
	{
		$data['title'] = 'Tambah Produk';
        $params['view'] = 'seller/product/add';
        $params['js'] = 'seller/product/add';

        $this->load_view($params,$data);
	}

	public function edit($produk_id)
	{
		// $produk_id = isset($_GET['p'])? $_GET['p'] : '';

		// if (empty($produk_id)) {
		// 	show_404();
		// }else{
			$data['title'] = 'Edit Produk';
	        $params['view'] = 'seller/product/edit';
	        $params['js'] = 'seller/product/edit';

	        $this->load_view($params,$data);
		// }
	}

	public function import()
	{
		$data['title'] = 'Import Product';
        $params['view'] = 'seller/product/import';
        $params['js'] = 'seller/product/import';

        $this->load_view($params,$data);
	}

}

/* End of file Product.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Product.php */