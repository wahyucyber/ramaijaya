<?php include 'Adm.php' ?>

<script>
	var TabelUlasan = new Table
	class Ulasan {
		constructor()
		{
			this.load()
		}

		load()
		{
			TabelUlasan.run({
				tabel: "table#data-ulasan",
				url: "admin/ulasan/",
				data: {
					client_token: $jp_client_token
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						render: function(data){
							return `<h4 class="fs-18 mb-0">${data.nama_produk}</h4>
							<small class="text-muted">${data.nama_toko}</small>`
						}
					},
					{
						data: 'user_nama'
					},
					{
						data: "rating"
					},
					{
						data: 'ulasan'
					},
					{
						data: null,
						render: function(data){
							return `<button class="btn btn-info" onclick="redirect('admin/ulasan/detail/${data.id}')">Detail</button>`
						}
					}
				]
			})
		}


	}

	var ulasan = new Ulasan

</script>