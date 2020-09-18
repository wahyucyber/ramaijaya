<?php include 'Seller.php' ?>

<script>
	class Kurir {
		constructor() {
			this.run();
		}

		run() {
			let output = $("div.list--kurir").html('');
			callApi("seller/kurir", {
				client_token: $jp_client_token
			}, res => {
				if (res.Data.length == 0) {
					notif("div.list--kurir", "warning", "Data tidak ada.");
				}else{
					let kurir = `<div class="row">`;
					$.each(res.Data, function(index, val) {
						let kurir_img = "";
						let kurir_nama = "";
						if (val.code == "jnt") {
							kurir_img = `<img src="<?php echo base_url('assets/img/kurir/jnt.png'); ?>" alt="">`;
							kurir_nama = " J&T Express";
						}else if (val.code == "jne") {
							kurir_img = `<img src="<?php echo base_url('assets/img/kurir/jne.png'); ?>" alt="">`;
							kurir_nama = "JNE Express";
						}else if (val.code == "tiki") {
							kurir_img = `<img src="<?php echo base_url('assets/img/kurir/tiki.png'); ?>" alt="">`;
							kurir_nama = "TIKI";
						}else if (val.code == "pos") {
							kurir_img = `<img src="<?php echo base_url('assets/img/kurir/pos.jpg'); ?>" alt="">`;
							kurir_nama = "POS Indonesia";
						}

						kurir += `
							<div class="col-md-3">
				      			<div class="kurir shadow">
				      				<div class="kurir-body">
				      				${kurir_img}
				      				</div>
				      				<div class="kurir-footer">
				      					${kurir_nama}
				      				</div>
				      				<div class="kurir-action">
				      					<button class="btn btn-danger btn-sm kurir--delete" data-toggle="modal" data-target="#delete" data-code="${val.code}"><i class="fal fa-trash-alt"></i></button>
				      				</div>
				      			</div>
				      		</div>
						`;
					});
					kurir += `</div>`;
					output.append(kurir);
				}
			})
		}

		add(params) {
			let code = params['code'];

			callApi("seller/kurir/add", {
				client_token: $jp_client_token,
				code: code
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					$("div#add").modal('hide');
					$("select.add--kurir").val('').trigger('change');
					notifAlert(message, "success", 5);
					kurir.run();
				}
			})
		}

		delete(params) {
			let code = params['code'];

			callApi("seller/kurir/delete", {
				client_token: $jp_client_token,
				code: code
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					$("div#delete").modal('hide');
					$("input.code").val('');
					notifAlert(message, "success", 5);
					kurir.run();
				}
			})
		}
	}

	let kurir = new Kurir;

	$(document).on("submit", "form.add", function () {
		let code = $("select.add--kurir").val();

		kurir.add({
			code: code
		})

		return false;
	})

	$(document).on("click", "button.btn-refresh", function () {
		kurir.run();
	})

	$(document).on("click", "button.kurir--delete", function () {
		let code = $(this).data('code');
		$("input.code").val(code);
	})

	$(document).on("click", "button.ya--hapus", function () {
		let code = $("input.code").val();

		kurir.delete({
			code: code
		})

		return false;
	})
</script>