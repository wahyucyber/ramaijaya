<?php include __DIR__.'/../Seller.php' ?>

<script>
	var TabelDiskon = new Table,
		produk_id = ''
	class DiskonProduk {
		constructor()
		{
			this.get_produk()
			this.load()
		}
		load()
		{
			TabelDiskon.run({
				tabel: "table#data--diskon",
				url: "seller/diskon/",
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
							return `<div>${data.nama_produk}</div><small class="text-muted">${data.nama_kategori}</small>`
						}
					},
					{
						data: null,
						render: function(data){
							return `Rp. ${rupiah(data.harga)}`
						}
					},
					{
						data: null,
						render: function(data){
							return `Rp. ${rupiah(data.harga_diskon)} <small class="badge badge-danger bagde-pill ml-1">-${data.diskon}%</small>`
						}
					},
					{
						data: null,
						render: function(data) {
							if(data.diskon_dari == null || data.diskon_ke == null) {
								return `-`;
							}else {
								return `${data.diskon_dari} / ${data.diskon_ke}`;
							}
						}
					},
					{
						data: null,
						render: function(data){
							return`<button class="btn btn-danger btn-sm btn--delete-kategori" data-toggle="modal" data-target="#ModalDelete" data-id="${data.id}"><i class="fa fa-times"></i> Hapus</button`
						}
					}
				]
			})
		}
		get_produk()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('seller/diskon/get_produk/',data,function(res){
				var options = ''
				if (res.Error) {
					options += '<option value=""></option>'
				}else{
					var val = res.Data
					options += `<option value=""></option>`
					$.each(val,function(index,data){
						options += `<option value="${data.id}">${data.nama_produk}</option>`
					})

				}
				$('select.produk').html(options).select2()
			})
		}
		add()
		{
			var data = {
				client_token: $jp_client_token,
				diskon: $('input.diskon').val(),
				dari_tanggal: $("input._daterangepicker--dari-tanggal").val(),
				ke_tanggal: $("input._daterangepicker--ke-tanggal").val(),
				produk_id: $('select.produk').val()
			}
			callApi('seller/diskon/add_produk/',data,function(res){
				if (res.Error) {
					notif('#msg--content','danger',res.Message,5)
				}else{
					$('input.diskon').val('')
					$('select.produk').val([]).trigger('change')
					notif('#msg--content','success',res.Message,5)
					diskon_produk.load()
					diskon_produk.get_produk()
				}
			})
		}
		delete(produk_id)
		{
			var data = {
				client_token: $jp_client_token,
				produk_id: produk_id
			}
			callApi('seller/diskon/produk_delete/',data,function(res){
				if (res.Error) {
					notif('#msg--content','danger',res.Message,5)
				}else{
					notif('#msg--content','success',res.Message,5)
					$('#ModalDelete').modal('hide')
					diskon_produk.load()
					diskon_produk.get_produk()
				}
			})
		}
	}

	var diskon_produk = new DiskonProduk

	$(document).on('click', 'button.btn--delete-kategori', function(event) {
		event.preventDefault();
		produk_id = $(this).attr('data-id')
	});

	$(document).on('click', '#ModalDelete button.btn--delete', function(event) {
		event.preventDefault();
		diskon_produk.delete(produk_id)
	});

</script>