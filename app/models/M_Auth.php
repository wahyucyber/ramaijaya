<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends MY_Model {

    protected $tabel = 'mst_user';

	function cek($token)
	{
		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel
									WHERE
										api_token = '$token'")->row_array();
		if ($user) {
			$result['Error'] = false;
			$result['Data'] = $user;
		}else{
			$result['Error'] = true;
		}
		return $result;
	}


}
