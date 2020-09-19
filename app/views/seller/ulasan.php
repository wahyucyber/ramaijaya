<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-18 badge badge-success bg-orange mb-3"><i class="fal fa-file-alt"></i>	Daftar Ulasan</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-warning btn-sm btn-refresh" title="segarkan" onclick="ulasan.load()"><i class="fa fa-retweet"></i>	Refresh</button>
			</div>
		</div>
		<div class="card shadow ">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table " id="data-ulasan">
						<thead class="bg-orange text-white fs-14">
							<tr>
								<th style="width: 5%;">No</th>
								<th style="width: 15%;">Pengguna</th>
								<th style="width: 35%;">Produk</th>
								<th style="width: 10%;">Rating</th>
								<th style="width: 30%;">Ulasan</th>
								<th style="width: 5%;">Aksi</th>
							</tr>
						</thead>
						<tbody class="fs-14"></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>
