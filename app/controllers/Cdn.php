<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cdn extends CI_Controller {

	public function index($segment1 = '',$segment2 = '')
	{
		$file = $segment2? "$segment1/$segment2" : $segment1;

		$lokasi =  FCPATH . "storage/".$file;

		if (file_exists($lokasi)) {
			$imginfo = getimagesize($lokasi);
			header("Content-type: {$imginfo['mime']}");
			readfile($lokasi);
		}else{
			echo 'Not Found';
		}

		// echo FCPATH . "storage\\".$file;
	}

}

/* End of file Cdn.php */
/* Location: .//F/xampp/htdocs/com/JPStore/base/controllers/Cdn.php */