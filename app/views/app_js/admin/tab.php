<?php include 'Adm.php' ?>

<script>
	class Tab {
		constructor() {
			this.run();
		}

		run(){
			let output = $("div.tab--list").html('');
			callApi("admin/tab", null, res => {
				if (res.Data.length == 0) {
					notif("div.tab--list", "danger", "Data tidak ditemukan.");
				}else{
					let content = '';
					$.each(res.Data, function(index, val) {
						content += `
							<div class="card mb-2">
								<div class="card-header">
									<div class="row">
										<div class="col-md-10 slide-toggle-title slide-toggle active tab-${val.id}" data-tab-id="${val.id}" data-tab-judul="${val.nama}" style="padding-top: 5px; cursor: pointer;">
											<i class="fa fa-plus tab-icon-${val.id}"></i> ${val.nama}
										</div>
										<div class="col-md-2" align="right">
											<button type="button" class="btn btn-info btn-sm tab-set-up" data-id="${val.id}"><i class="fa fa-angle-up"></i></button>
											<button type="button" class="btn btn-info btn-sm tab-set-down" data-id="${val.id}"><i class="fa fa-angle-down"></i></button>
											<button type="button" class="btn btn-primary btn-sm tab--edit" data-id="${val.id}" data-nama="${val.nama}" data-toggle="modal" data-target="#tab-update"><i class="fa fa-edit"></i></button>
											<button type="button" class="btn btn-danger btn-sm tab--delete" data-id="${val.id}" data-nama="${val.nama}" data-toggle="modal" data-target="#tab-delete"><i class="fa fa-trash"></i></button>
										</div>
									</div>
								</div>
								<div class="card-body slide-toggle-body none tab-${val.id}" data-tab-id="${val.id}">
									<div class="row">
										<div class="col-md-12 mb-2" align="right">
											<button type="button" class="btn btn-success btn-sm tab-content-add" data-tab-id="${val.id}" data-toggle="modal" data-target="#tab-content-add"><i class="fa fa-plus"></i></button>
										</div>
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="table table-hover table-striped table-condensed table-bordered data-tab-content-${val.id}">
													<thead>
														<tr>
															<th>No.</th>
															<th>Title</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody></tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						`;
					});

					output.append(content);
				}
			})
		}

		add(params) {
			let nama = params.nama;

			callApi("admin/tab/add", {
				nama: nama
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					$("form.tab-add input.nama").val('');
					$("div#tab-add").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}

		update(params) {
			let id = params['id'];
			let nama = params['nama'];

			callApi("admin/tab/update", {
				id: id,
				nama: nama
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					$("form.tab-update input.tab-id").val('');
					$("form.tab-update input.nama").val('');
					$("div#tab-update").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}

		delete(params) {
			let id = params.id;

			callApi("admin/tab/delete", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					$("div#tab-delete").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}

		setUp(params) {
			let id = params.id;

			callApi("admin/tab/set_up", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					notifAlert(message, "success", 5);
				}
			})
		}

		setDown(params) {
			let id = params.id;

			callApi("admin/tab/set_down", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					notifAlert(message, "success", 5);
				}
			})
		}
	}

	class Tab_content {
		constructor() {
		}

		run(params) {
			let tab_id = params['tab_id'];

			let tabel = new Table;
			tabel.run({
				tabel: `table.data-tab-content-${tab_id}`,
				data: {
					tab_id: tab_id
				},
				url: "admin/tab_content",
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: "title"
					},
					{
						data: null,
						render: res => {
							return `
								<button type="button" class="btn btn-primary btn-sm tab-content-update" data-tab-id="${res.tab_id}" data-id="${res.id}" data-title="${res.title}" data-content="${res.content}" data-toggle="modal" data-target="#tab-content-update"><i class="fa fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-sm tab-content-delete" data-tab-id="${res.tab_id}" data-tab-nama="${res.title}" data-id="${res.id}" data-toggle="modal" data-target="#tab-content-delete"><i class="fa fa-trash"></i></button>
							`;
						}
					}
				]
			})
		}

		add(params) {
			let tab_id = params['tab_id'];
			let title = params['title'];
			let content = params['content'];

			callApi("admin/tab_content/add", {
				tab_id: tab_id,
				title: title,
				content: content
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run({
						tab_id: tab_id
					});
					$("div#tab-content-add").modal('hide');
					$("form.tab-content-add input.title").val('');
					$("form.tab-content-add textarea.content").val('');
					notifAlert(message, "success", 5);
				}
			})
		}

		update(params) {
			let tab_id = params['tab_id'];
			let id = params['id'];
			let title = params['title'];
			let content = params['content'];

			callApi("admin/tab_content/update", {
				tab_id: tab_id,
				id: id,
				title: title,
				content: content
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run({
						tab_id: tab_id
					});
					$("div#tab-content-update").modal('hide');
					$("form.tab-content-update input.title").val('');
					$("form.tab-content-update textarea.content").val('');
					notifAlert(message, "success", 5);
				}
			})
		}

		delete(params) {
			let tab_id = params.tab_id;
			let id = params.id;

			callApi("admin/tab_content/delete", {
				tab_id: tab_id,
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					tab_content.run({
						tab_id: tab_id
					});
					$("div#tab-content-delete").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}
	}

	let tab = new Tab;
	let tab_content = new Tab_content;

	$(document).on("click", "div.slide-toggle", function () {

		let tab_judul = $(this).data('tab-judul');
		let tab_id = $(this).data('tab-id');
		
		if ($(this).hasClass('active') == true) {
			$(`i.tab-icon-${tab_id}`).addClass('fa-minus');
			$(`i.tab-icon-${tab_id}`).removeClass('fa-plus');
			$(this).removeClass('active');

			tab_content.run({
				tab_id: tab_id
			});
		}else{
			$(`i.tab-icon-${tab_id}`).addClass('fa-plus');
			$(`i.tab-icon-${tab_id}`).removeClass('fa-minus');
			$(this).addClass('active');
		}

		$(`div.slide-toggle-body[data-tab-id=${tab_id}]`).slideToggle('slow');
	})

	$(document).on("click", "button.tab--reload", function () {
		tab.run();
	})

	$(document).on("submit", "form.tab-add", function () {
		let nama = $("form.tab-add input.nama").val();

		tab.add({
			nama: nama
		});

		return false;
	})

	$(document).on("click", "button.tab--edit", function () {
		let id = $(this).data('id');
		let nama = $(this).data('nama');

		$("form.tab-update input.tab-id").val(id);
		$("form.tab-update input.nama").val(nama);
	})

	$(document).on("submit", "form.tab-update", function () {
		let id = $("form.tab-update input.tab-id").val();
		let nama = $("form.tab-update input.nama").val();

		tab.update({
			id: id,
			nama: nama
		});

		return false;
	})

	$(document).on("click", "button.tab--delete", function () {
		let id = $(this).data('id');
		let nama = $(this).data('nama');

		$("form.tab-delete b.nama-tab").html(nama);
		$("form.tab-delete input.tab-id").val(id);
	})

	$(document).on("submit", "form.tab-delete", function () {
		let id = $("form.tab-delete input.tab-id").val();

		tab.delete({
			id: id
		});

		return false;
	})

	$(document).on("click", "button.tab-content-add", function () {
		let id = $(this).data('tab-id');
		$("form.tab-content-add input.tab-id").val(id);
	})

	$(document).on("submit", "form.tab-content-add", function () {
		let tab_id = $("form.tab-content-add input.tab-id").val();
		let title = $("form.tab-content-add input.title").val();
		let content = $("form.tab-content-add textarea.content").val();

		tab_content.add({
			tab_id: tab_id,
			title: title,
			content: content
		})

		return false;
	})

	$(document).on("click", "button.tab-content-update", function () {
		let tab_id = $(this).data('tab-id');
		let id = $(this).data('id');
		let title = $(this).data('title');
		let content = $(this).data('content');

		$("form.tab-content-update input.tab-id").val(tab_id);
		$("form.tab-content-update input.tab-content-id").val(id);
		$("form.tab-content-update input.title").val(title);
		$("form.tab-content-update textarea.content").val(content);

		CKEDITOR.replace('content');
	})

	$(document).on("submit", "form.tab-content-update", function () {
		let tab_id = $("form.tab-content-update input.tab-id").val();
		let id = $("form.tab-content-update input.tab-content-id").val();
		let title = $("form.tab-content-update input.title").val();
		let content = $("form.tab-content-update textarea.content").val();

		tab_content.update({
			tab_id: tab_id,
			id: id,
			title: title,
			content: content
		});

		return false;
	})

	$(document).on("click", "button.tab-content-delete", function () {
		let tab_id = $(this).data('tab-id');
		let id = $(this).data('id');
		let title = $(this).data('nama');

		$("form.tab-content-delete b.nama").html(title);
		$("form.tab-content-delete input.tab-id").val(tab_id);
		$("form.tab-content-delete input.tab-content-id").val(id);
	})

	$(document).on("submit", "form.tab-content-delete", function () {
		let tab_id = $("form.tab-content-delete input.tab-id").val();
		let id = $("form.tab-content-delete input.tab-content-id").val();

		tab_content.delete({
			tab_id: tab_id,
			id: id
		});

		return false;
	})

	$(document).on("click", "button.tab-set-up", function () {
		let id = $(this).data('id');

		tab.setUp({
			id: id
		});
	})

	$(document).on("click", "button.tab-set-down", function () {
		let id = $(this).data('id');

		tab.setDown({
			id: id
		});
	})
</script>