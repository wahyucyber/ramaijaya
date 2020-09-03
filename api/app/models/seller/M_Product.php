<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Product extends MY_Model {

	protected $tabel = 'mst_produk';
	
	protected $tabel_produk_foto = 'mst_produk_foto';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_user = 'mst_user';

	protected $tabel_kategori = 'mst_kategori';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

	function all($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$draw = $params['draw'];
		$start = $params['start'];
		$length = $params['length'];
		// $limit = isset($params['limit'])? $params['limit'] : 10;
		$paging = ($start != "" && !empty($length)) ? "LIMIT $start, $length" : "";
		$kategori = $params['kategori_id'];
		$status = $params['status'];
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();

			if ($toko) {

				$where = empty($params['search']['value'])? "" : " AND $this->tabel.nama_produk LIKE '%".$params['search']['value']."%'";
				(!empty($kategori)) ? $where .= " AND $this->tabel.kategori_id = '$kategori'":"";
				($status != "") ? $where .= " AND $this->tabel.status = '$status'":"";
				
				$recordsTotal = $this->db->query("SELECT
												$this->tabel.id as id_produk,
												$this->tabel.toko_id,
												$this->tabel_toko.slug as slug_toko,
												$this->tabel.sku_produk,
												$this->tabel.nama_produk,
												$this->tabel.keterangan,
												$this->tabel.harga,
												$this->tabel.diskon,
												$this->tabel.berat,
												$this->tabel.stok_awal,
												$this->tabel.stok,
												$this->tabel.kondisi,
												$this->tabel.min_beli,
												$this->tabel.asuransi,
												$this->tabel.preorder,
												$this->tabel.lama_preorder,
												$this->tabel.waktu_preorder,
												$this->tabel.etalase_id,
												$this->tabel.kategori_id,
												$this->tabel_kategori.nama_kategori,
												$this->tabel.slug as slug_produk,
												$this->tabel.status as status_produk,
												$this->tabel.verifikasi
											FROM
												$this->tabel
											LEFT JOIN
												$this->tabel_kategori
											ON
												$this->tabel.kategori_id = $this->tabel_kategori.id
											LEFT JOIN
												$this->tabel_toko
											ON
												$this->tabel.toko_id = $this->tabel_toko.id
											WHERE
												$this->tabel.toko_id = $toko[id_toko]
											")->num_rows();

				$recordsFiltered = $this->db->query("SELECT
												$this->tabel.id as id_produk,
												$this->tabel.toko_id,
												$this->tabel_toko.slug as slug_toko,
												$this->tabel.sku_produk,
												$this->tabel.nama_produk,
												$this->tabel.keterangan,
												$this->tabel.harga,
												$this->tabel.diskon,
												$this->tabel.berat,
												$this->tabel.stok_awal,
												$this->tabel.stok,
												$this->tabel.kondisi,
												$this->tabel.min_beli,
												$this->tabel.asuransi,
												$this->tabel.preorder,
												$this->tabel.lama_preorder,
												$this->tabel.waktu_preorder,
												$this->tabel.etalase_id,
												$this->tabel.kategori_id,
												$this->tabel_kategori.nama_kategori,
												$this->tabel.slug as slug_produk,
												$this->tabel.status as status_produk,
												$this->tabel.verifikasi,
												$this->tabel.catatan_diblokir
											FROM
												$this->tabel
											LEFT JOIN
												$this->tabel_kategori
											ON
												$this->tabel.kategori_id = $this->tabel_kategori.id
											LEFT JOIN
												$this->tabel_toko
											ON
												$this->tabel.toko_id = $this->tabel_toko.id
											WHERE
												$this->tabel.toko_id = $toko[id_toko]
											$where")->num_rows();

				// $config['jumlah_data'] = $query->num_rows();
				// $config['limit'] = $limit;
				// $config['page']	= empty($params['page'])? null : $params['page'];
				// $pagination = $this->query_pagination($config);

				$query = $this->db->query("SELECT
												$this->tabel.id as id_produk,
												$this->tabel.toko_id,
												$this->tabel_toko.slug as slug_toko,
												$this->tabel.sku_produk,
												$this->tabel.nama_produk,
												$this->tabel.keterangan,
												$this->tabel.harga,
												$this->tabel.diskon,
												$this->tabel.berat,
												$this->tabel.stok_awal,
												$this->tabel.stok,
												$this->tabel.kondisi,
												$this->tabel.min_beli,
												$this->tabel.asuransi,
												$this->tabel.preorder,
												$this->tabel.lama_preorder,
												$this->tabel.waktu_preorder,
												$this->tabel.etalase_id,
												$this->tabel.kategori_id,
												$this->tabel_kategori.nama_kategori,
												$this->tabel.slug as slug_produk,
												$this->tabel.status as status_produk,
												$this->tabel.verifikasi,
												$this->tabel.catatan_diblokir
											FROM
												$this->tabel
											LEFT JOIN
												$this->tabel_kategori
											ON
												$this->tabel.kategori_id = $this->tabel_kategori.id
											LEFT JOIN
												$this->tabel_toko
											ON
												$this->tabel.toko_id = $this->tabel_toko.id
											WHERE
												$this->tabel.toko_id = $toko[id_toko]
											$where
											ORDER BY $this->tabel.id DESC
											$paging");


				if ($query->num_rows() > 0) {
					$no = 0;
					foreach($query->result_array() as $key){
						$result['Error'] = false;
						$result['Message'] = null;
						$result['Data'][$no++] = [
							'id_produk' => $key['id_produk'],
							'toko_id' => $key['toko_id'],
							'slug_toko' => $key['slug_toko'],
							'foto_produk' => $this->foto_produk($key['id_produk'])[0]['foto'],
							'sku_produk' => $key['sku_produk'],
							'nama_produk' => $key['nama_produk'],
							'keterangan' => $key['keterangan'],
							'harga' => $key['harga'],
							'diskon' => $key['diskon'],
							'harga_diskon' => $key['harga'] - (($key['diskon']/100)*$key['harga']),
							'berat' => $key['berat'],
							'stok_awal' => $key['stok_awal'],
							'stok' => $key['stok'],
							'kondisi' => $key['kondisi'],
							'min_beli' => $key['min_beli'],
							'asuransi' => $key['asuransi'],
							'preorder' => $key['preorder'],
							'lama_preorder' => $key['lama_preorder'],
							'waktu_preorder' => $key['waktu_preorder'],
							'etalase_id' => $key['etalase_id'],
							'kategori_id' => $key['kategori_id'],
							'nama_kategori' => $key['nama_kategori'],
							'slug_produk' => $key['slug_produk'],
							'status_produk' => $key['status_produk'],
							'verifikasi' => $key['verifikasi'],
							'catatan_diblokir' => $key['catatan_diblokir']
						];
						// $result['Pagination'] = $pagination;
						$result['draw'] = $draw;
						$result['recordsFiltered'] = $recordsFiltered;
						$result['recordsTotal'] = $recordsTotal;
					}
					goto output;

				}

				$result['Error'] = true;
				$result['Message'] = "Produk tidak ditemukan";
				$result['draw'] = $draw;
				$result['Data'] = array();
				$result['recordsFiltered'] = $recordsFiltered;
				$result['recordsTotal'] = $recordsTotal;
				goto output;


			}

			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;


		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	function get($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : 10;
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'produk_id' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();

			if ($toko) {

				$produk = $this->db->query("SELECT
												$this->tabel.id as id_produk,
												$this->tabel.toko_id,
												$this->tabel_toko.slug as slug_toko,
												$this->tabel.sku_produk,
												$this->tabel.nama_produk,
												$this->tabel.keterangan,
												$this->tabel.harga,
												$this->tabel.berat,
												$this->tabel.stok_awal,
												$this->tabel.stok,
												$this->tabel.kondisi,
												$this->tabel.min_beli,
												$this->tabel.asuransi,
												$this->tabel.preorder,
												$this->tabel.lama_preorder,
												$this->tabel.waktu_preorder,
												$this->tabel.etalase_id,
												$this->tabel.kategori_id,
												$this->tabel_kategori.nama_kategori,
												$this->tabel.slug as slug_produk,
												$this->tabel.status as status_produk
											FROM
												$this->tabel
											LEFT JOIN
												$this->tabel_kategori
											ON
												$this->tabel.kategori_id = $this->tabel_kategori.id
											LEFT JOIN
												$this->tabel_toko
											ON
												$this->tabel.toko_id = $this->tabel_toko.id
											WHERE
												$this->tabel.toko_id = $toko[id_toko]
											AND 
												$this->tabel.id = $produk_id")->row_array();


				if ($produk) {
					$no = 0;
					$result['Error'] = false;
					$result['Message'] = null;
					$result['Data'] = [
						'id_produk' => $produk['id_produk'],
						'toko_id' => $produk['toko_id'],
						'slug_toko' => $produk['slug_toko'],
						'foto_produk' => $this->foto_produk($produk['id_produk']),
						'sku_produk' => $produk['sku_produk'],
						'nama_produk' => $produk['nama_produk'],
						'keterangan' => $produk['keterangan'],
						'harga' => $produk['harga'],
						'berat' => $produk['berat'],
						'stok_awal' => $produk['stok_awal'],
						'stok' => $produk['stok'],
						'kondisi' => $produk['kondisi'],
						'min_beli' => $produk['min_beli'],
						'asuransi' => $produk['asuransi'],
						'preorder' => $produk['preorder'],
						'lama_preorder' => $produk['lama_preorder'],
						'waktu_preorder' => $produk['waktu_preorder'],
						'etalase_id' => $produk['etalase_id'],
						'kategori_id' => $produk['kategori_id'],
						'nama_kategori' => $produk['nama_kategori'],
						'induk_kategori_id' => $this->induk_kategori($produk['kategori_id'])['kategori_id'],
						'slug_produk' => $produk['slug_produk'],
						'status_produk' => $produk['status_produk']
					];
					goto output;

				}

				$result['Error'] = true;
				$result['Message'] = "Produk tidak ditemukan";
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;


		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
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

	private function induk_kategori($kategori_id)
	{
		$query = $this->db->query("SELECT
										id as id_kategori,
										icon as icon_kategori,
										kategori_id,
										nama_kategori,
										slug
									FROM
										$this->tabel_kategori
									WHERE 
										id = $kategori_id")->row_array();
		$result = $query? $query : null;
		return $result;
	}

	function add($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$foto = isset($params['foto'])? $params['foto'] : '';
		$nama_produk = isset($params['nama_produk'])? $params['nama_produk'] : '';
		$kategori = isset($params['kategori'])? $params['kategori'] : '';
		$sub_kategori = isset($params['sub_kategori'])? $params['sub_kategori'] : '';
		$kondisi = isset($params['kondisi'])? $params['kondisi'] : 0;
		$keterangan = isset($params['keterangan'])? $params['keterangan'] : '';
		// $url_video = isset($params['url_video'])? $params['url_video'] : '';
		$min_beli = isset($params['min_beli'])? $params['min_beli'] : 1;
		$harga = isset($params['harga'])? $params['harga'] : '';
		// $status_produk = isset($params['status_produk'])? $params['status_produk'] : '';
		$stok = isset($params['stok'])? $params['stok'] : '';
		$sku = isset($params['sku'])? $params['sku'] : '';
		$satuan_berat = isset($params['satuan_berat'])? $params['satuan_berat'] : '';
		$berat = isset($params['berat'])? $params['berat'] : '';
		// $asuransi = isset($params['asuransi'])? $params['asuransi'] : 1;
		// $preorder = isset($params['preorder'])? $params['preorder'] : 0;
		// $lama_preorder = isset($params['lama_preorder'])? $params['lama_preorder'] : '';
		// $waktu_preorder = isset($params['waktu_preorder'])? $params['waktu_preorder'] : '';

		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($foto)) {
			$result['Error'] = true;
			$result['Message'] = "Foto produk tidak boleh kosong";
			goto output;
		}else if(empty($nama_produk)) {
			$result['Error'] = true;
			$result['Message'] = "Nama produk tidak boleh kosong";
			goto output;
		}else if(empty($kategori)) {
			$result['Error'] = true;
			$result['Message'] = "Kategori produk tidak boleh kosong";
			goto output;
		}else if(empty($keterangan)) {
			$result['Error'] = true;
			$result['Message'] = "Keterangan produk tidak boleh kosong";
			goto output;
		}else if(empty($min_beli)) {
			$result['Error'] = true;
			$result['Message'] = "Minimum Pemesanan produk tidak boleh kosong";
			goto output;
		}else if(empty($harga)) {
			$result['Error'] = true;
			$result['Message'] = "Harga produk tidak boleh kosong";
			goto output;
		}else if(empty($stok)) {
			$result['Error'] = true;
			$result['Message'] = "Stok produk tidak boleh kosong";
			goto output;
		}else if(empty($sku)) {
			$result['Error'] = true;
			$result['Message'] = "SKU produk tidak boleh kosong";
			goto output;
		}else if(empty($satuan_berat)) {
			$result['Error'] = true;
			$result['Message'] = "Satuan Berat produk tidak boleh kosong";
			goto output;
		}else if(empty($berat)) {
			$result['Error'] = true;
			$result['Message'] = "Berat produk tidak boleh kosong";
			goto output;
		}

		// if (!empty($preorder) && $preorder == 1) {
		// 	if (empty($lama_preorder)) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Lama preorder tidak boleh kosong";
		// 		goto output;
		// 	}else if(empty($waktu_preorder)) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu preorder tidak boleh kosong";
		// 		goto output;
		// 	}
 	// 	}else if($preorder == 0){
 	// 		$lama_preorder = null;
 	// 		$waktu_preorder = null;
 	// 	}

 	// 	if ($waktu_preorder == 'minggu') {
		// 	if ($lama_preorder > 28) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu Proses Preorder maksimum 28 minggu";

		// 		goto output;
		// 	}
		// }else if($waktu_preorder == 'hari') {
		// 	if ($lama_preorder > 210) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu Proses Preorder maksimum 210 hari";

		// 		goto output;
		// 	}
		// }

		if (!empty($sub_kategori)) {
			$kategori = $sub_kategori;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();
			if ($toko) {
			    
			    $sku = $this->db->query("SELECT
        		                            id
        		                           FROM
        		                            $this->tabel
        		                           WHERE
        		                            sku_produk = '$sku'
        		                            AND
        		                            toko_id = '$toko[id_toko]'")->num_rows();
                if($sku > 1){
                    $result['Error'] = true;
        			$result['Message'] = "Sku tidak tersedia";
        			goto output;
                }
				
				$produk = $this->db->query("SELECT
												id as id_produk
											FROM
												$this->tabel
											WHERE
												toko_id = $toko[id_toko]");
				if ($produk->num_rows() < 1) {
					$this->db->update($this->tabel_toko,['status' => 1,'buka' => 1],['id' => $toko['id_toko']]);
				}

				if ($satuan_berat == 'kg') {
				
					$berat = $berat*1000;

				}
				$produk_id = $this->Func->generate_id($this->tabel);
                $slug = slugify($nama_produk);
				// $slug = str_replace(' ','-',strtolower(strtoupper($nama_produk)));

				$jml_produk = $this->db->query("SELECT
												id as produk_id
											FROM
												$this->tabel
											WHERE
												slug = '$slug'")->num_rows();

				if ($jml_produk > 1) {
					$prfx = intVal($jml_produk + 1);
					$slug = "$slug-$prfx";
				}

				$data = [
					'id' => $produk_id,
					'toko_id' => $toko['id_toko'],
					'sku_produk' => $sku,
					'nama_produk' => $nama_produk,
					'keterangan' => $keterangan,
					'harga' => $harga,
					'berat' => $berat,
					'stok' => $stok,
					'kondisi' => $kondisi,
					'min_beli' => $min_beli,
					// 'asuransi' => $asuransi,
					// 'preorder' => $preorder,
					// 'lama_preorder' => $lama_preorder,
					// 'waktu_preorder' => $waktu_preorder,
					'kategori_id' => $kategori,
					'slug' => $slug,
					'status' => 1
				];

				$config['tabel'] = $this->tabel;
				$config['data'] = $data;
				$config['pesan_sukses'] = "Berhasil menambah produk";

				$result = $this->query_add($config);
				if ($result['Error'] == false) {


					$no = 0;
					foreach ($foto as $key) {

						$upload = $this->upload_image->upload($foto[$no],'Foto-Produk','produk');

						$data = [
							'produk_id' => $produk_id,
							'foto' => $upload['Url']
						];

						$this->db->insert($this->tabel_produk_foto,$data);

						$no++;
					}
				}
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";

			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";

		goto output;

		output:
		return $result;

	}

	function edit($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : '';
		$foto = isset($params['foto'])? $params['foto'] : '';
		$hapus_foto = isset($params['hapus_foto'])? $params['hapus_foto'] : '';
		$nama_produk = isset($params['nama_produk'])? $params['nama_produk'] : '';
		$kategori = isset($params['kategori'])? $params['kategori'] : '';
		$sub_kategori = isset($params['sub_kategori'])? $params['sub_kategori'] : '';
		$kondisi = isset($params['kondisi'])? $params['kondisi'] : 0;
		$keterangan = isset($params['keterangan'])? $params['keterangan'] : '';
		// $url_video = isset($params['url_video'])? $params['url_video'] : '';
		$min_beli = isset($params['min_beli'])? $params['min_beli'] : 1;
		$harga = isset($params['harga'])? $params['harga'] : '';
		// $status_produk = isset($params['status_produk'])? $params['status_produk'] : '';
		$stok = isset($params['stok'])? $params['stok'] : '';
		$sku = isset($params['sku'])? $params['sku'] : '';
		$satuan_berat = isset($params['satuan_berat'])? $params['satuan_berat'] : '';
		$berat = isset($params['berat'])? $params['berat'] : '';
		// $asuransi = isset($params['asuransi'])? $params['asuransi'] : 1;
		// $preorder = isset($params['preorder'])? $params['preorder'] : 0;
		// $lama_preorder = isset($params['lama_preorder'])? $params['lama_preorder'] : '';
		// $waktu_preorder = isset($params['waktu_preorder'])? $params['waktu_preorder'] : '';

		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'produk_id' tidak diset";
			goto output;
		}else if(empty($nama_produk)) {
			$result['Error'] = true;
			$result['Message'] = "Nama produk tidak boleh kosong";
			goto output;
		}else if(empty($kategori)) {
			$result['Error'] = true;
			$result['Message'] = "Kategori produk tidak boleh kosong";
			goto output;
		}else if(empty($keterangan)) {
			$result['Error'] = true;
			$result['Message'] = "Keterangan produk tidak boleh kosong";
			goto output;
		}else if(empty($min_beli)) {
			$result['Error'] = true;
			$result['Message'] = "Minimum Pemesanan produk tidak boleh kosong";
			goto output;
		}else if(empty($harga)) {
			$result['Error'] = true;
			$result['Message'] = "Harga produk tidak boleh kosong";
			goto output;
		}else if(empty($stok)) {
			$result['Error'] = true;
			$result['Message'] = "Stok produk tidak boleh kosong";
			goto output;
		}else if(empty($sku)) {
			$result['Error'] = true;
			$result['Message'] = "SKU produk tidak boleh kosong";
			goto output;
		}else if(empty($satuan_berat)) {
			$result['Error'] = true;
			$result['Message'] = "Satuan Berat produk tidak boleh kosong";
			goto output;
		}else if(empty($berat)) {
			$result['Error'] = true;
			$result['Message'] = "Berat produk tidak boleh kosong";
			goto output;
		}

		// if (!empty($preorder) && $preorder == 1) {
		// 	if (empty($lama_preorder)) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Lama preorder tidak boleh kosong";
		// 		goto output;
		// 	}else if(empty($waktu_preorder)) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu preorder tidak boleh kosong";
		// 		goto output;
		// 	}
 	// 	}else if($preorder == 0){
 	// 		$lama_preorder = null;
 	// 		$waktu_preorder = null;
 	// 	}

 	// 	if ($waktu_preorder == 'minggu') {
		// 	if ($lama_preorder > 28) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu Proses Preorder maksimum 28 minggu";

		// 		goto output;
		// 	}
		// }else if($waktu_preorder == 'hari') {
		// 	if ($lama_preorder > 210) {
		// 		$result['Error'] = true;
		// 		$result['Message'] = "Waktu Proses Preorder maksimum 210 hari";

		// 		goto output;
		// 	}
		// }

		if (!empty($sub_kategori)) {
			$kategori = $sub_kategori;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();
			if ($toko) {
				
				$produk = $this->db->query("SELECT
												id as id_produk
											FROM
												$this->tabel
											WHERE
												toko_id = $toko[id_toko]
											AND
												id = $produk_id")->row_array();
				if (!$produk) {
					$result['Error'] = true;
					$result['Message'] = "Produk tidak ditemukan";

					goto output;
				}

				if ($satuan_berat == 'kg') {
				
					$berat = $berat*1000;

				}

				$slug = slugify($nama_produk);
				// $slug = str_replace(' ','-',strtolower(strtoupper($nama_produk)));

				$query = $this->db->query("SELECT
												id as produk_id
											FROM
												$this->tabel
											WHERE
												slug = '$slug'")->num_rows();

				if ($query > 1) {
					$slug = $slug.'-1';
				}

				$data = [
					'sku_produk' => $sku,
					'nama_produk' => $nama_produk,
					'keterangan' => $keterangan,
					'harga' => $harga,
					'berat' => $berat,
					'stok' => $stok,
					'kondisi' => $kondisi,
					'min_beli' => $min_beli,
					// 'asuransi' => $asuransi,
					// 'preorder' => $preorder,
					// 'lama_preorder' => $lama_preorder,
					// 'waktu_preorder' => $waktu_preorder,
					'kategori_id' => $kategori,
					'slug' => $slug,
					'status' => 1
				];

				// if (empty($hapus_foto) && empty($foto)) {
				// 	$result['Error'] = true;
				// 	$result['Message'] = "Foto Produk tidak boleh kosong";

				// 	goto output;
				// }
				
				if (!empty($hapus_foto)) {
					if (empty($foto)) {
						$result['Error'] = true;
						$result['Message'] = "Foto Produk tidak boleh kosong";

						goto output;
					}
					$no = 0;
					foreach ($hapus_foto as $key) {
						
						$_foto = $this->db->query("SELECT
														id as id_foto,
														foto
													FROM 
														$this->tabel_produk_foto
													WHERE
														id = $hapus_foto[$no]")->row_array();
						$this->db->delete($this->tabel_produk_foto,['id' => $hapus_foto[$no],'produk_id' => $produk['id_produk']]);
						$this->upload_image->remove($_foto['foto']);
						$no++;
					}
				}

				$config['tabel'] = $this->tabel;
				$config['data'] = $data;
				$config['filter'] = "id = $produk[id_produk] AND toko_id = $toko[id_toko]";
				$config['pesan_sukses'] = "Berhasil mengubah produk ".$nama_produk;

				$result = $this->query_update($config);
				if ($result['Error'] == false) {

					if (!empty($foto)) {
						$no = 0;

						foreach ($foto as $key) {

							$upload = $this->upload_image->upload($foto[$no],'Foto-Produk','produk');

							$data = [
								'produk_id' => $produk_id,
								'foto' => $upload['Url']
							];

							$this->db->insert($this->tabel_produk_foto,$data);

							$no++;
						}
					}
					
				}
				goto output;

			}
			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";

			goto output;
		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";

		goto output;

		output:
		return $result;
	}

	function set_status($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : 10;
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'produk_id' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();

			if ($toko) {

				$produk = $this->db->query("SELECT
												id as id_produk,
												nama_produk,
												status as status_produk
											FROM
												$this->tabel
											WHERE
												toko_id = $toko[id_toko]
											AND 
												id = $produk_id")->row_array();


				if ($produk) {

					$status = ($produk['status_produk'] == 1)? 0 : 1;
					$aksi = ($produk['status_produk'] == 1)? "Menonaktifkan" : "Mengaktifkan";

					$config['tabel'] = $this->tabel;
					$config['data'] = ['status' => $status];
					$config['filter'] = "toko_id = $toko[id_toko] AND id = $produk_id";
					$config['pesan_sukses'] = "Berhasil $aksi produk ".$produk['nama_produk'];
					$result = $this->query_update($config);
					goto output;

				}

				$result['Error'] = true;
				$result['Message'] = "Produk tidak ditemukan";
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;


		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}


	function delete($params)
	{
		$client_token = isset($params['client_token'])? $params['client_token'] : '';
		$produk_id = isset($params['produk_id'])? $params['produk_id'] : 10;
		if (empty($client_token)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'client_token' tidak diset";
			goto output;
		}else if(empty($produk_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter 'produk_id' tidak diset";
			goto output;
		}

		$user = $this->db->query("SELECT
										id as id_user
									FROM
										$this->tabel_user
									WHERE
										api_token = '$client_token'")->row_array();
		if ($user) {
			
			$toko = $this->db->query("SELECT
											id as id_toko
										FROM
											$this->tabel_toko
										WHERE
											user_id = $user[id_user]")->row_array();

			if ($toko) {

				$produk = $this->db->query("SELECT
												$this->tabel.id as id_produk,
												nama_produk
											FROM
												$this->tabel
											WHERE
												$this->tabel.toko_id = $toko[id_toko]
											AND 
												$this->tabel.id = $produk_id")->row_array();


				if ($produk) {

					$foto_produk = $this->foto_produk($produk['id_produk']);

					$no = 0;
					foreach ($foto_produk as $key) {
						
						$_foto = $this->db->query("SELECT
														id as id_foto,
														foto
													FROM 
														$this->tabel_produk_foto
													WHERE
														id = $key[id_foto]")->row_array();
						$this->db->delete($this->tabel_produk_foto,['id' => $key['id_foto'],'produk_id' => $produk['id_produk']]);
						$this->upload_image->remove($_foto['foto']);
						$no++;
					}

					$config['tabel'] = $this->tabel;
					$config['filter'] = "id = $produk[id_produk] AND toko_id = $toko[id_toko]";
					$config['pesan_sukses'] = "Berhasil menghapus produk ".$produk['nama_produk'];
					$result = $this->query_delete($config);
					goto output;

				}

				$result['Error'] = true;
				$result['Message'] = "Produk tidak ditemukan";
				goto output;

			}

			$result['Error'] = true;
			$result['Message'] = "Toko tidak ditemukan";
			goto output;


		}

		$result['Error'] = true;
		$result['Message'] = "Pengguna tidak ditemukan";
		goto output;
		output:
		return $result;
	}

	public function import($params)
	{
		$client_token = $params['client_token'];
		$json_data = json_decode($params['json_data'], true);

		if (empty($client_token)) {
			$result = array(
				'Error' => true,
				'Message' => "Parameter 'client_token' tidak diset."
			);
			goto output;
		}else if (empty($json_data)) {
			$result = array(
				'Error' => true,
				'Message' => "Parameter 'json_data' tidak diset."
			);
			goto output;
		}else{
			$user = $this->db->query("SELECT
										$this->tabel_user.id as id_user
									FROM
										$this->tabel_user
										-- LEFT JOIN $this->tabel_toko ON $this->tabel_toko.user_id = $this->tabel_user.id
									WHERE
										$this->tabel_user.api_token = '$client_token'");
			if ($user->num_rows() == 0) {
				$result['Error'] = true;
				$result['Message'] = "Pengguna tidak ditemukan";
				goto output;
			}

			$user_id = $user->row_array()['id_user'];

            $toko = $this->db->query("SELECT
                                            id
                                        FROM
                                            $this->tabel_toko
                                        WHERE
                                            user_id = '$user_id'")->row_array();
            if(!$toko){
                $result['Error'] = true;
                $result['Message'] = "Toko tidak ditemukan";
                goto output;
            }

			$get_kategori = $this->db->query("
				SELECT
					id
				FROM
					$this->tabel_kategori
			")->result_array();

			$kategori = array();

			$no = 0;
			foreach ($get_kategori as $key) {
				$kategori[$no++] = $key;
			}

			$jumlah_array = count($json_data);

			$result[] = [];

			$no_a = 0;
			for ($i=1; $i < $jumlah_array; $i++) { 

				if (empty($json_data[$i][1])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Nama produk harus diisi."
					);
				}else if (empty($json_data[$i][2])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Kategori ID harus diisi."
					);
				}else if (empty($json_data[$i][3])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Kondisi harus diisi."
					);
				}else if (empty($json_data[$i][4])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Keterangan harus diisi."
					);
				}else if (empty($json_data[$i][5])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Minimum Pemesanan harus diisi."
					);
				}else if (empty($json_data[$i][6])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Harga harus diisi."
					);
				}else if (empty($json_data[$i][7])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Status harus diisi."
					);
				}else if (empty($json_data[$i][8])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Stok harus diisi."
					);
				}else if (empty($json_data[$i][9])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> SKU (Stok Keeping Unit) harus diisi."
					);
				}else if (empty($json_data[$i][10])) {
					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Berat harus diisi."
					);
				}else{

					$result[$no_a] = array(
						'Error' => true,
						'Message' => "<b>#$i</b> Kategori ID tidak ditemukan."
					);

					foreach ($kategori as $key) {
						if ($json_data[$i][2] == $key['id']) {
							$kondisi = 1;

							if (!empty($json_data[$i][3])) {
								if (strtolower($json_data[$i][3]) == "baru") {
									$kondisi = 1;
								}else if(strtolower($json_data[$i][3]) == "bekas") {
									$kondisi = 0;
								}else{
									$kondisi = 1;
								}
							}

							$status = 1;

							if (!empty($json_data[$i][7])) {
								if (strtolower($json_data[$i][7]) == "aktif") {
									$status = 1;
								}else if(strtolower($json_data[$i][7]) == "tidak aktif") {
									$status = 0;
								}else{
									$status = 1;
								}
							}

							$produk_id = $this->Func->generate_id($this->tabel);

							$slug = str_replace(' ','-',strtolower(strtoupper($json_data[$i][1])));

							# Tambah mst produk
							$this->db->insert($this->tabel, array(
								'id' => $produk_id,
								'toko_id' => $toko['id'],
								'sku_produk' => $json_data[$i][9],
								'nama_produk' => $json_data[$i][1],
								'keterangan' => $json_data[$i][4],
								'harga' => $json_data[$i][6],
								'berat' => $json_data[$i][10],
								'stok' => $json_data[$i][8],
								'kondisi' => $kondisi,
								'min_beli' => $json_data[$i][5],
								'kategori_id' => $json_data[$i][2],
								'status' => $status,
								'slug' => $slug
							));

							# Tambah foto
							$array_foto = explode(",", $json_data[$i][0]);

							$jumlah_foto = 0;
							foreach ($array_foto as $key) {
								$jumlah_foto += 1;
							}

							for ($a=0; $a < $jumlah_foto; $a++) { 
								$file_url = file_get_contents(str_replace(' ', '%20', $array_foto[$a]));
								// $file_url = file_get_contents($array_foto[$a]);
								$name_file = $this->upload_image->generate_code().".jpg";
								file_put_contents(str_replace("api/", "", FCPATH) . "storage/Foto-Produk/".$name_file, $file_url);
								$this->db->insert($this->tabel_produk_foto, array(
									'produk_id' => $produk_id,
									'foto' => "cdn/Foto-Produk/$name_file"
								));
							}

							$result[$no_a] = array(
								'Error' => false,
								'Message' => "<b>#$i</b> Berhasil diimport."
							);
						}
					}

					$no_a++;
				}
			}
			goto output;
		}

		output:
		return $result;
	}

}

/* End of file M_Product.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/seller/M_Product.php */