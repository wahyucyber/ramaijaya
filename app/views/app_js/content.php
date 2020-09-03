<?php $this->load->view('app_js/home.php'); ?>

<script>
	class Content {
		constructor() {
			this.run();
		}

		run() {
			callApi("content", {
				id: <?php echo $id; ?>
			}, res => {
				$.each(res.Data, function(index, val) {
					$("h4.content--title").html(val.title);
					$("span.content--datetime").html(val.created_at);
					$("div.content div.card-body").html(val.content);
				});
			})
		}
	}

	let content = new Content;
</script>