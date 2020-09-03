<?php 

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class MY_Controller extends REST_Controller
{

    public function __construct() {
       parent::__construct();
       if (env('API_ENV') == 'production') {
       	   $auth = $this->Authorize->check_auth();
	       if ($auth['Error']) {
	       		return $this->response($auth);
	       }
       }
    }


}