

<script>

	$jp_client_token = check_auth()
	var chat_active = 0
	class Chat {
		constructor()
		{
			this.load()
		}

		load()
		{
			var data = {
				client_token: $jp_client_token
			}

			callApi('chat/list/',data,function(res){
				var output = ''
				if(res.Error){

				}else{
					var data = res.Data
					$.each(data,function(index,data){
					    output += `<li class="chat--box-message-item chat--items" data-nama="${data.nama_penerima}" data-foto="${data.foto? data.foto : base_url('fav.ico')}" data-id="${data.penerima_id}">
								<div class="message--content">
									<div class="user--image">
										<img src="${data.foto? data.foto : base_url('fav.ico')}" alt="">
									</div>
									<div class="message--info">
										<div class="user--name">
											<strong>${data.nama_penerima}</strong>
											<span class="badge badge-success p-1">${data.penjual == 1? 'Penjual' : 'Pembeli'}</span>
										</div>
										<div class="message--text">${data.pesan_terakhir? data.pesan_terakhir.pesan : ''}</div>
									</div>
								</div>
							</li>`
					})
				}
				$('#chat--content').html(output)
				chat.single(chat_active)
			})
		}

		single(id)
		{
			var data = {
				client_token: $jp_client_token,
				penerima_id: id
			}
			callApi('chat/single/',data,function(res){
				var output = ''
				if(res.Error){
                    $('.chat--box').trigger('close.chat')
				}else{
					var data = res.Data
					$.each(data,function(index,data){
					    if(data.meta == 1){
					        output += `<li class="chat--msg-item meta">
                							<div class="msg--text-content">
                								<div class="msg--meta">
                									<div class="meta--image">
                										<img src="${data.meta_image? data.meta_image : base_url('fav.ico')}" alt="">
                									</div>
                									<div class="meta--info">
                										<div class="meta--title" onclick="redirect('${data.meta_url}')">${data.meta_title}</div>
                										<div class="meta--description">${data.meta_description}</div>
                									</div>
                								</div>
                							</div>
                						</li>`
					    }else{
					        output += `<li class="chat--msg-item ${data.reply? 'reply' : ''}">
									<div class="msg--text-content">
    									<div class="msg--text">${data.pesan}</div>
    									<div class="msg--since">${data.waktu}</div>
									</div>
								</li>`
					    }
					})
					$('#chat--content-right').html(output)
    				$('.chat--box').trigger('open.chat')
    				$('.chat--box .chat--items[data-id="'+chat_active+'"]').addClass('active')
				}
				
			})
		}

		send(text,id)
		{
			var data = {
				penerima_id: id,
				client_token: $jp_client_token,
				pesan: text
			}
			callApi('chat/send/',data,function(res){
				if (res.Error) {

				}else{
					chat.load()
				}
			})
		}
	}

	var chat = new Chat

	function playNotif()
	{
		var audio = new Audio(base_url('assets/audio/chat_notification.mp3'));
		audio.play();
	}

	var ChatingChannel = Pusher.subscribe('chating');
    ChatingChannel.bind('load', function(data) {
    	if(data.Token == $jp_client_token){
    	    chat.load()
    	    playNotif()
    	}
    });

	$(document).on('click', '.chat--box .chat--items:not(.active)', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id')
		var nama = $(this).attr('data-nama')
		var foto = $(this).attr('data-foto')
		$('.chat--box .chat--name').html(nama)
		$('.chat--box .user--img img').attr('src',foto)
		$(this).addClass('active')
		$('.chat--box .chat--box-footer').attr('data-id',id)
		chat_active = id
		chat.single(id)
	});

	$(document).on('click', '.chat--box .btn--chat-send', function(event) {
		event.preventDefault();
		var text = $('.chat--box .form--type-msg').val(),
		        id = $(this).parents('.chat--box-footer').attr('data-id')
		chat.send(text,id)
		$('.chat--box .form--type-msg').val('')
		$('.chat--box').trigger('save.chat')
	});

</script>