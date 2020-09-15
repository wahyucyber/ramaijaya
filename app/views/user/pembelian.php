<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb ">
			    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian'); ?>">Pembelian</a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-12">
		    <div class="msg--content"></div>
			<div class="mb-4" align="right">
				<button class="btn btn-default btn-sm alamat--reload"><i class="fa fa-sync"></i></button>
			</div>
			<div class="mb-3">
				<button type="button" class="btn btn-success btn--tab" data-tab="pembelian">Pembelian</button>
				<button type="button" class="btn btn-secondary btn--tab" data-tab="tagihan">Tagihan</button>
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-condensed table-bordered table--pembelian" style="width: 100%;">
					<thead class="bg-primary text-white">
						<tr>
							<th width="10px">No.</th>
							<th width="180px">No. Invoice</th>
							<th>Detail</th>
							<th width="30px">#</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="payment-manual">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>