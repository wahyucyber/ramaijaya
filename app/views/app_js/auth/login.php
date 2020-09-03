<script>

	if(check_auth()){
		redirect('')
	}

	var goto = get_params('continue');

	var msg_success = session.flashdata('msg_success');

	if (msg_success) {
		notif('#login-form .msg-content','success',msg_success)
		session.destroy_flashdata('msg_success')
	}

	class Login {

		constructor()
		{
			this.run()
		}

		run(){
			var email = $('#login-form input.email').val(),
				password = $('#login-form input.password').val(),
				data = {
					email: email,
					password: password
				}
			callApi('login/',data,function(res){
				if(res.Error){
					notif('#login-form .msg-content','danger',res.Message)
				}else {
					notif('#login-form .msg-content','success',res.Message)
					$('#login-form input').val('')
					var data = res.Data
					cookie.set(data)
					if (goto) {
						redirect(goto)
					}else{
						redirect('')
					}
				}
			})
		}

	}

	$(document).on('submit', '#login-form', function(event) {
		event.preventDefault();
		new Login
	});

	$(document).on("mouseover", "div.show-password", function () {
		$("div.show-password i").removeClass('fa-eye-slash');
		$("div.show-password i").addClass('fa-eye');
		$("input.password").attr('type', 'text');
	})

	$(document).on("mouseout", "div.show-password", function () {
		$("div.show-password i").removeClass('fa-eye');
		$("div.show-password i").addClass('fa-eye-slash');
		$("input.password").attr('type', 'password');
	})
	
</script>
