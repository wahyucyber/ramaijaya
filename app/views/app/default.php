<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <meta name="theme-color" content="#007bff">
	<meta name="title" content="<?= $title; ?>">
	<meta name="app_name" content="Ramai Jaya">
	<title><?= env('APP_NAME'); ?></title>
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/img/logo/favicon.png">
	<meta property="og:url" content="<?= current_url(); ?>"/>
	<meta property="og:title" content="<?= $title == 'Beranda'? 'JPSTORE.ID' : $title ?>"/>
    <meta property="og:description" content="<?= isset($og_description)? ($og_description? $og_description : 'Deskripsi tidak tersedia') : env('APP_DESCRIPTION','PT.Nyata Grafika Media Surakarta') ?>"/>
    <meta property="og:image" content="<?= isset($og_image)? ($og_image? $og_image : base_url('fav.ico')) : base_url('fav.ico') ?>"/>
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="200" />
    <meta property="og:image:alt" content="<?= $title ?>" />
	 <meta name="google-signin-client_id" content="<?php echo env('GOOGLE_CLIENT_ID'); ?>">
	<script>
		$app_url = '<?= base_url(); ?>';
		$api_url = '<?= api_url(); ?>';
		$cdn_url = '<?= cdn_url(); ?>';
		$csrf = "<?= base64_encode(json_encode($this->Func->get_token())); ?>";
	</script>
	<?= stylesheet_url('https://fonts.googleapis.com/css2?family=Muli:wght@500&display=swap'); ?>
	<?= stylesheet([
		'ext/fontawesome/css/all.min.css',
		'ext/bootstrap/css/bootstrap.min.css',
		'ext/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css',
		'ext/DataTables/dataTables.min.css',
		'ext/DataTables/dist/css/dataTables.bootstrap4.min.css',
		'ext/jquery-ui/jquery-ui.min.css',
		'ext/datetimerangepicker/daterangepicker.css',
		'ext/select2/dist/css/select2.min.css',
		'ext/slick/slick-theme.css',
		'ext/slick/slick.css',
		'css/bundle.css',
		'css/seller-profil.css'
	]); ?>
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-classic.css" />
	<?= $default_css; ?>
	<!--Start of Tawk.to Script-->
	<!--<script type="text/javascript">-->
	<!--var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();-->
	<!--(function(){-->
	<!--var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];-->
	<!--s1.async=true;-->
	<!--s1.src='https://embed.tawk.to/5e68a6c6eec7650c331f6857/default';-->
	<!--s1.charset='UTF-8';-->
	<!--s1.setAttribute('crossorigin','*');-->
	<!--s0.parentNode.insertBefore(s1,s0);-->
	<!--})();-->
	<!--</script>-->
	<!--End of Tawk.to Script-->
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163329640-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-163329640-1');
    </script>
</head>
<body>
<div class="main-wrapper">
	<?php if (segment(1) == 'login' || segment(1) == 'register' || segment(1) == 'forgot'): ?>
		<?= $default_body; ?>
	<?php else: ?>
		<header class="navbar" id="navbar">
			<div class="sub-header">
				<div class="sub-header-inner">
					<div class="sub-header-left">
						<a href="#">Download Ramai Jaya App</a>
					</div>
					<div class="sub-header-right">
						<!-- <a href="https://siplah.jpstore.id" target="_blank">SIPLah <?= env('APP_NAME'); ?></a> -->
						<a href="<?= base_url('faq'); ?>">Pusat Bantuan</a>
					</div>
				</div>
			</div>
			<div class="navbar-inner">
				<div class="column">
					<a href="javascript:;" class="text-link navbar-toggle" id="sidebar-toggle">
						<span class="fal fa-bars"></span>
					</a>
					<!-- <a href="<?= base_url(); ?>" class="navbar-brand"><img src="<?= base_url('cdn/favicon_white.png'); ?>"></a> -->
					<a href="<?= base_url(); ?>" class="navbar-brand"><img src="<?= base_url('assets/img/logo/logo.png') ?>" alt=""></a>
					<div id="category--nav-list" class="d-inline-block"></div>

					<?php if (segment(1) !== 'seller' && segment(1) !== 'admin'): ?>
					<?php else : ?>
						<h5 class="d-inline-block fs-15 text-white fw-600 title--pages"><?= segment(1) == 'seller'? 'Penjual' : ''; ?><?= segment(1) == 'admin'? 'Administrator' : ''; ?></h5>
					<?php endif ?>
				</div>
				<div class="column" id="form-keyword">
					<?php if (segment(1) !== 'seller' && segment(1) !== 'admin'): ?>
					<form action="<?php echo base_url('search'); ?>" class="navbar-search nav--search search">
						<div class="navbar-search-back curs-p text-link text-white-lightern-3" id="hide-search-navbar"><i class="fa fa-angle-left fa-2x"></i></div>
						<div class="input-group">
							<input type="search" class="form-control" name="q" placeholder="Cari buku atau toko..." value="<?php echo urldecode($this->input->get('q')); ?>" id="navbar-search-input" autocomplete="off">
							<input type="hidden" name="st" value="<?php echo (!empty($this->input->get('st'))) ? $this->input->get('st'):"produk"; ?>">
							<input type="hidden" name="kategori" value="<?php echo $this->input->get('kategori') ?>">
							<input type="hidden" name="filter" value="<?php echo $this->input->get('filter'); ?>">
							<input type="hidden" name="page" class="page" value="<?php echo $this->input->get('page'); ?>">
							<div class="input-group-append">
								<button class="btn btn-warning text-white" type="submit" id="btn-search-query"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
					<div class="result-autocomplete" id="result-autocomplete"></div>
					<?php endif; ?>
				</div>
				<div class="column" id="navbar_right">
				    <?php if (segment(1) !== 'seller' && segment(1) !== 'admin'): ?>
					<a href="javascript:;" id="show-search-navbar" class="navbar-search-toggle text-link mr-2 icon--navbar-search"><span class="fa fa-search"></span></a>
					<?php endif ?>
					<div class="notif--user d-inline-block"></div>
					<div class="cart--user d-inline-block"></div>
					<hr class="divider">
					<div class="shop--user d-inline-block"></div>
					<div class="account--user d-inline-block"></div>
				</div>
			</div>
		</header>

		<div class="sidebar-sm" id="sidebar">
			<div class="sidebar-inner">
				<div class="d-flex sidebar-header">
					<div class="column">
						<img src="<?= base_url(); ?>cdn/favicon.png">
					</div>
					<div class="column text-right">
						<button class="btn btn-transparent" id="btn-close-sidebar"><span class="fal fa-times"></span></button>
					</div>
				</div>
				<ul class="list-group sidebar-content">
					<li class="list-sidebar-header"><i class="fa fa-list mr-2"></i> Kategori</li>
					<div id="sidebar--category-list">
					</div>
				</ul>
			</div>
		</div>
		<div class="backdrop-nav" id="backdrop"></div>
		<div class="backdrop-sidebar" id="backdrop-sidebar"></div>
		<!-- this is content -->
		<div class="content-wrapper">
			<div class="msg-page-content"></div>
			<?= $default_body; ?>
		<?php if (segment(1) != 'admin' && segment(1) != 'seller' && segment(1) !== 'chat' && segment(1) !== 'faq'): ?>
			<footer class="footer-wrapper">
				<div class="footer-header">
					<div class="footer-main">
						
					</div>
				</div>
				<div class="footer-additional">
					<div class="row justify-content-center text-center">
						<div class="span4 d-flex">
							<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="Logo">
							<div class="copy">
								<small class="text-muted">&copy; Ramai Jaya 2020, PT. Mascitra Teknologi Informasi.</small><br>
								<small class="text-muted">Server process time: {elapsed_time}</small>
							</div>
						</div>
					</div>
				</div>
			</footer>
		<?php endif ?>
		</div>
	<?php endif ?>
