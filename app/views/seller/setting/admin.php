<section class="admin_store">
	<?php include __DIR__.'/../sidebar.php' ?>
	<div class="content-right" id="content-right">

		<div class="card-body border">
			<h6><b>Pengaturan Admin</b></h6>

			<!-- Tidak Ada Admin -->
			<div class="card-body border bg-light mt-3">
				<div class="card-none-admin mt-2 mb-2 text-center">
					<h6><b>Anda Belum Memiliki Admin</b></h6>
					<a href="<?php echo base_url() ?>seller/settings/add" class="btn btn-primary">Tambah Admin</a>
				</div>
			</div>

			<!-- ada admin -->
			<div class="card-body border bg-light mt-3">
				<div class="card-responsive">
					<table class="table">
					  <thead class="thead-light">
					    <tr>
					      <th scope="col">No.</th>
					      <th scope="col">Nama</th>
					      <th scope="col">Email</th>
					      <th scope="col">Aksi</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>1</td>
					      <td>Teguh Sugiarto</td>
					      <td>teguhsugiarto@gmail.com</td>
					      <td>
					      	<button class="btn btn-danger ml-1 " href="" data-toggle="modal" data-target="#trash"><i class="far fa-trash-alt"></i></button>
							<div class="modal fade" id="trash" tabindex="-1" role="dialog" aria-labelledby="trashLabel" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
							    <div class="modal-content">
							      <div class="modal-body text-center">
							      	<img src="https://png.pngtree.com/svg/20170706/3d9a32a59e.svg" class="w-25">
							      	<h5><b>Apakah Anda Yakin ??</b></h5>
							      	<p>Ingin Menghapus Produk Ini ?</p>
							      	<div class="btn-group mt-3">
								        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tidak</button>
								        <button type="button" class="btn btn-primary ml-2">Ya</button>
							      	</div>
							      </div>
							    </div>
							  </div>
							</div>

					      </td>
					    </tr>
					  </tbody>
					</table>
				</div>
			</div>

		</div>

	</div>
</section>