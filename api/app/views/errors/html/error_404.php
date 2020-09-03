
<?php 
	
	function error_url($url = '')
	{
		$base = str_replace("/$_SERVER[CI_API]",'',config_item('base_url'));
		return $base.$url;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <meta name="theme-color" content="#007bff">
	<title>404 - Halaman tidak ditemukan</title>
	<link rel="shortcut icon" href="<?= error_url(); ?>cdn/fav.png">

	<link rel="stylesheet" href="<?= error_url('assets/ext/fontawesome/css/all.min.css'); ?>">

	<link rel="stylesheet" href="<?= error_url('assets/ext/bootstrap/css/bootstrap.min.css'); ?>">

	<link rel="stylesheet" href="<?= error_url('assets/css/bundle.css'); ?>">

</head>
<body>

	<div class="working-page on">
		<div class="inner">
			<div class="content">
				<div class="logo">
					<img src="<?= error_url(); ?>assets/img/default/il-error-not-found.png" alt="">
				</div>
				<h4 class="heading">404 Halaman tidak ditemukan</h4>
				<div class="message">Halaman yang Anda minta tidak di temukan.</div>
				<a href="<?= error_url(); ?>" class="btn btn-sm"><i class="fad fa-home"></i> Ke Beranda</a>
			</div>
		</div>
	</div>

</body>	
</html>	