<?php

class MY_Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->cek_auth['Error']) {
			show_404();
		}
		if ($this->cek_auth['Rules'] !== '1') {
			show_404();
		}
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/controllers/Admin_Controller.php */