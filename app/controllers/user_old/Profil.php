
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
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
		}else{
			header('location: '.base_url('404'));
		}
	}

}

/* End of file Profil.php */
/* Location: ./application/controllers/Profil.php */