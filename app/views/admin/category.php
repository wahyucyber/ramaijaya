<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page" id="content-right">
		
		<div class="row mb-3">
			<div class="col-md-6">
				<h4>Kategori</h4>
			</div>
			<div class="col-md-6 text-right">
				<button class="btn btn-light btn-sm" onclick="category.run()"><i class="fa fa-sync"></i> </button>
				<button class="btn btn-success btn-sm" onclick="category.ModalAddDraw()"><i class="fa fa-plus-circle"></i> Tambah</button>
			</div>
		</div>
    <hr>
		<div class="msg-content"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-borderless table-striped tabel-category" style="width: 100%;">
						<thead class="bg-primary text-white">
							<tr>
								<th width="30">No</th>
								<th>Nama Kategori</th>
								<th>Induk Kategori</th>
                <th>Urutan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	<div class="msg-content"></div>
      	<div class="form-group">
      		<small>Nama Kategori</small>
      		<input type="text" class="form-control nama" placeholder="Masukkan nama kategori">
      	</div>
        <div class="form-group">
          <small>Induk Kategori</small>
          <select class="form-control kategori select2" data-placeholder="Pilih sub kategori">
            <option value=""></option>
          </select>
        </div>
        <div class="form-group">
          <small>Icon</small>
          <div class="d-flex align-items-center">
            <div class="modal-sub-icon">
              <img src="<?= base_url(); ?>assets/images/kategori/pendamping.png" alt="">
            </div>
              <button class="btn btn-secondary btn-sm browse-img" type="button"><i class="fa fa-file-image"></i> Browse</button>
              <input type="file" class="d-none file-icon" data-base64="" hidden>
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

<div class="modal fade" id="ModalConfirm" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Iya</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>