<div class="container-fluid">
	<h3 class="text-center">Komplain</h3>
	<table class="table " id="data-komplain">
		<thead class="bg-orange text-white">
			<tr>
			<th>No</th>
			<th>Produk</th>
			<th>Nama Penjual</th>
			<th>Komplain</th>
			<th>Aksi</th>
		</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<div class="chat--content komplain--chat">
	<div class="chat--inner">
		<div class="chat--header">
			<div class="user--img">
				<img src="<?= base_url('fav.ico'); ?>" alt="" class="user--image">
			</div>
			<div class="user--info">
				<strong class="chat--name user--name"></strong> <span class="badge badge-success p-1">Penjual</span>
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

<div class="modal fade" id="modalKomentarOpen">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form action="">
	      <div class="modal-body">
	      	<div class="alert alert-warning">
				Apakah anda yakin ingin membuka komplain ini
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
	        <button type="submit" class="btn btn-warning"><i class="fal fa-check-circle"></i>	Iya</button>
	      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalKomentarClose">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-orange">
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
	        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
	        <button type="submit" class="btn btn-danger"><i class="fal fa-check-circle"></i>	Iya</button>
	      </div>
      </form>
    </div>
  </div>
</div>