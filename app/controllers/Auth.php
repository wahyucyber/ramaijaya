<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		if (!$this->cek_auth['Error']) {
			redirect('');
		}
		$this->load->model('M_Auth','auth');
	}

	public function login()
	{
		$data['title'] = 'Login';
		$params['view'] = 'auth/login';
		$params['js']  = 'auth/login';

		$this->load_view($params,$data);
	}

	public function register()
	{
		$data['title'] = 'Register';
		$params['view'] = 'auth/register';
		$params['js']  = 'auth/register';

		$this->load_view($params,$data);
	}
	
	public function forgot($key = null)
	{
		if ($key) {

			$result = explode('&&', $key);
			
			$token = $result[0];
			$email = isset($result[1])? $result[1] : '';
			if (empty($email)) {
				show_404();
			}

			$user = $this->auth->cek($token);

			if ($user['Error']) {
				show_404();
			}

			$data['title'] = 'Ubah Password';
			$params['view'] = 'auth/forgot_with_token';
			$params['js']  = 'auth/forgot_with_token';
		}else{
			$data['title'] = 'Lupa Password';
			$params['view'] = 'auth/forgot';
			$params['js']  = 'auth/forgot';
		}

		$this->load_view($params,$data);
	}

}

/* End of file Auth.php */
/* Location: .//F/xampp/htdocs/com/JPStore/base/controllers/Auth.php */