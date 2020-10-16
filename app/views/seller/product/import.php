<div class="container mb-5">
	<div class="pull-left mb-2">
		<a href="<?php echo base_url('seller/product'); ?>" class="btn btn-orange btn-sm"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
	</div>
	<h5>Import Produk</h5>
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning text-center">
				<a href="https://jpstore.id/cdn/Dokumen/Doc-20200418.xlsx" download="Import Product.xlsx">	Download</a> template import produk. <br>
				<a href="javascript:;" class="download-kategori-excel">Download</a> kategori excel. <br>
				<a href="javascript:;" class="download-etalase-excel">Download</a> etalase excel.
			</div>
		</div>
		<div class="col-md-12">
			<div class="import-produk">
				<h1 class="mt-3">
					<i class="fa fa-cloud-upload"></i>
				</h1>
				<div>
					Klik disini untuk import produk.
				</div>
				<div class="info-text">
					<span class="badge badge-danger">Note*</span> File harus sesuai template yang sudah disediakan.
				</div>
			</div>
		</div>
		<div class="col-md-12 mt-2 result-message">
		</div>
		<input type="file" name="" id="" class="file none" accept=".xlsx">
		<input type="hidden" name="" class="file">
	</div>
</div>

<table id="table-export-produk" border="1" class="none">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nama</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<table id="table-export-etalase" border="1" class="none">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nama</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<div class="modal fade" id="loading-import" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				Loading
			</div>
			<div class="modal-body" align="center">
				<div class="row">
					<div class="col-md-12">
						<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" alt="">
					</div>
					<div class="col-md-12">
						<p>
							Sedang mengimport data.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>