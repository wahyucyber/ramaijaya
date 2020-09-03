<section class="backend-settings">
	<?php include 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">
		
		<div class="clearfix">
			<div class="float-left">
				<h4>Slider</h4>
			</div>
			<div class="float-right">
				<button class="btn btn-light btn-sm" onclick="slider.run()"><i class="fad fa-sync"></i> </button>
				<button class="btn btn-success btn-s" onclick="slider.ModalAddDraw()"><i class="fa fa-plus-circle"></i> Tambah</button>
			</div>
		</div>
		<hr>
		<div class="msg-content"></div>
		<div class="slide-dekstop" id="slider-content">
			<?= loader(); ?>
		</div>
    <div id="pagination"></div>
		
	</div>
</section>

<!-- modal plus -->
<div class="modal fade" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Slide</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	<div class="msg-content"></div>
        <div class="form-group">
        	<div class="modal-slider-img mb-3">
        		<img src="<?= base_url(); ?>cdn/default/slider.jpg" alt="">
        	</div>
        	<small class="text-muted d-block mb-3"><span class="text-danger">*</span> Note: <i>Gunakan gambar berukuran minimal 1336px x 494px dengan format .png</i></small>
        	<button class="btn btn-secondary btn-sm browse-img" type="button"><i class="fa fa-file-image"></i> Browse</button>
        	<input type="file" class="d-none file-banner" data-base64="" hidden>
        </div>
        <div class="form-group">
        	<label for="">Judul</label>
        	<input type="text" class="form-control title" placeholder="Title">
        </div>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="show" value="1" checked>
            <label class="custom-control-label" for="show">Tampilkan Di Halaman Utama</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Iya</button>
      </div>
    </div>
  </div>
</div>