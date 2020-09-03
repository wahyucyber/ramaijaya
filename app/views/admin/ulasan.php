<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-24 mb-3">Daftar Ulasan</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-default btn-sm btn-refresh" title="segarkan" onclick="ulasan.load()"><i class="fa fa-retweet"></i></button>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped" id="data-ulasan">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Detail Produk</th>
								<th>Nama pengguna</th>
								<th>Rating</th>
								<th>Ulasan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>
