<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Slider extends MY_Model {

	protected $table = 'mst_slider';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Upload_image','upload_image');
	}

	function all($params)
	{
		$keyword = empty($params['keyword'])? null : $params['keyword'];
		$config['tabel'] = $this->table;
		$config['kolom'] = "
			id as id_slider,
			banner as banner_slider,
			title,
			slug,
			body,
			status
		";
		$config['limit'] = empty($params['limit'])? 10 : $params['limit'];
		$config['page'] = empty($params['page'])? null : $params['page'];
		$config['filter'] = "title LIKE '%$keyword%'";
		$result = $this->query_list($config);
		return $result;
	}

	function add($params)
	{

		$banner = isset($params['banner'])? htmlspecialchars($params['banner']) : null;
		$title = isset($params['title'])? htmlspecialchars($params['title']) : null;
		$body = isset($params['body']) ? htmlspecialchars($params['body']) : null;
		$status = isset($params['status'])? htmlspecialchars($params['status']) : 0;

		if (empty($banner)) {
			$result['Error'] = true;
			$result['Message'] = 'Banner tidak boleh kosong';

			goto output;
		}else if(empty($title)) {
			$result['Error'] = true;
			$result['Message'] = 'Title tidak boleh kosong';

			goto output;
		}else if(empty($body)) {
			$result = array(
				'Error' => true,
				'Message' => 'Body tidak boleh kosong'
			);
			goto output;
		}

		$query = $this->db->query("SELECT
									id
								FROM
									$this->table
								WHERE title = '$title'")->num_rows();

		if ($query > 0) {
			$result['Error'] = true;
			$result['Message'] = 'Title tidak tersedia';
			goto output;
		}

		$slug = str_replace(' ','-',strtolower(strtoupper($title)));

		$upload = $this->upload_image->upload($banner,'banner_slider','slider');

		if ($upload['Error']) {
        	$result['Error'] = true;
			$result['Message'] = $upload['Message'];
			goto output;
        }


		$data = [
			'banner' => $upload['Url'],
			'title' => $title,
			'body' => $body,
			'slug' => $slug,
			'status' => $status
		];

		$config['tabel'] = $this->table;
		$config['data'] = $data;

		$result = $this->query_add($config);
		goto output;

		output:
		return $result;
	}

	function update($params)
	{
		$id_slider = isset($params['id_slider'])? htmlspecialchars($params['id_slider']) : '';
		$banner = isset($params['banner'])? htmlspecialchars($params['banner']) : '';
		$title = isset($params['title'])? htmlspecialchars($params['title']) : '';
		$body = isset($params['body']) ? htmlspecialchars($params['body']) : null;
		$status = isset($params['status'])? htmlspecialchars($params['status']) : 0;

		if (empty($id_slider)) {
			$result['Error'] = true;
			$result['message'] = "Parameter 'id_slider' tidak diset ";
			goto output;
		}else if(empty($title)) {
			$result['Error'] = true;
			$result['Message'] = 'Title tidak boleh kosong';
			goto output;
		}else if(empty($body)) {
			$result = array(
				'Error' => true,
				'Message' => 'Body tidak boleh kosong'
			);
			goto output;
		}

		$slider = $this->db->query("SELECT
										id as id_slider,
										banner,
										title,
										status
									FROM 
										$this->table
									WHERE 
										id = $id_slider");
		if ($slider->num_rows() == 0) {
			$result['Error'] = false;
			$result['Message'] = 'Data tidak ditemukan';
			goto output;
		}
		$row = $slider->row_array();
		$upload = [
			'Url' => $row['banner']
		];
		if (!empty($banner)) {
			$upload = $this->upload_image->upload($banner,'banner_slider','slider',$row['banner']);
			if ($upload['Error']) {
	        	$result['Error'] = true;
				$result['Message'] = $upload['Message'];
				goto output;
	        }
		}
		$slug = str_replace(' ','-',strtolower(strtoupper($title)));
		$query = $this->db->query("SELECT
									id
								FROM
									$this->table
								WHERE title = '$title'")->num_rows();
		if ($title !== $row['title']) {
			if ($query > 0) {
				$result['Error'] = true;
				$result['Message'] = 'Title tidak tersedia';
				goto output;
			}
		}
		$data = [
			'banner' => $upload['Url'],
			'title' => $title,
			'body' => $body,
			'slug' => $slug,
			'status' => $status
		];
		$config['tabel'] = $this->table;
		$config['data'] = $data;
		$config['filter'] = "id = $id_slider";
		$result = $this->query_update($config);
		goto output;
		output:
		return $result;
	}

	function delete($params)
	{
		$id_slider = isset($params['id_slider'])? htmlspecialchars($params['id_slider']) : '';

		if (empty($id_slider)) {
			
			$result['Error'] = true;
			$result['Message'] = "Parameter 'id_slider' tidak diset";
			goto output;
		}

		$query = $this->db->query("SELECT
										banner as banner_slider
									FROM
										$this->table
									WHERE
										id = $id_slider")->row_array();
		$this->upload_image->remove($query['banner_slider']);

		$config['tabel'] = $this->table;
		$config['filter'] = "id = $id_slider";

		$result = $this->query_delete($config);
		goto output;

		output:
		return $result;
	}

}

/* End of file M_Slider.php */
/* Location: .//F/xampp/htdocs/com/JPStore/api/base/models/admin/M_Slider.php */