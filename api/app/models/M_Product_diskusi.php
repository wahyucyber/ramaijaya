<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Product_diskusi extends MY_Model {

	protected $tabel_diskusi = 'mst_produk_diskusi';

	protected $tabel_diskusi_foto = 'mst_produk_diskusi_foto';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_user = 'mst_user';

	public function __construct()
	{
		parent::__construct();
	}

	function add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$slug = isset($params['slug'])? $params['slug'] : '';
		$diskusi = isset($params['diskusi'])? $params['diskusi'] : '';
		$foto = isset($params['foto'])? $params['foto'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter slug tidak diset";
			goto output;
		}else if(empty($diskusi)) {
			$result['Error'] = true;
			$result['Message'] = "Pertanyaan tidak boleh kosong";
			goto output;
		}

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

		$produk = $this->db->query("SELECT
										id,
										toko_id
									FROM
										$this->tabel_produk
									WHERE
										slug = '$slug'")->row_array();
		if (!$produk) {
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
									id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		$status_penjual = 0;
		if ($toko) {
			if ($toko['id'] == $produk['toko_id']) {
				$status_penjual = 1;
			}
		}

		$data = [
			'toko_id' => $produk['toko_id'],
 			'produk_id' => $produk['id'],
			'user_id' => $user['id'],
			'diskusi' => $diskusi,
			'penjual' => $status_penjual
		];

		$add = $this->db->insert($this->tabel_diskusi,$data);
		$diskusi_id = $this->db->insert_id();
		if ($add) {
			
			$no = 0;
			foreach ($foto as $key) {
				$upload = $this->upload_image->upload($foto[$no++],'Foto-Produk','produk');

				$this->db->insert($this->tabel_diskusi_foto, array(
					'diskusi_id' => $diskusi_id,
					'foto' => $upload['Url']
				));
			}
			$result['Error'] = false;
			$result['Message'] = "Berhasil menambahkan diskusi";
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Gagal menambahkan diskusi";
		goto output;
		output:
		return $result;

	}

	function diskusi_foto($diskusi_id)
	{
		$foto = $this->db->query("SELECT
										foto
									FROM
										$this->tabel_diskusi_foto
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

	function all($params)
	{
		$slug = isset($params['slug'])? $params['slug'] : '';
		$limit = isset($params['limit'])? $params['limit'] : 10;
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter slug tidak diset";
			goto output;
		}

		$produk = $this->db->query("SELECT
										id
									FROm
										$this->tabel_produk
									WHERE
										slug = '$slug'")->row_array();
		if (!$produk) {
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;
		}

		$jumlah_data = $this->db->query("SELECT
										$this->tabel_diskusi.id,
										$this->tabel_diskusi.toko_id,
										$this->tabel_toko.nama_toko,
										$this->tabel_produk.nama_produk,
										$this->tabel_user.nama as nama_user,
										$this->tabel_diskusi.diskusi,
										$this->tabel_diskusi.reply_id,
										$this->tabel_diskusi.penjual
									FROM
										$this->tabel_diskusi
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel_diskusi.toko_id=$this->tabel_toko.id
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel_diskusi.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_diskusi.user_id=$this->tabel_user.id
									WHERE
										$this->tabel_diskusi.produk_id = '$produk[id]'
										AND
										$this->tabel_diskusi.reply_id = '0'
										AND
										$this->tabel_diskusi.diblokir = '0'")->num_rows();
		if ($jumlah_data == 0) {
			$result['Error'] = true;
			$result['Message'] = "Diskusi tidak ditemukan";
			goto output;
		}

		$config['jumlah_data'] = $jumlah_data;
		$config['limit'] = $limit;
		$config['page']	= empty($params['page'])? null : $params['page'];

		$pagination = $this->query_pagination($config);

		$diskusi = $this->db->query("SELECT
										$this->tabel_diskusi.id,
										$this->tabel_diskusi.toko_id,
										$this->tabel_toko.nama_toko,
										$this->tabel_produk.nama_produk,
										$this->tabel_user.nama as nama_user,
										$this->tabel_diskusi.diskusi,
										$this->tabel_diskusi.reply_id,
										$this->tabel_diskusi.created_at,
										$this->tabel_diskusi.penjual
									FROM
										$this->tabel_diskusi
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel_diskusi.toko_id=$this->tabel_toko.id
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel_diskusi.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_diskusi.user_id=$this->tabel_user.id
									WHERE
										$this->tabel_diskusi.produk_id = '$produk[id]'
										AND
										$this->tabel_diskusi.reply_id = '0'
										AND
										$this->tabel_diskusi.diblokir = '0'
									ORDER BY
										$this->tabel_diskusi.id DESC
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
				'nama_produk' => $key['nama_produk'],
				'penjual' => $key['penjual'],
				'nama_user' => $key['penjual'] == 1? $key['nama_toko'] : $key['nama_user'],
				'diskusi' => $key['diskusi'],
				'diskusi_foto' => $this->diskusi_foto($key['id']),
				'reply' => $this->get_balasan($key['id']),
				'tanggal' => $key['created_at']
			];
		}
		goto output;
		output:
		return $result;
	}

	

	private function get_balasan($diskusi_id)
	{
		if (empty($diskusi_id)) {
			return null;
		}

		$ulasan = $this->db->query("SELECT
										$this->tabel_diskusi.id,
										$this->tabel_diskusi.toko_id,
										$this->tabel_toko.nama_toko,
										$this->tabel_produk.nama_produk,
										$this->tabel_user.nama as nama_user,
										$this->tabel_diskusi.diskusi,
										$this->tabel_diskusi.reply_id,
										$this->tabel_diskusi.created_at,
										$this->tabel_diskusi.penjual
									FROM
										$this->tabel_diskusi
									LEFT JOIN
										$this->tabel_toko
										ON
										$this->tabel_diskusi.toko_id=$this->tabel_toko.id
									LEFT JOIN
										$this->tabel_produk
										ON
										$this->tabel_diskusi.produk_id=$this->tabel_produk.id
									LEFT JOIN
										$this->tabel_user
										ON
										$this->tabel_diskusi.user_id=$this->tabel_user.id
									WHERE
										$this->tabel_diskusi.reply_id = '$diskusi_id'
										AND
										$this->tabel_diskusi.diblokir = '0'");
		$result = null;
		if ($ulasan->num_rows() > 0) {
			
			$no = 0;
			foreach ($ulasan->result_array() as $key) {
				$result[$no++] = [
					'id' => $key['id'],
					'nama_toko' => $key['nama_toko'],
					'nama_produk' => $key['nama_produk'],
					'penjual' => $key['penjual'],
					'nama_user' => $key['penjual'] == 1? $key['nama_toko'] : $key['nama_user'],
					'diskusi' => $key['diskusi'],
					'diskusi_foto' => $this->diskusi_foto($key['id']),
					'reply' => $this->get_balasan($key['id']),
					'tanggal' => $key['created_at']
				];
			}
		}
		return $result;

	}

	function balas($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$diskusi_id = isset($params['diskusi_id'])? $params['diskusi_id'] : '';
		$slug = isset($params['slug'])? $params['slug'] : '';
		$diskusi = isset($params['diskusi'])? $params['diskusi'] : '';
		$foto = isset($params['foto'])? $params['foto'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter client_token tidak diset";
			goto output;
		}else if(empty($diskusi_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter diskusi_id tidak diset";
			goto output;
		}else if(empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter slug tidak diset";
			goto output;
		}else if(empty($diskusi)) {
			$result['Error'] = true;
			$result['Message'] = "Pertanyaan tidak boleh kosong";
			goto output;
		}

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

		$data_diskusi = $this->db->query("SELECT
										id
									FROM
										$this->tabel_diskusi
									WHERE
										id = '$diskusi_id'")->row_array();
		if (!$data_diskusi) {
			$result['Error'] = true;
			$result['Message'] = "Diskusi tidak ditemukan";
			goto output;
		}

		$produk = $this->db->query("SELECT
										id,
										toko_id
									FROM
										$this->tabel_produk
									WHERE
										slug = '$slug'")->row_array();
		if (!$produk) {
			$result['Error'] = true;
			$result['Message'] = "Produk tidak ditemukan";
			goto output;
		}

		$toko = $this->db->query("SELECT
									id
									FROM
										$this->tabel_toko
									WHERE
										user_id = '$user[id]'")->row_array();
		$status_penjual = 0;
		if ($toko) {
			if ($toko['id'] == $produk['toko_id']) {
				$status_penjual = 1;
			}
		}

		$data = [
			'toko_id' => $produk['toko_id'],
 			'produk_id' => $produk['id'],
			'user_id' => $user['id'],
			'diskusi' => $diskusi,
			'reply_id' => $diskusi_id,
			'penjual' => $status_penjual
		];

		$add = $this->db->insert($this->tabel_diskusi,$data);
		if ($add) {
			$result['Error'] = false;
			$result['Message'] = "Berhasil membalas diskusi";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Gagal membalas diskusi";
		goto output;
		output:
		return $result;
	}

}

/* End of file M_Product_diskusi.php */
/* Location: ./application/models/M_Product_diskusi.php */