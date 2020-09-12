
<?php include 'Search.php'; ?>

<script>
	
	class SearchProduk {

		constructor()
		{
			this.render()
			this.jmlPage = 0;
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

					var isset_keyword = search.Keyword? `Produk Untuk <b>"${search.Keyword}"</b> ( <b>1</b>-<b>${paging.Jml_halaman}</b> dari <b>${res.jumlah_data}</b> ) ${kt}` : `dari kategori <b>${search.NamaKategori}</b> `

					hasil_cari = `<span>Menampilkan <b>${res.jumlah_data}</b> ${isset_keyword} </span>`

					$("input.page").val(paging.Halaman);

					$('.search--result').html(hasil_cari)
					this.jmlPage = paging.Jml_halaman;

					$.each(data,function(no, data) {
						let img_produk = '<?php echo base_url('assets/img/default/no-image.png'); ?>';

						if (data.foto != null) {
							img_produk = data.foto[0].foto;
						}
						var harga = '',
							diskon = ''
						if (data.diskon == 0) {
							harga = `<div class="price">Rp ${Format_Rupiah(data.harga)}</div>`
						}else{
							harga = `<span class="text-caret fs-13 text-secondary ">Rp ${Format_Rupiah(data.harga)}</span><span class="price ml-1">Rp ${Format_Rupiah(data.harga_diskon.toString())}</span>`
							diskon = `<span class="free-ongkir badge badge-danger">-${data.diskon}% <br><b class="text-white">OFF</b></span>`
						}
					output += `<a href="<?php echo base_url(''); ?>shop/${data.toko_slug}/${data.slug}" class="card product-item">
									<div class="card-header head">
										<img src="${img_produk}">`
										output += `<span class="preorder badge badge-light"><i class="fa fa-bullhorn"></i></span>`
							output += `${diskon}
									</div>
									<div class="card-body body">
										<div class="small">${data.nama}</div>
										<div class="price-product">
											${harga}
										</div>
										<div class="dtl">
											<span class="fad fa-sm fa-store"></span>
											<div class="dtl-product">
												<span class="dtl-item">${data.toko_kecamatan_nama}</span>
												<span class="dtl-item">${data.toko_nama}</span>
											</div>
										</div>
										<div class="star_rate">
											<i class="product-rating _${data.rating}-star"></i>
											<span class="counter">(${data.rating})</span>
										</div>
									</div>
								</a>`

					});


				}else{

					output += `<div class="jumbotron text-center text-dark-2"><h3>${res.Message}</h3></div>`

				}

				output += `
				<div class="row">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-orange btn-sm produk-left"><i class="fa fa-angle-left"></i></button>
						<button type="button" class="btn btn-orange btn-sm produk-double-left"><i class="fa fa-angle-double-left"></i></button>
						<button type="button" class="btn btn-orange btn-sm produk-double-right"><i class="fa fa-angle-double-right"></i></button>
						<button type="button" class="btn btn-orange btn-sm produk-right"><i class="fa fa-angle-right"></i></button>
					</div>
				</div>
				`;

				$('#produk-search--content').html(output)

			})
		}

		wishlist(el)
		{
			var data = {
				_client: _client,
				produk_id: el.attr('data-produk')
			}

			callApi('wishlist',data,res => {

				if (res.status) {
					el.toggleClass('active')
					if (el.hasClass('active')) {
						el.attr('title','Sudah dalam wishlist')
					}else{
						el.attr('title','Tambah ke wishlist')
					}
				}

			})
		}

		get JmlPage() {
			return this.jmlPage;
		}

	}

	var search_produk = new SearchProduk

	$('#produk-search--content').on('click', 'button.add-to-wishlist', function(event) {
		event.preventDefault()
		search_produk.wishlist($(this))
	});

	$(document).on("change", ".produk-filter", function () {
		let filter = $(this).val();

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${filter}&page=${search.Page}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})

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
		let jumlah_halaman = search_produk.JmlPage;

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
		let jumlah_halaman = search_produk.JmlPage;

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${jumlah_halaman}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${search.Kecamatan}`;
	})
</script>