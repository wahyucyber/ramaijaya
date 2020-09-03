<div class="container people-single-page">
  <div class="msg-content"></div>
  <div class="row">
    <div class="col-md-12">
      <?= page_loader(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeEmail" tabindex="-1" role="dialog" aria-labelledby="modalChangeEmailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-light">
        <h5 class="modal-title">Ganti Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-light">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<small>Email</small>
			<input type="email" class="form-control material-form" placeholder="Masukkan email baru">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Kirim <i class="fa fa-paper-plane"></i></button>
      </div>
    </div>
  </div>
</div>