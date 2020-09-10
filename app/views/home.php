<div class="top--home">

	<div class="top-slider--home">
		<section class="slider">
			<div class="slider-inner _c287e" id="slick-slider-inner">
				<div class="slider-content d-none" id="top-slider"></div>
			</div>
		</section>
	</div>

	<div class="top-banner--home">
		<section>
			<img class="w-100 mb-2" src="<?= base_url() ?>assets/img/banner/banner.png" alt="">
			<img class="w-100 mb-2" src="<?= base_url() ?>assets/img/banner/banner.png" alt="">
		</section>
	</div>

</div>


<!-- <section class="category--box">
	<div class="page--title-header">Kategori</div>
	<div class="category--inner">
		<div class="category--box-content" id="home--category">
			<?= loader(); ?>
		</div>
	</div>
</section> -->

<section class="flash-sale produk--diskon d-none">
	<div class="flash-sale-inner text-center">
		<span class="title "><b> FLASH SALE </b></span>
		<hr class="w-50 hr-white">
		<div class="flash-sale-content" id="produk-diskon">
		</div>
	</div>
</section>

<section class="product">
	<div class="inner">
		<span class="title"><b> Produk Rekomendasi </b></span>
		<div class="product-content" id="product-list">
			<div class="w-100">
				<?= product_loader(); ?>
			</div>
			<div class="more-inner">
				
			</div>
		</div>
	</div>
</section>

<!-- <section class="flash-sale">
	<div class="flash-sale-inner">
		<span class="title">Produk Terbaru</span>
		<div class="flash-sale-content" id="new-product-list">
			<?= product_loader(); ?>
		</div>
	</div>
</section> -->

<!--<section class="category">-->
<!--	<div class="category-inner">-->
<!--		<div class="label-row">-->
<!--			<span class="label-left">-->
<!--				Kategori-->
<!--			</span>-->
<!--			<a href="<?= base_url('search'); ?>?q=&st=produk&kategori=" class="label-right text-link">-->
<!--				Lihat Semua-->
<!--			</a>-->
<!--		</div>-->
<!--		<div class="content-inner" id="category-list">-->
<!--			<?= loader(); ?>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->


<section class="newsletter">
	<div class="newsletter-inner">
		<div class="row" id="found--shop">
			<!-- <div class="col-md-6 column">
				<h2 class="title">Punya Toko Buku Online? Buka Cabangnya di <?= env('APP_NAME'); ?></h2>
				<p class="sub-title">Mudah, nyaman dan bebas komisi transaksi <b>GRATIS!</b></p>
				<p class="sub-link">
					<a href="<?= base_url(); ?>my-shop" class="btn btn-success">Buka Toko Gratis</a>
					<a href="javascript:;" class="text-primary">Pelajari lebih lanjut</a>
				</p>
			</div>
			<div class="col-md-6 column">
				<a href="">
					<img src="<?= base_url() ?>cdn/shop-banner-jpmall.png" alt="">
				</a>
			</div> -->
		</div>
		<div class="row">
			<div class="column" id="newsletter-readmore">
				<span class="title">
					<h2><?= env('APP_NAME'); ?> - Situs Jual Beli Buku Online di Indonesia</h2>
				</span>
				<p>
					<span>JP Store merupakan salah satu situs belanja buku secara online terlengkap di Indonesia yang menjual beragam produk buku penunjang pendidikan yang dibutuhkan seluruh masyarakat Indonesia dan telah lulus penilaian dari PUSBUK. Seiring berkembangnya dunia teknologi, semakin banyak aktivitas yang dilakukan secara digital, memang lebih mudah dan praktis, termasuk kegiatan pembelanjaan yang kini semakin marak dilakukan secara digital, baik melalui komputer, laptop, hingga smartphone yang bisa diakses kapan saja dan di mana saja. JP Store turut bagian dalam mengikuti perkembangannya sebagai toko online terpercaya dan mampu melayani hingga pelosok negeri. Hal ini memungkinkan setiap orang untuk menjual dan juga membeli buku dengan mudah secara online. Setiap orang di Indonesia juga dapat memasarkan buku unggulannya dengan membuka toko online di JP Store.</span>
				</p>
				
				<span class="title">
					<h2>Belanja Online Terlengkap Hanya di <?= env('APP_NAME'); ?></h2>
				</span>
				<p>
					<span>Salah satu keunggulan yang bisa langsung dirasakan dengan belanja online di JP Store adalah lengkapnya kategori produk. Selain menjual buku-buku pendidikan seperti buku kurnas, buku teks pendamping, Nonteks dan buku bacaan lainnya. JP Store juga menyediakan Al Quran, Alat Tulis Kantor atau ATK dan kertas, alat peraga pendidikan, media-media pembelajaran multimedia dari tablet hingga proyekor, bahkan barang-barang meubelair juga tersedia di JP Store.</span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="column"> <!-- this looping -->
				<a href="">
					<img src="<?= base_url() ?>assets/img/default/Gratis_ongkir.png" style="width: 24%;" alt="">
					<div class="paragraph">
						<span class="title">Gratis Biaya Pengiriman</span>
						<p class="sub-title">Kami Telah Bekerja Sama Dengan Ekspedisi Yang Kredibel, Sehingga Setiap Pembelian Anda Tidak Dikenakan Biaya Pengiriman.</p>
					</div>
				</a>
			</div>
			<div class="column"> <!-- this looping -->
				<a href="">
					<img src="<?= base_url() ?>assets/img/default/Jaminan_pengembalian.png" alt="">
					<div class="paragraph">
						<span class="title">7 Hari Pengembalian</span>
						<p class="sub-title">Kami Memberikan Garansi Pengembalian 100% Pada Setiap Pembelian Produk Terhitung Saat Barang Telah Diterima.</p>
					</div>
				</a>
			</div>
			<div class="column"> <!-- this looping -->
				<a href="">
					<img src="<?= base_url() ?>assets/img/default/transparan.png" alt="">
					<div class="paragraph">
						<span class="title">Transparan</span>
						<p class="sub-title">Pembayaran Anda baru diteruskan ke penjual setelah barang Anda terima</p>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>