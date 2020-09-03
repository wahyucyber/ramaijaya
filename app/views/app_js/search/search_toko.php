
<?php include 'Search.php' ?>

<script>
	
	class SearchToko {

		constructor()
		{
			this.Keyword = search.Keyword
			this.JmlPage = 0;
			this.render()
		}

		render()
		{
			var data = {
				q: search.Keyword,
				st: search.St,
				kategori_id: search.Kategori_id,
				filter: search.Filter,
				page: search.Page,
				provinsi_id: search.Provinsi,
				kabupaten_id: search.Kabupaten,
				kecamatan_id: search.Kecamatan,
				_client: $jp_client_token
			}

			callApi('product/search',data,res => {

				var output = ''

				if (res.Error == false) {

					var data = res.Data,
						paging = res.Pagination,
						hasil_cari = ''
					var kt = search.NamaKategori? 'Dari Kategori <b>'+search.NamaKategori+'</b>' : ''
					var isset_keyword = search.Keyword? `Toko Untuk <b>"${search.Keyword}"</b> ( <b>1</b>-<b>${paging.Jml_halaman}</b> dari <b>${res.jumlah_data}</b> ) ${kt}` : `dari kategori <b>${search.NamaKategori}</b> `

					hasil_cari = `<span>Menampilkan <b>${res.jumlah_data}</b> ${isset_keyword} </span>`

					$('.search--result').html(hasil_cari)
					this.jmlPage = paging.Jml_halaman;

					output += `
						<div class="row">
							<div class="col-md-12">
					`;

					$.each(data,(no,data) => {

						output += `<div class="card store_items">
										<div class="store-head">
											<a href="<?php echo base_url(''); ?>shop/${data.toko_slug}" class="img-store">
												<img src="${(data.toko_logo != null) ? data.toko_logo : '<?php echo base_url(''); ?>assets/img/default/shop.png'}" alt="">
											</a>
											<div class="store-detail">
												<span class="text-elipsis d-block store-name fs-14" style="width: 170px;">${data.toko_nama}</span>
												<span class="text-white-lightern-3 fs-13"><i class="fad fa-map-marker-alt"></i> <span>${data.toko_kabupaten_nama}</span></span>
											</div>
											<!--<div class="fav_btn ml-auto">
												<button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Follow</button>
											</div>-->
										</div>
									</div>`

					})
				}else{
					output += `<div class="jumbotron text-center text-dark-2"><h3>${res.Message}</h3></div>`
				}

				output += `
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-primary btn-sm produk-left"><i class="fa fa-angle-left"></i></button>
						<button type="button" class="btn btn-primary btn-sm produk-double-left"><i class="fa fa-angle-double-left"></i></button>
						<button type="button" class="btn btn-primary btn-sm produk-double-right"><i class="fa fa-angle-double-right"></i></button>
						<button type="button" class="btn btn-primary btn-sm produk-right"><i class="fa fa-angle-right"></i></button>
					</div>
				</div>
				`;

				$('#shop-search--content').html(output);

			})
		}

	}

	var search_toko = new SearchToko

	$(document).on("click", "button.produk-left", function () {
		let halaman = $("input.page").val();

		let page_ke = parseInt(halaman) - 1;

		if (page_ke <= 1) {
			page_ke = 1;
		}

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${page_ke}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})

	$(document).on("click", "button.produk-right", function () {
		let halaman = $("input.page").val();
		let jumlah_halaman = search_toko.JmlPage;

		let page_ke = parseInt(halaman) + 1;

		if (page_ke >= jumlah_halaman) {
			page_ke = jumlah_halaman;
		}

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${page_ke}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})

	$(document).on("click", "button.produk-double-left", function () {
		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=1&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})

	$(document).on("click", "button.produk-double-right", function () {
		let jumlah_halaman = search_toko.JmlPage;

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${jumlah_halaman}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})

</script>