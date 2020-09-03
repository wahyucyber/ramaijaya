<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alamat_pengiriman extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_Alamat_pengiriman', 'alamat_pengiriman');
	}

	function add_post()
	{
		$result = $this->alamat_pengiriman->add($this->post());
		$this->response($result);
	}

	function list_post()
	{
		$result = $this->alamat_pengiriman->list($this->post());
		$this->response($result);
	}

	function update_post()
	{
		$result = $this->alamat_pengiriman->update($this->post());
		$this->response($result);
	}

	function delete_post()
	{
		$result = $this->alamat_pengiriman->delete($this->post());
		$this->response($result);
	}

	function set_utama_post()
	{
		$result = $this->alamat_pengiriman->set_utama($this->post());
		$this->response($result);
	}

}

/* End of file Alamat_pengiriman.php */
/* Location: ./application/controllers/Alamat_pengiriman.php */