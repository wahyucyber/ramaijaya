$(document).ready(() => {

	var winSize = $(window).width()

	window.onload = function(){
		$('body .select2').select2({
			placeholder: $(this).attr('data-placeholder'),
			language: {
				noResults: function(term){
					return $(`<small class="fs-13 text-dark-2">Tidak ada hasil ditemukan</small>`)
				}
			},
		})
	}

	$('body .select2.minimum').select2({
		placeholder: $(this).attr('data-placeholder'),
		language: {
			noResults: function(term){
				return $(`<small class="fs-13 text-white-lightern-3">Tidak ada hasil ditemukan</small>`)
			}
		},
		minimumResultsForSearch: -1
	})

	// if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
	//     || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
	// 	// $('#modalApp').modal('show')
	// } 

	function ucFirst(str){
	     return str.replace(/\w\S*/g, function(txt){
	     	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	     });
	}

	$.widget( "custom.catcomplete", $.ui.autocomplete, {
	    _create: function() {
	      this._super();
	      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
	    },
	    _renderMenu: function( ul, items ) {
	      	var that = this,
	        currentCategory = "";
			$.each( items, function( index, item ) {
				var li;
				if ( item.category != currentCategory ) {
				  ul.append( "<li class='ui-autocomplete-category'>" + ucFirst(item.category) + "</li>" );
				  currentCategory = item.category;
				}
				li = that._renderItemData( ul, item );
				if ( item.category ) {
				  li.attr( "aria-label", item.category + " : " + item.label );
				}
			});
	    },
	    _renderItem: function( ul, item) {
	    	var t = String(item.value).replace(
	                new RegExp(this.term, "gi"),
	                "<b>$&</b>");


	    	var link = `${base_url()}search?q=${item.slug}&st=produk`,
	    		output = '';

	    	if (!item.status) {
	    		link = 'javascript:;';
	    	}

	    	if (item.category == 'toko') {
	    		output = `<a class="ui-corner-all text-elipsis search--result-content" href="${base_url()}shop/${item.slug}">
					<div class="search--result-content">
						<div class="search--result-logo">
							<img src="${item.logo? item.logo : base_url('assets/img/default/shop.png')}" alt="" />
						</div>
						<div class="search--result-details">
							<h4 class="fs-14 mb-1 fw-500">${t}</h4>
							<h5 class="fs-12 text-dark-2"><i class="fad fa-map-marker-alt"></i> ${item.kabupaten}</h5>
						</div>
					</div>
	    		</a>`;
	    	}else if(item.category == 'profil'){
	    		output = `<a class="ui-corner-all text-elipsis shop--result-content" href="${base_url()}people/${item.slug}">
					<div class="search--result-content">
						<div class="search--result-logo">
							<img src="${item.logo? item.logo : base_url('assets/img/default/profile.jpg')}" alt="" />
						</div>
						<div class="search--result-details">
							<h4 class="fs-15 mb-1 fw-500">${t}</h4>
						</div>
					</div>
	    		</a>`;
	    	}else{
	    		output = `<a class='ui-corner-all text-elipsis ${!item.status? 'text-center disabled' : ''}' href="${link}">${item.status? t : item.label}</a>`;
	    	}

	        return $( "<li></li>" )
	        .data( "item.autocomplete", item )
	        .append(output)
	        .appendTo( ul );
	    }
	  });

	$('#show-search-navbar').on('click', function(event) {
		event.preventDefault();
		
		$('#form-keyword').addClass('is-active');
		$('body').addClass('active')
		$('#navbar-search-input').focus()

	});

	$('#hide-search-navbar').on('click', function(event) {
		event.preventDefault();
		$('body').removeClass('active')
		$(this).parent().parent('#form-keyword').removeClass('is-active')
	});


	if (winSize > 539) {
		$('.backend-sidebar .backend-sidebar-body').hover(function() {
			$(this).parent().css({
				width: '20%'
			})
		}, function() {
			$(this).parent().removeAttr('style')
		});
		$(document).on({
		    mouseenter: function () {
		        $(this).addClass('open')
				$('#backdrop').addClass('active')
		    },

		    mouseleave: function () {
		        $(this).removeClass('open')
				$('#backdrop').removeClass('active')
		    }
		}, '.dropdowns');
	}else{
		$(document).on('click', '.dropdowns .btn-dropdowns', function(event) {
			event.preventDefault();
			$('body').addClass('dropdowns-open')
			$(this).parents('.dropdowns').addClass('open');
		});

		$(document).on('click', '.dropdowns .btn-dropdowns--header', function(event) {
			event.preventDefault();
			$('body').removeClass('dropdowns-open')
			$(this).parents('.dropdowns').removeClass('open');
		});
		$('#btn-close-sidebar').on('click', function(event) {
			event.preventDefault();
			
			$('#sidebar').addClass('is-off')
			$('body').removeClass('active')
			setTimeout(function(){
				$('#sidebar').removeClass('is-active').removeClass('is-off');
				$('#backdrop-sidebar').removeClass('is-active')
			},100)

		});
		$('#sidebar-toggle').on('click touchmove', function(event) {
			event.preventDefault();
			
			$('#sidebar').addClass('is-active');
			$('body').addClass('active')
			$('#backdrop-sidebar').addClass('is-active')

		});
		$(document).on('click touchmove', function(event) {

			if (!event.target.matches('#sidebar-toggle *,#sidebar-toggle, #btn-close-sidebar, #btn-close-sidebar *')) {
				$('#sidebar').addClass('is-off')
				$('body').removeClass('active')
				setTimeout(function(){
					$('#sidebar').removeClass('is-active').removeClass('is-off');
					$('#backdrop-sidebar').removeClass('is-active')
					$('#backdrop').removeClass('is-active')
				},100)
			}
			
			
		});
	}

	$(document).on('focus', '#navbar-search-input',function() {
		
		$('#backdrop').addClass('active')
		$('#result-autocomplete').css('display','block')
		$('body').addClass('active')

	})

	$(document).on('blur', '#navbar-search-input', function() {
	
		$('#backdrop').removeClass('active')
		$('#result-autocomplete').css('display','none')
		$('body').removeClass('active')

	});


	$('#btn-search-query').on('click', function(e) {

		if (search_keyword.val().length > 0) {
			return true;
		}else{
			search_keyword.focus()
			return false;
		}

		
	});

	$(document).on('input','textarea', function (e) {
		this.style.height = 'auto';
		this.style.height = (this.scrollHeight+3) + 'px';
		var val = $(this).val()
		var newval = $(this).val().replace(/(?:\r\n|\r|\n)/g, '\n');
		if (e.keyCode == 13 && e.keycode == 16) {
			val+'\n'
		}
	});

	

	$('#btn-toggle-sidebar').on('click', function(event) {
		event.preventDefault();
		
		$('#backend-sidebar').toggleClass('collapsed');
		// $('#backend-sidebar #navbar').toggleClass('expanded');
		$('#content-right').toggleClass('expanded');

	});

	$('#backend-sidebar .list-item .btn-collapse').on('click', function(event) {
		event.preventDefault();
		$(this).parent().toggleClass('active')
		$(this).parent().find('.collapse').collapse('toggle')
	});

	// qty input 
	$(document).on('input change','.quantity-input .qty',function() {
		
		if ($(this).val() > 1) {
			$(this).parent('.quantity-input').children('.qty-min').removeClass('disabled')
		}else{
			$(this).parent('.quantity-input').children('.qty-min').addClass('disabled')
		}

		
	});

	$(document).on('click', '.quantity-input .qty-min', function(event) {
		event.preventDefault();
		this.parentNode.querySelector('input.qty').stepDown()
	});

	$(document).on('click', '.quantity-input .qty-plus', function(event) {
		event.preventDefault();
		this.parentNode.querySelector('input.qty').stepUp()
	});

	$(document).on('click', '.quantity-input .qty-btn', function(e) {
		e.preventDefault();

		$(this).parent('.quantity-input').children('.qty').change()

	});

	

	

	// bootstrap validate
	window.addEventListener('load', function() {
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
		  form.addEventListener('submit', function(event) {
		    if (form.checkValidity() === false) {
		      event.preventDefault();
		      event.stopPropagation();
		    }
		    form.classList.add('was-validated');
		  }, false);
		});
	}, false);

	$('input[maxlength].input--length,textarea[maxlength].input--length').each(function() {
		$(this).parent().append('<div class="text-right fs-13 text-muted mt-2 input-length">\
			Maksimum <span class="fw-bold">'+$(this).attr('maxlength')+'</span> Karakter\
					              </div>')
	})

	$(document).on('input', 'input[maxlength].input--length,textarea[maxlength].input--length', function() {
		
		var maxlength = $(this).attr('maxlength')
		var length = $(this).val().length

		$(this).parent().find('.input-length').html(length+' dari '+maxlength)
		
	});

	class BackendPage {

		min()
		{
			$('#backend-sidebar').addClass('collapsed')
			$('#content-right').addClass('expanded')
		}

		max()
		{
			$('#backend-sidebar').removeClass('collapsed')
			$('#content-right').removeClass('expanded')
		}

	}

	var backend_page  = new BackendPage()

	var windowSize = $(window).width()

	if (windowSize > 539) {
		backend_page.max()
	}else{
		backend_page.min()
	}


	// $(window).resize(() => {

	// 	windowSize = $(window).width()

	// 	if (windowSize > 539) {
	// 		backend_page.max()
	// 	}else{
	// 		backend_page.min()
	// 	}

	// })

