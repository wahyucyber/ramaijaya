
<script>

	class Faq {
		constructor()
		{
			this.load()
		}
		load()
		{
			callApi('faq/',null,function(res){
				var menu = ''
				if (res.Error) {
					$('#faq--list').html('<div class="col-md-12"><div class="alert alert-warning">Faq tidak ditemukan</div></div>')
				}else{
					var result = res.Data,
							active_menu;

					$.each(result,function(index,data){
						if (index == 0) {
							active_menu = data.id
						}
						menu += `<a href="javascript:;" data-id="${data.id}" class="list-group-item list-group-item-action btn--menu ${index == 0? 'active' : ''}">
						    ${data.menu}
						  </a>`
					})
					faq.detail(active_menu)
					$('#menu--content').html(menu)
				}

			})
		}

		detail(id_menu)
		{
			callApi('faq/detail/',{id_menu: id_menu},function(res){
				if (res.Error) {
					$('#detail--content').html('<div class="alert alert-warning">Menu tidak memiliki pertanyaan</div>')
				}else{
					var result = res.Data,
						detail = ''

					$.each(result,function(index,data){
						detail += `<div class="card">
								    <div class="card-body bg-info p-2" id="head--${data.id}">
								      <h2 class="mb-0">
								        <button class="btn text-white btn-block text-left" type="button" data-toggle="collapse" data-target="#menu-${data.id}-detail" aria-expanded="true" aria-controls="menu-${data.id}-detail">
								          <strong>Q:</strong> ${data.pertanyaan}
								        </button>
								      </h2>
								    </div>

								    <div id="menu-${data.id}-detail" class="collapse ${index == 0? 'show' : ''}" aria-labelledby="head--${data.id}" data-parent="#detail--content">
								      <div class="card-body">
								        <strong>A:</strong> ${data.jawaban}
								      </div>
								    </div>
								  </div>`
					})
					$('#detail--content').html(detail)
				}
			})
		}
	}

	var faq = new Faq

	$(document).on('click', '.btn--menu:not(.active)', function(event) {
		event.preventDefault();
		$(this).addClass('active')
		$('.btn--menu').not($(this)).removeClass('active')
		faq.detail($(this).attr('data-id'))
	});

</script>