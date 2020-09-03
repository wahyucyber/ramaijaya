
<div class="container">
	<div class="chat--box">
		<div class="chat--box-content">
			<div class="chat--box-left">
				<div class="chat--box-header">
					<h4 class="mb-0 title--header">Chat</h4>
				</div>
				<!-- <div class="input-group">
					<div class="input-group-prepend">
						<button class="btn input-group-text"><i class="fas fa-search"></i></button>
					</div>
					<input type="text" class="form-control" placeholder="Cari chat atau pengguna">
				</div> -->
				<!-- <div class="row">
					<div class="col-3">Tampilkan:</div>
					<div class="col-5">
						<select class="form-control select2">
							<option value="0">Semua</option>
							<option value="1">Belum dibaca</option>
							<option value="2">Sudah dibaca</option>
							<option value="3">Belum dibalas</option>
						</select>
					</div>
					<div class="col-4"></div>
				</div> -->
				<div class="chat--box-list">
					<ul class="chat--box-message-list" id="chat--content">
					</ul>
				</div>
			</div>
			<div class="chat--box-right-no-content">
				<div class="no--chat-content">
					<i class="fad fa-comments icon"></i>
					<h4 class="fw-bold">Tidak ada Pesan</h4>
				</div>
			</div>
			<div class="chat--box-right">
				<div class="chat--box-header">
					<div class="btn--back">
						<button class="btn btn--action-chat close--chat"><i class="far fa-angle-left"></i></button>
					</div>
					<div class="user--img">
						<img src="<?= base_url('fav.ico'); ?>" alt="">
					</div>
					<div class="user--info">
						<strong class="chat--name"></strong> 
						<p class="mb-0 chat--since">Online</p>
					</div>
				</div>
				<div class="chat--box-body">
					<ul class="chat--msg-list" id="chat--content-right">
					</ul>
				</div>
				<div class="chat--box-footer">
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
	</div>
</div>