// upload_image

	$(document).on('change', '.file-upload .file-upload-item input.data-base64', function(event) {
		$(this).parents('.file-upload-item').removeClass('active').removeClass('disabled')
		var next  = $(this).parents('.file-upload-item').next('.file-upload-item')

		if (next.hasClass('disabled')) {
			next.removeClass('disabled').addClass('active')
		}else if(next.next('.file-upload-item').hasClass('disabled')) {
			next.next('.file-upload-item').removeClass('disabled').addClass('active')
		}else if(next.next('.file-upload-item').next('.file-upload-item').hasClass('disabled')) {
			next.next('.file-upload-item').next('.file-upload-item').removeClass('disabled').addClass('active')
		}else if(next.next('.file-upload-item').next('.file-upload-item').next('.file-upload-item').hasClass('disabled')) {
			next.next('.file-upload-item').next('.file-upload-item').next('.file-upload-item').removeClass('disabled').addClass('active')
		}
		
	});

	$(document).on('click', '.file-upload .file-upload-item button.btn-delete-file-upload', function(event) {
		event.preventDefault();
		var parent = $(this).parents('.file-upload-item')
		var img_default = parent.find('img').attr('data-default')
		var next = parent.next('.file-upload-item')
		var prev = parent.prev('.file-upload-item')
		parent.addClass('active')

		if (next.length > 0) {

			if (next.find('input.data-base64').attr('data-base64').length > 0) {
				next.removeClass('active').removeClass('disabled')
			}else{
				next.removeClass('active').addClass('disabled')
			}

			parent.nextAll('.file-upload-item').each((no,data) => {
				if ($(data).find('input.data-base64').attr('data-base64').length < 1) {
					$(data).removeClass('active').addClass('disabled')
				}
			})

		}

// 		if (prev.length > 0) {
// 			parent.prevAll('.file-upload-item').each((no,data) => {
// 				if ($(data).find('input.data-base64').attr('data-base64').length < 1) {
// 					parent.removeClass('active').addClass('disabled')
// 				}
// 			})
// 		}

		parent.find('img').attr('src',img_default)
		parent.find('input.data-base64').attr('data-base64','')

	});

