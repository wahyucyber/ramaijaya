
<section class="product-single">
	<div class="product-single-inner" id="single-product">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" id="nav-product">
		    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Beranda</a></li>
		    <li class="breadcrumb-item"><a href="javascript:;" class="kategori--nama">Produk</a></li>
		    <li class="breadcrumb-item active text-elipsis produk--nama" aria-current="page">Produknya Lorem ipsum dolor sit amet.</li>
		  </ol>
		</nav>
		<div class="product-single-content">
			<div class="first-column">
				<div class="product-detail">
					<div class="column">
						<div class="slider-product-single img-thumbnail" id="slider-product-single">
						</div>
						<div class="slider-product-nav" id="slider-product-nav">
							<div class="slider-product-single img-thumbnail" id="slider-product-single">
    							<img src="<?php echo base_url('assets/img/default/no-image-small.png'); ?>" alt="">
    						</div>
    						<div class="slider-product-nav" id="slider-product-nav">
    							<div class="item curs-p">
    								<img src="<?php echo base_url('assets/img/default/no-image-small.png'); ?>" alt="">
    							</div>
    						</div>
						</div>
					</div>
					<div class="column" id="product-single--content">
						<a href="" class="text-primary fs-13 link--toko"><i class="fad fa-store text-success mb-1"></i> <span class="nama--toko">Nama Toko</span></a>
						<h3 class="font-weight-bold mb-1 nama--produk">Nama Produk</h3>
						<div class="shared--content mb-2">
							<button class="btn btn-sm shared--btn" data-url="<?= current_url(); ?>"><i class="fa fa-share-alt"></i> Bagikan</button>
							<div class="shared--overlay">
								<div class="shared--item">
									<div class="shared--header">
										<button class="btn close px-2 shared--btn-close">&times;</span></button>
										<h5 class="fs-18 mb-0 pl-2 my-auto">Bagikan Produk Ini</h5>
									</div>
									<div class="shared--item-content">
										<ul class="shared--item-list">
											<li><div class="shared--link color-facebook" data-action="shared" data-type="facebook" data-url="" title="Facebook"><i class="fab fa-facebook-f"></i></div></li>
											<li><div class="shared--link color-twitter" data-action="shared" data-type="twitter" data-url="" title="Twiiter"><i class="fab fa-twitter"></i></div></li>
											<li><div class="shared--link color-whatsapp d-flex d-lg-none" data-action="shared" data-type="whatsapp" data-url="" title="Whatsapp"><i class="fab fa-whatsapp"></i></div></li>
											<li><div class="shared--link color-other" data-action="shared" data-type="copy" data-url="" title="Salin Link"><i class="far fa-link"></i></div></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="star_rate m-0" id="rating--ulasan">
							<i class="product-rating _0-star"></i>
							<span class="counter ml-1">0 Ulasan</span>
						</div>
						<div class="price" id="harga--produk">
						</div>
						<div class="d-xl-flex mt-3 product_input">
							<div class="w-25">
								<div class="form-group">
									<label class="font-weight-bold">Jumlah</label>
									<div class="qty-input">
										<div class="quantity-input">
											<div class="qty-min qty-btn disabled"></div>
											<input type="hidden" name="" class="harga--produk">
											<input class="qty jumlah_produk" value="0" type="number" style="width: 22px">
											<div class="qty-plus qty-btn"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="w-75 pl-lg-4 pl-0">
								<div class="form-group">
									<label class="font-weight-bold">Catatan untuk Penjual (Opsional)</label>
									<input type="text" name="note" class="form-control catatan" placeholder="">
								</div>
							</div>
						</div>
						<!-- <div class="my-3 text-muted fs-14">
							<span>Cicilan bunga 0% mulai dari Rp 1.875 </span><div class="curs-p d-inline-block text-primary">Bandingkan Cicilan</div>
						</div> -->
						<div class="product-info clearfix">
							<div class="product-info-item">
								<i class="fa fa-eye text-muted"></i>
								<div class="d-inline-block ml-2">
									<div class="text-muted fs-11">Dilihat</div>
									<div class="font-weight-bold fs-14 p-0 dilihat--">0</div>
								</div>
							</div>
							<div class="product-info-item">
								<i class="fa fa-truck text-muted"></i>
								<div class="d-inline-block ml-2">
									<div class="text-muted fs-11">Terkirim</div>
									<div class="font-weight-bold fs-14 p-0">0</div>
								</div>
							</div>
							<div class="product-info-item">
								<i class="fa fa-box-open text-muted"></i>
								<div class="d-inline-block ml-2">
									<div class="text-muted fs-11">Kondisi</div>
									<div class="font-weight-bold fs-14 p-0 kondisi--">-</div>
								</div>
							</div>
							<div class="product-info-item">
								<i class="fa fa-tag text-muted"></i>
								<div class="d-inline-block ml-2">
									<div class="text-muted fs-11">Min. Beli</div>
									<div class="font-weight-bold fs-14 p-0 minimal--beli">0</div>
								</div>
							</div>
							<!-- <div class="product-info-item">
								<i class="fa fa-shield-alt text-muted"></i>
								<div class="d-inline-block ml-2">
									<div class="text-muted fs-11">Asuransi</div>
									<div class="font-weight-bold fs-14 p-0">Opsional</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
				<nav class="navbar navbar-store-bottom" id="shop-nav--bottom">
					<div class="store-wrapper">
						<div class="shop-info">
							<a href="" class="img-store">
								<img src="<?= base_url(); ?>cdn/fav.png" class="toko--logo" alt="">
							</a>
							<div class="__info">
								<div class="__info-name">
									<a href="" class="mr-1 link--toko"><span class="fw-600 text-dark nama--toko">Nama Toko</span></a>
									<i class="fa fa-check-circle icon-pb fill" title="Power Badge"></i>
								</div>
								<p class="fs-10"><span class="toko--kabupaten">Kabupaten</span> &#9679; Online Hari Ini &#9679; </p>
							</div>
						</div>
						<div class="shop--event">
						    <?php if ($Auth['Error']): ?>
                            <?php else: ?>
							<button class="btn btn-outline-success btn--chat" data-toggle="chating">
								<i class="fas fa-comment-lines"></i>
								<span class="text">Chat Penjual</span>
							</button>
							<?php endif ?>
							<!-- <div class="d-inline-block btn-follow">
								<button class="btn btn-primary">Follow</button>
							</div> -->
						</div>
						<div class="shop-action">
							<div class="pd-price">
								<div class="fs-10 text-white-lightern-3 text-uppercase">Total</div>
								<span class="fs-18 fw-700 total--beli">Rp 0</span>
							</div>
							<!-- <button class="btn btn-light ml-2 btn-chat-nav"><i class="fa fa-comment"></i></button> -->
							<button class="btn btn-light ml-2 btn-wishlist-nav produk--favorit"><i class="fa fa-heart"></i></button>
							<button class="btn btn-outline-primary ml-2 btn-buy-nav add--to-cart-order">Beli</button>
							<button class="btn btn-primary ml-2 btn-cart-nav add--to-cart">Tambah Ke Keranjang</button>
						</div>
					</div>
				</nav>
			</div>
			<div class="last-column" id="product-single--right">
				<div class="shop-notes">
					<div class="card p-3 mb-3">
						<h4 class="mb-3 fs-12">Catatan Toko</h4>
						<div class="catatan--toko">
						</div>
					</div>
				</div>
				<!-- <div class="shipping-list">
					<div class="card p-3 mb-3">
						<h4 class="mb-3 fs-12">Dukungan Pengiriman</h4>
						<div class="shipping-item">
							<div class="img-shipping">
								<img src="https://ecs7.tokopedia.net/img/kurir-pos.png" alt="" title="Pos Indonesia">
							</div>
							<ul class="list-unstyled text-white-lightern-3">
								<li title="POs Kilat Khusus">POs Kilat Khusus</li>
							</ul>
						</div>
						<div class="shipping-item">
							<div class="img-shipping">
								<img src="https://ecs7.tokopedia.net/img/kurir-jnt.png" alt="" title="SiCepat">
							</div>
							<ul class="list-unstyled text-white-lightern-3">
								<li title="Reguler">Reguler</li>
							</ul>
						</div>
						<div class="shipping-item">
							<div class="img-shipping">
								<img src="https://ecs7.tokopedia.net/img/kurir-jne.png" alt="" title="JNE">
							</div>
							<ul class="list-unstyled text-white-lightern-3">
								<li title="Reguler">Reguler</li>
								<li title="OKE">OKE</li>
								<li title="YES">YES</li>
							</ul>
						</div>
					</div>
				</div> -->
			</div>
		</div>
		<div class="summary-product">
			<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link <?= $tabs == 1? 'active' : ''; ?>" href="<?= base_url("shop/$toko/$produk?tab=1"); ?>"><i class="fa fa-file-alt icon"></i> Informasi Produk</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link <?= $tabs == 2? 'active' : ''; ?>" href="<?= base_url("shop/$toko/$produk?tab=2"); ?>"><i class="fa fa-comments icon"></i> Ulasan</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link <?= $tabs == 3? 'active' : ''; ?>" href="<?= base_url("shop/$toko/$produk?tab=3"); ?>"><i class="fab fa-discourse icon"></i> Diskusi Produk </a>
			  </li>
			</ul>
			<div class="tab-content">
			  <div class="tab-pane fade <?= $tabs == 1? 'show active' : ''; ?>" id="product--info">
				<?php if ($tabs == 1) {
					include 'product/tab_info.php';
				} ?>
			  </div>
			  <div class="tab-pane fade <?= $tabs == 2? 'show active' : ''; ?>">
				<?php if ($tabs == 2) {
					include 'product/tab_ulasan.php';
				} ?>
			  </div>
			  <div class="tab-pane fade <?= $tabs == 3? 'show active' : ''; ?>" id="discuss">
			 	<?php if ($tabs == 3) {
					include 'product/tab_diskusi.php';
				} ?>
			  </div>
			</div>
		</div>
		<div class="more-product">
			<h4 class="fs-18 mb-3 fw-600">Produk lainnya dari toko ini</h4>
			<div class="product-list other-product" id="other-product">
			</div>
		</div>
	</div>
