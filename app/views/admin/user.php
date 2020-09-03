<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page" id="content-right">
		
		<div class="row mb-3">
			<div class="col-md-6">
				<h4>Menajemen Pengguna</h4>
			</div>
			<div class="col-md-6 text-right">
				<button class="btn btn-light" onclick="user.run()"><i class="fa fa-sync"></i></button>
				<button class="btn btn-success" onclick="user.ModalAddDraw()"><i class="fa fa-plus-circle"></i> Tambah</button>
			</div>
		</div>
		<div class="msg-content"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-borderless table-striped table-user" style="width: 100%;">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>
									Pengguna
								</th>
								<th>Email</th>
								<th>No Telepon</th>
								<th>Status</th>
								<th width="150px">Aksi</th>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Sub Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	<div class="msg-content"></div>
      	<div class="line-separtor">
			<span class="line-separator-text">Informasi Akun</span>
		</div>
		<div class="form-group">
			<label for="">Nama</label>
			<input type="text" class="form-control nama" placeholder="Masukkan Nama" value="">
		</div>
		<div class="form-group">
			<label for="">Email</label>
			<input type="email" class="form-control email" placeholder="Masukkan Email" value="">
		</div>
		<div class="form-group row">
			<div class="col-md-6 mb-3">
				<label for="">Password</label>
				<input type="password" class="form-control password" placeholder="Masukkan Password">
			</div>
			<div class="col-md-6">
				<label for="">Konfirmasi Password</label>
				<input type="password" class="form-control konfirmasi_password" placeholder="Konfirmasi Password">
			</div>
		</div>
		<div class="line-separtor">
			<span class="line-separator-text">Informasi Kontak</span>
		</div>
		<div class="form-group">
			<label for="">Domisili</label>
			<select class="form-control select2 provinsi" data-placeholder="Pilih Provinsi">
				<option value=""></option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control select2 kabupaten" data-placeholder="Pilih Kabupaten / Kota">
				<option value=""></option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control select2 kecamatan" data-placeholder="Pilih Kecamatan">
				<option value=""></option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Alamat Lengkap</label>
			<textarea rows="3" class="form-control alamat" placeholder="Alamat Lengkap"></textarea>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label for="">Kode Pos</label>
					<input type="number" class="form-control kode_pos" placeholder="Masukkan kodepos">
				</div>
				<div class="col-md-6">
					<label for="">Telepon</label>
					<input type="number" class="form-control telepon" placeholder="Masukkan Nomor Telepon" value="">
				</div>
			</div>
		</div>
		<div class="form-group col-md-4 p-0">
			<label for="">Role</label>
			<select class="form-control select2 rule" data-placeholder="Pilih Rule">
				<option value=""></option>
				<option value="1">Admin</option>
				<option value="2">Pengguna</option>
			</select>
		</div>
		<div class="form-group">
			<div class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input send-mail" id="send-mail" value="0">
			  <label class="custom-control-label" for="send-mail">Verifikasi</label>
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

<div class="modal fade" id="ModalDetail">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalReset">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <?= form_open(); ?>
      <div class="modal-body">
      	<div class="msg-content"></div>
      	<div class="form-group">
			<label for="">Password</label>
			<input type="password" class="form-control password" placeholder="Masukkan Password">
		</div>
		<div class="form-group">
			<label for="">Konfirmasi Password</label>
			<input type="password" class="form-control konfirmasi_password" placeholder="Konfirmasi Password">
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

<div class="modal fade" id="ModalBukaBlokir">
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
      	<div class="alert alert-warning">Apakah anda yakin ingin Membuka Blokir akun ini?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Iya</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalBlokir">
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
      	<div class="alert alert-warning">Apakah anda yakin ingin Memblokir akun ini?</div>
      	<div class="form-group">
      		<small class="text-danger">Catatan :</small>
      		<input type="text" class="form-control catatan" placeholder="Masukkan Catatan">
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Iya</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>