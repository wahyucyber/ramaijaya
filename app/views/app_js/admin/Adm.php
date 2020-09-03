
<script>

	var $jp_client_token = check_auth();

	var adm;

	class Adm {

		constructor()
		{
			this.run()
		}

		SidebarDraw(data)
		{
			// $('#sidebar-account').html(`
			// 	<div class="d-flex align-items-center">
			// 		<div class="d-flex mb-3">
			// 			<div class="profile-img shadow-sm border">
			// 				<img src="${data.foto_user?data.foto_user : base_url('assets/img/default/profile.jpg')}" alt="${data.nama_user}">
			// 			</div>
			// 			<div class="text-wrapper">
			// 				<h5>${data.nama_user}</h5>
			// 				<div><span class="status-indicator online"></span> <small><i>Online</i></small></div>
			// 			</div>
			// 		</div>
			// 	</div>
			// `)
			$('#sidebar-account img.shop--avatar-default').attr('src',data.foto_user?data.foto_user : base_url('assets/img/default/profile.jpg'));
			$('#sidebar-account .user--name').html(data.nama_user).attr('title',data.nama_user)
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}

			callApi('get_token/',data,function(res){

				if (res.Error) {

					redirect('')

				}else{
					adm.SidebarDraw(res.Data)
				}

			})

		}

	}

	if (check_auth()) {
		adm = new Adm
	}else{
		page_found.not_found()
	}

</script>