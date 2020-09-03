<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_User
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    public function __construct()
    {
        parent::__construct();
    }

    public function komplain()
    {
    	$data['title'] = 'Komplain';
		$params['view'] = 'user/komplain';
		$params['js'] = 'user/komplain';

        $this->load_view($params,$data);
    }

    public function pembelian()
    {
    	$data['title'] = 'Pembelian';
        $params['view'] = 'user/pesanan';
        $params['js'] = 'user/pesanan';
        $params['modal'] = 'user/pembelian';

        $this->load_view($params,$data);
    }

    public function pembelian_detail($no_invoice)
    {
    	if(!$no_invoice){
    		show_404();
    	}
    	$data['no_invoice'] = $no_invoice;

		$data['title'] = 'Pembelian';
        $params['view'] = 'user/pembelian_detail';
        $params['js'] = 'user/pembelian_detail';

        $this->load_view($params,$data);
    }

    public function profil()
    {
    	$tab = isset($_GET['tab']) ? $_GET['tab']:"";
        if (empty($tab)) {
			redirect('user/profil?tab=profil');
		}
		if ($tab == "profil") {
			$data['title'] = 'Profil';
	        $params['view'] = 'user/profil';
	        $params['js'] = 'user/profil';

	        $this->load_view($params,$data);
		}else if ($tab == "informasi_pengiriman") {
			$data['title'] = 'Informasi Pengiriman';
	        $params['view'] = 'user/informasi_pengiriman';
	        $params['js'] = 'user/informasi_pengiriman';

	        $this->load_view($params,$data);
		}else if ($tab == "tambah_informasi_pengiriman") {
			$data['title'] = 'Informasi Pengiriman';
	        $params['view'] = 'user/informasi_pengiriman_add';
	        $params['js'] = 'user/informasi_pengiriman_add';

	        $this->load_view($params,$data);
		}else if($tab == 'ubah-password'){
            $data['title'] = 'Ubah Password';
            $params['view'] = 'user/ubah_password';
            $params['js'] = 'user/ubah_password';

            $this->load_view($params,$data);
        }else{
			show_404();
		}
    }

    public function ulasan()
    {
    	$data['title'] = 'Ulasan';
		$params['view'] = 'user/ulasan';
		$params['js'] = 'user/ulasan';

        $this->load_view($params,$data);
    }

    public function ulasan_detail($id = null)
    {
    	$ulasan = $this->db->query("SELECT
                                        id
                                    FROM
                                        mst_produk_ulasan
                                    WHERE
                                        id = '$id'
                                        AND
                                        reply_id = '0'")->row_array();
        if (!$ulasan) {
            show_404();
        }
        $data['title'] = 'Detail Ulasan';
        $params['view'] = 'user/ulasan_detail';
        $params['js'] = 'user/ulasan_detail';

        $this->load_view($params,$data);
    }
}