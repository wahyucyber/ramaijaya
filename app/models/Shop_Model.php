<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_Model extends MY_Model {

	protected $tabel = 'mst_toko';

	protected $tabel_produk = 'mst_produk';
	
	protected $tabel_produk_foto = 'mst_produk_foto';

	function cek_toko($slug)
	{
		$toko = $this->db->query("SELECT
										id as id_toko,
										nama_toko,
										CONCAT('".base_url()."',logo) as image,
										deskripsi as description
									FROM
										$this->tabel
									WHERE
										slug = '$slug'
									AND
										status = 1
									AND
										buka = 1")->row_array();
		$result['Error'] = true;
		if ($toko) {
			$result['Error'] = false;
			$result['Data'] = $toko;
		}
		return $result;
	}

	function cek_produk($slug)
	{
		$produk = $this->db->query("SELECT
										$this->tabel_produk.id as id_produk,
										$this->tabel_produk.nama_produk,
										$this->tabel.nama_toko
									FROM
										$this->tabel_produk
									LEFT JOIN
									    $this->tabel
									    ON
									    $this->tabel_produk.toko_id=$this->tabel.id
									WHERE
										$this->tabel_produk.slug = '$slug'
									AND
										$this->tabel_produk.status = 1
									AND
										$this->tabel_produk.verifikasi = 1")->row_array();
		$result['Error'] = true;
		if ($produk) {
			$result['Error'] = false;
			$result['Data'] = [
			    'id_produk' => $produk['id_produk'],
			    'nama_produk' => $produk['nama_produk'],
			    'description' => $produk['nama_toko'],
			    'image' => $this->foto_produk($produk['id_produk'])[0]['foto']
		    ];
		}
		return $result;
	}
	
	private function foto_produk($produk_id)
	{
		$query = $this->db->query("SELECT
										id as id_foto,
										CONCAT('".base_url('')."', '', foto) AS foto
									FROM
										$this->tabel_produk_foto
									WHERE
										produk_id = $produk_id");
		$result = null;
		if ($query->num_rows() > 0) {
			$no = 0;
			foreach($query->result_array() as $key) {
				$result[$no++] = $key;
			}
		}
		return $result;
	}

}