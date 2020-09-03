<?php include 'Adm.php' ?>

<script>
	
	class PPN {
		constructor()
		{
			this.load()
		}
		load()
		{
			callApi('admin/ppn/',null,function(res){
				var output = ''
				if (res.Error) {

					output += `<div class="alert alert-warning mb-3 text-center">${res.Message}</div>
						<button class="btn btn-success btn-block" data-toggle="modal" data-target="#ModalSetAktif">Aktifkan PPN</button>`

				}else{
					var data = res.Data
					output += `<div class="alert alert-success mb-3 text-center">PPN ${data.ppn}% diaktifkan</div>
						<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#ModalSetNonAktif">Nonaktifkan PPN</button>`
				}
				$('#ppn--content').html(output)
			})
		}
		setAktif(ppn)
		{
			callApi('admin/ppn/set/',{status: 1,ppn: ppn},function(res){
				if (res.Error) {
					notif('#ModalSetAktif .msg-content','danger',res.Message)
				}else{
					$('#ModalSetAktif input.ppn').val('')
					$('#ModalSetAktif').modal('hide')
					ppn_content.load()
				}
			})
		}
		setNonaktif(ppn)
		{
			callApi('admin/ppn/set/',{status: 0},function(res){
				if (res.Error) {
					notif('#ModalSetNonAktif .msg-content','danger',res.Message)
				}else{
					$('#ModalSetNonAktif').modal('hide')
					ppn_content.load()
				}
			})
		}
	}

	var ppn_content = new PPN

	$(document).on('submit', '#ModalSetAktif form', function(event) {
		event.preventDefault();
		var ppn = $('#ModalSetAktif input.ppn').val()
		ppn_content.setAktif(ppn)
	});

	$(document).on('submit', '#ModalSetNonAktif form', function(event) {
		event.preventDefault();
		ppn_content.setNonaktif()
	});

</script>