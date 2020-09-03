<?php 

class Search extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $q = isset($_GET['q'])? $_GET['q'] : '';

        $st = isset($_GET['st'])? $_GET['st'] : '';
        $kategori = isset($_GET['kategori'])? $_GET['kategori'] : '';

        if ($st == 'produk') {

            $params['js'] = 'search/search_produk';

        }else if($st == 'toko') {

            $params['js'] = 'search/search_toko';
            
        }else if ($st == "katalog") {
            $params['js'] = 'search/search_katalog';
        }
        
        if (!empty($kategori)) {
            $kategori = $this->db->query("SELECT
                                            nama_kategori
                                            FROM
                                            mst_kategori
                                            WHERE
                                            id = '$kategori'")->row_array();
            $data['kategori'] = $kategori['nama_kategori'];
        }

        $data['keyword'] = $q;
        $data['tabs'] = $st;

    	$data['title'] = 'Pencarian';
		$params['view'] = 'search';

        $this->load_view($params,$data);
    }
}