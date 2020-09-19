
<div class="card-body">
	<!-- <div class="card-body border-0 shadow-sm mb-3 d-flex align-items-center justify-content-between">
		<div class="col-auto">
			<h4 class="fs-14">Status Keanggotaan</h4>
			<h2 class="fs-16">Regular Merchant</h2>
		</div>
		<div class="float-right">
			<span class="fs-12 text-muted mr-2">Power Merchant sekarang bebas biaya bulanan</span> 
			<button class="btn btn-success btn-sm">Upgrade jadi Power Merchant</button>
		</div>
	</div> -->
	<!-- <div class="msg-div-shop-info"></div> -->
    <form class="update-profil-toko">
    	<div class="form-group row">
    		<h4 class="col-md-3 fs-14 fw-bold">Nama Toko</h4>
            <div class="col-md-9">
              <input type="text" class="form-control nama_toko" value="" placeholder="Masukkan Nama Toko">
            </div>
        </div>
        <div class="form-group row">
        	<h4 class="col-md-3 fs-14 fw-bold">Slogan</h4>
            <div class="col-md-9">
              <input type="text" class="form-control slogan input--length" value="" placeholder="Masukkan Slogan" maxlength="47">
            </div>
        </div>
        <div class="form-group row">
        	<h4 class="col-md-3 fs-14 fw-bold">Deskripsi</h4>
            <div class="col-md-9">
              <textarea rows="3" class="form-control deskripsi input--length ckeditor" id="ckeditor" placeholder="Masukkan deskripsi toko" maxlength="140"></textarea>
            </div>
        </div>
        <div class="form-group row">
        	<h4 class="col-md-3 fs-14 fw-bold">Bank</h4>
            <div class="col-md-9">
            	<input type="text" name="" id="" class="form-control bank input--length" placeholder="Nama bank rekening anda">
            </div>
        </div>
        <div class="form-group row">
            <h4 class="col-md-3 fs-14 fw-bold">Atasnama</h4>
            <div class="col-md-9">
                <input type="text" name="" id="" class="form-control atasnama input--length" placeholder="Atasnama rekening anda">
            </div>
        </div>
        <div class="form-group row">
        	<h4 class="col-md-3 fs-14 fw-bold">No. Rekening</h4>
            <div class="col-md-9">
            	<input type="text" name="" id="" class="form-control no-rekening input--length" placeholder="No. Rekening anda">
            </div>
        </div>

        <div class="form-group row mb-5">
        	<h4 class="col-md-3 fs-14 fw-bold"></h4>
            <div class="col-md-9">
              <button type="submit" class="btn btn-success btn-sm"><i class="fal fa-save"></i>  Simpan</button>
            </div>
        </div>
    </form>
    
    <div class="form-group row mb-4">
        <h4 class="col-md-3 fs-14 fw-bold">Status Toko</h4>
        <div class="col-md-9 shop-status">
          	
        </div>
    </div>
    <div class="form-group">
    	<h4 class="fs-14 fw-bold mb-3">Logo Toko</h4>
		<div class="header-shop d-flex">
			<div class="logo">
				<img src="">
				<input type="file" class="data-logo" hidden>
			</div>
			<div class="ml-3 fs-14">
				<p class="text-muted">Besar file: maksimum 10.000.000 bytes (10 Megabytes)<br>Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</p>
				<button class="btn border btn-sm btn-default browse-logo">Pilih Foto</button>
			</div>
		</div>
    </div>
    <div class="form-group">
    	<h4 class="fs-14 fw-bold">Sampul Toko</h4>
		<div class="text-muted mb-2 fs-14">
			<p>
				Jadikan halaman toko Anda lebih menarik dengan menambahkan sampul toko.
			</p>
		</div>
		<!-- <div class="header-shop">
			<div class="banner">
				<?php echo lock_screen('
					Sampul toko membuat toko Anda lebih menarik. Upgrade toko Anda menjadi <a href="" class="text-warning">Power Merchant</a> untuk mendapatkan akses sampul toko.
                    ','Upgrade ke Power Merchant',base_url('seller/power-merchant')); ?>
				<img src="">
				<button class="btn btn-browse browse-banner"><i class="fa fa-image"></i> Ganti</button>
				<input type="file" class="data-banner" hidden>
			</div>
		</div> -->
        <div class="header-shop">
            <div class="banner">
                <img src="">
                <button class="btn btn-browse browse-banner"><i class="fa fa-image"></i> Ganti</button>
                <input type="file" id="file-banner" class="data-banner" hidden>
            </div>
        </div>
    </div>
</div>