$(document).on('click', '[data-toggle=show-password]', function(event) {
	event.preventDefault();
	var target = $(this).attr('data-target')
	$(target).togglePassword('type','password')
	$(this).toggleClass('show')
});
(function($){
	$.fn.togglePassword = function(at,type) 
	{
		if (type == 'password') {
			var this_type = this.attr(at)
			if (this_type == type) {
				this.attr(at,'text')
			}else{
				this.attr(at,type)
			}
		}
	}
})(jQuery)
$(document).on('click', '.shared--content button.shared--btn', function(event) {
	event.preventDefault();
	var url = $(this).attr('data-url')
	if (windowSize <= 539) {
		$('body').toggleClass('shared--activated')
	}
	$(this).parents('.shared--content').find('[data-action=shared]').attr('data-url',url)
	$(this).parents('.shared--content').toggleClass('open')
});

function textToClipboard (text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}

$(document).on('click', '[data-action=shared]', function(event) {
	event.preventDefault();
	var tipe = $(this).attr('data-type'),
		link = $(this).attr('data-url'),
		url = '';
	switch(tipe){
		case 'facebook' :
			url = 'https://www.facebook.com/sharer.php?u='+link
			window.open(url,'_blank')
			break;
		case 'whatsapp' :
			url = "whatsapp://send?text="+link
			window.open(url,'_blank')
			break;
		case 'twitter' :
			url = "https://twitter.com/intent/tweet?url="+link
			window.open(url,'_blank')
			break;
		case 'copy' :
			textToClipboard(link)
			notifAlert('Link berhasil di salin','',3000)
			break;

	}
});

