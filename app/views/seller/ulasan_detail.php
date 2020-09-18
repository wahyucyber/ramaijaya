<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">
		<div class="card shadow border-0 mb-4">
			<div class="card-header bg-orange text-white clearfix">
				<div class="float-left">
					<h5 class="fs-20"><i class="fal fa-info"></i>	Detail Ulasan</h5>
				</div>
				<div class="float-right">
					<button class="btn btn-light btn-sm" onclick="redirect('seller/ulasan')"><i class="fa fa-arrow-left"></i>	Kembali</button>
				</div>
			</div>
		</div>
		<div class="card shadow border-0">
			<div class="card-body p-0">
				<div class="top-reviews-list">
					<ul class="list-box mb-0" id="ulasan--content">
					</ul>
				</div>
			</div>
		</div>

	</div>
</section>
