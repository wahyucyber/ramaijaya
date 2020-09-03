<div class="card-body">
	<div class="row mb-3">
		<div class="col-4">
			<h6 class="mb-2">Catatan Toko</h6>
			<small>Lihat Catatan Toko di <a href="" class="link--toko">Halaman toko</a></small>
		</div>
		<div class="col-8 text-left text-lg-right">
			<button class="btn btn-sm btn-info" onclick="catatan.ModalAdd()"><i class="fas fa-plus"></i> Tambah catatan</button>
		</div>
	</div>
	<div class="msg--content"></div>   
	<div id="data--catatan" class="mb-3">
		<!-- <div class="jumbotron jumbotron-fluid text-center rounded">
			<h5>Anda tidak memiliki catatan toko</h5>
			<p>Tambahkan kebijakan serta syarat & ketentuan toko anda pada catatan toko di halaman toko anda</p>
			<button class="btn btn-sm btn-info" onclick="catatan.ModalAdd()"><i class="fas fa-plus"></i> Tambah catatan</button>
		</div> -->
		<!--<div class="card">-->
		<!--	<div class="card-header">-->
		<!--		<h5 class="fs-16 mb-0">Judul Catatan</h5>-->
		<!--	</div>-->
		<!--	<div class="catatan--list">-->
		<!--		<div class="card-body d-flex">-->
		<!--			<h6 class="fs-13">Tes</h6>-->
		<!--			<div class="ml-auto">-->
		<!--				<button class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Preview</button>-->
		<!--				<button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Ubah</button>-->
		<!--				<button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> Hapus</button>-->
		<!--			</div>-->
		<!--		</div>-->
		<!--	</div>-->
		<!--</div>-->
	</div>
	<div id="pagination"></div>
</div>

<div class="modal fade" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
	      <div class="modal-body">
	          <div class="msg--modal"></div>
			<div class="form-group">
				<small>Judul</small>
				<input type="text" class="form-control judul" placeholder="Masukkan judul">
			</div>
			<div class="form-group">
				<small>Keterangan</small>
				<textarea rows="2" class="form-control teks" placeholder="Masukkan keterangan"></textarea>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	        <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalPreview">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="card-body bg-light judul fw-bold">
			
		</div>
		<div class="card-body teks"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form action="">
	      <div class="modal-body">
			<div class="alert alert-warning">
				Apakah anda yakin ingin menghapus data ini?
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	        <button type="submit" class="btn btn-danger">Iya</button>
	      </div>
      </form>
    </div>
  </div>
</div>