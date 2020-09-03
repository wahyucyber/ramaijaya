<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Shop extends MY_Model {

	protected $tabel = 'mst_toko';

	protected $tabel_user = 'mst_user';

	protected $tabel_provinsi = 'mst_provinsi';

	protected $tabel_kabupaten = 'mst_kabupaten';

	protected $tabel_kecamatan = 'mst_kecamatan';

	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_toko_catatan = 'mst_toko_catatan';

	protected $tabel_produk = 'mst_produk';

	protected $tabel_produk_favorit = 'mst_produk_favorit_';

	protected $tabel_ulasan = 'mst_produk_ulasan';

	protected $tabel_ulasan_foto = 'mst_produk_ulasan_foto';

	protected $tabel_kategori = 'mst_kategori';
	
	protected $tabel_kurir = 'mst_kurir';
	
	protected $tabel_catatan = 'mst_toko_catatan';

	public function __construct()
	{
		parent::__construct();
	}

	function get($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Paramater 'client_token' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM 
										$this->tabel_user
									WHERE
										api_token = '$client_token'");
		if ($user->num_rows() == 1) {
			$user = $user->row_array();

			$toko = $this->db->query("SELECT
								        $this->tabel.id as id_toko,
								        $this->tabel_user.id as id_user,
								        CONCAT('".base_url('')."', $this->tabel.logo) as logo_toko,
								        $this->tabel.banner as banner_toko,
								        $this->tabel.nama_toko,
								        $this->tabel.slogan,
								        $this->tabel.deskripsi,
								        $this->tabel.provinsi_id,
								        $this->tabel_provinsi.nama as nama_provinsi,
								        $this->tabel.kabupaten_id,
								        $this->tabel_kabupaten.nama as nama_kabupaten,
								        $this->tabel.kecamatan_id,
								        $this->tabel_kecamatan.nama as nama_kecamatan,
								        $this->tabel_kabupaten.kode_pos,
								        $this->tabel.slug,
								        $this->tabel.status as status_toko,
								        $this->tabel.power_merchant,
								        $this->tabel.buka as buka_toko,
								        $this->tabel.awal_tutup,
								        $this->tabel.akhir_tutup,
								        $this->tabel.catatan_tutup,
								        $this->tabel.diblokir,
								        $this->tabel.catatan_diblokir
									FROM
										$this->tabel
								    LEFT JOIN
										$this->tabel_user
										ON
											$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN
										$this->tabel_provinsi
										ON
											$this->tabel.provinsi_id=$this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
										ON
											$this->tabel.kabupaten_id=$this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
										ON
											$this->tabel.kecamatan_id=$this->tabel_kecamatan.id
									WHERE
										user_id = $user[id_user]")->row_array();
			if ($toko) {
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Data'] = $toko;
				goto output;
			}
			$result['Error'] = true;
			$result['Message'] = "Anda Belum Memiliki Toko";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function cek($params)
	{
		$nama_toko = isset($params['nama_toko'])? $params['nama_toko'] : '';
		if (empty($nama_toko)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'nama_toko' tidak diset";
			goto output;
		}
		$query = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										nama_toko LIKE '$nama_toko'");
		if ($query->num_rows() > 0) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak tersedia";
			goto output;
		}

		$result['Error'] = false;
		$result['Message'] = "Toko tersedia";
		goto output;

		output:
		return $result;

	}

	function open($params)
	{
		$user_id = isset($params['user_id'])? $params['user_id'] : '';

		$nama_toko = isset($params['nama_toko'])? $params['nama_toko'] : '';

		$provinsi = isset($params['provinsi'])? $params['provinsi'] : '';

		$kabupaten = isset($params['kabupaten'])? $params['kabupaten'] : '';

		$kecamatan = isset($params['kecamatan'])? $params['kecamatan'] : '';

		$kodepos = isset($params['kodepos'])? $params['kodepos'] : '';

		if (empty($user_id)) {
			$result['Error'] = true;
			$result['Message'] = "Paramater 'user_id' tidak diset";
			goto output;
		}else if(empty($nama_toko)) {
			$result['Error'] = true;
			$result['Message'] = "Nama toko tidak boleh kosong";
			goto output;
		}else if(empty($provinsi)) {
			$result['Error'] = true;
			$result['Message'] = "Provinsi tidak boleh kosong";
			goto output;
		}else if(empty($kabupaten)) {
			$result['Error'] = true;
			$result['Message'] = "Kabupaten tidak boleh kosong";
			goto output;
		}else if(empty($kecamatan)) {
			$result['Error'] = true;
			$result['Message'] = "Kecamatan tidak boleh kosong";
			goto output;
		}else if(empty($kodepos)) {
			$result['Error'] = true;
			$result['Message'] = "Kode Pos tidak boleh kosong";
			goto output;
		}

		if (strlen($nama_toko) > 24) {
			$result['Error'] = true;
			$result['Message'] = "Nama Toko maksimal 24 karakter";
			goto output;
		}

		$query = $this->db->query("SELECT
										id
									FROM
										$this->tabel_user
									WHERE
										id = $user_id
									AND 
										level != 1");
		if ($query->num_rows() < 1) {
			$result['Error'] = true;
			$result['Message'] = "Pengguna tidak ditemukan";
			goto output;
		}

		$query = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										user_id = $user_id");
		if ($query->num_rows() > 0) {
			$result['Error'] = true;
			$result['Message'] = "Tidak dapat membuat toko lagi";
			goto output;
		}
		
		$query = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										nama_toko = '$nama_toko'");
		if ($query->num_rows() > 0) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak tersedia";
			goto output;
		}

// 		$slug = str_replace(' ','-',strtolower(strtoupper($nama_toko)));
		
		$slug = slugify($nama_toko);

		$data = [
			'user_id' => $user_id,
			'nama_toko' => $nama_toko,
			'provinsi_id' => $provinsi,
			'kabupaten_id' => $kabupaten,
			'kecamatan_id' => $kecamatan,
			'kode_pos' => $kodepos,
			'slug' => $slug
		];

// 		$config['tabel'] = $this->tabel;
// 		$config['data'] = $data;
// 		$config['pesan_sukses'] = "Berhasil membuka toko $nama_toko";
		
		$add = $this->db->insert($this->tabel,$data);
        if($add){
            $result['Error'] = false;
            $result['Message'] = "Berhasil membuka toko $nama_toko";
            
            $toko_id = $this->db->insert_id();
            
            // $kurir = [
            //     'code' => 'pos'  
            // ];
            
            // $this->create_table_kurir($toko_id);
            // $this->db->insert("$this->tabel_kurir$toko_id",$kurir);

            $kurir = [
            	[
            		'toko_id' => $toko_id,
            		'code' => 'pos'
            	],
            	[
            		'toko_id' => $toko_id,
            		'code' => 'jne'
            	],
            	[
            		'toko_id' => $toko_id,
            		'code' => 'jnt'
            	],
            	[
            		'toko_id' => $toko_id,
            		'code' => 'tiki'
            	]
            ];

            $this->db->insert_batch($this->tabel_kurir,$kurir);
            
            goto output;
        }
// 		$result = $this->query_add($config);
		$result['Error'] = true;
        $result['Message'] = "Gagal membuka toko $nama_toko";
		goto output;

		output:
		return $result;
	}
	
	public function create_table_kurir($toko_id)
	{
		$this->db->query("
			CREATE TABLE `$this->tabel_kurir$toko_id` (
				`id` INT NOT NULL AUTO_INCREMENT,
				`code` VARCHAR(25) NOT NULL,
				`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP NOT NULL,
				`updated_at` TIMESTAMP NULL on UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
				PRIMARY KEY (`id`), INDEX (`code`)
			);
		");
	}

	function detail($params)
	{
		$slug = isset($params['slug'])? $params['slug'] : '';
		if (empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Slug tidak diset";
			goto output;
		}

		$toko = $this->db->query("SELECT
								        $this->tabel.id as id_toko,
								        $this->tabel_user.id as id_user,
								        $this->tabel.logo as logo_toko,
								        $this->tabel.banner as banner_toko,
								        $this->tabel.nama_toko,
								        $this->tabel.slogan,
								        $this->tabel.deskripsi,
								        $this->tabel.provinsi_id,
								        $this->tabel_provinsi.nama as nama_provinsi,
								        $this->tabel.kabupaten_id,
								        $this->tabel_kabupaten.nama as nama_kabupaten,
								        $this->tabel.kecamatan_id,
								        $this->tabel_kecamatan.nama as nama_kecamatan,
								        $this->tabel_kabupaten.kode_pos,
								        $this->tabel.slug,
								        $this->tabel.status as status_toko,
								        $this->tabel.power_merchant,
								        $this->tabel.buka as buka_toko,
								        $this->tabel.awal_tutup,
								        $this->tabel.akhir_tutup,
								        $this->tabel.catatan_tutup
									FROM
										$this->tabel
								    LEFT JOIN
										$this->tabel_user
										ON
											$this->tabel.user_id=$this->tabel_user.id
									LEFT JOIN
										$this->tabel_provinsi
										ON
											$this->tabel.provinsi_id=$this->tabel_provinsi.id
									LEFT JOIN
										$this->tabel_kabupaten
										ON
											$this->tabel.kabupaten_id=$this->tabel_kabupaten.id
									LEFT JOIN
										$this->tabel_kecamatan
										ON
											$this->tabel.kecamatan_id=$this->tabel_kecamatan.id
									WHERE
										$this->tabel.slug = '$slug'")->row_array();
		if ($toko) {

			$id_toko = $toko['id_toko'];

			$total_produk = $this->db->query("SELECT
												 id as id_produk
											FROM
													$this->tabel_produk
											WHERE
												toko_id = '$id_toko'
												AND
												status = 1
												AND
												verifikasi = 1")->num_rows();
			
			$result['Error'] = false;
			$result['Message'] = null;
			$result['Data'] = [
				'id_toko' => $toko['id_toko'],
		        'id_user' => $toko['id_user'],
		        'logo_toko' => $toko['logo_toko'],
		        'banner_toko' => $toko['banner_toko'],
				'nama_toko' => $toko['nama_toko'],
				'slogan' => $toko['slogan'],
				'deskripsi' => $toko['deskripsi'],
				'provinsi_id' => $toko['provinsi_id'],
		        'nama_provinsi' => $toko['nama_provinsi'],
				'kabupaten_id' => $toko['kabupaten_id'],
		        'nama_kabupaten' => $toko['nama_kabupaten'],
				'kecamatan_id' => $toko['kecamatan_id'],
		        'nama_kecamatan' => $toko['nama_kecamatan'],
		        'kode_pos' => $toko['kode_pos'],
				'slug' => $toko['slug'],
		        'status_toko' => $toko['status_toko'],
				'power_merchant' => $toko['power_merchant'],
		        'buka_toko' => $toko['buka_toko'],
				'awal_tutup' => $toko['awal_tutup'],
				'akhir_tutup' => $toko['akhir_tutup'],
				'catatan_tutup' => $toko['catatan_tutup'],
				'jumlah_produk' => $total_produk,
				'catatan' => $this->get_catatan($toko['id_toko'])
			];
			goto output;
		}

		$result['Error'] = false;
		$result['Message'] = "Toko tidak ditemukan";
		goto output;
		output:
		return $result;

	}
	
	private function get_catatan($id)
	{
	    $data = $this->db->query("SELECT
										id,
										judul,
										teks
									FROM
										$this->tabel_catatan
									WHERE
										toko_id = '$id'");
        if($data->num_rows() > 0){
            
            return $data->result_array();
            
        }
        return null;
	}

	function product($params)
	{
		$slug = isset($params['slug'])? $params['slug'] : '';
		$kategori = isset($params['kategori'])? $params['kategori'] : '';
		$keyword = isset($params['keyword'])? $params['keyword'] : '';
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$filter = isset($params['filter'])? $params['filter'] : '';
		if (empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Slug tidak diset";
			goto output;
		}

		$where_kategori = empty($kategori)? "" : " AND $this->tabel_kategori.id='$kategori'";

		$where_nama = empty($keyword)? "" : " AND $this->tabel_produk.nama_produk LIKE '%$keyword%'";

		$limit = empty($params['limit'])? 20 : $params['limit'];

		$reg = '';

		if (!empty($filter)) {
			$reg = str_replace('filter.', '', $filter);
		}

		switch ($reg) {
			case 'termurah':
					$order_filter = " ORDER BY $this->tabel_produk.harga ASC";
				break;
			case 'termahal':
					$order_filter = " ORDER BY $this->tabel_produk.harga DESC";
				break;
			case 'terbaru':
					$order_filter = " ORDER BY $this->tabel_produk.id DESC";
				break;
			case 'terlama':
					$order_filter = " ORDER BY $this->tabel_produk.id ASC";
				break;
			
			default:
					$order_filter = "";
				break;
		}

		$toko = $this->db->query("SELECT
										id as id_toko
									FROM
										$this->tabel
									WHERE
										slug = '$slug'")->row_array();
		if ($toko) {
			$toko_id = $toko['id_toko'];
			// $query_produk_favorit = '0 AS favorit,';

			// if (!empty($client_token)) {
			// 	$user = $this->db->query("SELECT
			// 									id as id_user
			// 								FROM
			// 									$this->tabel_user
			// 								WHERE
			// 									api_token = '$client_token'")->row_array();
			// 	if (!$user) {
			// 		$result['Error'] = true;
			// 		$result['Message'] = "Pengguna tidak ditemukan";
			// 		goto output;
			// 	}

			// 	$tabel_favorit = $this->tabel_produk_favorit.$user['id_user'];

			// 	$this->product_favorit->create_table_produk_favorit($user['id_user']);

			// 	$query_produk_favorit = "(SELECT COUNT($tabel_favorit.id) FROM $tabel_favorit WHERE $tabel_favorit.produk_id = $this->tabel.id) AS favorit,";
			// }
			
			$produk_total = $this->db->query("SELECT
											$this->tabel_produk.id as id_produk,
											$this->tabel_produk.nama_produk,
											$this->tabel_produk.harga,
											$this->tabel_produk.diskon,
											$this->tabel_produk.slug,
											CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS nama_kabupaten,
											$this->tabel.nama_toko
										FROM
											$this->tabel_produk
										LEFT JOIN
											$this->tabel
											ON
											$this->tabel_produk.toko_id=$this->tabel.id
										LEFT JOIN
											$this->tabel_kabupaten
											ON
											$this->tabel.kabupaten_id=$this->tabel_kabupaten.id
										LEFT JOIN 
											    $this->tabel_kategori
											    ON
											    $this->tabel_produk.kategori_id=$this->tabel_kategori.id
										WHERE
											$this->tabel_produk.toko_id=$toko_id
											AND
											$this->tabel_produk.status = 1
											AND
											$this->tabel_produk.verifikasi = 1
											$where_kategori
											$where_nama
											$order_filter
											")->num_rows();
			if ($produk_total > 0) {
				$no = 0;

				$config['jumlah_data'] = $produk_total;
				$config['limit'] = $limit;
				$config['page']	= empty($params['page'])? null : $params['page'];
				$pagination = $this->query_pagination($config);

				$produk = $this->db->query("SELECT
													$this->tabel_produk.id as id_produk,
													$this->tabel_produk.nama_produk,
													$this->tabel_produk.harga,
													$this->tabel_produk.diskon,
													$this->tabel_produk.slug,
													CONCAT($this->tabel_kabupaten.type, ' ', $this->tabel_kabupaten.nama) AS nama_kabupaten,
													$this->tabel.nama_toko,
													$this->tabel_kategori.id as kategori_id
												FROM
													$this->tabel_produk
												LEFT JOIN
													$this->tabel
													ON
													$this->tabel_produk.toko_id=$this->tabel.id
												LEFT JOIN
													$this->tabel_kabupaten
													ON
													$this->tabel.kabupaten_id=$this->tabel_kabupaten.id
												LEFT JOIN 
												    $this->tabel_kategori
												    ON
												    $this->tabel_produk.kategori_id=$this->tabel_kategori.id
												WHERE
													$this->tabel_produk.toko_id=$toko_id
													AND
													$this->tabel_produk.status = 1
													AND
													$this->tabel_produk.verifikasi = 1
													$where_kategori
													$where_nama
													$order_filter
												LIMIT
											    	$pagination[Data_ke],$limit
													");
				if ($produk->num_rows() > 0) {
					$result['Error'] = false;
					$result['Message'] = null;
					$result['Pagination'] = $pagination;
					foreach ($produk->result_array() as $key) {
						$result['Data'][$no++] = [
							'id' => $key['id_produk'],
							'nama_toko' => $key['nama_toko'],
							'foto' => $this->foto_produk($key['id_produk']),
							'nama' => $key['nama_produk'],
							'harga' => $key['harga'],
							'diskon' => $key['diskon'],
							'harga_diskon' => $key['harga'] - (($key['diskon']/100)*$key['harga']),
							'slug' => $key['slug'],
							'nama_kabupaten' => $key['nama_kabupaten'],
							'rating' => $this->produk_rating($key['id_produk']),
							'kategori' => $key['kategori_id']
						];
					}
					goto output;
				}
				$result['Error'] = true;
				$result['Message'] = "Tidak ada produk";
				goto output;			

			}
			$result['Error'] = true;
			$result['Message'] = "Tidak ada produk";
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = "Toko tidak ditemukan";
		goto output;
		output:
		return $result;

	}

	private function produk_rating($produk_id)
	{

		$get_ulasan = $this->db->query("SELECT
											id
										FROM
											$this->tabel_ulasan
										WHERE
											produk_id = '$produk_id'");

		$jumlah_ulasan = $get_ulasan->num_rows();

		$get_rating = $this->db->query("
			SELECT
				SUM(rating) AS total_rating
			FROM
				$this->tabel_ulasan
			WHERE
				produk_id = '$produk_id'
		")->row_array();

		$jumlah_rating = ($get_rating['total_rating'] == null) ? 0 : $get_rating['total_rating'];

		if ($jumlah_ulasan == 0) {
			return 0;
		}else{
			return $jumlah_rating/$jumlah_ulasan;
		}
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

	function category_product($params)
	{
		$slug = isset($params['slug'])? $params['slug'] : '';
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Slug tidak diset";
			goto output;
		}
		$toko = $this->db->query("SELECT
										id as id_toko
									FROM
										$this->tabel
									WHERE
										slug = '$slug'")->row_array();
		if ($toko) {
			$toko_id = $toko['id_toko'];

			$produk = $this->db->query("SELECT
											$this->tabel_kategori.nama_kategori,
											$this->tabel_kategori.id as id_kategori
										FROM
											$this->tabel_produk
										LEFT JOIN
											$this->tabel_kategori
											ON
											$this->tabel_produk.kategori_id=$this->tabel_kategori.id
										WHERE
											$this->tabel_produk.toko_id = $toko_id
											AND
											$this->tabel_produk.status = 1
											AND
											$this->tabel_produk.verifikasi = 1
										GROUP BY $this->tabel_produk.kategori_id");
			if ($produk->num_rows() > 0) {
				
				$no = 0;
				foreach ($produk->result_array() as $kategori_produk) {
					$result['Error'] = false;
					$result['Message'] = null;
					$result['Data'][$no++] = $kategori_produk;
				}
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Tidak ada produk";
			goto output;

		}
		$result['Error'] = true;
		$result['Message'] = "Toko tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function ulasan($params)
	{
		$slug = isset($params['slug'])? $params['slug'] : '';
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		if (empty($slug)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter slug tidak diset";
			goto output;
		}

		$limit = empty($params['limit'])? 10 : $params['limit'];

		$toko = $this->db->query("SELECT
										id
									FROM
										$this->tabel
									WHERE
										slug = '$slug'")->row_array();
		if ($toko) {

			$jumlah_ulasan = $this->db->query("SELECT
		                                            $this->tabel_ulasan.id,
		                                            $this->tabel_ulasan.user_id,
		                                            $this->tabel_ulasan.produk_id,
		                                            $this->tabel_produk.nama_produk,
		                                            $this->tabel_user.nama AS user_nama,
		                                            $this->tabel_ulasan.rating,
		                                            $this->tabel_ulasan.ulasan,
		                                            $this->tabel_ulasan.created_at,
		                                            $this->tabel_ulasan.updated_at
		                                        FROM
		                                            $this->tabel_ulasan
		                                        LEFT JOIN
		                                            $this->tabel_user
		                                            ON
		                                            $this->tabel_ulasan.user_id = $this->tabel_user.id
		                                        LEFT JOIN
		                                            $this->tabel_produk
		                                            ON
		                                            $this->tabel_ulasan.produk_id = $this->tabel_produk.id
		                                        WHERE
		                                            $this->tabel_ulasan.toko_id = '$toko[id]'")->num_rows();
			if ($jumlah_ulasan == 0) {
				$result['Error'] = true;
				$result['Message'] = "Ulasan tidak ditemukan";
				goto output;
			}

			$config['jumlah_data'] = $jumlah_ulasan;
			$config['limit'] = $limit;
			$config['page']	= empty($params['page'])? null : $params['page'];

			$pagination = $this->query_pagination($config);

			$data_ulasan = $this->db->query("SELECT
		                                            $this->tabel_ulasan.id,
		                                            $this->tabel_ulasan.user_id,
		                                            $this->tabel_ulasan.produk_id,
		                                            $this->tabel_produk.nama_produk,
		                                            $this->tabel_produk.slug as slug_produk,
		                                            $this->tabel_user.nama AS user_nama,
		                                            $this->tabel_ulasan.rating,
		                                            $this->tabel_ulasan.ulasan,
		                                            $this->tabel_ulasan.created_at,
		                                            $this->tabel_ulasan.updated_at
		                                        FROM
		                                            $this->tabel_ulasan
		                                        LEFT JOIN
		                                            $this->tabel_user
		                                            ON
		                                            $this->tabel_ulasan.user_id = $this->tabel_user.id
		                                        LEFT JOIN
		                                            $this->tabel_produk
		                                            ON
		                                            $this->tabel_ulasan.produk_id = $this->tabel_produk.id
		                                        WHERE
		                                            $this->tabel_ulasan.toko_id = '$toko[id]'
		                                            AND
		                                            $this->tabel_ulasan.reply_id = '0'")->result_array();
			$no = 0;
			foreach ($data_ulasan as $key) {
				$result['Error'] = false;
				$result['Message'] = null;
				$result['Pagination'] = $pagination;
				$result['Data'][$no++] = [
					'id' => $key['id'],
					'user_id' => $key['user_id'],
					'user_nama' => $key['user_nama'],
					'nama_produk' => $key['nama_produk'],
					'slug_produk' => $key['slug_produk'],
					'foto_produk' => $this->foto_produk($key['produk_id'])[0]['foto'],
					'ulasan_foto' => $this->ulasan_foto($key['produk_id'], $key['id']),
					'rating' => $key['rating'],
					'ulasan' => $key['ulasan'],
					'reply' => $this->get_balasan_ulasan($key['id']),
					'created_at' => $key['created_at'],
					'updated_at' => $key['updated_at']
				];
			}
			goto output;

		}

		$result['Error'] = true;
		$result['Message'] = "Toko tidak ditemukan";
		goto output;
		output:
		return $result;

	}

	public function ulasan_foto($produk_id, $ulasan_id)
	{
		$get_foto = $this->db->query("
			SELECT
				id,
				CONCAT('".base_url('')."', foto) AS foto
			FROM
				$this->tabel_ulasan_foto
			WHERE
				ulasan_id = '$ulasan_id'
				AND
				produk_id = '$produk_id'
		");
		$result = [];
		$no = 0;
		if ($get_foto->num_rows() > 0) {
			foreach ($get_foto->result_array() as $key) {
				$result[$no++] = $key;
			}
		}
		return $result;
	}

	private function get_balasan_ulasan($ulasan_id)
	{
		if (empty($ulasan_id)) {
			return null;
		}

		$ulasan = $this->db->query("SELECT
                                        $this->tabel_ulasan.id,
                                        $this->tabel_ulasan.user_id,
                                        $this->tabel_ulasan.produk_id,
                                        $this->tabel_produk.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel.nama_toko,
                                        $this->tabel_ulasan.rating,
                                        $this->tabel_ulasan.ulasan,
                                        $this->tabel_ulasan.reply_id,
                                        $this->tabel_ulasan.created_at,
                                        $this->tabel_ulasan.updated_at
                                    FROM
                                        $this->tabel_ulasan
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel_ulasan.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel_produk
                                        ON
                                        $this->tabel_ulasan.produk_id = $this->tabel_produk.id
                                   LEFT JOIN
	                                   $this->tabel
	                                   ON
	                                   $this->tabel_ulasan.toko_id = $this->tabel.id
                                    WHERE
                                        $this->tabel_ulasan.reply_id = '$ulasan_id'
								")->result_array();
		$no = 0;
		foreach ($ulasan as $key) {
			$hasil[$no++] = array(
				'id' => $key['id'],
				'user_id' => $key['user_id'],
				'user_nama' => $key['nama_toko'],
				'ulasan_foto' => $this->ulasan_foto($key['produk_id'], $key['id']),
				'rating' => $key['rating'],
				'ulasan' => $key['ulasan'],
				'created_at' => $key['created_at'],
				'updated_at' => $key['updated_at']
			);
		}
		return $hasil;
	}


	// private function ulasan_produk($produk_id)
	// {
	// 	$produk = $this->db->query("SELECT
	// 									id as id_produk,
	// 									nama_produk,
	// 									slug
	// 								FROM
	// 									$this->tabel_produk
	// 								WHERE
	// 									id = '$produk_id'")->row_array();

	// 	$data = $this->db->query("SELECT
	// 							$this->tabel_ulasan$produk_id.id,
	// 							$this->tabel_ulasan$produk_id.user_id,
	// 							$this->tabel_user.nama AS user_nama,
	// 							$this->tabel_ulasan$produk_id.rating,
	// 							$this->tabel_ulasan$produk_id.ulasan,
	// 							$this->tabel_ulasan$produk_id.created_at,
	// 							$this->tabel_ulasan$produk_id.updated_at
	// 						FROM
	// 							$this->tabel_ulasan$produk_id
	// 							LEFT JOIN $this->tabel_user ON $this->tabel_user.id = $this->tabel_ulasan$produk_id.user_id
	// 						ORDER BY $this->tabel_ulasan$produk_id.id DESC
	// 						LIMIT
	// 							0,5
	// 					");
	// 	$result = null;
	// 	if ($data->num_rows() > 0) {
	// 		foreach ($data->result_array() as $key) {
	// 			$result = [
	// 				'user_nama' => $key['user_nama'],
	// 				'rating' => $key['rating'],
	// 				'ulasan' => $key['ulasan'],
	// 				'foto_produk' => $this->foto_produk($produk['id_produk'])[0]['foto'],
	// 				'nama_produk' => $produk['nama_produk'],
	// 				'slug_produk' => $produk['slug']
	// 			];
	// 		}
	// 	}
	// 	return $result;
	// }

}

/* End of file M_Shop.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/M_Shop.php */