<div class="container card">
	<div class="row mb-3 card-header bg-orange text-white">
		<div class="col-6 pl-0">
			<h3>
				<i class="fal fa-bullhorn"></i> Checkout
			</h3>
		</div>
		<div class="col-6 mb-2 pr-0" align="right">
			<a href="<?php echo base_url('cart'); ?>" class="btn btn-light btn-sm"><i class="fal fa-arrow-circle-left"></i> Kembali</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="payment-detail">
				<div class="grid mb-2 grid--alamat-pengiriman">
					<div class="payment-card">
						<div class="payment-title text-orange">
							<i class="fal fa-map-marker-alt"></i> Alamat Pengiriman
						</div>
						<div class="payment-body">
							<div class="row">
								<div class="col-md-10 alamat-selected">
									-
								</div>
								<div class="col-md-2" align="right">
									<button class="btn btn-orange btn-sm ubah--alamat-pengiriman"><i class="fal fa-edit"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="grid mb-2 grid--alamat-pengiriman-add" style="display: none;">
					<div class="payment-card">
						<div class="payment-title">
							<div class="row">
								<div class="col-md-6 text-orange">
									<i class="fal fa-map-marker-alt"></i> Alamat Pengiriman
								</div>
								<div class="col-md-6" align="right">
									<a href="javascript:;" data-toggle="modal" data-target="#add--alamat-pengiriman" class="text-orange"><i class="fal fa-plus"></i> Tambah alamat pengiriman</a>
								</div>
							</div>
						</div>
						<div class="payment-body">
						</div>
					</div>
				</div>
				<div class="check-out">
					<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="payment-detail">
				<div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title text-orange">
							<i class="fal fa-cart-arrow-down"></i><b> Sub. Total </b>
						</div>
						<div class="payment-body pesanan--sub-total">
							Rp. 0
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title text-orange">
							<!-- <i class="fal fa-cart-arrow-down"></i> PPN 10% -->
							<i class="fal fa-file-invoice-dollar"></i><b> PPN </b>
						</div>
						<div class="payment-body pesanan--ppn">
							Rp. 0
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title text-orange">
							<i class="fal fa-car-side"></i><b> Total Ongkir </b>
						</div>
						<div class="payment-body pesanan--total-ongkir">
							Rp. 0
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title text-orange">
							<i class="fal fa-bullhorn"></i><b> Biaya Penanganan </b>
						</div>
						<div class="payment-body" id="biaya--admin">
							Rp. 0
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title text-orange">
							<b><i class="fal fa-hands-helping"></i> Total Bayar</b>
						</div>
						<input type="hidden" name="" class="pesanan--total-bayar">
						<div class="payment-body pesanan--total-bayar">
							Rp. 0
						</div>
					</div>
				</div>
				<div class="grid">
					<div class="payment-card">
						<div class="payment-title text-orange">
							<i class="fal fa-credit-card"></i><b> Cara pembayaran</b>
						</div>
						<div class="payment-body">
							<div class="payment-metode active" data-payment="midtrans">Online</div>
							<div class="payment-metode" data-payment="manual">Manual</div>
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-orange btn-lg btn-block mt-2 pesanan--buat"><i class="fal fa-dolly-flatbed-alt"></i>	Buat Pesanan</button>
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
							<input type="text" name="" id="" placeholder="Rumah, Sekolah, Kantor, Dll." class="form-control alamat--nama" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Nama Penerima <span class="required">*</span></label>
							<input type="text" name="" placeholder="Andi" id="" class="form-control alamat--nama-penerima" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">No. Telepon Penerima <span class="required">*</span></label>
							<input type="number" name="" id="" placeholder="085******" class="form-control alamat--telepon-penerima" maxlength="13">
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

<div class="modal fade" id="kurir">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">Pilih Kurir</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Pilih Kurir</label>
							<input type="hidden" name="" class="pilih-kurir--toko-id">
							<input type="hidden" name="" class="pilih-kurir--asal-id">
							<input type="hidden" name="" class="pilih-kurir--tujuan-id">
							<input type="hidden" name="" class="pilih-kurir--berat">
							<select name="" id="" class="form-control select2 pilih--kurir">
								<option value=""></option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="payment-detail">
							<div class="grid">
								<div class="payment-card">
									<div class="payment-title">
										<div class="row">
											<div class="col-md-1">No.</div>
											<div class="col-md-3">Name</div>
											<div class="col-md-2">Service</div>
											<div class="col-md-2">ETD</div>
											<div class="col-md-2">Harga (Rp)</div>
											<div class="col-md-1" align="center">Aksi</div>
										</div>
									</div>
								</div>
							</div>
							<div class="kurir--list"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>