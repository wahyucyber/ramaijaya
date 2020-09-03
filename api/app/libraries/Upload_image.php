<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_image {

	function upload($file_base64,$lokasi_file = 'storage',$nama_file = 'file',$url_file_lama = '')
    {

        $api_url = str_replace('/','',env('API_URL'));
        $cdn_url = str_replace('/','',env('CDN_URL'));

        $tipe = explode(';base64,',$file_base64);
        $format = explode('data:image/',$tipe[0]);
        $file_base64 = str_replace('data:image/'.$format[1].';base64,', '', $file_base64);
        $file_base64 = str_replace(' ', '+', $file_base64);
        $decode_data = base64_decode($file_base64);

        // $nama_file_baru = uniqid($nama_file.'-',true).'.'.$format[1];

        $nama_file_baru = strtoupper($nama_file).'-'.$this->generate_code().'.'.$format[1];

        $lokasi_upload = FCPATH . "/storage/".$lokasi_file.'/';

        $lokasi_file_upload = str_replace("\\".$api_url,'',str_replace('/'.$api_url,'',$lokasi_upload));

        if (!file_exists($lokasi_file_upload)) {
            mkdir($lokasi_file_upload, 0777);
        }

        // $lokasi_file_baru = str_replace("\\".$api_url,'',str_replace('/'.$api_url,'',base_url()))."/".$cdn_url."/".$lokasi_file.'/'.$nama_file_baru;
        $lokasi_file_baru = $cdn_url."/".$lokasi_file.'/'.$nama_file_baru;

        $lokasi_file_lama = null;

        $lokasi_baru = $lokasi_file_upload.$nama_file_baru;

        if (!empty($url_file_lama)) {
            $this->remove($url_file_lama);
        }

        $upload = file_put_contents($lokasi_baru, $decode_data);

        if ($upload) {
            $result = [
                'Error' => false,
                'Message' => "success.",
                'Url' => $lokasi_file_baru
            ];
        }else{
            $result = [
                'Error' => true,
                'Message' => "Gagal mengunggah file",
                'Url' => null
            ];
        }

        return $result;
    }

    function remove($url_file_lama)
    {
        $api_url = str_replace('/','',env('API_URL'));
        $cdn_url = str_replace('/','',env('CDN_URL'));
        
        $lokasi_upload = $_SERVER['DOCUMENT_ROOT'] . "/storage/".str_replace("cdn/", "", $url_file_lama);;

        // $lokasi_file_upload = str_replace("\\".$api_url,'',str_replace('/'.$api_url,'',$lokasi_upload));
        // $lokasi_file_upload = str_replace(base_url(''), "", $lokasi_upload)

        // $file_lama = str_replace(app_url("/".$cdn_url."/"),'',$url_file_lama);

        // $lokasi_file_lama = $lokasi_file_upload.$file_lama;
        // $lokasi_file_lama = str_replace(base_url(''), $lokasi_upload, $url_file_lama);

        // if (file_exists($lokasi_file_lama)) {
            unlink($lokasi_upload);
        // }

    }

    public function generate_code()
    {
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $result = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid, 12, 4).$hyphen
            .substr($charid, 16, 4).$hyphen
            .substr($charid, 20, 12);
        return $result;
    }

}

/* End of file Uploads.php */
/* Location: .//F/xampp/htdocs/GitHub/JPMall/api/app/models/Uploads.php */