<?php 


if (!function_exists('env')) {
	
	function env($params,$alternate = ''){

		$config = str_replace("\\"."api", "", str_replace("/"."api", "", FCPATH)).'.env';;

		$env = parse_ini_file($config);

		return $env[$params]? $env[$params] : ($alternate ? $alternate : '');

	}

}

if (!function_exists('app_url')) {
	
	function app_url($params = ''){

		return str_replace("\api", "", str_replace("/api", "",base_url())).$params; 

	}

}

if(!function_exists('slugify')) {
    function slugify($text)
    {
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      $text = trim($text, '-');
    
      $text = preg_replace('~-+~', '-', $text);
    
      $text = strtolower($text);
    
      if (empty($text)) {
        return 'n-a';
      }
    
      return $text;
    }
}


if (!function_exists('__hs')) {
  function __hs($text)
  {
    $ci =& get_instance();
    return $ci->db->escape_str($text);
  }
}

if (!function_exists('__hsp')) {
  function __hsp($array)
  {
    if (is_array($array)) {
      $no = 0;
      foreach ($array as $key => $value) {
        $result[$key] = __hs($value);
      }
      return $result;
    }else{
      return __hs($array);
    }
  }
}