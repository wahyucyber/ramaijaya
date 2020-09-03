<?php

class Cart extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Midtrans');
        if ($this->cek_auth['Error']) {
            redirect('login?continue='.base_url('cart'));
        }
    }

    public function index()
    {
    	$data['title'] = 'Keranjang';
		$params['view'] = 'cart';
        $params['js'] = 'cart';

        $this->load_view($params,$data);
    }

    public function payment()
    {
        $data['title'] = 'Pembayaran';
        $params['view'] = 'payment';
        $params['js'] = 'payment';

        $this->load_view($params,$data);
    }
}