<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ulasan extends MY_Seller
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
		$data['title'] = 'Ulasan';
        $params['view'] = 'seller/ulasan';
        $params['js'] = 'seller/ulasan';

        $this->load_view($params,$data);
	}

    public function detail($id = null)
    {
        $ulasan = $this->db->query("SELECT
                                        id
                                    FROM
                                        mst_produk_ulasan
                                    WHERE
                                        id = '$id'")->row_array();
        if (!$ulasan) {
            show_404();
        }
        $data['title'] = 'Detail Ulasan';
        $params['view'] = 'seller/ulasan_detail';
        $params['js'] = 'seller/ulasan_detail';

        $this->load_view($params,$data);
    }
}