if (windowSize <= 539) {
	$(document).on('click', '.shared--content .shared--overlay', function(event) {
		event.preventDefault();
		var parent = $(this).parents('.shared--content')
		parent.addClass('closing')
		setTimeout(function(){
			$('button.shared--btn-close').parents('.shared--content').removeClass('open').removeClass('closing')
		},500)
		$('body').removeClass('shared--activated')
	});
	$(document).on('click', '.shared--content  button.shared--btn-close', function(event) {
		event.preventDefault();
		var parent = $(this).parents('.shared--content')
		parent.addClass('closing')
		setTimeout(function(){
			$('.shared--content button.shared--btn-close').parents('.shared--content').removeClass('open').removeClass('closing')
		},500)
		$('body').removeClass('shared--activated')
	});
}else{
	$(document).on('click', function(event) {
		if (!event.target.matches('.shared--content button.shared--btn')) {
				$('.shared--content').removeClass('open')
			}
	});
}

// chat features


$(document).on('click', '[data-toggle=chating]', function(event) {
	event.preventDefault();
	$('.chat--content').toggleClass('open').trigger('classChange')
});

$(document).on('click', '.chat--content .close--btn', function(event) {
	event.preventDefault();
	$('.chat--content').toggleClass('open').trigger('classChange')
});

$(document).on('click', '.chat--content .meta--close button', function(event) {
	event.preventDefault();
	$('.chat--content .placeholder--meta').remove()
	if(windowSize <= 539){
	    $('.chat--content .chat--body').css({
	        height: '600px'
	    })
	}else{
	    $('.chat--content .chat--body').css({
	        height: '335px'
	    })
	}
});

// $(document).on('keyup','.chat--content .form--type-msg',function(e){
// 	var bodyHeight = $(this).parents('.chat--content').find('.chat--body')[0].scrollHeight
// 	var formHeight = $(this).parents('.chat--footer')[0].scrollHeight
// 	var add = 55;
// 	if (windowSize <= 539) {
// 		add = 27
// 	}
// 	var NewHeight = parseInt(bodyHeight) - (parseInt(formHeight) + add)
// 	$(this).parents('.chat--content').find('.chat--body').css({
// 		height: NewHeight+'px'
// 	})
// 	console.log(NewHeight+'px')
// })

