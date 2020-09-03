<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_Model extends MY_Model {

	protected $tabel = 'notifikasi';
	
	protected $tabel_chat = 'notifikasi_chat';

	protected $tabel_user = 'mst_user';

	function all($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client token tidak diset";
			goto output;
		}


		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$notif = $this->db->query("SELECT
											$this->tabel.id,
											$this->tabel_user.nama,
											$this->tabel.tipe,
											$this->tabel.link,
											$this->tabel.konten,
											$this->tabel.dilihat,
											$this->tabel.created_at
										FROM
											$this->tabel
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel.user_id = $this->tabel_user.id
										WHERE
											$this->tabel.user_id = $user[id]
										ORDER BY $this->tabel.created_at DESC");
			if ($notif->num_rows() > 0) {
			    
			    $jumlah = $this->db->query("SELECT
											$this->tabel.id,
											$this->tabel_user.nama,
											$this->tabel.tipe,
											$this->tabel.link,
											$this->tabel.konten,
											$this->tabel.dilihat,
											$this->tabel.created_at
										FROM
											$this->tabel
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel.user_id = $this->tabel_user.id
										WHERE
										    $this->tabel.dilihat = '0' AND
											$this->tabel.user_id = '$user[id]'")->num_rows();
				
				$no = 0;
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Jumlah'] = $jumlah;
				foreach ($notif->result_array() as $key) {
					$result['Data'][$no++] = [
						'id' => $key['id'],
						'nama' => $key['nama'],
						'tipe' => $key['tipe'],
						'link' => $key['link'],
						'konten' => $key['konten'],
						'dilihat' => $key['dilihat'],
						'created_at' => date('d M Y H:i:s',strtotime($key['created_at']))						
					];
				}
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Tidak ada Notifikasi";
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

    function dibaca($params)
    {
        $client_token = isset($params['client_token'])? $params['client_token'] : '';
        $id = isset($params['id'])? $params['id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client token tidak diset";
			goto output;
		}else if(empty($id)) {
		    $result['Error'] = true;
			$result['Message'] = "Parameter id tidak diset";
			goto output;
		}


		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$notif = $this->db->query("SELECT
											$this->tabel.id,
											$this->tabel_user.nama,
											$this->tabel.tipe,
											$this->tabel.link,
											$this->tabel.konten,
											$this->tabel.dilihat
										FROM
											$this->tabel
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel.user_id = $this->tabel_user.id
										WHERE
    										$this->tabel.id = '$id'")->row_array();
			if ($notif) {
				
				$update = $this->db->update($this->tabel,['dilihat' => 1],['id' => $id]);
				if ($update){
				    $result['Error'] = false;
        			$result['Message'] = "Dibaca";
        			goto output;
				}
				$result['Error'] = true;
    			$result['Message'] = "Gagal dibaca";
    			goto output;
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Tidak ada Notifikasi";
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
    }
    
    function all_chat($params)
    {
        $client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client token tidak diset";
			goto output;
		}


		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$notif = $this->db->query("SELECT
											$this->tabel_chat.id,
											$this->tabel_user.nama,
											$this->tabel_chat.konten,
											$this->tabel_chat.dilihat,
											$this->tabel_chat.created_at
										FROM
											$this->tabel_chat
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_chat.user_id = $this->tabel_user.id
										WHERE
											$this->tabel_chat.user_id = '$user[id]'
										ORDER BY $this->tabel_chat.created_at DESC");
			if ($notif->num_rows() > 0) {
			    
			    $jumlah = $this->db->query("SELECT
											$this->tabel_chat.id,
											$this->tabel_user.nama,
											$this->tabel_chat.konten,
											$this->tabel_chat.dilihat,
											$this->tabel_chat.created_at
										FROM
											$this->tabel_chat
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_chat.user_id = $this->tabel_user.id
										WHERE
										    $this->tabel_chat.dilihat = '0' AND
											$this->tabel_chat.user_id = '$user[id]'")->num_rows();
				
				$no = 0;
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Jumlah'] = $jumlah;
				foreach ($notif->result_array() as $key) {
					$result['Data'][$no++] = [
						'id' => $key['id'],
						'nama' => $key['nama'],
						'konten' => $key['konten'],
						'dilihat' => $key['dilihat'],
						'tanggal' => date('d M Y H:i:s',strtotime($key['created_at']))						
					];
				}
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Tidak ada Notifikasi";
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
    }
    
    function dibaca_chat($params)
    {
        $client_token = isset($params['client_token'])? $params['client_token'] : '';
        $id = isset($params['id'])? $params['id'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client token tidak diset";
			goto output;
		}else if(empty($id)) {
		    $result['Error'] = true;
			$result['Message'] = "Parameter id tidak diset";
			goto output;
		}


		$user = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$notif = $this->db->query("SELECT
											$this->tabel_chat.id,
											$this->tabel_user.nama,
											$this->tabel_chat.tipe,
											$this->tabel_chat.link,
											$this->tabel_chat.konten,
											$this->tabel_chat.dilihat
										FROM
											$this->tabel_chat
										LEFT JOIN
											$this->tabel_user
											ON
											$this->tabel_chat.user_id = $this->tabel_user.id
										WHERE
    										$this->tabel_chat.id = '$id'")->row_array();
			if ($notif) {
				
				$update = $this->db->update($this->tabel_chat,['dilihat' => 1],['id' => $id]);
				if ($update){
				    $result['Error'] = false;
        			$result['Message'] = "Dibaca";
        			goto output;
				}
				$result['Error'] = true;
    			$result['Message'] = "Gagal dibaca";
    			goto output;
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Tidak ada Notifikasi";
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
    }

}
