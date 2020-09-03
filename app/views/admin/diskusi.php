<section class="backend-settings">
	<?php include 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-24 mb-3">Diskusi Produk</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-default btn-sm btn-refresh" title="segarkan" onclick="diskusi.load()"><i class="fa fa-retweet"></i></button>
			</div>
		</div>
		
		<div class="top-reviews">
			<div class="top-reviews-list">
				<ul class="list-box diskusi--list">
				</ul>
				<div id="Pagination" class="text-center"></div>
			</div>					
		</div>
	</div>
</section>

<div class="modal fade" id="ModalBlokir">
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
      	<div class="msg-content"></div>
      	<div class="form-group">
      		<small>Catatan <small class="text-danger">*</small></small>
      		<input type="text" class="form-control catatan" placeholder="Masukkan catatan...">
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

<div class="modal fade" id="ModalOpenBlokir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form action="">
      <div class="modal-body">
      	<div class="alert alert-warning">Apakah anda yakin ingin membuka blokir komentar ini?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Iya</button>
      </div>
      </form>
    </div>
  </div>
</div>