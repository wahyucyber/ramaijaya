
var storage = [
	'jp_token',
	'jp_client_token'
];

var app_name = $('meta[name=app_name]').attr('content');

var title = $('meta[name=title]').attr('content');

class Helper {

	save_session(key,value)
	{
		sessionStorage.setItem(key,JSON.stringify(value));
	}

	get_session(key)
	{
		return JSON.parse(sessionStorage.getItem(key));
	}

	remove_session(key)
	{
		if (Array.isArray(key)) {
			
			for(var i = 0;i < key.length;i++){
				sessionStorage.removeItem(key[i])
			}

		}else{
			sessionStorage.removeItem(key)
		}
	}

	save_local(key,value)
	{
		localStorage.setItem(key,JSON.stringify(value));
	}

	get_local(key)
	{
		return JSON.parse(localStorage.getItem(key));
	}

	remove_local(key)
	{
		if (Array.isArray(key)) {
			
			for(var i = 0;i < key.length;i++){
				localStorage.removeItem(key[i])
			}

		}else{
			localStorage.removeItem(key)
		}
	}

	last_segment()
	{
		return window.location.pathname.split("/").pop();
	}
}

var helper = new Helper;



function notif(el,type,msg, time = false) //element tipe {error, success, deleted, added,connected} pesan waktu perdetik
{
	$(el).html(`
		<div class="alert alert-${type} alert-dismissible fade show" role="alert">
		  ${msg}
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	`);

	notifScroll(el)

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

function notifAlert(type = '',msg = '',time = 3)
{

	var waktu = time*1000

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

	setTimeout(() => {

		$('.notif--alert').fadeOut('slow')

	},waktu)

	$(document).on('click', '.notif--alert .close--alert', function(event) {
		event.preventDefault();
		$(this).parents('.notif--alert').fadeOut()
	});

}

function callApi(_url,data,callback)
{
	$.ajax({
		url: api_url+_url,
		type: 'POST',
		data: data,
		headers: ajax_headers,
		success: (result) => {
			callback(result)
		}
	})
	
}

class Authorize {

	constructor()
	{
		this.get_token();
	}

	get_token()
	{
		var data = {
			app_id: 'jpstore.devs',
			auth_token: 'Bearer'
		}
		callApi('api/bearer_token',data,res => {
			if (res.Error) {
				notifAlert('error',res.Message,5)
			}else{
				helper.save_local(storage[0],res.Data)
			}
		})
	}

}

new Authorize

function split_nama(nama)
{
	return nama.split(' ')[0]
}

function make_slug(text)
{
	var slug = text.split(' ').join('-').toLowerCase()
	return slug;
}

let format_rupiah = (angka) => {
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

let page_title = (_title = '') => {

	$('title').html(app_name+' | '+_title)

}

page_title(title)

class NoConnection {

	draw()
	{
		var html = '';

		$('title').html('Tidak ada koneksi internet')

		html += `<div class="inner">
					<div class="content">
						<div class="logo">
							<img src="${url}assets/images/default/il-error-not-found.png" alt="">
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

var no_internet = new NoConnection()

class PageNotFound {

	body()
	{
		var html = '';

		$('title').text('404 - Halaman tidak ditemukan')

		html += `<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
					<div class="text-center">
						<div class="images" style="
							width: 450px;
							margin: 0 auto;
						">
							<img src="${url+'assets/images/default/il-error-not-found.png'}" alt="">
						</div>
						<h4 class="fw-700">404 Halaman tidak ditemukan</h4>
						<span class="d-block mb-3 text-dark-2">Halaman yang Anda minta tidak di temukan..</span>
						<a href="${url}" class="btn btn-primary">Kembali ke Home</a>
					</div>
				</div>`;
		$('.main-wrapper').html(html)
		$('body').addClass('active')
	}

	draw()
	{
		var html = '';

		$('title').html('404 - Page Not Found')

		html += `<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
					<div class="text-center">
						<div class="images" style="
							width: 450px;
							margin: 0 auto;
						">
							<img src="${url+'assets/images/default/il-error-not-found.png'}" alt="">
						</div>
						<h4 class="fw-700">404 Page Not Found</h4>
						<span class="d-block mb-3 text-dark-2">The page you requested was not found.</span>
						<a href="${url}" class="btn btn-primary">Kembali ke Home</a>
					</div>
				</div>`;

		return html;
	}

}

var page_not_found = new PageNotFound();

class Loader {

	constructor()
	{
		this.Html = `<div class="container d-flex justify-content-center h-100">
						<div class="text-center">
							<div class="jpmall-loader"></div>
						</div>
					</div>`
	}

	show()
	{
		$('title').html('Sedang Memuat...')
		$('#loader').html(loader.Html).addClass('on')
		$('body').addClass('active')
	}

	hide()
	{	
		$('title').html(app_name+' | '+title)
		$('#loader').removeClass('on').html('')
		$('body').removeClass('active')
	}

}

var loader = new Loader()


let segment = (index) => {
	return window.location.pathname.split("/")[index];
}

var url_get = (params) => {

	var vars = {}

	var uri = location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value){
		vars[key] = value
	})

	return vars[params]

}

class Paginator {

	make(count_page,active_page)
	{
		// console.log(count_page+' '+active_page)
		var html = '';

		html += `
		<nav>
			<ul class="pagination justify-content-end px-2">`

				if (active_page > 1) {
					html += `<li class="page-item">
								<button class="page-link" data-page=${parseInt(active_page)-1} rel="prev">Previous</button>
							</li>`
				}

				for(var i = 1; i <= count_page; i++){

					if (i == active_page) {
						html += `<li class="page-item active" aria-current="page">
									<button class="page-link">${i}</button>
								</li>`
					}else{
						html += `<li class="page-item">
									<button class="page-link" data-page=${i}>${i}</button>
								</li>`
					}

				}

				if (active_page < count_page) {
					html += `<li class="page-item">
								<button class="page-link" data-page=${parseInt(active_page)+1} rel="next">Next</button>
							</li>`
				}

		html += `</ul>
		</nav>`;

		return html;

	}

}

var paginator = new Paginator()

class BrowseImg {

	constructor()
	{
		// slider 510 x 172
		// icon 50 x 50
		this.w = 510
		this.h = 172
		this.Crop = false
		this.Quality = 80
	}

	options(w = browseImage.w,h = browseImage.h,crop = false,quality = 80)
	{
		this.w = w
		this.h = h
		this.Crop = crop
		this.Quality = quality
	}

	getFile(input,prev,e)
	{

		if (input.files && input.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
            var file = e.target.files[0];
            canvasResize(file, {
		          width: browseImage.w,
		          height: browseImage.h,
		          crop: browseImage.Crop,
		          quality: browseImage.Quality,
		          //rotate: 90,
		          callback: function(data, width, height) {
	            	input.setAttribute('data-img',data)
	            	browseImage.handleShowImg(prev,data)
	            	e.target.value = ''
	            	// console.log(data)
		          }
		    });
        }else{
        	
        	alert('Format yang didukung: .jpg .jpeg .png .gif')

        }

	}

	handleShowImg(prev,data)
	{

		prev.attr('src',data)

	}

}

var browseImage = new BrowseImg()

let redirect = uri => {

	var props = uri.split('//'),
		base = ''

	if (props[0] == location.protocol) {

		base = uri

	}else{

		base = url+uri

	}

	window.location = base

}

$('input[maxlength],textarea[maxlength]').each(function() {
	$(this).parent().append('<div class="text-right fs-13 text-muted mt-2 input-length">\
		Maksimum <span class="fw-bold">'+$(this).attr('maxlength')+'</span> Karakter\
				              </div>')
})


$(document).on('input', 'input[maxlength],textarea[maxlength]', function() {
	
	var maxlength = $(this).attr('maxlength')
	var length = $(this).val().length

	$(this).parent().find('.input-length').html(length+' dari '+maxlength)
	
});


let show_login = () => {

	$('#modalLogin').modal('show')

}


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
