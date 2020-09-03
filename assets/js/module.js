
var token_api = JSON.parse(atob($csrf))

var $userdata = [
	'jp_token',
	'role',
	'role_session'
];

var $app_name = $('meta[name=app_name]').attr('content');

var $title = $('meta[name=title]').attr('content');

function base_url(url = '')
{
	return $app_url+url
}

function api_url(url = '')
{
	return $api_url+url
}


function page_title(label = $title)
{
	$('title').html($app_name+' | '+label);
}

page_title($title)

class Session {

	set_flashdata(key,value)
	{
		sessionStorage.setItem(key,JSON.stringify(value));
	}

	flashdata(key)
	{
		setTimeout(function(){
			session.destroy_flashdata(key)
		},2000*10)
		return JSON.parse(sessionStorage.getItem(key));
	}

	destroy_flashdata(key)
	{
		if (Array.isArray(key)) {
			
			for(var i = 0;i < key.length;i++){
				sessionStorage.removeItem(key[i])
			}

		}else{
			sessionStorage.removeItem(key)
		}
	}

	set_userdata(key,value)
	{
		localStorage.setItem(key,JSON.stringify(value));
	}

	userdata(key)
	{
		return JSON.parse(localStorage.getItem(key));
	}

	destroy_userdata(key)
	{
		if (Array.isArray(key)) {
			
			for(var i = 0;i < key.length;i++){
				localStorage.removeItem(key[i])
			}

		}else{
			localStorage.removeItem(key)
		}
	}

}

var session = new Session

class Cookie {

	get(key)
	{
		return $.cookie(key)
	}

	set(params)
	{
		var name = params.name,
			value = params.value,
			expires = params.expire
		$.cookie(name,value,{expires: expires, path: '/'})
	}

	remove(key)
	{
		$.removeCookie(key,{path: '/'})
	}

	set_userdata(params)
	{
		var name = params.name,
			value = params.value,
			expires = params.expire
		document.cookie = name+"="+value+";max-age="+expires+";path=/";
	}

	destroy_userdata(name)
	{
		document.cookie = name+"="+''+";max-age="+'';
	}

}

var cookie = new Cookie

class Connection {

	found()
	{
		page_title($title)

		$('#working-page').html('').removeClass('on')
		$('body').removeClass('active')
		console.log('Terhubung...')
	}

	not_found()
	{
		var html = '';

		page_title('Tidak ada koneksi internet');

		html += `<div class="inner">
					<div class="content">
						<div class="logo">
							<img src="${base_url('cdn/default/il-error-not-found.png')}" alt="">
						</div>
						<h4 class="heading">Tidak ada koneksi internet</h4>
						<div class="message">Halaman yang Anda minta memerlukan koneksi internet.</div>
						<button class="btn btn-sm" onclick="window.location.reload(true)"><i class="fa fa-sync"></i> Segarkan</button>
					</div>
				</div>`;
		$('#working-page').html(html).addClass('on')
		$('body').addClass('active')
		console.log('Tidak ada koneksi internet!!')
	}

}

class PageFound {

	found()
	{
		page_title($title)
		reload()
	}

	not_found(title = '')
	{
		var html = '';

		page_title(title? title : '404 - Halaman tidak ditemukan')

		html += `<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
					<div class="text-center">
						<div class="images" style="
							width: 450px;
							margin: 0 auto;
						">
							<img src="${base_url('cdn/default/il-error-not-found.png')}" alt="">
						</div>
						<h4 class="fw-700">404 Halaman tidak ditemukan</h4>
						<span class="d-block mb-3 text-dark-2">Halaman yang Anda minta tidak di temukan..</span>
						<a href="${base_url()}" class="btn btn-primary">Kembali ke Home</a>
					</div>
				</div>`;
		$('.main-wrapper').html(html)
		$('body').addClass('active')
	}

}

var page_found = new PageFound

class Loader {

	show(text = '')
	{
		var html = `<div class="container d-flex justify-content-center h-100">
						<div class="text-center">
							<div class="jpmall-loader"></div>
						</div>
					</div>`
		$('title').html('Sedang Memuat...')
		$('#loader').html(html).addClass('on')
		$('body').addClass('active')
	}

	hide()
	{	
		page_title($title)
		$('#loader').html('').removeClass('on')
		$('body').removeClass('active')
	}

}

class UploadImage {

