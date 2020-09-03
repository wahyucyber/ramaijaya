

<script>
		
	class EditPass {
		edit()
		{
			var data = {
				client_token: check_auth(),
				password_lama: $('input.password_lama').val(),
				password_baru: $('input.password_baru').val(),
				konfirmasi_password_baru: $('input.konfirmasi_password_baru').val()
			}

			callApi('user/profil/ubah_password/',data,function(res){
				if (res.Error) {
					notif('.msg--content','danger',res.Message)
					$('#ModalConfirm').modal('hide')
				}else{

					session.set_flashdata('msg_success','Berhasil mengubah password, silahkan login kembali!')
					var cookie = new Cookie;
					session.destroy_userdata($userdata)
					cookie.remove('role')
					redirect('login')
					$('#ModalConfirm').modal('hide')

				}
			})
		}
	}

	$(document).on('submit', '#ModalConfirm form', function(event) {
		event.preventDefault();
		var pass = new EditPass
		pass.edit()
	});

</script>