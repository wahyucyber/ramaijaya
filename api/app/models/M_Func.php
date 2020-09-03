<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Func extends MY_Model {
    
    protected $tabel_notifikasi = 'notifikasi';

    protected $tabel_chat = 'notifikasi_chat';
    
    protected $tabel_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();
	}

	function generate_code()
	{
		mt_srand((double)microtime()*10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);
		$result = substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid, 12, 4).$hyphen
			.substr($charid, 16, 4).$hyphen
			.substr($charid, 20, 12);
		return $result;
	}

	function str_random($length = 30,$prefix = 'alnum')
    {
    	$str = random_string($prefix, $length);
        $uniqid = strtoupper(uniqid());
    	return $str.$uniqid;
    }

    function generate_id($tabel,$id = 'id')
    {
		$this->db->select($id);
		$this->db->order_by($id,'DESC');
		$this->db->limit(1);
		$result = $this->db->get($tabel);
		if ($result->num_rows() > 0) {
			$result = $result->result_array()[0]['id'];
		}else{
			$result = 0; 
		}

		$result++;

		return $result;

    }
    
    function get_urlmeta($params)
	{
		$url = isset($params['url'])? $params['url'] : '';
		if (empty($url)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter url tidak diset";
			goto output;
		}
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.urlmeta.org/?url=".$url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Basic bWFzdGVndWhkb3Rjb21AZ21haWwuY29tOjFyRXl1QUM0bHJ3NTFQSG9pcWJW"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$data = json_decode($response,true);

		if ($data['result']['status'] == 'OK') {
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Data'] = $data['meta'];
			$result['Url'] = $url;
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = $data['result']['reason'];
		goto output;

		output:
		return $result;
	}
	
	public function set_notif($data)
	{
	    $this->db->insert($this->tabel_notifikasi,$data);
	    $user = $this->db->query("SELECT
	                                    id,
	                                    api_token
	                               FROM
	                                    $this->tabel_user
	                               WHERE
	                                    id = '$data[user_id]'")->row_array();
	    $message['Status'] = "OK";
	    $message['Token'] = $user['api_token'];
	    $this->pusherTrigger('notification','load',$message);
	}

	// public function set_notif_chat($data)
	// {
	//     $this->db->insert($this->tabel_notifikasi,$data);
	//     $user = $this->db->query("SELECT
	//                                     id,
	//                                     api_token
	//                                FROM
	//                                     $this->tabel_user
	//                                WHERE
	//                                     id = '$data[user_id]'")->row_array();
	//     $message['Status'] = "OK";
	//     $message['Token'] = $user['api_token'];
	//     $this->pusherTrigger('notification','load',$message);
	// }

	public function set_notif_chat($data)
	{
	   // $this->db->insert($this->tabel_chat,$data);
	    $user = $this->db->query("SELECT
	                                    id,
	                                    api_token
	                               FROM
	                                    $this->tabel_user
	                               WHERE
	                                    id = '$data[user_id]'")->row_array();
	    $message['Status'] = "OK";
	    $message['Token'] = $user['api_token'];
	    $this->pusherTrigger('chating','load',$message);
	}
	
	public function pusherTrigger($channel,$event,$message)
	{
        require APPPATH.'/libraries/vendor/autoload.php';
		$options = array(
			'cluster' => env('PUSHER_APP_CLUSTER'),
			'useTLS' => true
		);
		$pusher = new Pusher\Pusher(
			env('PUSHER_APP_KEY'),
			env('PUSHER_APP_SECRET'),
			env('PUSHER_APP_ID'),
			$options
		);
		$pusher->trigger($channel, $event, $message);
	}
	

}

/* End of file M_Func.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Func.php */