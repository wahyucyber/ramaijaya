<?php include __DIR__.'/../Seller.php' ?>

<script>
	var TabelDiskon = new Table,
		kategori_id = ''
	class DiskonKategori {
		constructor()
		{
			this.get_kategori()
			this.load()
		}
		load()
		{
			TabelDiskon.run({
				tabel: "table#data--diskon",
				url: "seller/diskon/",
				data: {
					client_token: $jp_client_token,
					tipe: 'kategori'
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: 'nama_kategori'
					},
					{
						data: null,
						render: function(data){
							return `<b>${data.diskon}%</b>`
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
		get_kategori()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('seller/diskon/get_kategori/',data,function(res){
				var options = ''
				if (res.Error) {
					options += '<option value=""></option>'
				}else{
					var val = res.Data
					options += `<option value=""></option>`
					$.each(val,function(index,data){
						options += `<option value="${data.id}">${data.nama_kategori}</option>`
					})

				}
				$('select.kategori').html(options).select2()
			})
		}
		add()
		{
			var data = {
				client_token: $jp_client_token,
				diskon: $('input.diskon').val(),
				kategori_id: $('select.kategori').val()
			}
			callApi('seller/diskon/add_kategori/',data,function(res){
				if (res.Error) {
					notif('#msg--content','danger',res.Message,5)
				}else{
					$('input.diskon').val('')
					$('select.kategori').val([]).trigger('change')
					notif('#msg--content','success',res.Message,5)
					diskon_kategori.load()
					diskon_kategori.get_kategori()
				}
			})
		}
		delete(kategori_id)
		{
			var data = {
				client_token: $jp_client_token,
				kategori_id: kategori_id
			}
			callApi('seller/diskon/kategori_delete/',data,function(res){
				if (res.Error) {
					notif('#msg--content','danger',res.Message,5)
				}else{
					notif('#msg--content','success',res.Message,5)
					$('#ModalDelete').modal('hide')
					diskon_kategori.load()
					diskon_kategori.get_kategori()
				}
			})
		}
	}

	var diskon_kategori = new DiskonKategori

	$(document).on('click', 'button.btn--delete-kategori', function(event) {
		event.preventDefault();
		kategori_id = $(this).attr('data-id')
	});

	$(document).on('click', '#ModalDelete button.btn--delete', function(event) {
		event.preventDefault();
		diskon_kategori.delete(kategori_id)
	});

</script>