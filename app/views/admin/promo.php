<section class="backend-settings">
	<?php include 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">
		
		<div class="clearfix">
			<div class="float-left">
				<h4>Promo</h4>
			</div>
			<div class="float-right">
				<button class="btn btn-light btn-sm" onclick="promo.run()"><i class="fad fa-sync"></i> </button>
				<button class="btn btn-success btn-sm" onclick="promo.ModalDraw()"><i class="fa fa-plus-circle"></i> Tambah</button>
			</div>
		</div>
		<hr>
		<div class="msg-content"></div>
		<div class="promo--content">
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
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	<div class="msg-content"></div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
            	<small>Gambar promo</small>
              <img src="<?= base_url('assets/img/default/promo.jpg'); ?>" alt="" class="img--promo mb-3">
              <button class="btn btn-sm btn-secondary browse-img"><i class="fa fa-file-image"></i> Browse</button>
              <input type="file" class="data-base64" hidden>
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <small for="">Nama Promo</small>
              <input type="text" class="form-control nama" placeholder="Nama Promo">
            </div>
            <div class="form-group">
              <small for="">Kode Promo</small>
              <input type="text" class="form-control kode-promo" placeholder="Kode Promo">
              <div class="custom-control custom-checkbox mt-1">
                <input type="checkbox" class="custom-control-input" id="auto-generate" value="0">
                <label class="custom-control-label" for="auto-generate">Generate Otomatis</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <small for="">Potongan Promo</small>
                  <div class="input-group">
                    <input type="number" class="form-control potongan" value="0" min="0" max="99">
                    <div class="input-group-append">
                      <span class="input-group-text">%</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <small>Jangka Waktu</small>
                  <div class="input-group">
                    <input type="number" class="form-control jangka-waktu" value="1" min="1">
                    <div class="input-group-append">
                      <span class="input-group-text">Hari</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox mt-1">
                <input type="checkbox" class="custom-control-input" id="status--promo" value="1" checked>
                <label class="custom-control-label" for="status--promo">Aktifkan</label>
              </div>
            </div>
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