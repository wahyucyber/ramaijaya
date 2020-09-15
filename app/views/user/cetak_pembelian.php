<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb ">
			  <ol class="breadcrumb ">
			    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian'); ?>">Pembelian</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian/cetak/'.$no_transaksi); ?>">Cetak</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian/cetak/'.$no_transaksi); ?>"><?php echo $no_transaksi ?></a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-6" align="left">
			<u>Cetak Transaksi</u>
		</div>
		<div class="col-md-6" align="right">
			<a target="_blank" href="<?php echo base_url('user/pembelian/print/'.$no_invoice."/".$no_transaksi); ?>" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
			<a href="<?php echo base_url('user/pembelian/detail/'.$no_invoice); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
		</div>
		<div class="col-md-12 print-media cetak-pembelian mt-2" id="print-media">
		</div>
	</div>
</div>