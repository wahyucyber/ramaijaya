<?php include 'Seller.php' ?>

<script>
	var $jp_client_token = check_auth()

	class Penjualan {
		constructor() {
			this.tabel = new Table;
			this.run();
		}

		run() {
			this.tabel.run({
				tabel: "table.tabel--pesanan",
				url: "seller/pesanan",
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
						data: "no_transaksi"
					},
					{
						data: "created_at"
					},
					{
						data: "status"
					},
					{
						data: null,
						render: res => {
							if (res.status_pencairan == "Ditransfer") {
								return `<div class="badge badge-success" style="padding: 7px;">Ditransfer <sup>${res.status_pencairan_tanggal}</sup></div>`;
							}else{
								return `<div class="badge badge-warning" style="padding: 7px;">${res.status_pencairan}</div>`;
							}
						}
					},
					{
						data: null,
						render: res => {
							return `Rp. ${rupiah(res.total_transaksi)}`;
						}
					},
					{
						data: null,
						render: res => {
							return `<a href="<?php echo base_url('seller/penjualan/detail/'); ?>${res.no_transaksi}" class="btn btn-orange btn-sm" title="Detail"><i class="fal fa-info"></i></href>`;
						}
					}
				]
			})
		}
	}

	var penjualan = new Penjualan;

	$(document).on("click", "button.btn-refresh", function () {
		penjualan.run();
	})
</script>