$(document).on('classChange sendChat', '.chat--content', function(event) {
	event.preventDefault();
	if ($('.chat--content').hasClass('open')) {
		$('.chat--content .chat--body').scrollTop($('.chat--content .chat--body')[0].scrollHeight)
		$('.chat--content .form--type-msg').removeAttr('style')
		if (windowSize <= 539) {
			$('body').css({
			    overflowY: 'hidden'
			})
		}
		
	}else{
		if (windowSize <= 539) {
			$('body').removeAttr('style')
		}
	}
});


// $(document).on('keyup','.chat--box .form--type-msg',function(e){
// 	var bodyHeight = $(this).parents('.chat--box').find('.chat--box-body')[0].scrollHeight
// 	var formHeight = $(this).parents('.chat--box-footer')[0].scrollHeight
// 	var addHeight = 112;
// 	if (windowSize <= 539) {
// 		addHeight = 27
// 	}
// 	var NewHeight = parseInt(bodyHeight) - (parseInt(formHeight) + addHeight)
// 	$(this).parents('.chat--box').find('.chat--box-body').css({
// 		height: NewHeight+'px'
// 	})
// })


$(document).on('open.chat','.chat--box',function(e){

	$(this).addClass('open--chat')
	$('.chat--box .chat--box-body').scrollTop($('.chat--box .chat--box-body')[0].scrollHeight)

})

$(document).on('close.chat','.chat--box',function(e){

	$(this).removeClass('open--chat')
	$(this).find('.chat--box-message-item').removeClass('active')

})

$(document).on('save.chat','.chat--box',function(e){

	$('.chat--box .chat--box-body').scrollTop($('.chat--box .chat--box-body')[0].scrollHeight)
	$('.chat--box .form--type-msg').css({
	    height: 'auto'
	})

})

$(document).on('click', '.chat--box .chat--box-message-item', function(event) {
	event.preventDefault();
	$(this).addClass('active')
	$('.chat--box .chat--box-message-item').not(this).removeClass('active')
});

$(document).on('click', '.chat--box .close--chat', function(event) {
	event.preventDefault();
	$(this).parents('.chat--box').trigger('close.chat')
});


$(document).on('click', '.btn--dropify .btn', function(event) {
	event.preventDefault();
	$(this).parent().toggleClass('open')
	$('.btn--dropify').not($(this).parent()).removeClass('open')
});

$(document).on('click', '.btn--dropify .dropify--item:not(.disabled)', function(event) {
	event.preventDefault();
	$(this).trigger('selected')

})

$(document).on('selected', '.btn--dropify .dropify--item', function(event) {
	event.preventDefault();
	$(this).addClass('selected')
	$(this).parents('.btn--dropify').find('.dropify--item').not($(this)).removeClass('selected')
});


function get_step_value(value)
{
	var num = parseInt(value)
	if (num < 75) {
		return `calc(${value}% - 100px)`
	}
	if (num < 100) {
		return `calc(${value}% - 60px)`
	}
	if (num >= 100) {
		return `100%`
	}
}

function get_step_bg(value)
{
	var num = parseInt(value)
	if (num <= 25) {
		return '#ffc107'
	}
	if (num <= 50) {
		return '#17a2b8'
	}
	if(num <= 75) {
		return '#007bff'
	}
	if (num <= 100) {
		return '#28a745'
	}
}


$(document).on('set.active', '.step--status .step--list-item:not(.active)', function(event) {
	event.preventDefault();
	
	var stepValue = 0;

	var __this = $(this)

	var stepLength = 4

	var defaultWidth = ((100 / parseInt(stepLength)) * parseInt(__this.index() + 1))

	var stepValueWidth = get_step_value(defaultWidth)

	var stepColor = get_step_bg(defaultWidth)

	__this.parents('.step--status').find('.step--status-value').css({
		width: stepValueWidth,
		background: stepColor
	})

	var prevStep = __this.prevAll('.step--list-item:not(.active)')
	prevStep.each(function(i,el){
		$(el).addClass('active')
		$(el).find('.list-item-content').css('--step-bg',stepColor)
	})
	__this.addClass('active')

	__this.find('.list-item-content').css('--step-bg',stepColor)

});

})