<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_Model extends MY_Model {

	protected $tabel = 'pusher_chat';

	protected $tabel_pusher = 'pusher';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	function single($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$slug_toko = isset($params['slug_toko'])? $params['slug_toko'] : '';
		$penerima_id = isset($params['penerima_id'])? $params['penerima_id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}

		// pengirim
		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

// 		if (empty($slug_toko) || empty($penerima_id)) {
// 			$result['Error'] = true;
// 			$result['Message'] = "Parameter slug_toko atau penerima_id tidak diset";
// 			goto output;
// 		}

		$receiver = 0;

		if (!empty($slug_toko)) {

			$toko = $this->db->query("SELECT
											$this->tabel_toko.id,
											$this->tabel_toko.user_id
										FROM
											$this->tabel_toko
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_toko.user_id=$this->tabel_user.id
										WHERE
											$this->tabel_toko.slug = '$slug_toko'")->row_array();
			if (!$toko) {
				$result['Error'] = true;
				$result['Message'] = "Penjual tidak ditemukan";
				goto output;
			}

			$receiver = $toko['user_id'];
		}

		if (!empty($penerima_id)) {
			
			$receiver = $penerima_id;

		}

		// penerima
		$penerima = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										id = '$receiver'")->row_array();

		if(!$penerima){
			$result['Error'] = true;
			$result['Message'] = "Penerima tidak ditemukan";
			goto output;
		}

		$chat_channel = $this->db->query("SELECT
												id,
												channel
											FROM
												$this->tabel_pusher
											WHERE
												user_id = '$user[id]'
												AND
												penerima_id = '$penerima[id]'")->row_array();

		if(!$chat_channel){
			$result['Error'] = true;
			$result['Message'] = "Tidak ada pesan";
			goto output;
		}

		$chat = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel.channel,
										$this->tabel_user.nama,
										$this->tabel.user_id,
										$this->tabel.pesan,
										$this->tabel_toko.nama_toko,
										$this->tabel.created_at as waktu,
										$this->tabel.meta_url,
										$this->tabel.meta_image,
										$this->tabel.meta_title,
										$this->tabel.meta_description,
										$this->tabel.meta
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN
									    $this->tabel_toko
									    ON
									    $this->tabel_user.id=$this->tabel_toko.user_id
									WHERE
										$this->tabel.channel ='$chat_channel[channel]'
									ORDER BY $this->tabel.created_at ASC");
		if ($chat->num_rows() > 0) {
			$no = 0;
			foreach($chat->result_array() as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id' => $key['id'],
					'channel' => $key['channel'],
					'nama' => $key['nama'],
					'pesan' => $key['pesan'],
					'reply' => $key['user_id'] == $user['id']? false : true,
					'waktu' => date('Y-m-d H:i',strtotime($key['waktu'])),
					'meta_url' => $key['meta_url'],
					'meta_image' => $key['meta_image'],
					'meta_title' => $key['meta_title'],
					'meta_description' => $key['meta_description'],
					'meta' => $key['meta']
				];
			}
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Tidak ada pesan";
		goto output;
		output:
		return $result;

	}

	function list($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}

		// pengirim
		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$chat = $this->db->query("SELECT
										$this->tabel_pusher.id,
										$this->tabel_pusher.channel,
										$this->tabel_pusher.penerima_id,
										CONCAT('".app_url()."',$this->tabel_user.foto) as foto,
										$this->tabel_user.nama,
										CONCAT('".app_url()."',$this->tabel_toko.logo) as logo_toko,
										$this->tabel_toko.nama_toko,
										$this->tabel_pusher.penjual
									FROM
										$this->tabel_pusher
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_pusher.penerima_id=$this->tabel_user.id
									LEFT JOIN
									    $this->tabel_toko
									    ON
									    $this->tabel_user.id=$this->tabel_toko.user_id
									WHERE
										$this->tabel_pusher.user_id = '$user[id]'
									ORDER BY
										$this->tabel_pusher.created_at DESC");
		if ($chat->num_rows() > 0) {
			$no = 0;
			foreach($chat->result_array() as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id' => $key['id'],
					'channel' => $key['channel'],
					'penjual' => $key['penjual'],
					'penerima_id' => $key['penerima_id'],
					'foto' => $key['penjual'] == 1? $key['logo_toko'] : $key['logo_toko'],
					'nama_penerima' => $key['penjual'] == 1? $key['nama_toko'] : $key['nama'],
					'pesan_terakhir' => $this->get_pesan_terakhir($key['channel'],$user['id'])
				];
			}
			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Tidak ada pesan";
		goto output;
		output:
		return $result;

	}

	private function cek_toko($user_id)
	{
		$toko = $this->db->query("SELECT
										id,
										user_id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user_id'")->num_rows();
		return $toko;
	}

	private function get_pesan_terakhir($channel,$user_id)
	{
		$chat = $this->db->query("SELECT
		                                $this->tabel.id,
		                                $this->tabel.channel,
										$this->tabel.user_id,
										$this->tabel_user.nama,
										$this->tabel.pesan,
										$this->tabel.created_at as waktu,
										$this->tabel.meta_url,
										$this->tabel.meta_image,
										$this->tabel.meta_title,
										$this->tabel.meta_description,
										$this->tabel.meta
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									WHERE
										$this->tabel.channel = '$channel'
										AND
										$this->tabel.meta = '0'
									ORDER BY $this->tabel.created_at DESC
									LIMIT 0,1");
		$result = null;
		if ($chat->num_rows() > 0) {
			
			$chat = $chat->row_array();
			$result = [
                'id' => $chat['id'],
                'channel' => $chat['channel'],
                'nama' => $chat['nama'],
                'pesan' => $chat['meta'] == 1? ">> Produk" : $chat['pesan'],
                'reply' => $chat['user_id'] == $user_id? false : true,
                'waktu' => date('H:i',strtotime($chat['waktu'])),
                'meta_url' => $chat['meta_url'],
				'meta_image' => $chat['meta_image'],
				'meta_title' => $chat['meta_title'],
				'meta_description' => $chat['meta_description'],
				'meta' => $chat['meta']
			];

		}
		return $result;
	}

	function send($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$slug_toko = isset($params['slug_toko'])? $params['slug_toko'] : '';
		$penerima_id = isset($params['penerima_id'])? $params['penerima_id'] : '';
		$pesan = isset($params['pesan'])? htmlspecialchars($params['pesan']) : '';
		$pesan = trim($pesan);

		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($pesan)) {
			$result['Error'] = true;
			$result['Message'] = "Pesan harus diisi";
			goto output;
		}

		// pengirim
		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

// 		if (empty($slug_toko) || empty($penerima_id)) {
// 			$result['Error'] = true;
// 			$result['Message'] = "Parameter slug_toko atau penerima_id tidak diset";
// 			goto output;
// 		}

		$receiver = 0;

		if (!empty($slug_toko)) {

			$toko = $this->db->query("SELECT
											$this->tabel_toko.id,
											$this->tabel_toko.user_id
										FROM
											$this->tabel_toko
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_toko.user_id=$this->tabel_user.id
										WHERE
											$this->tabel_toko.slug = '$slug_toko'")->row_array();
			if (!$toko) {
				$result['Error'] = true;
				$result['Message'] = "Penjual tidak ditemukan";
				goto output;
			}

			$receiver = $toko['user_id'];
		}

		if (!empty($penerima_id)) {
			
			$receiver = $penerima_id;

		}
		
		$penerima = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										id = '$receiver'")->row_array();

		if(!$penerima){
			$result['Error'] = true;
			$result['Message'] = "Penerima tidak ditemukan";
			goto output;
		}

		$channel = $this->db->query("SELECT
										id,
										channel
									FROM
										$this->tabel_pusher
									WHERE
										user_id = '$user[id]'
										AND
										penerima_id = '$receiver'")->row_array();
		if (!$channel) {

			$kode_channel = $this->generate_channel();

			$data_pusher = [
				[
					'channel' => $kode_channel,
					'user_id' => $user['id'],
					'penerima_id' => $receiver,
					'penjual' => 1
				],
				[
					'channel' => $kode_channel,
					'user_id' => $receiver,
					'penerima_id' => $user['id'],
					'penjual' => 0
				]				
			];

			$add_channel = $this->db->insert_batch($this->tabel_pusher,$data_pusher);
			if ($add_channel) {
				
				$data_chat = [
					'user_id' => $user['id'],
					'channel' => $kode_channel,
					'pesan' => $pesan
				];

				$add_chat = $this->db->insert($this->tabel,$data_chat);
				if ($add_chat) {

					$result['Error'] = false;
					$result['Message'] = "Berhasil mengirim pesan";
					$config['user_id'] = $receiver;
					$config['konten'] = $pesan;
					$this->Func->set_notif_chat($config);
					goto output;		

				}
				$result['Error'] = true;
				$result['Message'] = "Gagal mengirim pesan";
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Gagal membuat channel";
			goto output;

		}else{

			$data_chat = [
				'user_id' => $user['id'],
				'channel' => $channel['channel'],
				'pesan' => $pesan
			];

			$add_chat = $this->db->insert($this->tabel,$data_chat);
			if ($add_chat) {

				$result['Error'] = false;
				$result['Message'] = "Berhasil mengirim pesan";
				$config['user_id'] = $receiver;
				$config['konten'] = $pesan;
				$this->Func->set_notif_chat($config);
				goto output;		

			}
			$result['Error'] = true;
			$result['Message'] = "Gagal mengirim pesan";
			goto output;

		}

		output:
		return $result;

	}

	function send_meta($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$slug_toko = isset($params['slug_toko'])? $params['slug_toko'] : '';
		$penerima_id = isset($params['penerima_id'])? $params['penerima_id'] : '';
		$meta_url = isset($params['meta_url'])? $params['meta_url'] : '';
		$meta_image = isset($params['meta_image'])? $params['meta_image'] : '';
		$meta_title = isset($params['meta_title'])? $params['meta_title'] : '';
		$meta_description = isset($params['meta_description'])? $params['meta_description'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($meta_url)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter meta_url tidak diset";
			goto output;
		}else if(empty($meta_image)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter meta_image tidak diset";
			goto output;
		}else if(empty($meta_title)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter meta_title tidak diset";
			goto output;
		}else if(empty($meta_description)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter meta_description tidak diset";
			goto output;
		}

		// pengirim
		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if (!$user) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

// 		if (empty($slug_toko) || empty($penerima_id)) {
// 			$result['Error'] = true;
// 			$result['Message'] = "Parameter slug_toko atau penerima_id tidak diset";
// 			goto output;
// 		}

		$receiver = 0;

		if (!empty($slug_toko)) {

			$toko = $this->db->query("SELECT
											$this->tabel_toko.id,
											$this->tabel_toko.user_id
										FROM
											$this->tabel_toko
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_toko.user_id=$this->tabel_user.id
										WHERE
											$this->tabel_toko.slug = '$slug_toko'")->row_array();
			if (!$toko) {
				$result['Error'] = true;
				$result['Message'] = "Penjual tidak ditemukan";
				goto output;
			}

			$receiver = $toko['user_id'];
		}

		if (!empty($penerima_id)) {
			
			$receiver = $penerima_id;

		}
		
		$penerima = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										id = '$receiver'")->row_array();

		if(!$penerima){
			$result['Error'] = true;
			$result['Message'] = "Penerima tidak ditemukan";
			goto output;
		}

		$channel = $this->db->query("SELECT
										id,
										channel
									FROM
										$this->tabel_pusher
									WHERE
										user_id = '$user[id]'
										AND
										penerima_id = '$receiver'")->row_array();
		if (!$channel) {

			$kode_channel = $this->generate_channel();

			$data_pusher = [
				[
					'channel' => $kode_channel,
					'user_id' => $user['id'],
					'penerima_id' => $receiver,
					'penjual' => 1
				],
				[
					'channel' => $kode_channel,
					'user_id' => $receiver,
					'penerima_id' => $user['id'],
					'penjual' => 0
				]				
			];

			$add_channel = $this->db->insert_batch($this->tabel_pusher,$data_pusher);
			if ($add_channel) {
				
				$data_chat = [
					'user_id' => $user['id'],
					'channel' => $kode_channel,
					'meta_url' => $meta_url,
					'meta_image' => $meta_image,
					'meta_title' => $meta_title,
					'meta_description' => $meta_description,
					'meta' => 1
				];

				$add_chat = $this->db->insert($this->tabel,$data_chat);
				if ($add_chat) {

					$result['Error'] = false;
					$result['Message'] = "Berhasil mengirim pesan";
					$config['user_id'] = $receiver;
					$config['konten'] = '>> Produk';
					$this->Func->set_notif_chat($config);
					goto output;		

				}
				$result['Error'] = true;
				$result['Message'] = "Gagal mengirim pesan";
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Gagal membuat channel";
			goto output;

		}else{

			$data_chat = [
				'user_id' => $user['id'],
				'channel' => $channel['channel'],
				'meta_url' => $meta_url,
				'meta_image' => $meta_image,
				'meta_title' => $meta_title,
				'meta_description' => $meta_description,
				'pesan' => null,
				'meta' => 1
			];

			$add_chat = $this->db->insert($this->tabel,$data_chat);
			if ($add_chat) {

				$result['Error'] = false;
				$result['Message'] = "Berhasil mengirim pesan";
				$config['user_id'] = $receiver;
				$config['konten'] = '>> Produk';
				$this->Func->set_notif_chat($config);
				goto output;		

			}
			$result['Error'] = true;
			$result['Message'] = "Gagal mengirim pesan";
			$result['Debug'] = $this->db->error();
			goto output;

		}

		output:
		return $result;

	}

	private function generate_channel()
	{
		$prefix = "JP_Chat_";
		$uniq_num = random_string('nozero',10);
		$channel = $prefix.$uniq_num;

		$data = $this->db->query("SELECT
										id
									FROM
									 $this->tabel_pusher
									WHERE
										channel = '$channel'")->num_rows();
		if ($data > 1) {
			return $channel.random_string('numeric',2);
		}
		return $channel;
	}

}
