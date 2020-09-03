<?php 

if (!function_exists('product_loader')) {
	
	function product_loader($count = 5)
	{
		$html = '<div class="product--loader">';
	
			for ($i = 0; $i < $count; $i++) {
				$html .= '<div class="product--loader-item">
						<div class="head--loader _c287e"></div>
						<div class="body--content">
							<div class="product--name mb-3 _c287e"></div>
							<div class="product--price mb-3 _c287e"></div>
							<div class="shop--name mb-3 _c287e"></div>
							<div class="star--rate _c287e"></div>
						</div>
					</div>';
			}

		$html .= '</div>';

		return $html;
	}

}

if (!function_exists('table_loader')) {
    function table_loader($col)
    {
        return '<tr>
                    <td colspan="'.$col.'" class="text-center"><img src="'.base_url().'assets/img/default/loader.gif" alt="" style="width: 40px"></td>
                </tr>';
    }
}

if (!function_exists('loader')) {
    function loader($class = '')
    {
        return '<div class="d-flex justify-content-center '.$class.' loader-helper">
                    <div class="text-center mx-auto"><img src="'.base_url().'assets/img/default/loader.gif" alt="" style="width: 40px"></div>
                </div>';
    }
}

if (!function_exists('page_loader')) {
    function page_loader()
    {
        return '<div class="container d-flex justify-content-center" style="min-height: 70vh">
					<div class="text-center">
						<div class="jpmall-loader"></div>
					</div>
				</div>';
    }
}

if (!function_exists('lock_screen')) {
    function lock_screen($message,$btn_title,$link)
    {
        return '<div class="lock-screen active position-absolute">
                    <div class="lock-screen-inner text-center">
                        <div class="lock-icon my-3">
                            <i class="fad fa-lock-alt fs-50 text-warning"></i>
                        </div>
                        <div class="lock-content">
                            <p class="fs-14">
                                '.$message.'
                            </p>
                            <a href="'.$link.'" class="btn btn-outline-success text-white">'.$btn_title.'</a>
                        </div>
                    </div>
                </div>';
    }
}