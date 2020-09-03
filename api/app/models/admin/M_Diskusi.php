<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Diskusi extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/
    
    protected $tabel = 'mst_produk_diskusi';

    protected $tabel_foto = 'mst_produk_diskusi_foto';

    protected $tabel_user = 'mst_user';

    protected $tabel_toko = 'mst_toko';

    protected $tabel_produk = 'mst_produk';

    protected $tabel_produk_foto = 'mst_produk_foto';

    function all($params)
    {
    	$limit = isset($params['limit'])? $params['limit'] : 10;

    	$jumlah_data = $this->db->query("SELECT
    									$this->tabel.id,
    									$this->tabel_produk.nama_produk,
    									$this->tabel_user.nama as nama_user,
    									$this->tabel_toko.nama_toko,
    									$this->tabel.diskusi,
    									$this->tabel.diblokir,
    									$this->tabel.catatan_diblokir,
    									$this->tabel.created_at as tanggal,
    									$this->tabel.reply_id
    								FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel.produk_id = $this->tabel_produk.id
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel.toko_id = $this->tabel_toko.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id = $this->tabel_user.id
									WHERE
										$this->tabel.reply_id = '0'")->num_rows();
    	if ($jumlah_data == 0) {
    		$result['Error'] = true;
    		$result['Message'] = "Tidak ada diskusi produk ditemukan";
    		goto output;
    	}

    	$config['jumlah_data'] = $jumlah_data;
		$config['limit'] = $limit;
		$config['page']	= empty($params['page'])? null : $params['page'];

		$pagination = $this->query_pagination($config);

    	$diskusi = $this->db->query("SELECT
    									$this->tabel.id,
    									$this->tabel.produk_id,
    									$this->tabel_produk.nama_produk,
    									$this->tabel_user.nama as nama_user,
    									$this->tabel_toko.nama_toko,
    									$this->tabel.diskusi,
    									$this->tabel.diblokir,
    									$this->tabel.catatan_diblokir,
    									$this->tabel.created_at as tanggal,
    									$this->tabel.reply_id,
    									$this->tabel.penjual
    								FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel.produk_id = $this->tabel_produk.id
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel.toko_id = $this->tabel_toko.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id = $this->tabel_user.id
									WHERE
										$this->tabel.reply_id = '0'
									ORDER BY
										$this->tabel.id DESC
									LIMIT
										$pagination[Data_ke],$limit")->result_array();
    	$no = 0;
    	foreach ($diskusi as $key) {
    		$result['Error'] = false;
    		$result['Message'] = null;
    		$result['Pagination'] = $pagination;
    		$result['Data'][$no++] = [
    			'id' => $key['id'],
				'nama_toko' => $key['nama_toko'],
				'id_produk' => $key['id_produk'],
				'nama_produk' => $key['nama_produk'],
				'foto_produk' => $this->foto_produk($key['produk_id'])[0]['foto'],
				'penjual' => $key['penjual'],
				'nama_user' => $key['penjual'] == 1? $key['nama_toko'] : $key['nama_user'],
				'diskusi' => $key['diskusi'],
				'diskusi_foto' => $this->diskusi_foto($key['id']),
				'reply' => $this->get_balasan($key['id']),
				'diblokir' => $key['diblokir'],
				'catatan_diblokir' => $key['catatan_diblokir'],
				'tanggal' => $key['tanggal']
    		];
    	}
    	goto output;
    	output:
    	return $result;

    }

    function foto_produk($id)
	{
		$foto = $this->db->query("SELECT
									CONCAT('".app_url()."',foto) as foto
								FROM
									$this->tabel_produk_foto
								WHERE
									produk_id = '$id'");
		$result = null;
		if ($foto->num_rows() > 0) {
			$no = 0;
			foreach($foto->result_array() as $key){
				$result[$no++] = $key;
			}
		}
		return $result;
	}

	function set($params)
	{
		$diskusi_id = isset($params['diskusi_id'])? $params['diskusi_id'] : '';
		$blokir = isset($params['blokir'])? $params['blokir'] : 0;
		$catatan_diblokir = isset($params['catatan_diblokir'])? $params['catatan_diblokir'] : 0;
		if (empty($diskusi_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter diskusi_id tidak diset";
			goto output;
		}

		$data = $this->db->query("SELECT
									id
								FROM
									$this->tabel
								WHERE
									id = '$diskusi_id'")->row_array();
		if (!$data) {
			$result['Error'] = true;
			$result['Message'] = "Diskusi tidak ditemukan";
			goto output;
		}

		if ($blokir == 1) {
			if (empty($catatan_diblokir)) {
				$result['Error'] = true;
				$result['Message'] = "Catatan harus diisi";
				goto output;
			}
			$result = $this->set_blokir($diskusi_id,$catatan_diblokir);
			goto output;
		}else{
			$result = $this->set_bukablokir($diskusi_id);
			goto output;
		}

		output:
		return $result;

	}

	private function set_blokir($id,$catatan)
	{
		$update = $this->db->update($this->tabel,['diblokir' => 1,'catatan_diblokir' => $catatan],['id' => $id]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil memblokir komentar";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal memblokir komentar";
		goto output;
		output:
		return $result;
	}

	private function set_bukablokir($id)
	{
		$update = $this->db->update($this->tabel,['diblokir' => 0,'catatan_diblokir' => null],['id' => $id]);
		if ($update) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil membuka blokir";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal membuka blokir";
		goto output;
		output:
		return $result;
	}

  //   function balas($params)
  //   {
  //   	$client_token = isset($params['client_token'])? $params['client_token'] : '';
		// $diskusi_id = isset($params['diskusi_id'])? $params['diskusi_id'] : '';
		// $diskusi = isset($params['diskusi'])? $params['diskusi'] : '';
		// $foto = isset($params['foto'])? $params['foto'] : '';
		// if (empty($client_token)) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Parameter client_token tidak diset";
		// 	goto output;
		// }else if(empty($diskusi_id)) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Parameter diskusi_id tidak diset";
		// 	goto output;
		// }else if(empty($diskusi)) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Pertanyaan tidak boleh kosong";
		// 	goto output;
		// }

		// $user = $this->db->query("SELECT
		// 								id
		// 							FROM
		// 								$this->tabel_user
		// 							WHERE
		// 								api_token = '$client_token'")->row_array();
		// if (!$user) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Pengguna tidak ditemukan";
		// 	goto output;
		// }

		// $data_diskusi = $this->db->query("SELECT
		// 									id,
		// 									toko_id,
		// 									produk_id
		// 								FROM
		// 									$this->tabel
		// 								WHERE
		// 									id = '$diskusi_id'")->row_array();
		// if (!$data_diskusi) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "Diskusi tidak ditemukan";
		// 	goto output;
		// }

		// $data = [
		// 	'toko_id' => $data_diskusi['toko_id'],
 	// 		'produk_id' => $data_diskusi['produk_id'],
		// 	'user_id' => $user['id'],
		// 	'diskusi' => $diskusi,
		// 	'reply_id' => $diskusi_id,
		// 	'penjual' => 1
		// ];

		// $add = $this->db->insert($this->tabel,$data);
		// if ($add) {
		// 	$result['Error'] = false;
		// 	$result['Message'] = "Berhasil membalas diskusi";
		// 	goto output;
		// }
		// $result['Error'] = true;
		// $result['Message'] = "Gagal membalas diskusi";
		// goto output;
		// output:
		// return $result;
  //   }

    function diskusi_foto($diskusi_id)
	{
		$foto = $this->db->query("SELECT
										foto
									FROM
										$this->tabel_foto
									WHERE
										diskusi_id = '$diskusi_id'");
		$result = null;
		if ($foto->num_rows() > 0) {
			$no = 0;
			foreach ($foto as $key) {
				$result[$no++] = $key;
			}
		}
		return $result;
	}

	private function get_balasan($diskusi_id)
	{
		if (empty($diskusi_id)) {
			return null;
		}

		$ulasan = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel.toko_id,
										$this->tabel_toko.nama_toko,
										$this->tabel_produk.nama_produk,
										$this->tabel_user.nama as nama_user,
										$this->tabel.diskusi,
    									$this->tabel.diblokir,
    									$this->tabel.catatan_diblokir,
										$this->tabel.reply_id,
										$this->tabel.created_at as tanggal,
										$this->tabel.penjual
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel.toko_id=$this->tabel_toko.id
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									WHERE
										$this->tabel.reply_id = '$diskusi_id'");
		$result = null;
		if ($ulasan->num_rows() > 0) {
			
			$no = 0;
			foreach ($ulasan->result_array() as $key) {
				$result[$no++] = [
					'id' => $key['id'],
					'nama_toko' => $key['nama_toko'],
					'id_produk' => $key['id_produk'],
					'nama_produk' => $key['nama_produk'],
					'foto_produk' => $this->foto_produk($key['produk_id'])[0]['foto'],
					'penjual' => $key['penjual'],
					'nama_user' => $key['penjual'] == 1? $key['nama_toko'] : $key['nama_user'],
					'diskusi' => $key['diskusi'],
					'diskusi_foto' => $this->diskusi_foto($key['id']),
					'reply' => $this->get_balasan($key['id']),
					'diblokir' => $key['diblokir'],
					'catatan_diblokir' => $key['catatan_diblokir'],
					'tanggal' => $key['tanggal']
				];
			}
		}
		return $result;

	}
}