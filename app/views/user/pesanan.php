<div class="container">

	<div class="card my-3 border-0 shadow">
		<div class="card-body">
			<div class="reviews-filter">
				<div class="row">
					<div class="col-md-1 pr-0 d-flex align-items-center">
						<h6 class="fs-15">Status</h6>
					</div>
					<div class="col-md-11" style="overflow-x: auto;overflow-y: hidden;padding: .5rem 0;">
						<ul class="btn_list-filter mb-0 order--status--filter">
							<li><button class="btn fs-13 btn_filter" data-status="all">Semua Pesanan</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="belum-dibayar">Menunggu Dibayar</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="1">Menunggu Diproses</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="2">Diproses</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="3">Dikirim</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="4">Pesanan Selesai</button></li>
							<li><button class="btn fs-13 btn_filter" data-status="dibatalkan">Pesanan Dibatalkan</button></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- <div class="row fs-13">
				<div class="col-md-4 mb-3">
					<div class="input-group">
						<input type="text" class="form-control fs-13" placeholder="Cari nama produk atau invoice">
						<div class="input-group-append">
							<button class="input-group-text"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
				<div class="col-md-1 mb-3 d-flex align-items-center">
					<button class="btn text-primary fs-13 w-100 p-0" type="reset">Reset</button>
				</div>
			</div> -->
		</div>
		<div class="card-body">

			<div class="order--list" id="order--list">
				<div class="card">
					<div class="card-body d-flex align-items-center justify-content-center">
						<div class="order-empty text-center">
							<img src="https://ecs7.tokopedia.net/assets-frontend-resolution/production/media/ic-laporkan-masalah-copy-5@2x.14ca80fb.png" class="w-25">
							<h6 class="mt-3 fw-600">Belum Ada Pesanan</h6>
							<small>Anda tidak memiliki pesanan</small>
						</div>
					</div>
				</div>
			</div>
			<div id="Pagination" class="text-center"></div>
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