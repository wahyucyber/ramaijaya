<?php include 'Adm.php' ?>
<script>
	class Manual_payment {
		constructor() {
			this.run();
		}

		run() {
			callApi("admin/manual_payment", null, res => {
				if (res.Data.length != 0) {
					$("textarea.ckeditor").val(res.Data[0].content);
				}
			})
		}

		add(params) {
			var content = params['content'];

			callApi("admin/manual_payment/add", {
				content: content
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					notifAlert(message, "success", 5);
				}
			})
		}
	}

	var manual_payment = new Manual_payment;

	$(document).on("submit", "form.payment--manual-form", function () {
		content = CKEDITOR.instances['ckeditor'].getData();
		manual_payment.add({
			content: content
		});

		return false;
	})
</script>