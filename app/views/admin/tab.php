<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Tab
			</div>

			<div class="col-md-6" align="right">
				<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tab-add"><i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-sm btn-default tab--reload"><i class="fa fa-sync"></i></button>
			</div>

		</div>
		<hr>

		<div class="row">
			<div class="col-md-12 tab--list">
				<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="tab-add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Tambah Tab
			</div>
			<form class="tab-add">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Nama</label>
								<input type="text" name="" maxlength="50" id="" class="form-control nama">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="tab-update">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Edit Tab
			</div>
			<form class="tab-update">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Nama</label>
								<input type="text" name="" maxlength="50" id="" class="form-control nama">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="" class="tab-id">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="tab-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<form class="tab-delete">
				<div class="modal-body">
					<p>
						Apakah anda yakin ingin menghapus tab <b class="nama-tab"></b>? <br>
						<span style="font-size: 13px; color: grey;">Jika anda menghapus tab ini maka seluruh content yang ada di tab ini akan terhapus.</span>
					</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="" class="tab-id">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
					<button type="submit" class="btn btn-danger btn-sm">Ya</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="tab-content-add">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Tambah tab content
			</div>
			<form class="tab-content-add">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Title</label>
								<input type="text" name="" id="" class="form-control title" maxlength="100">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea name="" id="ckeditor" class="form-control content ckeditor"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="" class="tab-id">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="tab-content-update">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Edit tab content
			</div>
			<form class="tab-content-update">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Title</label>
								<input type="text" name="" id="" class="form-control title" maxlength="100">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<textarea name="" id="content" class="form-control content"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="" class="tab-id">
					<input type="hidden" name="" class="tab-content-id">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="tab-content-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<form class="tab-content-delete">
				<div class="modal-body">
					<p>
						Apakah anda yakin ingin menghapus content <b class="nama"></b>?
					</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="" class="tab-id">
					<input type="hidden" name="" class="tab-content-id">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
					<button type="submit" class="btn btn-danger btn-sm">Ya</button>
				</div>
			</form>
		</div>
	</div>
</div>