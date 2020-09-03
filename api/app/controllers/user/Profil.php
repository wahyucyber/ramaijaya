<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Profil', 'profil');
	}

	function index_post()
	{
		$result = $this->profil->get($this->post());
		$this->response($result);
	}

	function update_post()
	{
		$result = $this->profil->update($this->post());
		$this->response($result);
	}

	function uploadImage_post()
	{
		$result = $this->profil->uploadImage($this->post());
		$this->response($result);
	}

    function ubah_password_post()
	{
		$result = $this->profil->ubah_password($this->post());
		$this->response($result);
	}

}

/* End of file Profil.php */
/* Location: ./application/controllers/Profil.php */