	constructor()
	{
		this.options()
		this.Opt
	}

	options(width = 0,height = 0,crop = false, quality = 80)
	{
		var data = {
			w: width,
			h: height,
			crop: crop,
			quality: quality
		}

		this.Opt = data
	}

	get_base64(input,image_preview,event,target = null)
	{
		var option = this.Opt
		if (input.files && input.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
            var file = event.target.files[0];
            canvasResize(file, {
		          width: option.w,
		          height: option.h,
		          crop: option.crop,
		          quality: option.quality,
		          //rotate: 90,
		          callback: function(data, width, height) {
	            	input.setAttribute('data-base64',data)
	            	image_preview.attr('src',data)
	            	event.target.value = ''
	            	if (typeof target == 'function') {
		            	target(data);
	            	}
	            	// console.log(data)
		          }
		    });
        }else{
        	
        	alert('Format yang didukung: .jpg .jpeg .png .gif')

        }

	}

}

var winSize = $(window).width()

class Pagination {
    
    constructor()
    {
        this.element = ''
    }

	make(params,el)
	{
	    this.element = el
		if (params) {
			var html = '',
                status = params.Status,
                jumlah_halaman = parseInt(params.Jml_halaman),
                halaman = parseInt(params.Halaman),
                jml_data = parseInt(params.Jml_data),   
                info_paging = params.Info_paging,
                mulai,
                selesai;
                
                var winSize = $(window).width()

                if (jumlah_halaman > 1) {
                    if (winSize > 539) {
                        mulai = halaman,
                        selesai = halaman + 9
                        if (selesai > jumlah_halaman) {
                            selesai = jumlah_halaman
                            mulai = jumlah_halaman - 9
                        }
                    }else{
                        mulai = halaman
                        selesai = halaman + 4
                        if (selesai > jumlah_halaman) {
                            selesai = jumlah_halaman
                            mulai = jumlah_halaman - 5
                        }
                    }
                }else{
                    mulai = halaman
                    selesai = halaman
                }
                
                if (mulai < 1) {
                    mulai = 1
                }


            html += `
                <div class="row">
                    <div class="col-md-6 d-flex d-lg-block order-2 order-lg-0">
                        <small class="my-auto mx-auto">Menampilkan ${info_paging}</small>
                    </div>
                    <div class="col-md-6 mb-2 mb-lg-0">
                        <nav>
                            <ul class="pagination justify-content-center justify-content-lg-end px-2 mb-0">`

                                if (halaman > 1) {
                                    html += `<li class="page-item">
                                                <button class="page-link btn-page" data-page=${halaman-1} rel="prev" title="Sebelumnya"><i class="fa fa-angle-left"></i></button>
                                            </li>`
                                }

                                for(var i = mulai; i <= selesai; i++){
                                    if (i == halaman) {
                                        html += `<li class="page-item active" aria-current="page">
                                                    <button class="page-link btn-page">${i}</button>
                                                </li>`
                                    }else{
                                        html += `<li class="page-item">
                                                    <button class="page-link btn-page" data-page=${i}>${i}</button>
                                                </li>`
                                    }

                                }

                                if (halaman < jumlah_halaman) {
                                    html += `<li class="page-item">
                                                <button class="page-link btn-page" data-page=${halaman+1} rel="next" title="Selanjutnya"><i class="fa fa-angle-right"></i></button>
                                            </li>`
                                }

                        html += `</ul>
                        </nav>
                    </div>
                </div>
                `;
            if (status) {
                $(el).html(html)
            }else{
                $(el).html("")
            }
		}else{
			$(el).html('')
		}

	}
	
	clear()
	{
	    if(this.element){
	        $(this.element).html('')
	    }
	}

}

var AjaxPagination = new Pagination

session.set_userdata($userdata[0],token_api)

// 
var $jp_token = session.userdata($userdata[0]);
var $_client_token = cookie.get($userdata[1]);

var $ajax_headers = {
	'X-Api-App': $jp_token? $jp_token.application_id : token_api.application_id,
	'X-Api-Token': $jp_token? $jp_token.access_token : token_api.access_token,
	'X-Client-Token': $_client_token
}

function reload()
{
	window.location.reload(true)
}

function redirect(params)
{
	var props = params.split('//'),
		base = ''

	if (props[0] == location.protocol) {

		base = params

	}else{

		base = base_url(params)

	}

	window.location = base
}

