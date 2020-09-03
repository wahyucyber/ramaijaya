<?php 

class Midtrans
{
	
	function __construct()
	{
		$env_type = env('MIDTRANS_ENV');
		if ($env_type == "production") {
			$this->midtrans_url = "https://api.midtrans.com/";
		}else{
			$this->midtrans_url = "https://api.sandbox.midtrans.com/";
		}
	}

	public function transaksi($params)
	{

		$url = $params['url'];
		$type = $params['type'];
		$name = $params['name'];
		$order_id = $params['order_id'];
		$gross_amount = $params['gross_amount'];
		$item_details = $params['item_details'];

		if ($type == "bank_transfer") {
			if ($name == "permata") {
				$data = array(
					"payment_type": "bank_transfer",
					"bank_transfer": array(
						"bank" => "permata"
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "bca") {
				$data = array(
					"payment_type": "bank_transfer",
					"bank_transfer": array(
						"bank" => "bca"
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "mandiri") {
				$data = array(
					"payment_type": "echannel",
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if (empty($name == "bni")) {
				$data = array(
					"payment_type": "bank_transfer",
					"bank_transfer": array(
						"bank" => "bni"
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}
		}else if ($type == "internet_banking") {
			if ($name == "bca_klikpay") {
				$data = array(
					"payment_type": "bca_klikpay",
					"bca_klikpay": array(
						"description" => "Transaksi JPStore."
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "bca_klikbca") {
				$data = array(
					"payment_type": "bca_klikbca",
					"bca_klikpay": array(
						"description" => "Transaksi JPStore."
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "bri_epay") {
				$data = array(
					"payment_type": "bri_epay",
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "cimb_clicks") {
				$data = array(
					"payment_type": "cimb_clicks",
					"cimb_clicks": array(
						"description" => "Transaksi JPStore."
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}else if ($name == "danamon_online") {
				$data = array(
					"payment_type": "danamon_online",
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}
		}else if ($type == "ewallet") {
			if ($name == "gopay") {
				$data = array(
					"payment_type": "gopay",
					"gopay": array(
						"enable_callback" => true,
						"callback_url" => base_url('')
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}
		}else if ($type == "cstore") {
			if ($name == "indomaret") {
				$data = array(
					"payment_type": "gopay",
					"cstore": array(
						"store" => "Indomaret",
						"description" => "Transaksi JPSTore."
					),
					"transaction_details" => array(
						"order_id" => $order_id,
						"gross_amount" => $gross_amount
					),
					"costumer_details" => array(
						"email" => $customer_email,
						"first_name" => $customer_first_name,
						"last_name" => $customer_last_name,
						"phone" => $customer_phone
					),
					"item_details" => $item_details
				);
			}
		}

		$ch = curl_init();
		curl_setopt_array($ch, array(
			'CURLOPT_URL' => $this->midtrans_url.$url,
			'CURLOPT_CUSTOMREQUEST' => 'POST',
			'CURLOPT_POSTFIELD' => $data,
			'CURLOPT_RETURNTRANSFER' => true,
			'CUROPT_HTTPHEADER' => array(
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'Authorization' => base64_encode(env('MIDTRANS_SERVER_KEY'))
			)
		));

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}

	public function status($params)
	{
		$url = $params['url'];

		$ch = curl_init();
		curl_setopt_array($ch, array(
			'CURLOPT_URL' => $this->midtrans_url.$url,
			'CURLOPT_CUSTOMREQUEST' => 'GET',
			'CURLOPT_RETURNTRANSFER' => true,
			'CUROPT_HTTPHEADER' => array(
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'Authorization' => base64_encode(env('MIDTRANS_SERVER_KEY'))
			)
		));

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}
}