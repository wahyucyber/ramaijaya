<section class="dashboard_store">
	<?php $this->load->view('seller/sidebar') ?>
	<div class="content-right" id="content-right">

		<div class="row">
			<div class="col-md-6" align="left">
				<u>Cetak Transaksi</u>
			</div>
			<div class="col-md-6" align="right">
				<a target="_blank" href="<?php echo base_url('seller/penjualan/print/'.$no_invoice."/".$no_transaksi."/".$user_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
				<a href="<?php echo base_url('seller/penjualan/detail/'.$no_transaksi); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
			</div>
			<div class="col-md-12 print-media cetak-pembelian mt-2" id="print-media">
			</div>
		</div>

	</div>
</section>