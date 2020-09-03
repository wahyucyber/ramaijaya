
<script>
	
	var $jp_client_token = check_auth()

	class Seller {

		constructor()
		{
			if (check_auth()) {
				this.run()
			}else{
				page_found.not_found()
			}
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('shop/',data,res => {
				if (res.Error) {
					
				}else{
					var data = res.Data,
						output = ''

					$('#shop-profile img.shop--avatar-default').attr('src',data.logo_toko? data.logo_toko : base_url('assets/img/default/shop.png'));
					$('.shop--name').html(data.nama_toko).attr('title',data.nama_toko)
					this.getUser()
				}
			})
		}

		getUser()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('get_token/',data,res => {
				if (res.Error) {
					notifAlert(res.Message,'error')
				}else{
					var data = res.Data
					if (data.role == 1) {
						redirect('admin/shop')
					}else{
						$('#shop-profile .user--name').html(data.nama_user)
					}
				}
			})
		}

		

	}

	var seller = new Seller

</script>