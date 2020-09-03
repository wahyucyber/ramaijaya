<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Komplain extends MY_Model {

	protected $tabel = 'mst_produk_komplain';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_transaksi = 'mst_transaksi';

	protected $tabel_transaksi_detail = 'mst_transaksi_detail_';

	function all($params)
	{
		$start = $params['start'];
		$length = $params['length'];
		$draw = $params['draw'];
		$search = $params['search']['value'];
		$keyword = empty($search)? "" : " WHERE $this->tabel_user.nama LIKE '%$search%'
											OR $this->tabel_produk.nama_produk LIKE '%$search%'
											OR $this->tabel.no_invoice LIKE '%$search%'
											OR $this->tabel.komplain LIKE '%$search%'";

		$jumlah_data = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel.user_id,
										$this->tabel_user.nama,
										$this->tabel.produk_id,
										$this->tabel_produk.nama_produk,
										$this->tabel.no_invoice,
										$this->tabel.transaksi_id,
										$this->tabel.komplain
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN 
										$this->tabel_produk
										ON
										$this->tabel.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_transaksi
										ON
										$this->tabel.transaksi_id=$this->tabel_transaksi.id
									LEFT JOIN 
    									$this->tabel_toko
									    ON
									    $this->tabel_produk.toko_id=$this->tabel_toko.id
										$keyword
									ORDER BY $this->tabel.created_at DESC")->num_rows();
		if ($jumlah_data > 0) {

			$no = 0;

			$data = $this->db->query("SELECT
										$this->tabel.id,
										$this->tabel_user.nama,
										$this->tabel_produk.nama_produk,
										$this->tabel_toko.nama_toko,
										$this->tabel.no_invoice,
										$this->tabel.komplain,
										$this->tabel.status,
										$this->tabel.created_at
									FROM
										$this->tabel
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN 
										$this->tabel_produk
										ON
										$this->tabel.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_transaksi
										ON
										$this->tabel.transaksi_id=$this->tabel_transaksi.id
									LEFT JOIN 
    									$this->tabel_toko
    								    ON
    								    $this->tabel_produk.toko_id=$this->tabel_toko.id
										$keyword
									ORDER BY $this->tabel.created_at DESC
									LIMIT $start,$length")->result_array();
			foreach($data as $key){
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'][$no++] = [
					'id' => $key['id'],
					'nama' => $key['nama'],
					'nama_produk' => $key['nama_produk'],
					'nama_toko' => $key['nama_toko'],
					'no_invoice' => $key['no_invoice'],
					'komplain' => $key['komplain'],
					'status' => $key['status'],
					'tanggal' => date('d M Y H:i',strtotime($key['created_at']))
				]; 
			}
			$result['recordsTotal'] = $jumlah_data;
			$result['recordsFiltered'] = count($data);
			$result['draw'] = $draw;
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Tidak ada komplain";
		$result['Data'] = [];
		$result['recordsTotal'] =0;
		$result['recordsFiltered'] = 0;
		$result['draw'] = 0;
		goto output;
		output:
		return $result;
	}

}
