<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Ulasan extends MY_Model
{
	/**
	* @author          Masteguh
	* @link            https://github.com/AnteikuDevs
	*/

	protected $tabel = 'mst_produk_ulasan';

    protected $tabel_foto = 'mst_produk_ulasan_foto';

	protected $tabel_user = 'mst_user';

	protected $tabel_toko = 'mst_toko';

	protected $tabel_produk = 'mst_produk';

    public function __construct()
    {
        parent::__construct();
    }

    function all($params)
    {
    	$client_token = isset($params['client_token'])? $params['client_token'] : '';
        $start = $params['start'];
        $length = $params['length'];
        $draw = $params['draw'];
        $search = $params['search']['value'];
    	if (empty($client_token)) {
    		$result['Error'] = true;
    		$result['Message'] = "Parameter client_token tidk diset";
    		goto output;
    	}

        $where = empty($search)? "" : "AND ($this->tabel_user.nama LIKE '%$search%' OR $this->tabel_produk.nama_produk LIKE '%$search%' OR $this->tabel.rating LIKE '%$search%' OR $this->tabel.ulasan LIKE '%$search%')";

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

    	$toko = $this->db->query("SELECT
    									id
    								FROM
    									$this->tabel_toko
    								WHERE
    									user_id = '$user[id]'")->row_array();
    	if (!$toko) {
    		$result['Error'] = true;
    		$result['Message'] = "Toko tidak ditemukan";
    		goto output;
    	}

    	$jumlah_ulasan = $this->db->query("SELECT
                                            $this->tabel.id,
                                            $this->tabel.user_id,
                                            $this->tabel.produk_id,
                                            $this->tabel_produk.nama_produk,
                                            $this->tabel_user.nama AS user_nama,
                                            $this->tabel.rating,
                                            $this->tabel.ulasan,
                                            $this->tabel.created_at,
                                            $this->tabel.updated_at
                                        FROM
                                            $this->tabel
                                        LEFT JOIN
                                            $this->tabel_user
                                            ON
                                            $this->tabel.user_id = $this->tabel_user.id
                                        LEFT JOIN
                                            $this->tabel_produk
                                            ON
                                            $this->tabel.produk_id = $this->tabel_produk.id
                                        WHERE
                                            $this->tabel.toko_id = '$toko[id]'
                                            AND
                                            $this->tabel.reply_id = '0'
                                            $where")->num_rows();
        $no = 0;
        if ($jumlah_ulasan > 0) {
            $ulasan = $this->db->query("SELECT
                                            $this->tabel.id,
                                            $this->tabel.user_id,
                                            $this->tabel.produk_id,
                                            $this->tabel_produk.nama_produk,
                                            $this->tabel_user.nama AS user_nama,
                                            $this->tabel.rating,
                                            $this->tabel.ulasan,
                                            $this->tabel.created_at,
                                            $this->tabel.updated_at
                                        FROM
                                            $this->tabel
                                        LEFT JOIN
                                            $this->tabel_user
                                            ON
                                            $this->tabel.user_id = $this->tabel_user.id
                                        LEFT JOIN
                                            $this->tabel_produk
                                            ON
                                            $this->tabel.produk_id = $this->tabel_produk.id
                                        WHERE
                                            $this->tabel.toko_id = '$toko[id]'
                                            AND
                                            $this->tabel.reply_id = '0'
                                            $where
                                        LIMIT $start,$length")->result_array();
            foreach ($ulasan as $key) {
                $result['Data'][$no++] = $key;
                $result['Error'] = false;
                $result['Message'] = null;
                $result['recordsTotal'] = $jumlah_ulasan;
                $result['recordsFiltered'] = count($ulasan);
            }
            goto output;
        }

    	$result['Error'] = true;
    	$result['Message'] = "Produk tidak ditemukan";
        $result['Data'] = [];
        $result['recordsTotal'] =0;
        $result['recordsFiltered'] = 0;
    	goto output;
    	output:
    	return $result;

    }

    private function ulasan_produk($produk_id)
	{
		$ulasan = $this->db->query("SELECT
                                        $this->tabel.id,
                                        $this->tabel.user_id,
                                        $this->tabel.produk_id,
                                        $this->tabel_produk.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel.rating,
                                        $this->tabel.ulasan,
                                        $this->tabel.created_at,
                                        $this->tabel.updated_at
                                    FROM
                                        $this->tabel
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel_produk
                                        ON
                                        $this->tabel.produk_id = $this->tabel_produk.id
                                    WHERE
                                        $this->tabel.produk_id = '$produk_id'")->result_array();
        $result = null;
        $no = 0;
        if (count($ulasan) > 0) {
            foreach ($ulasan as $key) {
                $result[$no++] = $key;
            }
        }
        return $result;
	}

    function detail($params)
    {
        $client_token = isset($params['client_token'])? $params['client_token'] : '';
        $ulasan_id = isset($params['ulasan_id'])? $params['ulasan_id'] : '';
        if (empty($client_token)) {
            $result['Error'] = true;
            $result['Message'] = "Parameter client_token tidk diset";
            goto output;
        }else if(empty($ulasan_id)) {
            $result['Error'] = true;
            $result['Message'] = "Parameter ulasan_id tidk diset";
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

        $toko = $this->db->query("SELECT
                                        id
                                    FROM
                                        $this->tabel_toko
                                    WHERE
                                        user_id = '$user[id]'")->row_array();
        if (!$toko) {
            $result['Error'] = true;
            $result['Message'] = "Toko tidak ditemukan";
            goto output;
        }

        $ulasan = $this->db->query("SELECT
                                        $this->tabel.id,
                                        $this->tabel.user_id,
                                        $this->tabel.produk_id,
                                        $this->tabel_produk.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel.rating,
                                        $this->tabel.ulasan,
                                        $this->tabel.created_at,
                                        $this->tabel.updated_at
                                    FROM
                                        $this->tabel
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel_produk
                                        ON
                                        $this->tabel.produk_id = $this->tabel_produk.id
                                    WHERE
                                        $this->tabel.id = '$ulasan_id'")->row_array();
        if ($ulasan) {
            
            $result['Error'] = false;
            $result['Message'] = null;
            $result['Data'] = [
                'id' => $ulasan['id'],
                'user_id' => $ulasan['user_id'],
                'user_nama' => $ulasan['user_nama'],
                'ulasan_foto' => $this->ulasan_foto($ulasan['produk_id'], $ulasan['id']),
                'rating' => $ulasan['rating'],
                'ulasan' => $ulasan['ulasan'],
                'reply' => $this->get_balasan_ulasan($ulasan['id']),
                'created_at' => $ulasan['created_at'],
                'updated_at' => $ulasan['updated_at']
            ];
            goto output;

        }
        $result['Error'] = true;
        $result['Message'] = "Ulasan tidak ditemukan";
        goto output;

        output:
        return $result;
    }


    private function get_balasan_ulasan($ulasan_id)
    {
        if (empty($ulasan_id)) {
            return null;
        }

        $ulasan = $this->db->query("SELECT
                                        $this->tabel.id,
                                        $this->tabel.user_id,
                                        $this->tabel.produk_id,
                                        $this->tabel_produk.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel_toko.nama_toko,
                                        $this->tabel.rating,
                                        $this->tabel.ulasan,
                                        $this->tabel.reply_id,
                                        $this->tabel.created_at,
                                        $this->tabel.updated_at
                                    FROM
                                        $this->tabel
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel_produk
                                        ON
                                        $this->tabel.produk_id = $this->tabel.id
                                    LEFT JOIN
                                        $this->tabel_toko
                                        ON
                                        $this->tabel.toko_id = $this->tabel_toko.id
                                    WHERE
                                        $this->tabel.reply_id = '$ulasan_id'
                                ")->result_array();
        $no = 0;
        foreach ($ulasan as $key) {
            $hasil[$no++] = array(
                'id' => $key['id'],
                'user_id' => $key['user_id'],
                'user_nama' => $key['nama_toko'],
                'ulasan_foto' => $this->ulasan_foto($produk['id'], $key['id']),
                'rating' => $key['rating'],
                'ulasan' => $key['ulasan'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            );
        }
        return $hasil;
    }

    public function ulasan_foto($produk_id, $ulasan_id)
    {
        $get_foto = $this->db->query("
            SELECT
                id,
                CONCAT('".base_url('')."', foto) AS foto
            FROM
                $this->tabel_foto
            WHERE
                ulasan_id = '$ulasan_id'
                AND
                produk_id = '$produk_id'
        ");
        $result = null;
        $no = 0;
        if ($get_foto->num_rows() > 0) {
            foreach ($get_foto->result_array() as $key) {
                $result[$no++] = $key;
            }
        }
        return $result;
    }

    function add($params)
    {
        $client_token = isset($params['client_token'])? $params['client_token'] : '';
        $ulasan_id = isset($params['ulasan_id'])? $params['ulasan_id'] : '';
        $ulasan = isset($params['ulasan'])? $params['ulasan'] : '';
        if (empty($client_token)) {
            $result['Error'] = true;
            $result['Message'] = "Parameter client_token tidk diset";
            goto output;
        }else if(empty($ulasan_id)) {
            $result['Error'] = true;
            $result['Message'] = "Parameter ulasan_id tidk diset";
            goto output;
        }else if(empty($ulasan)) {
            $result['Error'] = true;
            $result['Message'] = "Jawaban tidak boleh kosong";
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

        $toko = $this->db->query("SELECT
                                        id
                                    FROM
                                        $this->tabel_toko
                                    WHERE
                                        user_id = '$user[id]'")->row_array();
        if (!$toko) {
            $result['Error'] = true;
            $result['Message'] = "Toko tidak ditemukan";
            goto output;
        }

        $data_ulasan = $this->db->query("SELECT
                                        $this->tabel.id,
                                        $this->tabel.user_id,
                                        $this->tabel.produk_id,
                                        $this->tabel_produk.nama_produk,
                                        $this->tabel_user.nama AS user_nama,
                                        $this->tabel.rating,
                                        $this->tabel.ulasan,
                                        $this->tabel.created_at,
                                        $this->tabel.updated_at
                                    FROM
                                        $this->tabel
                                    LEFT JOIN
                                        $this->tabel_user
                                        ON
                                        $this->tabel.user_id = $this->tabel_user.id
                                    LEFT JOIN
                                        $this->tabel_produk
                                        ON
                                        $this->tabel.produk_id = $this->tabel_produk.id
                                    WHERE
                                        $this->tabel.id = '$ulasan_id'")->row_array();
        if (!$data_ulasan) {
            $result['Error'] = true;
            $result['Message'] = "Ulasan tidak ditemukan";
            goto output;
        }
        $data = [
            'toko_id' => $toko['id'],
            'produk_id' => $data_ulasan['produk_id'],
            'user_id' => $user['id'],
            'rating' => $data_ulasan['rating'],
            'ulasan' => $ulasan,
            'reply_id' => $data_ulasan['id']
        ];
        $add = $this->db->insert($this->tabel,$data);
        if ($add) {
            $result['Error'] = false;
            $result['Message'] = "Berhasil membalas ulasan";
            goto output;
        }
        $result['Error'] = true;
        $result['Message'] = "Gagal membalas ulasan";
        goto output;
        output:
        return $result;
    }
}