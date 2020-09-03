<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Transaksi Refund
			</div>

			<div class="col-md-6" align="right">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filter"><i class="fa fa-filter"></i></button>
				<button type="button" class="btn btn-sm btn-default transaksi--reload"><i class="fa fa-sync"></i></button>
			</div>

		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-striped tabel-condensed table-bordered data--transaksi-refund">
						<thead class="bg-primary text-white">
							<tr>
								<th>No.</th>
								<th>No. Transaksi</th>
								<th>User</th>
								<th>Total</th>
								<th>Status</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="filter">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Filter
			</div>
			<form class="filter">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Status</label>
								<select name="" id="" class="form-control status select2">
									<option value=""></option>
									<option value="1">Ditransfer</option>
									<option value="0">Belum ditransfer</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Filter</button>
				</div>
			</form>
		</div>
	</div>
</div>