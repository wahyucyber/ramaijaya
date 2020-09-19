
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
				tabel: "table#data--ulasan",
				url: "user/ulasan/",
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
							return `<h6 class="mb-1 fs-14">${data.nama_produk}</h6>
							<span class="fs-12 text-secondary">${data.nama_toko}</span>`
						}
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
							return`<button class="btn btn-info btn-sm" onclick="redirect(base_url('user/ulasan/detail/${data.id}'))"><i class="fal fa-eye"></i> Detail</button`
						}
					}
				]
			})
		}
	}

	var ulasan = new Ulasan

</script>