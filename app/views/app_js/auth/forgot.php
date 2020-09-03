
<script>
	
	var msg_success = session.flashdata('success');
	if (msg_success) {
		$('.msg-content').html(msg_success)
	}
	
	
	class Forgot {
		constructor()
		{

		}
		send(email)
		{
			callApi('forgot/send',{
				email: email
			},function(res){
				if (res.Error) {
					notif('.msg-content','danger',res.Message)
				}else{
					session.set_flashdata('success',res.Message)
					redirect('forgot?success=true')
				}
			})
		}
	}

	var forgot = new Forgot
	
	if(get_params('success') && !msg_success){
	    redirect('login')
	}

	$(document).on('submit', 'form#form-forgot', function(event) {
		event.preventDefault();
		
		var email = $('#form-forgot input.email').val()

		forgot.send(email)

	});

</script>