<?php include 'Adm.php' ?>

<script>
	
	class Komplain {
		constructor()
		{
			this.tabel = new Table;
			this.load()
		}

		load()
		{
			this.tabel.run({
				tabel: "table#data-komplain",
				url: "admin/komplain/",
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
						data: "no_invoice"
					},
					{
						data: "tanggal"
					},
					{
						data: "nama_toko"
					},
					{
						data: "nama_produk"
					},
					{
						data: null,
						render: function(data){
							var status = ''
							if(data.status == 0){
								status = `<span class="badge badge-success">Open</span>`
							}else if(data.status == 1){
								status = `<span class="badge badge-warning">Pending</span>`
							}else if(data.status == 2) {
								status = `<span class="badge badge-danger">Close</span>`
							}
							return `<b>${data.nama} <br>${status}</b>`
						}
					},
					{
						data: "komplain"
					}
				]
			})
		}
	}

	var komplain = new Komplain

</script>