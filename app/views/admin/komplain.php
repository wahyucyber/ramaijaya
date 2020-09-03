<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-24 mb-3">Daftar Komplain</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-default btn-sm btn-refresh" title="segarkan" onclick="komplain.load()"><i class="fa fa-retweet"></i></button>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped" id="data-komplain">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>No Invoice</th>
								<th>Tanggal</th>
								<th>Nama Toko</th>
								<th>Nama Produk</th>
								<th>Nama</th>
								<th>Komplain</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>