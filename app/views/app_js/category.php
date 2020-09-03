<script>
	class Category {
		constructor() {
			this.run();
		}

		run() {
			callApi("category/subKategori", {
				kategori_id: <?php echo $kategori_id; ?>
			}, res => {
				let content = ``;

				$.each(res.Data, function(index, val) {
					let icon = val.icon_kategori;
					// if (val.icon_kategori != null) {
						// icon = val.icon_kategori;
					// }
					content += `
						<a href="<?php echo base_url(''); ?>/search?q=&st=produk&kategori=${val.id_kategori}" class="category--box-items">
										<img src="${icon}" width="100%" alt="">
									</a>
					`;
				});

				$('#sub--category').html(content);
			})
		}
	}

	let category = new Category;
</script>