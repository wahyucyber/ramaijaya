
<div class="container">
	<div class="chat--box">
		<div class="chat--box-content">
			<div class="chat--box-left">
				<div class="chat--box-header">
					<h4 class="mb-0 title--header"><i class="fal fa-comments"></i> Chat</h4>
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
					<!-- <i class="fad fa-comments icon"></i> -->
					<img src="<?= base_url() ?>assets/img/default/no-chat-selected.png" class="w-50" alt="">
					<br>
					<span class="fw-bold fs-20 mt-3 badge badge-warning">Tidak ada Pesan Terpilih</span>
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
						<input type="file" name="" class="_files none" multiple="multiple">
						<div class="_files--output">
						</div>
						<div class="field _files" style="padding: 4px 10px; border: 1px solid #ddd; margin-right: 5px; border-radius: 50%; cursor: pointer;">
							<i class="fas fa-file-archive"></i>
						</div>
						<div class="chat--type-msg">
							<textarea rows="1" class="form-control form--type-msg none" id="emojionearea" placeholder="Tulis Pesan"></textarea>
						</div>
						<div class="chat--send-btn">
							<button class="btn btn--chat-send bg-orange"><i class="fas fa-angle-right"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

