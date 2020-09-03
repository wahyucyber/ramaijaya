<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page" id="content-right">
		<div class="row mb-3">
			<div class="col-md-6">
				<h5>FAQ</h5>
			</div>
			<div class="col-md-6 text-right">
				<button class="btn btn-sm btn-success btn--add-menu" onclick="faq.menuAdd()"><i class="fal fa-plus"></i> Menu</button>
			</div>
		</div>
		<div class="card shadow">
			<div class="card-body bg-light">
				<nav class="nav nav-pills" id="menu--content">
				</nav>
			</div>
			<div class="card-body d-none">
				<div class="menu--active-action mb-3"></div>
				<div class="table-responsive">
					<table class="table table-striped" id="menu--detail">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Pertanyaan</th>
								<th>Jawaban</th>
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

<div class="modal fade" id="ModalMenu">
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
					<div class="form-group">
						<small>Nama Menu</small>
						<input type="text" class="form-control menu" placeholder="Masukkan nama menu">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Batal</button>
					<button type="submit" class="btn btn-sm btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalConfirmMenu">
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
					<div class="alert alert-warning">Apakah anda yakin ingin menghapus menu ini?</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Batal</button>
					<button type="submit" class="btn btn-sm btn-danger">Iya</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- detail -->

<div class="modal fade" id="ModalMenuDetail">
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
					<div class="form-group">
						<small>Pertanyaan</small>
						<input type="text" class="form-control pertanyaan" placeholder="Masukkan pertanyaan">
					</div>
					<div class="form-group">
						<small>Jawaban</small>
						<textarea rows="3" class="form-control jawaban" placeholder="Masukkan jawaban dari pertanyaan diatas"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Batal</button>
					<button type="submit" class="btn btn-sm btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalConfirmMenuDetail">
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
					<div class="alert alert-warning">Apakah anda yakin ingin menghapus pertanyaan ini?</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">Batal</button>
					<button type="submit" class="btn btn-sm btn-danger">Iya</button>
				</div>
			</form>
		</div>
	</div>
</div>