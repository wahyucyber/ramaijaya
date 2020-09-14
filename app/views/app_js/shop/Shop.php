
<script>
	
	var $jp_client_token = check_auth()

	class Shop {
		constructor()
		{
			this.run();
		}
		run()
		{
			var data = {
				slug: uri_segment(2)
			}
			callApi('shop/detail/',data,function(res){
				if (res.Error) {

				}else{
					var data = res.Data
					$('img.banner--toko').attr('src',data.banner_toko?
														base_url(data.banner_toko) : base_url('assets/img/default/seller_no_cover_3.png'))
					$('img.logo--toko').attr('src',data.logo_toko?
														base_url(data.logo_toko) : base_url('assets/img/default/shop.png'))
					$('.nama--toko').html(data.nama_toko)
					$('.deskripsi--toko').html(data.deskripsi? data.deskripsi : '<small class="text-muted"><i>Deskripsi toko tidak tersedia</i></small>')
					$('.kabupaten--toko').html(data.nama_kabupaten)
					$('.total-produk--toko').html(Format_Rupiah(data.jumlah_produk.toString()))
					var catatan = '',
					    navs = '',content = '';
					if(data.catatan){
					    $.each(data.catatan,function(index,data){
					        navs += `<a class="btn btn-light mb-3 ${index == 0? 'active' : ''}" data-toggle="pill" href="#catatan-${data.id}-menu" role="tab" aria-selected="true">${data.judul}</a>`
					        content += `<div class="tab-pane fade show ${index == 0? 'active' : ''}" id="catatan-${data.id}-menu" role="tabpanel">
                    				      	${data.teks}
                    				      </div>`
					    })
					    catatan += `<div class="row">
                    				  <div class="col-3">
                    				    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    				        ${navs}
                    				    </div>
                    				  </div>
                    				  <div class="col-9">
                    				    <div class="tab-content border p-3" id="v-pills-tabContent">
                    				      ${content}
                    				    </div>
                    				  </div>
                    				</div>`
                        $('#ModalCatatanToko .modal-body').html(catatan)
					}else{
					    $('#ModalCatatanToko .modal-body').html('<div class="alert alert-danger text-center"> Toko tidak memiliki catatan</div>')
					}

				}
			})
		}
	}

	var shop = new Shop

</script>