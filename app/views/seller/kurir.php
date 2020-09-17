<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">

		<div class="row">
			
			<div class="col-md-12">
				<h4 class="fs-24">Kurir</h4>
				<hr>
			</div>

			<div class="col-md-12 mb-2" align="right">
				<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Kurir</button>
				<button class="btn btn-warning btn-sm btn-refresh"><i class="fal fa-retweet"></i> Refresh</button>
			</div>

			<div class="col-md-12 list--kurir">
				<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
			</div>

		</div>
	
	</div>

</section>

<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-orange text-white">
				<h5>Tambah Kurir</h5>
			</div>
			<form class="add">
				<div class="modal-body">
					<select name="" id="" class="form-control add--kurir select2">
						<option value="">-Pilih Kurir-</option>
						<option value="jnt">J&T</option>
						<option value="jne">JNE</option>
						<option value="tiki">TIKI</option>
						<option value="pos">POS</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fal fa-save"></i>	Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				<h5>Konfirmasi</h5>
			</div>
			<div class="modal-body">
				<p class="alert alert-warning">
					Apakah anda yaking ingin menghapus kurir <b class="nama--kurir">Nama Kurir ?</b>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="code">
				<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
				<button type="button" class="btn btn-danger btn-sm ya--hapus"><i class="fal fa-check-circle"></i>	Ya</button>
			</div>
		</div>
	</div>
</div>