<?php 

class MY_Controller extends CI_Controller
{
    protected $app_default = 'app/default';

    protected $app_css = 'app_css';

    protected $app_js = 'app_js';

    protected $app_modal = 'app_modal';

    protected $cek_auth;

    public function __construct() {
       parent::__construct();
       $this->cek_auth = $this->Func->cek_auth();
    }

    public function load_view($params,$data)
    {

    	$css 	= isset($params['css'])?$params['css'] : '';
    	$view 	= $params['view'];
    	$modal 	= isset($params['modal'])?$params['modal'] : '';
        $js     = isset($params['js'])?$params['js'] : '';
        
        $data['Auth'] = $this->cek_auth;

    	$config['default_css'] 	= $css?$this->load->view("$this->app_css/".$css,$data,true) : '';
    	$config['default_body'] = $this->load->view($view,$data,true);
        $config['default_modal']   = $modal?$this->load->view("$this->app_modal/".$modal,$data,true) : '';
    	$config['default_js'] 	= $js?$this->load->view("$this->app_js/".$js,$data,true) : '';

    	$this->load->view($this->app_default,$config);

    }

}