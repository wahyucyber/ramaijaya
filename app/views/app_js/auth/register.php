<script>
	if(check_auth()){
		redirect('')
	}
	class Register {
		constructor()
		{
			// this.render()
			this.authGoogle();
		}
		render()
		{
			var nama = $('#register-form input.nama').val(),
				email = $('#register-form input.email').val(),
				password = $('#register-form input.password').val(),
				konfirmasi_password = $('#register-form input.konfirmasi_password').val(),
				data = {
					nama: nama,
					email: email,
					password: password,
					konfirmasi_password: konfirmasi_password
				}
			callApi('register/',data,res => {
				// loader.show()
				// console.log(res)
				if (res.Error) {
					notifAlert(res.Message,'error')
				}else{
					session.set_flashdata('msg_success',res.Message)
					$('#register-form input').val('')
					redirect('login')
				}
			})
		}

		authGoogle() {
			callApi('auth/google', null, res => {
				console.log(res);
			})
		}
	}

	var register = new Register;

	$('#register-form').on('submit', function(e) {
		e.preventDefault();
		register.render();
	});
</script>