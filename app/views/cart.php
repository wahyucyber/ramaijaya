<section class="cart">	
	<div class="cart-inner">
		<div class="cart-content">
			<div class="column col-first card shadow border-0">
				<div class="cart-header card-header bg-orange">
					<div class="column p-0">
						<div class="custom-control custom-checkbox text-white">
						  <input type="checkbox" class="custom-control-input" id="checkAll">
						  <label class="custom-control-label" for="checkAll">Pilih Semua Produk</label>
						</div>
					</div>
					<div class="column p-0 text-right">
						<a href="javascript:;" class="text-link text-muted-fs-12 hapus--all text-white" data-toggle="modal" data-target="#konfirmasi-semua"><i class="fal fa-trash-alt"></i>	Hapus</a>
					</div>
				</div>
				<div class="cart-list-item card-body" id="contentCart">
					<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
					
				</div>
			</div>
			<div class="column">
				<div class="summary card  shadow border-0">
					<div class="title border-bottom pb-3 card-header text-center">
						<h6 class="fs-18 font-weight-bold text-orange"><i class="fal fa-info"></i>	Ringkasan Belanja</h6>
					</div>
					<div class="detail d-flex border-bottom pb-3 card-body">
						<div class="dt-label w-50">Total Harga</div>
						<div class="dt-value w-50 text-right" id="grand-total-product">Rp 0</div>
					</div>
					<div class="btn-checkout">
						<button class="btn btn-orange btn-block text-white lanjut--kepembayaran"><i class="fal fa-check-circle"></i>	Checkout</button>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="jumbotron cart-empty text-center bg-white shadow">
			<img src="https://ecs7.tokopedia.net/img/new-checkout/ic_empty.svg" alt="" width="300" class="mb-4">
			<h2 class="fs-20 text-muted mb-4">Keranjang Belanja Kosong</h2>
			<a href="<?= base_url(); ?>" class="btn btn-primary">Belanja Sekarang</a>
		</div> -->
	</div>
</section>
<!-- <section class="product">
	<div class="inner">
		<span class="title">Rekomendasi Untuk Anda</span>
		<div class="product-content" id="product-content">
			<a href="<?= base_url(); ?>product" class="card product-item h-100">
				<div class="card-header head">
					<img src="http://jpstore.online/files/product/2019/buku-nonteks-sd-panduan-praktis-pengembangan-karakter-dan-budaya-bangsa.jpg">
					<button class="wishlist btn badge badge-light fs-16" id="btn-wishlist" data-render="122,n"><i class="fa fa-heart"></i></button>
					<span class="preorder badge badge-light"><i class="fa fa-bullhorn"></i></span>
					<span class="free-ongkir badge badge-success">Gratis Ongkir</span>
				</div>
				<div class="card-body body">
					<div class="small">Panduan Praktis Pengembangan Karakter</div>
					<div class="price-product">
						<div class="price">Rp 39.500</div>
					</div>
					<div class="dtl">
						<span class="fa fa-sm fa-calendar-check"></span>
						<div class="dtl-product">
							<span class="dtl-item">Kota Gresik</span>
							<span class="dtl-item">JPMall</span>
						</div>
					</div>
					<div class="star_rate">
						<i class="product-rating _5-star"></i>
						<span class="counter">(3)</span>
					</div>
					<button class="btn btn-sm btn-block btn-outline-primary mt-1 p-1" id="add-to-cart" data-id="">Tambahkan Ke Keranjang</button>
				</div>
			</a>
		</div>
	</div>
</section> -->

<div class="modal fade" id="konfirmasi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-orange text-white">
				<h5 class="modal-title"><i class="fal fa-exclamation-triangle"></i>	Konfirmasi</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<input type="hidden" name="" class="produk-id">
					Apakah anda yakin ingin menghapus produk <b class="nama-produk"></b>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
				<button type="button" class="btn btn-warning btn-hapus"><i class="fal fa-check-circle"></i>	Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="konfirmasi-semua">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-orange text-white">
				<h5 class="modal-title"><i class="fal fa-exclamation-triangle"></i>	Konfirmasi</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					Apakah anda yakin ingin menghapus produk yang terpilih ?
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
				<button type="button" class="btn btn-warning btn-hapus-semua"><i class="fal fa-check-circle"></i>	Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="payment none">
	<div class="payment-header">
		<div align="left">
			<h3>
				Pembayaran
			</h3>
		</div>
		<div align="right" style="margin-top: -30px;">
			<button type="button" class="btn btn-danger btn-sm btn--batal">Batal</button>
		</div>
		<hr>
	</div>
	<div class="payment-body">
		<div class="container">
			<div class="row">
				<div class="col-md-9 get-payment mt-2">
				</div>
				<div class="col-md-3 mt-2">
					<div class="card card-info-payment">
						<div class="card-header">
							Info Pembayaran
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-info-payment">
									<div class="pull-left">Jumlah</div>
									<div class="pull-right payment--total">Rp. 0</div>
								</div>
								<div class="col-md-12 text-info-payment">
									<div class="pull-left">Ongkir</div>
									<div class="pull-right payment--ongkir">Rp. 0</div>
								</div>
								<div class="col-md-12 text-info-payment">
									<div class="pull-left">Biaya Admin</div>
									<div class="pull-right">Rp. 4.000</div>
								</div>
								<div class="col-md-12 text-info-payment-total">
									<div class="pull-left">Total Bayar</div>
									<div class="pull-right payment--bayar">Rp. 0</div>
								</div>
								<div class="col-md-12 text-info-payment">
									<button type="button" class="btn btn-info btn-sm btn-block payment--beli"><i class="fa fa-credit-card"></i> Bayar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9 mb-4">
					<div class="card card-metode-pembayaran">
						<div class="card-header"><i class="fa fa-credit-card"></i> Metode Pembayaran</div>
						<div class="card-body">
							<div class="row payment--metode-pembayaran">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add--alamat-pengiriman">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form--add-alamat">
			<div class="modal-header">
				Tambah
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Nama <span class="required">*</span></label>
							<input type="text" name="" id="" class="form-control alamat--nama" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Nama Penerima <span class="required">*</span></label>
							<input type="text" name="" id="" class="form-control alamat--nama-penerima" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">No. Telepon Penerima <span class="required">*</span></label>
							<input type="number" name="" id="" class="form-control alamat--telepon-penerima" maxlength="13">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Provinsi <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--provinsi select2">
								<option value="">-Pilih Provinsi-</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Kabupaten/Kota <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--kabupaten select2">
								<option value="">-Pilih Kabupaten/Kota-</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Kecamatan <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--kecamatan select2">
								<option value="">-Pilih Kecamatan-</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Alamat <span class="required">*</span></label>
							<textarea name="" id="" rows="4" class="form-control alamat--alamat" style="resize:" none=""></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>