function notif(el,type,msg, time = false, scroll = false) //element tipe {error, success, deleted, added,connected} pesan waktu perdetik
{
	$(el).html(`
		<div class="alert alert-${type} alert-dismissible fade show" role="alert">
		  ${msg}
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	`);

	if (scroll == true) {
		notifScroll(el)
	}

	if (time) {
		setTimeout(function(){
			$(el).html('')
		},time*1000)
	}
}

function notifScroll(el)
{	
	elem = $('body')
	if ($(el).length) {
		elem = $(el)
	}
	$('html, body').animate({
        scrollTop: elem.offset().top - 90
    }, 1000);
}

var element_notif = $('body').append('<div class="document" role="notif-alert"></div>')

function notifAlert(msg = '',type = '',time = false)
{

	var alert = `<div class="notif--alert ${type}">
					<div class="notif--alert-content">
						<div class="message">
							${msg}
						</div>
						<div class="close--alert">
							<i class="fal fa-times"></i>
						</div>
					</div>
				</div>`

	$('.document[role=notif-alert]').html(alert);
	if (time) {
		setTimeout(() => {

			$('.notif--alert').fadeOut('slow')

		},time)
	}

	$(document).on('click', '.notif--alert .close--alert', function(event) {
		event.preventDefault();
		$(this).parents('.notif--alert').fadeOut()
	});

}

function callApi(url,data,callback)
{
	$.ajax({
		url: api_url(url),
		type: 'POST',
		data: data,
		headers: $ajax_headers,
		success: (result) => {
			callback(result)
		}
	})
	
}

function Format_Rupiah(num)
{
	var angka = num.toString()
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
 
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return rupiah ? rupiah : '';
}

function rupiah(number) {
	return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function uri_segment(index)
{
	var uri_path = window.location.pathname.split("/")[index];
	return decodeURIComponent(uri_path);
}

function get_params(param)
{
	var vars = {}

	var uri = location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value){
		vars[key] = value
	})

	return vars[param]
}

function check_auth()
{
	var $jp_client_token = cookie.get('role');
	if ($jp_client_token) {
		return $jp_client_token
	}else{
		return ''
	}
}

function split_nama(nama)
{
	return nama.split(' ')
}

function make_slug(text)
{
	var slug = text.split(' ').join('-').toLowerCase()
	return slug;
}

// end helpers

class Component {

	constructor()
	{
		
	}

}

class Authorization {

	constructor()
	{
		this.get_token();
	}

	get_token()
	{
		var data = {
			app_id: $jp_token.application_id,
			auth_token: 'Bearer'
		}
		callApi('bearer_token/',data,function(res){
			if (res.Error) {
				notifAlert('error',res.Message,5)
			}else{
				session.set_userdata($userdata[0],res.Data)
				// if (!$jp_token) {
				// 	reload()
				// }
			}
		})
	}

}

class Table {
	constructor(){
	}
	
	run(params) {
		var table = params['tabel'];
		var columns = params['columns'];
		var url = params['url'];
		var data = params['data'];
		var dataSrc = params['dataSrc'] ? params['dataSrc'] : "Data";
		$(table).DataTable().destroy();
		$(table).DataTable({
			"serverSide": true,
			"deferRender": true,
			"responsive": true,
			"processing": true,
			"language": {
				"processing": 'Memuat data...'
			},
			"ajax": {
				url: api_url(url),
				type: 'POST',
				headers: $ajax_headers,
				dataSrc: dataSrc,
				data: data
			},
			"columns": columns
		})
	}
	destroy(el)
	{
		$(el).DataTable().destroy();
	}
}

// new Authorization

// if (/MSIE/.test(window.navigator.userAgent)) {
//   alert('Unsupported browser')
// }

$(window).ajaxStart(function() {
	// loader.show()
	if (!navigator.onLine) {
		// no_internet.draw()
	}
});


$(window).ajaxError(function(event, xhr, settings, thrownError) {
	console.log('Error : ',thrownError)
});

// window.error = window.close

$(window).ajaxSuccess(function(event, xhr, settings) {
	// console.clear()
});

class Datepicker {
	run(params) {
		var format = params['format'];
		var container = params['container'];
		var input = params['input'];
		$(input).datepicker({
			format: (format) ? format: "yyyy-mm-dd",
			autoclose: true,
			container: container
		});
	}
}
