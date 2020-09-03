<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Ongkir extends MY_Model {

	protected $tabel_kurir = 'mst_kurir';

	private function rajaongkir_url($params)
	{
		$method = $params['method'];
		$url = $params['url'];
		$data = $params['data'];

		if ($method == "POST") {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => env('RAJAONGKIR_URL')."/".$url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $data,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "key: ".env('RAJAONGKIR_KEY')
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
		}else if ($method == "GET") {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => env('RAJAONGKIR_URL')."/".$url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "key: ".env('RAJAONGKIR_KEY')
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
		}

		return json_decode($response, true);
	}
	
	
	public function kurir($params)
	{
		$toko_id = isset($params['toko_id'])? $params['toko_id'] : '';
		$asal_id = isset($params['asal_id'])? $params['asal_id'] : '';
		$tujuan_id = isset($params['tujuan_id'])? $params['tujuan_id'] : '';
		$berat = isset($params['berat'])? $params['berat'] : '';
		if (empty($toko_id)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter toko_id tidak diset";
			goto output;
		}else if(empty($asal_id)){
			$result['Error'] = true;
			$result['Message'] = "Parameter asal_id tidak diset";
			goto output;
		}else if(empty($tujuan_id)){
			$result['Error'] = true;
			$result['Message'] = "Parameter tujuan_id tidak diset";
			goto output;
		}else if(empty($berat)){
			$result['Error'] = true;
			$result['Message'] = "Parameter berat tidak diset";
			goto output;
		}

		$kurir = $this->db->query("SELECT
										code
									FROM
										$this->tabel_kurir
									WHERE
										toko_id = '$toko_id'");
		if ($kurir->num_rows() == 0) {
			$result['Error'] = true;
			$result['Message'] = "Toko tidak memiliki kurir";
			goto output;
		}

		$no = 0;
		$result['Error'] = false;
		$result['Message'] = null;
		foreach ($kurir->result_array() as $key) {
			
			$kurir = $key['code'];

			$cost = $this->get_kurir(compact('asal_id','tujuan_id','berat','kurir'));
			$result['Data'][$no++] = $cost;
		}
		goto output;
		output:
		return $result; 

	}

	private function get_kurir($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];
		$kurir = $params['kurir'];

		$cost = $this->rajaongkir_url([
			'method' => 'POST',
			'url' => 'cost',
			'data' => "origin=$asal_id&originType=subdistrict&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=$kurir"
		]);
		$rajaongkir = $cost['rajaongkir'];
		$results = $rajaongkir['results'];
		$status = $rajaongkir['status'];
		$data = null;
		if ($status['code'] == 200) {
			$courier_code = $rajaongkir['query']['courier'];
			$courier_name = $results[0]['code'];
			$data = $results[0]['costs'][0];
			$data['code'] = $courier_code;
			$data['name'] = $courier_name;
		}
		return $data;

	}

	private function jnt($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];

		return $this->rajaongkir_url(array(
			'method' => 'POST',
			'url' => 'cost',
			'data' => "origin=$asal_id&originType=subdistrict&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=jnt"
		));
	}

	private function jne($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];

		return $this->rajaongkir_url(array(
			'method' => 'POST',
			'url' => 'cost',
			'data' => "origin=$asal_id&originType=subdistrict&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=jne"
		));
	}

	private function pos($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];

		return $this->rajaongkir_url(array(
			'method' => 'POST',
			'url' => 'cost',
			'data' => "origin=$asal_id&originType=subdistrict&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=pos"
		));
	}

	private function tiki($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];

		return $this->rajaongkir_url(array(
			'method' => 'POST',
			'url' => 'cost',
			'data' => "origin=$asal_id&originType=subdistrict&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=tiki"
		));
	}

	public function index($params)
	{
		$asal_id = $params['asal_id'];
		$tujuan_id = $params['tujuan_id'];
		$berat = $params['berat'];
		$kurir = $params['kurir'];

		if (empty($asal_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kecamatan asal belum dipilih."
			);
			goto output;
		}else if (empty($tujuan_id)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kecamatan tujuan belum dipilih."
			);
			goto output;
		}else if (empty($berat)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Berat belum diisi."
			);
			goto output;
		}else if (empty($kurir)) {
			$hasil = array(
				'Error' => true,
				'Message' => "Kurir belum dipilih."
			);
			goto output;
		}else{
			$hasil = array(
				'Error' => false,
				'Message' => 'success.',
				'Kurir' => $this->$kurir(array(
					'asal_id' => $asal_id,
					'tujuan_id' => $tujuan_id,
					'berat' => $berat
				))
			);
			goto output;
		}

		output:
		return $hasil;
	}

    public function get_tracking($params)
	{
		$no_resi = isset($params['no_resi'])? $params['no_resi'] : '';
		$courier_code = isset($params['courier_code'])? $params['courier_code'] : '';
		if (empty($no_resi)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter no_resi tidak diset";
			goto output;			
		}else if(empty($courier_code)) {
			$result['Error'] = true;
			$result['Message'] = "Parameter courier_code tidak diset";
			goto output;		
		}

		// $pembelian = $this->db->query("SELECT
		// 									id
		// 								FROM
		// 									transaksi_pembelian
		// 								WHERE
		// 									no_resi = '$no_resi'")->row_array();
		// if (!$pembelian) {
		// 	$result['Error'] = true;
		// 	$result['Message'] = "No Resi tidak ditemukan";
		// 	goto output;		
		// }

		$config['method'] = 'POST';
		$config['url'] = 'waybill';
		$config['data'] = "waybill=$no_resi&courier=$courier_code";

		$data = $this->rajaongkir_url($config);

		// $data = json_decode($data,true);

		$rajaongkir = $data['rajaongkir'];

		if ($rajaongkir['status']['code'] == 200) {
			$res = $rajaongkir['result'];
			$manifest = $res['manifest'];
			$result['Error'] = false;
			$result['Message'] = "OK";
			$result['delivered'] = $res['delivered'];
			$result['summary'] = $res['summary'];
			$result['details'] = $res['details'];
			$result['delivery_status'] = $res['delivery_status'];
			$no = 0;
			$sort = array_column($manifest, 'manifest_date');
			$sort2 = array_column($manifest, 'manifest_time');
			array_multisort($sort, SORT_DESC, $sort2, SORT_DESC,$manifest);
			foreach ($manifest as $key) {
				$tgl = date('l, j M',strtotime($key['manifest_date']));
				$waktu = date('H:i',strtotime($key['manifest_time']));
				$result['Data'][$no++] = [
					'manifest_title' => "$key[manifest_code] - $tgl",
					'manifest_date' => $tgl,
					'manifest_time' => $waktu,
					'manifest_code' => $key['manifest_code'],
					'manifest_description' => $key['manifest_description'],
					'city_name' => $key['city_name']
				];
			}
			goto output;
		}
		$result['Error'] = true;
		$result['Message'] = $data['rajaongkir']['status']['description'];
		goto output;
		output:
		return $result;

	}

}

/* End of file M_Ongkir.php */
/* Location: ./application/models/M_Ongkir.php */