<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-20 mb-3 badge badge-success bg-orange"><i class="fal fa-file-alt"></i>	Daftar Komplain</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-warning btn-sm btn-refresh" title="segarkan" onclick="komplain.load()"><i class="fa fa-retweet"></i> Refresh</button>
			</div>
		</div>
		<div class="card shadow">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table " id="data-komplain">
						<thead class="bg-orange text-white fs-14">
							<tr>
								<th style="width: 5%">No</th>
								<th style="width: 45%">Produk</th>
								<th style="width: 20%">Nama Pengguna</th>
								<th style="width: 25%">Komplain</th>
								<th style="width: 5%">Aksi</th>
							</tr>
						</thead>
						<tbody class="fs-14"></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="chat--content komplain--chat">
	<div class="chat--inner">
		<div class="chat--header">
			<div class="user--img">
				<img src="<?= base_url('fav.ico'); ?>" alt="" class="user--image">
			</div>
			<div class="user--info">
				<strong class="chat--name user--name"></strong> <span class="badge badge-success p-1">Pembeli</span>
				<p class="mb-0 chat--since">Online</p>
			</div>
			<div class="chat--header-action">
				<button class="btn btn--chat-action close--btn"><i class="far fa-times"></i></button>
			</div>
		</div>
		<div class="chat--body">
			<ul class="chat--msg-list" id="chat--content">
			</ul>
		</div>
		<div class="chat--footer">
			<div class="chat--footer-content">
				<div class="chat--type-msg">
					<textarea rows="1" class="form-control form--type-msg" placeholder="Tulis Pesan"></textarea>
				</div>
				<div class="chat--send-btn">
					<button class="btn btn--chat-send"><i class="fas fa-angle-right"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalKomentarClose">
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
				Apakah anda yakin ingin menutup komplain ini
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