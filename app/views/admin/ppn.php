<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page" id="content-right">
		<div class="container">
			<div class="card border-0 shadow">
				<div class="card-body">
					<h4 class="mb-3">PPN</h4>
					<div id="ppn--content">
						<div class="alert alert-light text-center border">Memuat...</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</section>

<div class="modal fade" id="ModalSetAktif">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">	
      <div class="modal-body">
      	<div class="msg-content"></div>
      	<div class="form-group">
      		<small>PPN</small>
      		<input type="number" class="form-control ppn" placeholder="0">
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Aktifkan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalSetNonAktif">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>	
      <form action="">
      <div class="modal-body">
      	<div class="alert alert-warning">
			Apakah anda yakin ingin menonaktifkan PPN
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Nonaktifkan</button>
      </div>
      </form>
    </div>
  </div>
</div>