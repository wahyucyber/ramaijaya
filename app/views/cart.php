<section class="cart">	
	<div class="cart-inner">
		<div class="cart-content">
			<div class="column col-first">
				<div class="cart-header">
					<div class="column p-0">
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" id="checkAll">
						  <label class="custom-control-label" for="checkAll">Pilih Semua Produk</label>
						</div>
					</div>
					<div class="column p-0 text-right">
						<a href="javascript:;" class="text-link text-muted-fs-12 hapus--all" data-toggle="modal" data-target="#konfirmasi-semua">Hapus</a>
					</div>
				</div>
				<div class="cart-list-item" id="contentCart">
					<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
					<!-- <div class="cart-item">
						<div class="cart-store">
							<div class="column">
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="store">
								  <label class="custom-control-label" for="store"></label>
								</div>
							</div>
							<div class="column">
								<label for="store">
									<h6 class="m-0">JPMall</h6>
									<small class="fs-12 text-muted">Kota Gresik</small>
								</label>
							</div>
						</div>
						<div class="cart-product mb-3">
							<div class="column">
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="product">
								  <label class="custom-control-label" for="product"></label>
								</div>
							</div>
							<div class="column">
								<label for="product" class="row">
									<div class="column">
										<img src="http://jpstore.online/files/product/2019/buku-nonteks-smp-belajar-berbahagia.jpg" alt="">
									</div>
									<div class="column">
										<div class="product-name">
											<a href="<?= base_url(); ?>product" class="text-elipsis">Belajar Berbahagia</a>
										</div>
										<div>
											<div class="product-price">
												Rp 39.500
											</div>
										</div>
									</div>
								</label>
								<div class="note-for-seller _nfs mt-3">
									<div class="olc-wrapper fs-13">
										<div class="olc-text text-elipsis text-muted"></div>
										<span class="olc-handler curs-p ml-2 text-dominan">Ubah</span>
									</div>
									<div class="display-handler fs-12">
										<span class="curs-p ">Tulis Catatan Untuk Toko</span>
									</div>
									<div class="display-target">
										<div class="form-group">
											<div class="fs-12 mb-2 text-muted">Catatan Untuk Penjual (Opsional)</div>
											<textarea name="note" maxlength="144" id="note_23" rows="1" class="note-text"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="column d-flex text-right">
								<div class="wishlist-btn">
									<div class="cta-wishlist curs-p fs-23 text-white-lightern-3" data-product-id=""><span class="fa fa-heart"></span></div>
								</div>
								<div class="delete-btn">
									<div class="cta-delete curs-p fs-23 text-white-lightern-3" data-product-id=""><span class="fa fa-trash"></span></div>
								</div>
								<div class="qty-input">
									<div class="quantity-input">
										<div class="qty-min qty-btn disabled"></div>
										<input class="qty" min="1" name="quantity" value="1" type="number" style="width: 22px">
										<div class="qty-plus qty-btn"></div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
			<div class="column">
				<div class="summary card card-body shadow border-0">
					<div class="title border-bottom pb-3 mb-3">
						<h6 class="fs-18 font-weight-bold">Ringkasan Belanja</h6>
					</div>
					<div class="detail d-flex border-bottom pb-3 mb-3">
						<div class="dt-label w-50">Total Harga</div>
						<div class="dt-value w-50 text-right" id="grand-total-product">Rp 0</div>
					</div>
					<div class="btn-checkout">
						<!-- <div class="form-group">
							<select name="" id="" class="form-control select2 payment--alamat-pengiriman">
								<option value="">-Pilih Alamat Pengiriman-</option>
							</select>
							<div class="text-info" data-toggle="modal" data-target="#add--alamat-pengiriman" style="font-size: 13px; cursor: pointer; margin-top: 5px;">
								<i class="fa fa-plus"></i> Tambahkan alamat
							</div>
						</div> -->
						<button class="btn btn-info btn-block text-white lanjut--kepembayaran">Checkout</button>
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
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					<input type="hidden" name="" class="produk-id">
					Apakah anda yakin ingin menghapus produk <b class="nama-produk"></b>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-danger btn-hapus">Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="konfirmasi-semua">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin menghapus produk yang terpilih.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-danger btn-hapus-semua">Ya</button>
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