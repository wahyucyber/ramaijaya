<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($kategori_id = null)
	{
		if ($kategori_id == null) {
			header('location: '.base_url(''));
		}

		$data['title'] = 'SubCategory';
		$params['view'] = 'category';
		$params['js'] = 'category';
		$data['kategori_id'] = $kategori_id;

		$this->load_view($params,$data);
	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */