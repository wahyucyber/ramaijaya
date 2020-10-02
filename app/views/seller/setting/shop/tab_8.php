<div class="card-body">
   <div class="row">
            
      <div class="col-md-6 mb-3">
         <h4 class="fs-18 badge badge-success bg-orange"><i class="fal fa-car-side "></i> Kurir</h4>
      </div>

      <div class="col-md-6 mb-3" align="right">
         <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Kurir</button>
         <button class="btn btn-warning btn-sm btn-refresh"><i class="fal fa-retweet"></i> Refresh</button>
      </div>

      <hr>

      <div class="col-md-12 list--kurir">
         <img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
      </div>

   </div>
	<ul class="list-group mt-3">
	  <li class="list-group-item bg-light">
	  	<div class="clearfix">
	  		<div class="float-left">
	  			<h6>
	  				<b>Balasan Ulasan Otomatis</b>
		  			
	  			</h6>
	  		</div>
	  		<div class="float-right">
	  			<a href="" class="card-link text-primary">Ubah Template</a>
	  		</div>
	  	</div>
	  </li>

	  <li class="list-group-item">
	  	<h6>
	  		<b>Template Balasan Otomatis</b>
	  		<span class="badge badge-warning">Balasan Otomatis</span>
	  	</h6>
	  	<small>Terima kasih telah berbelanja di Desa IT. Bagikan link toko kami https://www.tokopedia.com/desait kepada teman-teman Anda dan favoritkan Toko kami untuk terus update mengenai stok dan produk terbaru</small>
	  </li>
	
	</ul>
</div>

<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-orange text-white">
				<h5>Tambah Kurir</h5>
			</div>
			<form class="add">
				<div class="modal-body">
					<select name="" id="" class="form-control add--kurir select2">
						<option value="">-Pilih Kurir-</option>
						<option value="jnt">J&T</option>
						<option value="jne">JNE</option>
						<option value="tiki">TIKI</option>
						<option value="pos">POS</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fal fa-save"></i>	Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				<h5>Konfirmasi</h5>
			</div>
			<div class="modal-body">
				<p class="alert alert-warning">
					Apakah anda yaking ingin menghapus kurir <b class="nama--kurir">Nama Kurir ?</b>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="code">
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
				<button type="button" class="btn btn-danger btn-sm ya--hapus"><i class="fal fa-check-circle"></i>	Ya</button>
			</div>
		</div>
	</div>
</div>