</div>
<?= $default_modal; ?>
<?php 
if (segment(1) == 'login' || segment(1) == 'register' || segment(1) == 'forgot') {
}else{
	include APPPATH . 'views/app_modal/index.php';
}
?>

<script src="https://unpkg.com/@popperjs/core@2"></script>

<?= script([
	// 'ext/jquery.min.js',
	'ext/jquery-3.4.0.min.js',
	'ext/jquery-ui/jquery-ui.min.js',
	'ext/bootstrap/js/bootstrap.min.js',
	'js/jquery.cookie.min.js',
	'ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
	'ext/select2/dist/js/select2.min.js',
	'ext/canvasResize/binaryajax.js',
	'ext/canvasResize/exif.js',
	'ext/canvasResize/jquery.exif.js',
	'ext/canvasResize/jquery.canvasResize.js',
	'ext/canvasResize/canvasResize.js',
	'ext/DataTables/dist/js/jquery.dataTables.min.js',
	'ext/DataTables/dist/js/dataTables.bootstrap4.js',
	'ext/ckeditor/ckeditor.js',
	'ext/slick/slick.min.js',
	'ext/chart/Chart.min.js',
	'ext/datetimerangepicker/moment.min.js',
	'ext/datetimerangepicker/daterangepicker.js',
	'js/bundle.js',
	'js/module.js'
]); ?>

<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v8.0" nonce="d2CkeC2i"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

<script type="text/javascript">
function init() {
	gapi.load('auth2', function() {
		gapi.auth2.init(
		{
			client_id: "<?php echo env('GOOGLE_CLIENT_ID'); ?>"
		});
	});
}

function Google_signIn(googleUser) {
	if (!check_auth()) {
		var profile = googleUser.getBasicProfile();

		var account = {
			'id': profile.getId(),
			'name': profile.getName(),
			'image_url': profile.getImageUrl(),
			'email': profile.getEmail()
		};

		callApi("auth/google", account, res => {
			if(res.Error){
				notif('#login-form .msg-content','danger',res.Message)
			}else {
				notif('#login-form .msg-content','success',res.Message)
				$('#login-form input').val('')
				var data = res.Data
				cookie.set(data)
				redirect('');
			}
		})
	}
}
</script>

<script>
function statusChangeCallback(response) {
    if (response.status === 'connected') {
      testAPI();  
    }
  }


  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo env('FACEBOOK_APP_ID'); ?>',
      cookie     : true,
      xfbml      : true,
      version    : '<?php echo env('FACEBOOK_API_VERSION'); ?>'
    });

	 FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  };
 
  function testAPI() {
	  if(!check_auth()) {
			FB.api('/me',{fields: 'first_name,last_name,name,id, email'},  function(response) {
				callApi("auth/facebook", response, res => {
					if(res.Error){
						notif('#login-form .msg-content','danger',res.Message)
					}else {
						notif('#login-form .msg-content','success',res.Message)
						$('#login-form input').val('')
						var data = res.Data
						cookie.set(data)
						redirect('');
					}
				})
			});
	  }
  }

</script>

<?php 
if (segment(1) == 'login' || segment(1) == 'register') {
}else{
	include VIEWPATH . '/app_js/index.php';
}
?>

<?= $default_js; ?>
</body>
</html>