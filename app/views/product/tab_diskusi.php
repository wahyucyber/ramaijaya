<div class="pt-3">
	<div class="question-discuss mb-3">
		<div class="d-flex">
			<i class="fal fa-comments fa-2x text-orange"></i>
			<p class="m-0 ml-3 mt-auto">
				Ada pertanyaan? <b class="fw-600">Diskusikan dengan penjual atau pengguna lain</b>
			</p>
		</div>
		<div class="btn-question">
			<?php if ($Auth['Error']): ?>
			<?php else: ?>
			<a href="" class="btn btn-orange" data-toggle="collapse" data-target="#pertanyaan--baru"><i class="fal fa-pen"></i>	Tulis Pertanyaan</a>
			<?php endif ?>
		</div>
		<div class="clearfix"></div>
		<?php if ($Auth['Error']): ?>
		<?php else: ?>
		<div class="card-body collapse" id="pertanyaan--baru">
			<div class="form-group">
				<textarea rows="1" class="form-control diskusi" placeholder="Masukkan pertanyaan anda disini"></textarea>
			</div>
			<div class="text-right">
				<button class="btn btn-sm btn-danger"><i class="fal fa-times-circle"></i>	Batal</button>
				<button class="btn btn-sm btn-success btn--send-diskusi"><i class="fal fa-paper-plane"></i>	Kirim</button>
			</div>
		</div>
		<?php endif ?>
	</div>

	<div class="top-reviews">
		<div class="top-reviews-header">
			<div class="float-left">
				<h4 class="fs-18 mb-3 fw-600">Diskusi Terbaru</h4>
			</div>
			<div class="float-right">
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="top-reviews-list">
			<ul class="list-box diskusi--list">
			</ul>
			<div id="Pagination" class="text-center"></div>
		</div>					
	</div>
</div>