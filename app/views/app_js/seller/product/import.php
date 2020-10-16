<?php include __DIR__.'/../Seller.php' ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.5/xlsx.full.min.js"></script>
<script type="text/javascript">
	class Import_produk {
		constructor() {
			this.getEtalase();
		}

		getKategori() {
			callApi('category/',null,res => {
				let output = ``;
				$.each(res.Data, function(index, val) {

					if (val.sub_kategori.length > 0) {
						$.each(val.sub_kategori, function(index_sub, val_sub) {
							output += `
								<tr>
									<td>${val_sub.id_kategori}</td>
									<td>${val_sub.nama_kategori}</td>
								</tr>
							`;
						});
					}else{
						output += `
							<tr>
								<td>${val.id_kategori}</td>
								<td>${val.nama_kategori}</td>
							</tr>
						`;
					}
				});

				$("table#table-export-produk tbody").html(output);
			})
		}

		exportF(elem) {
		  var table = document.getElementById("table-export-produk");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Kategori.xls"); // Choose the file name
		  return false;
		}

		getEtalase() {
			callApi('seller/etalase/get', { client_token: $jp_client_token },res => {
				let output = ``;
				$.each(res.Data, function(index, val) {
					output += `
						<tr>
							<td>${val.id}</td>
							<td>${val.nama}</td>
						</tr>
					`;
				});

				$("table#table-export-etalase tbody").html(output);
			})
		}

		exportEtalase(elem) {
		  var table = document.getElementById("table-export-etalase");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Etalase.xls"); // Choose the file name
		  return false;
		}

		fileReader(oEvent) {
	        var oFile = oEvent.target.files[0];
	        var sFilename = oFile.name;

	        var reader = new FileReader();
	        var result = {};

	        reader.onload = function (e) {
	            var data = e.target.result;
	            data = new Uint8Array(data);
	            var workbook = XLSX.read(data, {type: 'array'});
	            console.log(workbook);
	            var result = {};
	            workbook.SheetNames.forEach(function (sheetName) {
	                var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
	                // if (roa.length) result[sheetName] = roa;
	                if (roa.length) result = roa;
	            });

	            $("div.result-message").html('');

	            callApi("seller/product/import", {
	            	client_token: $jp_client_token,
	            	json_data: JSON.stringify(result)
	            }, res => {
	            	let message = ``;
	            	$.each(res, function(index, val) {
	            		if (val.Error == true) {
	            			message += `
	            				<div class="alert alert-danger">
	            					${val.Message}
	            				</div>
	            			`;
	            		}else{
	            			message += `
	            				<div class="alert alert-success">
	            					${val.Message}
	            				</div>
	            			`;
	            		}
	            	});

	            	$("div#loading-import").removeClass("in");
					$(".modal-backdrop").remove();
					$('body').removeClass('modal-open');
					$('body').css('padding-right', '');
					$("div#loading-import").hide();
	            	$("div.result-message").html(message);
	            });
	        };
	        reader.readAsArrayBuffer(oFile);
		}
	}

	let import_produk = new Import_produk;

	$(document).on("click", "a.download-kategori-excel", function () {
		import_produk.exportF(this);
	})

	$(document).on("click", "a.download-etalase-excel", function () {
		import_produk.exportEtalase(this);
	})

	$(document).on("click", "div.import-produk", function () {
		$("input[type=file].file").trigger('click');
	})

	$(document).on("change", "input[type=file].file", function (e) {
		import_produk.fileReader(e);
		$("div#loading-import").modal('show');
	})
</script>