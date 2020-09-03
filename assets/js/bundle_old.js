"use-strict";

$(document).ready(function(){

	if (typeof home == 'function') {

		if ($('#flash-sale-content')) {
			$('#flash-sale-content').slick({
				draggable: false,
				infinite: false,
				speed: 300,
				slidesToShow: 5,
				slidesToScroll: 5,
				adaptiveHeight: true,
				variableWidth: true,
				lazyLoad: 'ondemand',
			    lazyLoadBuffer: 0,
			    cssEase: 'linear',
			    responsive: [
				    {
				      breakpoint: 540,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2,
				      }
				    },
			    ]
			});
		}

		if ($('#brand-slider')) {
			$('#brand-slider').slick({
				draggable: false,
				infinite: false,
				speed: 300,
				slidesToShow: 5,
				slidesToScroll: 5,
				adaptiveHeight: true,
				variableWidth: true,
				lazyLoad: 'ondemand',
			    lazyLoadBuffer: 0,
			    cssEase: 'linear',
			    responsive: [
				    {
				      breakpoint: 540,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2,
				      }
				    },
			    ]
			});

			$('#brand-slider').on('touchmove', function(event) {
				event.preventDefault();
				if (!$(this).hasClass('touchstart')) {
					$(this).addClass('touchstart')
				}else{
					$(this).off('touchmove')
				}
			});

		}

		if ($('#newsletter-readmore')) {
			$('#newsletter-readmore').expander({
	            slicePoint: 550,
	            expandText: 'Selengkapnya',
	            userCollapseText: '',
	            expandEffect: 'fadeIn',
	        });
		}

		var timeFlashSale = $('.setTimeFlashSale');

		var sec   = 0;
        var minute   = 40;
        var hour     = 48;
              


	}

	if (typeof cart == 'function') {

		

		$('#checkAll').click(function(){
			$('input:checkbox').not(this).prop('checked', this.checked)
		})

		$('.note-for-seller .display-handler').click(function() {
			
			$(this).parent('.note-for-seller').addClass('textfield-displayed')
			$(this).parent('.note-for-seller').find('textarea').focus()

		});

		$('.note-for-seller .olc-wrapper').click(function() {
			
			$(this).parent('.note-for-seller').addClass('textfield-displayed')
			$(this).parent('.note-for-seller').find('textarea').focus()

		});

		$('.note-for-seller .display-target .form-group textarea').on('input', function() {
			
			var scroll_height = $(this).get(0).scrollHeight;

			$(this).css('height', scroll_height + 'px');
			if ($(this).val().length > 144) {
				return false;
			}

			
		});

		$('.note-for-seller .display-target .form-group textarea').blur( function() {
			
			$(this).parent().parent().parent('.note-for-seller').removeClass('textfield-displayed')
			if ($(this).val().length > 0) {
				$(this).parent().parent().parent('.note-for-seller')
				.addClass('olc-displayed');
				$(this).parent().parent().parent('.note-for-seller').find('.olc-text').html($(this).val())
			}else{
				$(this).parent().parent().parent('.note-for-seller')
				.removeClass('olc-displayed');
				$(this).parent().parent().parent('.note-for-seller').find('.olc-text').html('')
			}

		});

	}

	if (typeof productSingle == 'function') {

		 $('#slider-product-single').slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  fade: true,
		  draggable:false,
		  asNavFor: '#slider-product-nav',
		  infinite: false,
		  responsive: [
			    {
			      breakpoint: 540,
			      settings: {
					infinite: true,
			        fade: false
			      }
			    },
		    ]
		});

		$('#slider-product-nav').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  asNavFor: '#slider-product-single',
		  dots: false,
		  centerMode: true,
		  draggable:false,
		  infinite: false,
		  focusOnSelect: true
		});

		$('#filter-o').slick({
			draggable: true,
			infinite: false,
			speed: 300,
			slidesToShow: 5,
			slidesToScroll: 5,
			adaptiveHeight: true,
			variableWidth: true,
		    responsive: [
			    {
			      breakpoint: 540,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 2,
			      }
			    },
		    ]
		})

		$('#calc-shipping').on('click', function(event) {
			event.preventDefault();
			
			$('.shipping-result').addClass('active')

		});

		$('.btn_collapse_shipping').on('click', function(event) {
			event.preventDefault();
			if(!$(this).hasClass('collapsed')){
				$(this).children('i').removeClass('fa-angle-up')
				$(this).children('i').addClass('fa-angle-down')
			}
			if ($(this).hasClass('collapsed')) {
				$(this).children('i').addClass('fa-angle-up')
				$(this).children('i').removeClass('fa-angle-down')
			}


		});


		$("[data-fancybox]").fancybox({
			// thumbs: {
			// 	autoStart: true,
			// 	hideOnClose: true,
			// 	parentEl: ".fancybox-container",
			// 	axis: "y"
			// },
			transitionEffect: "tube",
		});

	}

	if (typeof categorySingle == 'function') {
		if ($('#top-slider')) {

			$('#slick-slider-inner').addClass('_c287e')
			
			setTimeout(function(){
				$('#top-slider').removeClass('d-none')
				$('#slick-slider-inner').removeClass('_c287e')
			},4000)
			$('#top-slider').slick({
				draggable: false,
				centerMode: true,
				centerPadding: '60px',
				dots: true,
				speed: 400,
				useTransform: true,
				cssEase: 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight: true,
				variableWidth: true,
				autoplay: true,
				autoplaySpeed: 5000,
			});


		}
		if ($('#sub-category')) {
		
			$('#sub-category').slick({
				draggable: true,
				dots: false,
				speed: 400,
				infinite: false,
				slidesToShow: 6,
				slidesToScroll: 6,
				adaptiveHeight: true,
				variableWidth: true,
				responsive: [
				    {
				      breakpoint: 540,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2,
				      },
				    },
			    ]
			});

		}

		if ($('#product-category-slider')) {
		
			$('#product-category-slider').slick({
				draggable: true,
				dots: false,
				speed: 400,
				infinite: false,
				slidesToShow: 4,
				slidesToScroll: 4,
				adaptiveHeight: true,
				variableWidth: true,
				responsive: [
				    {
				      breakpoint: 540,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1,
				      }
				    },
			    ]
			});

		}
	}

	$('#btn-close-sidebar').on('click', function(event) {
		event.preventDefault();
		
		$('#sidebar').addClass('is-off')
		$('body').removeClass('active')
		setTimeout(function(){
			$('#sidebar').removeClass('is-active').removeClass('is-off');
			backdrop.removeClass('is-active')
		},100)

	});

	$('#btn-toggle-filter').on('click', function(event) {
		event.preventDefault();
		$('#filter-b').collapse('toggle');
		$(this).find('i').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
	});

	
	$('#filter-o .btn_filter').on('click', function(event) {
		event.preventDefault();
		$('#filter-o .btn_filter').not(this).removeClass('active')
		$(this).addClass('active');

	});

	if (typeof seller == 'function') {

		if (typeof seller_order == 'function') {

			$('#filter-o').slick({
				draggable: true,
				infinite: false,
				speed: 300,
				dots: false,
				slidesToShow: 5,
				slidesToScroll: 5,
				adaptiveHeight: true,
				variableWidth: true,
			    responsive: [
				    {
				      breakpoint: 540,
				      settings: {
				        slidesToShow: 2,
				        slidesToScroll: 2,
				      }
				    },
			    ]
			})

			$('#filter-o .slick-arrow').hide()
		}

		if (typeof addProduct == 'function') {

			// img upload

			function viewImg(input,imgView)
			{
				if (input.files && input.files[0]) {
		            var reader = new FileReader();
		            
		            reader.onload = function (e) {
		            	imgView.css('background','url('+e.target.result+')')
		            }
		            reader.readAsDataURL(input.files[0]);
		            $(input).parent().removeClass('active')
		        }
			}

		    $('.input-wrapper').on('change', function(e) {
		    	e.preventDefault();
	            // $('.trigger-file-upload').removeClass('disabled').addClass('active')
		    	viewImg(this,$(this).parent().find('.img-viewer'))
		    });

			$('.trigger-file-upload .img-viewer').on('click', function(event) {
				event.preventDefault();
				$(this).parent().find('.input-wrapper').trigger('click')
			});

			// end
		}



	}

})
