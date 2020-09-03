<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Shop_Model','toko');
	}

	public function index($toko = null, $produk = null)
	{
		if ($toko && empty($produk)) {

            $tab = isset($_GET['tab'])? $_GET['tab'] : '';

            if (empty($tab)) {
                redirect('shop/'.$toko.'?tab=2');
            }


            $data['tabs'] = $tab;
            $data['toko'] = $toko;

            if ($tab == 1) {
                $params['js'] = 'shop/shop_home';
            }else if($tab == 2) {
                $params['js'] = 'shop/shop_product';
            }else if($tab == 3) {
                $params['js'] = 'shop/shop_ulasan';
            }else{
                show_404();
            }

            $cek_toko = $this->toko->cek_toko($toko);

            if ($cek_toko['Error']) {
                show_404();
            }

            $toko = $cek_toko['Data'];

            $data['title'] = $toko['nama_toko'];
            $data['og_image'] = $toko['image'];
            $data['og_description'] = strtolower(strip_tags($toko['description']));

            $params['view'] = 'shop';
            $params['modal'] = 'shop';
            $this->load_view($params,$data);

        }else if($toko && $produk) {

            $tab = isset($_GET['tab'])? $_GET['tab'] : '';

            if (empty($tab)) {
                redirect("shop/$toko/$produk?tab=1");
            }

            $data['tabs'] = $tab;
            $data['toko'] = $toko;
            $data['produk'] = $produk;

            if ($tab == 1) {
                $params['js'] = 'product/tab_info';
            }else if($tab == 2) {
                $params['js'] = 'product/tab_ulasan';
            }

            $cek_produk = $this->toko->cek_produk($produk);

            if ($cek_produk['Error']) {
                show_404();
            }

            $produk = $cek_produk['Data'];

            $data['title'] = $produk['nama_produk'];
            $data['og_image'] = $produk['image'];
            $data['og_description'] = $produk['description'];

            $params['view'] = 'product';
            $params['css'] = 'product';
            $params['js'] = 'product';

            $this->load_view($params,$data);

        }else{
            show_404();
        }
	}

	public function open()
	{
        if ($this->cek_auth['Rules'] == 1) {
            redirect('admin/shop');
        }
		$data['title'] = 'Buka Toko';
        $params['view'] = 'my-shop';
        $params['js'] = 'my-shop';

        $this->load_view($params,$data);
	}

}

/* End of file Shop.php */
/* Location: .//F/xampp/htdocs/com/JPStore/base/controllers/Shop.php */