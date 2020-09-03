<?php

class MY_Seller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->cek_auth['Error']) {
			show_404();
		}
		if ($this->cek_auth['Toko'] == '0') {
			show_404();
		}
	}

}
