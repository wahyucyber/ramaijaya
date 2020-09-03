<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{

		$member = isset($_GET['member'])? $_GET['member'] : '';

		if (empty($member)) {
			$data['title'] = 'Beranda';
			$params['view'] = 'home';
			$params['css'] = 'home';
			$params['js'] = 'home';

			$this->load_view($params,$data);
		}else{

			$data = explode('=',$member);
			$kode_verifikasi = strtoupper($data[0]);
			$token = $data[1];
			$post = [
				'kode_verifikasi' => $kode_verifikasi,
				'token' => $token
			];

			$result = $this->Func->verifikasi_member($post);
			if ($result['Error']) {
				$this->session->set_flashdata('msg_error',$result['Message']);
				redirect('login');
			}else{
				$this->session->set_flashdata('msg_success',$result['Message']);
				redirect('login');
			}


		}

	}
}
