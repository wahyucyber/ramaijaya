<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


class Api extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Api','api');
	}

	function add_post()
	{
		$result = $this->api->add($this->post());
		return $this->response($result);
	}

	function bearer_token_post()
	{
		$result = $this->api->bearer_token($this->post());
		return $this->response($result);
	}

    function channel_get()
    {
        $prefix = "JP_Chat_";
		$uniq_num = random_string('nozero',10);
		$channel = $prefix.$uniq_num;

		$data = $this->db->query("SELECT
										id
									FROM
									 pusher
									WHERE
										channel = '$channel'")->num_rows();
		if ($data > 1) {
			$channel =  $channel.random_string('numeric',2);
		}
		return $this->response($channel);
    }

}
