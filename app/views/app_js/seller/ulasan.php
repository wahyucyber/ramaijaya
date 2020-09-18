<?php include 'Seller.php' ?>

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
				url: "seller/ulasan/",
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
						data: 'user_nama'
					},
					{
						data: "nama_produk"
					},
					{
						data: null,
						render: function(data){
							return `<i class="fa fa-star text-warning fs-20"></i> ${data.rating}`
						}
					},
					{
						data: 'ulasan'
					},
					{
						data: null,
						render: function(data){
							return`<button class="btn btn-orange btn-sm" onclick="redirect(base_url('seller/ulasan/detail/${data.id}'))" title="Detail"><i class="fal fa-info"></i></button`
						}
					}
				]
			})
		}


	}

	var ulasan = new Ulasan

</script>