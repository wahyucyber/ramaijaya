<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dashboard extends CI_Model {

  protected $detail = "mst_transaksi_detail";
  protected $transaksi = "mst_transaksi";
  protected $produk = "mst_transaksi_produk";
  protected $tabel_produk = 'mst_produk';
  protected $tabel_ulasan = 'mst_produk_ulasan';
  protected $tabel_komplain = 'mst_produk_komplain';
  
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $menunggu_dibayar = $this->db->query("
      SELECT 
        COUNT(id) AS total
      FROM
        $this->transaksi
      WHERE
        status = '0'
    ")->row_array()['total'];

    $menunggu_diproses = $this->db->query("
      SELECT 
        COUNT($this->detail.id) AS total
      FROM
        $this->detail
        LEFT JOIN $this->transaksi ON $this->transaksi.id = $this->detail.transaksi_id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '1'
    ")->row_array()['total'];

    $diproses = $this->db->query("
      SELECT 
        COUNT($this->detail.id) AS total
      FROM
        $this->detail
        LEFT JOIN $this->transaksi ON $this->transaksi.id = $this->detail.transaksi_id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '2'
    ")->row_array()['total'];

    $dikirim = $this->db->query("
      SELECT 
        COUNT($this->detail.id) AS total
      FROM
        $this->detail
        LEFT JOIN $this->transaksi ON $this->transaksi.id = $this->detail.transaksi_id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '3'
    ")->row_array()['total'];

    $selesai = $this->db->query("
      SELECT 
        COUNT($this->detail.id) AS total
      FROM
        $this->detail
        LEFT JOIN $this->transaksi ON $this->transaksi.id = $this->detail.transaksi_id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '4'
    ")->row_array()['total'];

    $dibatalkan = $this->db->query("
      SELECT 
        COUNT($this->detail.id) AS total
      FROM
        $this->detail
        LEFT JOIN $this->transaksi ON $this->transaksi.id = $this->detail.transaksi_id
      WHERE
        $this->transaksi.status = '2' AND
        $this->detail.status = '0'
    ")->row_array()['total'];

    $total_pesanan = $this->db->query("SELECT
    									COUNT(id) as total
    								FROM
    									$this->detail")->row_array();

    $total_ulasan = $this->db->query("SELECT
    									COUNT(id) as total
    								FROM
    									$this->tabel_ulasan
    								WHERE
    									reply_id = '0'")->row_array();

    $total_komplain = $this->db->query("SELECT
    									COUNT(id) as total
    								FROM
    									$this->tabel_komplain")->row_array();

    $total_produk = $this->db->query("SELECT
    									COUNT(id) as total
    								FROM
    									$this->tabel_produk
    								WHERE
    									verifikasi = '1'")->row_array();

    $total_produk_diblokir = $this->db->query("SELECT
    									COUNT(id) as total
    								FROM
    									$this->tabel_produk
    								WHERE
    									verifikasi = '0'")->row_array();

    $hasil = array(
      'Error' => false,
      'Message' => 'success.',
      'Data' => array(
        array(
          'menunggu_dibayar' => $menunggu_dibayar,
          'menunggu_diproses' => $menunggu_diproses,
          'diproses' => $diproses,
          'dikirim' => $dikirim,
          'selesai' => $selesai,
          'dibatalkan' => $dibatalkan,
          'total_pesanan' => $total_pesanan['total'],
          'total_ulasan' => $total_ulasan['total'],
          'total_komplain' => $total_komplain['total'],
          'total_produk' => $total_produk['total'],
          'total_produk_diblokir' => $total_produk_diblokir['total']
        )
      )
    );
    goto output;

    output:
    return $hasil;
  }

  public function chart()
  {
    $belum_dibayar = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->transaksi.created_at) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        $this->transaksi.status = '0'
      GROUP BY
        MONTH($this->transaksi.created_at)
    ");

    $menunggu_diproses = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->transaksi.log_dibayar) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '1'
      GROUP BY
        MONTH($this->transaksi.log_dibayar)
    ");

    $diproses = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->detail.log_diproses) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '2'
      GROUP BY
        MONTH($this->detail.log_diproses)
    ");

    $dikirim = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->detail.log_dikirim) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '3'
      GROUP BY
        MONTH($this->detail.log_dikirim)
    ");

    $diterima = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->detail.log_diterima) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        $this->transaksi.status = '1' AND
        $this->detail.status = '4'
      GROUP BY
        MONTH($this->detail.log_diterima)
    ");

    $dibatalkan = $this->db->query("
      SELECT
        COUNT($this->detail.id) AS total,
        MONTH($this->detail.log_dibatalkan) AS bulan
      FROM
        $this->transaksi
        LEFT JOIN $this->detail ON $this->detail.transaksi_id = $this->transaksi.id
      WHERE
        -- $this->transaksi.status = '1' AND
        $this->detail.status = '0'
      GROUP BY
        MONTH($this->detail.log_dibatalkan)
    ");

    $penjualan_hari_ini = $this->db->query("
      SELECT
        SUM($this->produk.harga * $this->produk.qty) + SUM($this->detail.kurir_value) AS total
      FROM
        $this->detail
        LEFT JOIN $this->produk ON $this->produk.transaksi_id = $this->detail.transaksi_id AND $this->produk.toko_id = $this->detail.toko_id
      WHERE
        DATE($this->detail.log_diterima) = '".date('Y-m-d')."' AND
        $this->detail.status = '4'
      GROUP BY $this->detail.id
    ")->row_array()['total'];

    $penjualan_minggu_ini = $this->db->query("
      SELECT
        SUM($this->produk.harga * $this->produk.qty) + SUM($this->detail.kurir_value) AS total
      FROM
        $this->detail
        LEFT JOIN $this->produk ON $this->produk.transaksi_id = $this->detail.transaksi_id AND $this->produk.toko_id = $this->detail.toko_id
      WHERE
        YEARWEEK($this->detail.log_diterima) = YEARWEEK(NOW()) AND
        $this->detail.status = '4'
    ")->row_array()['total'];

    $penjualan_bulan_ini = $this->db->query("
      SELECT
        SUM($this->produk.harga * $this->produk.qty) + SUM($this->detail.kurir_value) AS total
      FROM
        $this->detail
        LEFT JOIN $this->produk ON $this->produk.transaksi_id = $this->detail.transaksi_id AND $this->produk.toko_id = $this->detail.toko_id
      WHERE
        YEAR($this->detail.log_diterima) = '".date('Y')."' AND
        MONTH($this->detail.log_diterima) = '".date('m')."' AND
        $this->detail.status = '4'
    ")->row_array()['total'];

    $total_penjualan = $this->db->query("
      SELECT
        SUM($this->produk.harga * $this->produk.qty) + SUM($this->detail.kurir_value) AS total
      FROM
        $this->detail
        LEFT JOIN $this->produk ON $this->produk.transaksi_id = $this->detail.transaksi_id AND $this->produk.toko_id = $this->detail.toko_id
      WHERE
        YEAR($this->detail.log_diterima) = YEAR(NOW()) AND
        $this->detail.status = '4'
    ")->row_array()['total'];

    $hasil['Error'] = false;
    $hasil['Message'] = "success.";
    $hasil['Data']['label'] = array(
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

    $hasil['Data']['belum_dibayar'] = [];
    $hasil['Data']['menunggu_diproses'] = [];
    $hasil['Data']['diproses'] = [];
    $hasil['Data']['dikirim'] = [];
    $hasil['Data']['diterima'] = [];
    $hasil['Data']['dibatalkan'] = [];

    $hasil['Data']['statistik'] = array(
      'penjualan_hari_ini' => ($penjualan_hari_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_hari_ini),
      'penjualan_minggu_ini' => ($penjualan_minggu_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_minggu_ini),
      'penjualan_bulan_ini' => ($penjualan_bulan_ini == null) ? "Rp. 0" : $this->uang->convert($penjualan_bulan_ini),
      'total_penjualan' => ($total_penjualan == null) ? "Rp. 0" : $this->uang->convert($total_penjualan)
    );

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($belum_dibayar->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['belum_dibayar'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($menunggu_diproses->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['menunggu_diproses'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($diproses->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['diproses'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($dikirim->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['dikirim'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($diterima->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['diterima'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    for ($i=0; $i < 12; $i++) { 
      $total = intval(0);
      foreach ($dibatalkan->result_array() as $key) {
        if (($i + 1) == $key['bulan']) {
          $total = intval($key['total']);
        }
      }
      $hasil['Data']['dibatalkan'][$i] = array(
        'total' => $total,
        'bulan' => $i+1
      );
    }

    output:
    return $hasil;
  }

}

/* End of file M_Dashboard.php */