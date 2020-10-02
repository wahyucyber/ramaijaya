<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Seller {

	public function shop()
	{
		$tabs = isset($_GET['tab'])? $_GET['tab'] : '';
		if (empty($tabs)) {
			redirect('seller/setting/shop?tab=1');
		}

		if ($tabs == 1) {

			$title = 'Informasi';
	        $params['js'] = 'seller/setting/shop/info';

		}else if($tabs == 2) {

			$title = 'Etalase';
	        $params['js'] = 'seller/setting/shop/etalase';

		}else if($tabs == 3) {

			$title = 'Etalase';
	        $params['js'] = 'seller/setting/shop/catatan';

		}else if($tabs == 4) {

			$title = 'Pengiriman';
	        $params['js'] = 'seller/setting/shop/pengiriman';

		}else if($tabs == 5) {

			$title = 'Produk Unggulan';
	        $params['js'] = 'seller/setting/shop/produk';

		}else if($tabs == 6) {

			$title = 'Template Balasan';
	        $params['js'] = 'seller/setting/shop/balasan';

		}else if($tabs == 7) {

			$title = 'Layanan';
	        $params['js'] = 'seller/setting/shop/layanan';

		}else if($tabs == 8) {

			$title = 'Kurir';
	        $params['js'] = 'seller/setting/shop/layanan';

		}else{

			redirect('seller/setting/shop?tab=1');

		}

		$data['title'] = "$title Toko";
        $params['view'] = 'seller/setting/shop';
        $data['tabs'] = $tabs;

        $this->load_view($params,$data);
	}

	public function admin()
	{
		$data['title'] = 'admin';
        $params['view'] = 'seller/setting/admin';

        $this->load_view($params,$data);
	}

}

/* End of file Setting.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/app/controllers/seller/Setting.php */