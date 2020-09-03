<?php
class Search extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Search','search');

    }

    function index_post()
    {
    	$result = $this->search->all($this->post());
    	return $this->response($result);
    }

}
