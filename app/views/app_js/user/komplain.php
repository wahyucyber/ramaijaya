

<script>
	
	class Komplain {
		constructor()
		{
			this.komplain_id = 0
			this.tabel = new Table;
			this.load()
		}

		load()
		{
			this.tabel.run({
				tabel: "table#data-komplain",
				url: "user/komplain/",
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
						render: function(data)
						{
							var status = ''
							if(data.status == 0){
								status = `<span class="badge badge-success">Open</span>`
							}else if(data.status == 1){
								status = `<span class="badge badge-warning">Pending</span>`
							}else if(data.status == 2) {
								status = `<span class="badge badge-danger">Close</span>`
							}
							return `<div class="fs-14 fw-bold text-orange">${data.nama_produk}</div>
							<div class="fs-10">${data.no_invoice}</div>
							${status}`
						}
					},
					{
						data: "nama_toko"
					},
					{
						data: "komplain"
					},
					{
						data: null,
						render: function(data){
							var action = ''
							if (data.status == 2) {
								action += `<button class="btn btn-success btn-sm btn-komentar-open" title="Buka percakapan" data-id="${data.id}"><i class="fal fa-check">	Buka</i></button>`
							}

							if(data.status !== 2){
								action += `<button class="btn btn-orange btn-sm btn-komentar ml-2" title="Beri jawaban" data-toggle="chating" data-id="${data.id}" data-toko-id="${data.toko_id}" data-nama="${data.nama_toko}" data-foto="${base_url($(this).attr('data-foto')? $(this).attr('data-foto') : 'fav.ico')}"><i class="fal fa-comments"></i></button>`
							}

							if (data.status == 1) {
								action += `<button class="btn btn-danger btn-sm btn-komentar-close ml-2" data-id="${data.id}" title="Tutup percakapan" data-id="${data.id}"><i class="fal fa-times"></i> Tutup</button>`
							}
							return `
								${action}
							`;
						}
					}
				]
			})
		}

		komentar(id)
		{
			this.komplain_id = id
			var data = {
				komplain_id: id,
				client_token: $jp_client_token
			}

			callApi('user/komplain/komentar/',data,function(res){
				var output = ''
				if (res.Error) {
					output += `<li class="chat--msg-item komplain"> 
									<div class="msg--text-content"> 
										<div class="msg--text">${res.Komplain.komplain}</div> 
										<div class="msg--since">${res.Komplain.waktu}</div>
									</div> 
								</li>`
				}else{
					var data = res.Data
					output += `<li class="chat--msg-item"> 
									<div class="msg--text-content"> 
										<div class="msg--text">${res.Komplain.komplain}</div> 
										<div class="msg--since">${res.Komplain.waktu}</div>
									</div> 
								</li>`
					$.each(data,function(index,data){
						output += `<li class="chat--msg-item ${data.reply? 'reply' : ''}"> 
									<div class="msg--text-content"> 
										<div class="msg--text">${data.komentar}</div> 
										<div class="msg--since">${data.waktu}</div>
									</div> 
								</li>`
					})
				}
				$('.komplain--chat #chat--content').html(output)
				$('.komplain--chat').trigger('sendChat')
			})
		}

		komentar_send(id,user_id,teks)
		{
			var data = {
				komplain_id: id,
				user_id: user_id,
				komentar: teks,
				client_token: $jp_client_token
			}

			callApi('user/komplain/komentar_add/',data,function(res){
				if (res.Error) {

				}else{
					komplain.komentar(id)
					if (res.reload) {
						komplain.load()
					}
				}
			})
		}

		komentar_open(id)
		{
			var data = {
				komplain_id: id,
				client_token: $jp_client_token
			}

			callApi('user/komplain/komentar_open/',data,function(res){
				if (res.Error) {

				}else{
					komplain.load()
					$('#modalKomentarOpen').modal('hide')
				}
			})
		}

		komentar_close(id)
		{
			var data = {
				komplain_id: id,
				client_token: $jp_client_token
			}

			callApi('user/komplain/komentar_close/',data,function(res){
				if (res.Error) {

				}else{
					komplain.load()
					$('#modalKomentarClose').modal('hide')
				}
			})
		}
	}

	var komplain = new Komplain

	var NotificationKomplain = Pusher.subscribe('komplain_chat');
    NotificationKomplain.bind('load', function(data) {
    	if(data.Token == $jp_client_token){
    	   // init_app.ChatNotification()
    	   if (komplain.komplain_id !== 0) {
	    	   komplain.komentar(komplain.komplain_id)
    	   }
    	}
    });

	$(document).on('click', '.komplain--chat .btn--chat-send', function(event) {
		event.preventDefault();
		
		var id = $(this).parents('.chat--footer-content').attr('data-id')
		var user_id = $(this).parents('.chat--footer-content').attr('data-user-id')
		var teks = $('.komplain--chat textarea').val()

		komplain.komentar_send(id,user_id,teks)
		$('.komplain--chat textarea').val('')

	});

	$(document).on('click', '.btn-komentar', function(event) {
		event.preventDefault();
		
		$('.komplain--chat .user--name').html($(this).attr('data-nama'))
		$('.komplain--chat .user--image').attr('src',$(this).attr('data-foto'))
		$('.komplain--chat .chat--footer-content').attr('data-id',$(this).attr('data-id'))
		$('.komplain--chat .chat--footer-content').attr('data-user-id',$(this).attr('data-toko-id'))

		komplain.komentar($(this).attr('data-id'))

	});

	var komplain_id = 0

	$(document).on('click', '.btn-komentar-open', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id')

		komplain_id = id
		$('#modalKomentarOpen').modal('show')
	});

	$(document).on('submit', '#modalKomentarOpen form', function(event) {
		event.preventDefault();
		komplain.komentar_open(komplain_id)
	});

	$(document).on('click', '.btn-komentar-close', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id')

		komplain_id = id
		$('#modalKomentarClose').modal('show')
	});

	$(document).on('submit', '#modalKomentarClose form', function(event) {
		event.preventDefault();
		komplain.komentar_close(komplain_id)
	});

</script>