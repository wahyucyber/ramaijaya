<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('admin/M_Dashboard', 'dashboard');
  }

  function index_post()
  {
    $result = $this->dashboard->index();

    $this->response($result);
  }

  function chart_post()
  {
    $result = $this->dashboard->chart();

    $this->response($result);
  }
}
/** End of file Dashboard.php **/