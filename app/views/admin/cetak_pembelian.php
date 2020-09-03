<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page" id="content-right">

		<div class="row">
			<div class="col-md-6" align="left">
				<u>Cetak Transaksi</u>
			</div>
			<div class="col-md-6" align="right">
				<a target="_blank" href="<?php echo base_url('admin/transaction/print/'.$no_invoice."/".$user_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
				<a href="<?php echo base_url('admin/transaction/detail/'.$no_invoice."/".$user_id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
			</div>
			<div class="col-md-12 print-media cetak-pembelian mt-2" id="print-media">
			</div>
		</div>
		
	</div>
</section>