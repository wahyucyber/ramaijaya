<script>

	let urlParams = new URLSearchParams(window.location.search);

	// var keyword = url_get('q')
	// var kategori = url_get('st')
	var keyword = (urlParams.get('q')) ? urlParams.get('q') : "";
	var kategori = (urlParams.get('st')) ? urlParams.get('st') : "";
	var kategori_id = (urlParams.get('kategori')) ? urlParams.get('kategori') : "";
	var filter = (urlParams.get('filter')) ? urlParams.get('filter') : "";
	var page = (urlParams.get('page')) ? urlParams.get('page') : "";
	var provinsi = (urlParams.get('provinsi')) ? urlParams.get('provinsi') : "";
	var kabupaten = (urlParams.get('kabupaten')) ? urlParams.get('kabupaten') : "";
	var kecamatan = (urlParams.get('kecamatan')) ? urlParams.get('kecamatan') : "";

	class Search {

		constructor()
		{
			this.Keyword = keyword.replace('-',' ').replace('+',' ').replace('%20',' ')
			this.Kategori = kategori.replace('-',' ').replace('+',' ').replace('%20',' ')
			this.St = kategori;
			this.Kategori_id = kategori_id;
			this.Filter = filter;
			this.Page = page;
			this.Provinsi = provinsi;
			this.Kabupaten = kabupaten;
			this.Kecamatan = kecamatan;
			this.NamaKategori = '<?= isset($kategori)? $kategori : ''; ?>'
			this.provinsi(provinsi);
			this.kabupaten(kabupaten);
			this.kecamatan(kecamatan);
		}

		provinsi(provinsi_id) {
			callApi('provinsi', null, res => {
				let option = `<option value="">Provinsi</option>`;
				$.each(res.Data, function(index, val) {
					if (provinsi_id == val.id_provinsi) {
						option += `<option value="${val.id_provinsi}" selected>${val.nama_provinsi}</option>`;
					}else{
						option += `<option value="${val.id_provinsi}">${val.nama_provinsi}</option>`;
					}
				});
				$("select.provinsi").html(option);
			})
		}

		kabupaten(kabupaten_id = null) {
			callApi("kabupaten", {
				provinsi_id: this.Provinsi
			}, res => {
				let option = `<option value="">Kabupaten</option>`;
				$.each(res.Data, function(index, val) {
					if (kabupaten_id == val.id_kabupaten) {
						option += `<option value="${val.id_kabupaten}" selected>${val.nama_kabupaten}</option>`;
					}else{
						option += `<option value="${val.id_kabupaten}">${val.nama_kabupaten}</option>`;
					}
				});
				$("select.kabupaten").html(option);
			})
		}

		kecamatan(kecamatan_id = null) {
			callApi("kecamatan", {
				kabupaten_id: this.Kabupaten
			}, res => {
				let option = `<option value="">Kecamatan</option>`;
				$.each(res.Data, function(index, val) {
					if (kecamatan_id == val.id_kecamatan) {
						console.log(true);
						option += `<option value="${val.id_kecamatan}" selected>${val.nama_kecamatan}</option>`;
					}else{
						option += `<option value="${val.id_kecamatan}">${val.nama_kecamatan}</option>`;
					}
				});
				$("select.kecamatan").html(option);
			})
		}

	}

	var search = new Search

	$(document).on("change", "select.provinsi", function () {
		let provinsi_id = $(this).val();

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${search.Page}&provinsi=${provinsi_id}`;
	})

	$(document).on("change", "select.kabupaten", function () {
		let kabupaten_id = $(this).val();

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${search.Page}&provinsi=${search.Provinsi}&kabupaten=${kabupaten_id}`;
	})

	$(document).on("change", "select.kecamatan", function () {
		let kecamatan_id = $(this).val();

		window.location=`<?php echo base_url('search'); ?>?q=${search.Keyword}&st=${search.St}&kategori=${search.Kategori_id}&filter=${search.Filter}&page=${search.Page}&provinsi=${search.Provinsi}&kabupaten=${search.Kabupaten}&kecamatan=${kecamatan_id}`;
	})

</script>