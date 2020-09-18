<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-20 mb-3 badge badge-success bg-orange"><i class="fal fa-file-alt"></i>	Daftar Diskusi</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-default btn-sm btn-warning" title="segarkan" onclick="diskusi.load()"><i class="fa fa-retweet"></i> Refresh</button>
			</div>
		</div>
		
		<div class="top-reviews">
			<div class="top-reviews-list">
				<ul class="list-box diskusi--list">
				</ul>
				<div id="Pagination" class="text-center"></div>
			</div>					
		</div>

	</div>
</section>
