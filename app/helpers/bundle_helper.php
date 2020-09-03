<?php 

include 'loader_helper.php';

if (!function_exists('env')) {
	
	function env($params,$alternate = ''){

		$config = FCPATH.'.env';

		$env = parse_ini_file($config);

		return $env[$params]? $env[$params] : ($alternate ? $alternate : '');

	}

}

if (!function_exists('app_url')) {
	
	function app_url($params = ''){

		return site_url($params); 

	}

}

if (!function_exists('api_url')) {
    function api_url($url = '')
    {
        return base_url(env('API_URL').$url.'/');
    }
}

if (!function_exists('cdn_url')) {
    function cdn_url($url = '')
    {
        return base_url(env('CDN_URL').$url.'/');
    }
}

if (!function_exists('stylesheet')) {

    function stylesheet($css, $folder = NULL, $location = 'assets/') {
        $output = NULL;
        if (is_array($css)) {
            foreach ($css as $file) {
                $output .= link_tag($location . $folder . $file);
            }
        } else {
            $output .= link_tag($location . $folder . $css);
        }
        return $output;
    }

}

if (!function_exists('stylesheet_url')) {

    function stylesheet_url($link) {
        $output = link_tag($link);
        return $output;
    }

}

if (!function_exists('script')) {

    function script($js, $folder = NULL, $location = 'assets/') {
        $output = NULL;
        if (is_array($js)) {
            foreach ($js as $file) {

                $output .= '<script type="text/javascript" src="' . base_url() . $location . $folder . $file . '"></script>';
            }
        } else {
            $output .= '<script type="text/javascript" src="' . base_url() . $location . $folder . $js . '"></script>';
        }
        return $output;
    }

}

if (!function_exists('script_url')) {

    function script_url($link) {
        $output = '<script type="text/javascript" src="'.$link.'"></script>';
        return $output;
    }

}

if (!function_exists('segment')) {
	
	function segment($prefix)
	{
		$ci =& get_instance();
		return $ci->uri->segment($prefix);
	}

}

if (!function_exists('session')) {
    
    function session($prefix)
    {
        $ci =& get_instance();
        return $ci->session->userdata($prefix);
    }

}

if (!function_exists('flashdata')) {
    
    function flashdata($prefix)
    {
        $ci =& get_instance();
        return $ci->session->flashdata($prefix);
    }

}


// function __autoload($class)
// {
//     if(strpos($class, 'CI_') !== 0)
//     {
//         spl_autoload_register(function($class){
//             @include_once( APPPATH . 'core/'. $class . '.php' );
//         });
//     }
// }