</section>


<?php if ($Auth['Error']): ?>
<?php else: ?>
<div class="chat--content">
	<div class="chat--inner">
		<div class="chat--header">
			<div class="user--img">
				<img src="<?= base_url('fav.ico'); ?>" alt="" class="toko--logo">
			</div>
			<div class="user--info">
				<strong class="chat--name nama--toko"></strong> <span class="badge badge-success p-1">Penjual</span>
				<p class="mb-0 chat--since">Online</p>
			</div>
			<div class="chat--header-action">
				<button class="btn btn--chat-action close--btn"><i class="far fa-times"></i></button>
			</div>
		</div>
		<div class="chat--body">
			<ul class="chat--msg-list" id="chat--content">
<!--				<li class="chat--msg-item meta">-->
<!--					<div class="msg--text-content">-->
<!--						<div class="msg--meta">-->
<!--							<div class="meta--image">-->
<!--								<img src="<?= base_url('fav.ico'); ?>" alt="">-->
<!--							</div>-->
<!--							<div class="meta--info">-->
<!--								<div class="meta--title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse, deleniti!</div>-->
<!--								<div class="meta--description">JPStore</div>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</li>-->
<!--				<li class="chat--msg-item">-->
<!--					<div class="msg--text-content">-->
<!--						<div class="msg--text">Ready Kak?</div>-->
<!--					</div>-->
<!--				</li>-->
<!--				<li class="chat--msg-item reply">-->
<!--					<div class="msg--text-content">-->
<!--						<div class="msg--text">Ready,-->
<!--Silahkan di order</div>-->
<!--					</div>-->
<!--				</li>-->
<!--				<li class="chat--msg-item">-->
<!--					<div class="msg--text-content">-->
<!--						<div class="msg--text">Siap Kak</div>-->
<!--					</div>-->
<!--				</li>-->
<!--				<li class="chat--msg-item reply">-->
<!--					<div class="msg--text-content">-->
<!--						<div class="msg--text">Kami Tunggu</div>-->
<!--					</div>-->
<!--				</li>-->
			</ul>
		</div>
		<div class="chat--footer">
			<div class="placeholder--meta">
				<div class="msg--meta">
					<div class="meta--image">
						<img src="" alt="">
					</div>
					<div class="meta--info">
						<div class="meta--title"></div>
						<div class="meta--description"></div>
					</div>
				</div>
				<div class="meta--close">
					<button class="btn btn--chat-action"><i class="far fa-times"></i></button>
				</div>
			</div>
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
<?php endif ?>