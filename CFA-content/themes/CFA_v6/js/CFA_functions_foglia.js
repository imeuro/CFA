/* custom CFA Functions - FOGLIA
================================================== */
let modalSwiper = [];
let BlockSwiper = [];
let curModalSwiper = [];
let fogliaSwiper = document.querySelectorAll('.CFAslider, .wp-block-gallery');


// load additional js's
if (document.body.classList.contains('page') != true) {
	CFALoader({
	    src: themepath+'js/CFA_LoadMore.js',
	    // src: themepath+'js/CFA_LoadMore.js?cb='+parseInt(Math.random()*1000000),
	    defer: ''
	}, "CFA_Foglia_Chain").then(
	    element => {
	    }
	);
}


if (fogliaSwiper && fogliaSwiper.length > 0) {

	CFALoader({
		href: themepath+'js/swiper.min.css',
		rel: 'stylesheet',
		type: 'text/css',
		media: 'all'
	}, "CFA_Foglia_Chain", 'link', document.head)
	.then( element => CFALoader({
			src: themepath+'js/swiper.min.js',
			async: true
		}, "CFA_Foglia_Chain"))
	.then( element => CFALoader({
			src: themepath+'js/CFA_slider.js',
			async: true
		}, "CFA_Foglia_Chain"))
	.then( element => {
    	gallery2swiper()
    });

}





////////////////////////////////////
// Foglia / Foglia in Modal Functions
////////////////////////////////////


// Foglia: handle printing event
//===============================
if (window.location.search.substr(1) == "print=enabled") {
	
	var destroyFogliaswiper = function() {
		if (typeof fogliaSwiper == 'object'){ 
			if (typeof BlockSwiper == 'object') {
				BlockSwiper.forEach((i) => {
					i.destroy();
				});
				console.log('fogliaswipers destroyed.');
			} else if (typeof curSwiper == 'object') {
				curSwiper.forEach((i) => {
					i.destroy();
				});
				console.log('legacy fogliaswipers destroyed.');
			}
		} 
	};

	if (window.matchMedia) {
		var checkprinting = window.matchMedia('print');
		checkprinting.addListener(destroyFogliaswiper);
	}

	window.onbeforeprint = destroyFogliaswiper;

	setTimeout(function(){
		console.log('printing...');
		window.self.print();
	},500);

} else { //redirect to printable version

	var suggest_printable = function() {
		window.location.replace("?print=enabled")
	};

	if (window.matchMedia) {
		var checkprinting = window.matchMedia('print');
		checkprinting.addListener(suggest_printable);
	}

	window.onbeforeprint = suggest_printable;

}

// Foglia: handle auto-summary generation
var get_summary = function(context) {

	var ToCTarget = document.querySelector('.summary-container');

	if (ToCTarget && ToCTarget !== null) {

		// there is a flag in backend, adding specific DOM to the page, which enables auto summary (Table Of Contents) functionality

		var Sumheaders=document.querySelectorAll('.pinbin-copy h2,.pinbin-copy h3,.pinbin-copy h4');
		if (Sumheaders.length > 1) {

			var ToC = document.createElement('div');
			ToC.classList.add('indice');
			
			var Sumitem='';
			var Hindex=1;
			Sumheaders.forEach(function(item,index){
				item.setAttribute('id', 'content-'+index);
			 	Sumitem = Sumitem+"\n<li><a class='ToC-scroll' data-href='#content-"+index+"'>"+Hindex+". "+item.textContent+"</a></li>";
				Hindex++;
			});

			ToC.innerHTML="\n<h3 class='ToC-heading'>Summary:</h3>\n<ul id='ToC-list'>"+Sumitem+"\n</ul>";

				ToCTarget.appendChild(ToC, ToCTarget);

			var ToClinks = document.querySelectorAll(".ToC-scroll");
			ToClinks.forEach(function(item,index){
				item.addEventListener("click",function(e){
					e.preventDefault;
				  scrollTo(document.getElementById('content-'+index),context);
				});
			});
		}
	}
}

// Foglia: button to return to the top of the article
var bottomLinks = function(context) {
	if (bodyClasses.contains('single') || bodyClasses.contains('page') || bodyClasses.contains('modal-open')) {
		var Uplink = document.createElement('button');
		Uplink.setAttribute('id','uplink');
		Uplink.classList.add('hidden');
		document.getElementsByTagName('body')[0].appendChild(Uplink);
		Uplink.addEventListener("click",function() { 
			scrollTo(document.getElementsByTagName('body')[0],context);
		});

		let Showmehome = document.createElement('a');
		let Hometext = document.createTextNode('HOME');
		Showmehome.appendChild(Hometext);
		Showmehome.setAttribute('id','showmehome');
		Showmehome.classList.add('hidden');
		document.body.appendChild(Showmehome);
		Showmehome.addEventListener("click",function() { 
			context.location.href="/"
		});

		context.addEventListener('scroll', function() {
			if (document.documentElement.scrollTop > 500) {
				Uplink.classList.remove('hidden');
				Showmehome.classList.remove('hidden');
			} else {
				Uplink.classList.add('hidden');
				Showmehome.classList.add('hidden');
			}
		});
	}
}
// Foglia: button to return home
let ShowMeHome = () => {
	if( document.documentElement.scrollTop > logo_v6.offsetHeight ) {
		showmehome.classList.remove('hidden');
	} else {
		showmehome.classList.add('hidden');
	}
}

function scrollTo(element,context) {
	if (sw>640 && context==window) {
		Stop = element.offsetTop - 180;
	} else {
		Stop = element.offsetTop;
	}
	context.scroll({
		behavior: 'smooth',
		left: 0,
		top: Stop
	});
}


let checkGallery = () => {
	const iframeInPage = document.querySelector('iframe');
	if (iframeInPage && iframeInPage.src.includes('art.kunstmatrix.com')) {
		iframeInPage.classList.add('alignfull');
	}
}

let micrioInstance = null;
let injectMicrio = () => {
	const MicrioTag = document.querySelectorAll('a.micrio-code');
	const MicrioIframe = document.querySelectorAll('iframe[src*="micr.io"]');
	if (MicrioTag.length >= 1) {
		console.debug('Micr.io tag present: injecting library...');
		
		let Mscript = document.createElement('script');
		Mscript.src = 'https://b.micr.io/micrio-2.8.min.js';
		Mscript.type = 'text/javascript';
		Mscript.async = 'async';
		Mscript.id = 'micrio-2.8-lib';
		document.body.append(Mscript);

		let Mcss = document.createElement('style');
		Mcss.type = 'text/css';
		Mcss.innerHTML = `
			.micrio-code { cursor: pointer; }
			@font-face {
			  font-family: "celtic";
			  src: url(`+themepath+`/js/celt.ttf) format("truetype");
			}  
			.marker-popup.class-test {
				font-family: "celtic" !important;
			    color: aqua !important;
			}`;
		document.head.append(Mcss);

		let Mdiv = document.createElement('div');
		Mdiv.id = 'Micriocontent';
		document.body.append(Mdiv);

		Array.from(MicrioTag).forEach(function(el) {
			const MicrioID = el.getAttribute('data-micrio-id');
			el.addEventListener('click', function(){ 
				initMicrioFS(MicrioID,Mdiv);
			 });
		});
		return true
	} else if (MicrioIframe.length >= 1) {
		Array.from(MicrioIframe).forEach(function(el) {
			let contDiv = document.createElement('div');
			contDiv.classList.add('wp-block-image','alignfull','size-large')
			// insert wrapper before el in the DOM tree
			el.parentNode.insertBefore(contDiv, el);
			// move el into wrapper
			contDiv.appendChild(el);
		});
		return true
	} else {
		return false
	}
}

let initMicrioFS = (MicrioID,Mdiv) => {
	if (micrioInstance) { // reset
		clearMicriocontent();
	}
	if (MicrioID) {
		console.debug('generating Micrio DOM Elements...');
		micrioInstance = new Micrio({
			// Image ID, required
			id: MicrioID,
			// HTML element to put the image in, defaults to <body>
			container: Mdiv,
			// Listen to touch and mouse events, defaults to true
			hookEvents: true,
			// Initializes and draws image on instance creation, defaults to true
			autoInit: true,
			// How to render the initial view, like CSS background-size
			// 'cover' or 'contain'. Defaults to 'contain'.
			initType: 'cover',
			logo: false,
		});

		micrioInstance.addEventListener('preset', () => {
			console.debug('Micrio preset');
			micrioInstance.camera.fullScreenToggle();
		});
		micrioInstance.addEventListener('load', () => {
			console.debug('Micrio load');
			// micrioInstance.camera.fullScreenToggle();
		});
		micrioInstance.addEventListener('show', () => {
			console.debug('Micrio show');
			document.addEventListener('fullscreenchange', clearMicriocontent);
			document.addEventListener('webkitfullscreenchange', clearMicriocontent);
			document.addEventListener('mozfullscreenchange', clearMicriocontent);
			document.addEventListener('MSFullscreenChange', clearMicriocontent);
		});
	}

}

let clearMicriocontent = () => {
	if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
		micrioInstance.destroy();
		micrioInstance.container.removeAttribute('class');
		micrioInstance.container.removeAttribute('style');
		micrioInstance.container.firstElementChild.remove();
		micrioInstance = null;
	}
}


// Lightbox on links with #lightbox hashtag
let checkLightbox = () => {
	const activator = 'lightbox';
	let scanLinks = document.querySelectorAll("a[href$='#"+activator+"']");
	if (scanLinks.length > 0) {

		Array.from(scanLinks).forEach((el) => {
			el.classList.add('glightbox-black');
			el.href = el.href.replace(/#.*$/, '');
		});

		let glightboxJS = document.createElement('script');
		glightboxJS.src = themepath+'js/glightbox.min.js';
		document.body.append(glightboxJS);

		let glightboxCSS = document.createElement('link');
		glightboxCSS.rel = 'stylesheet';
		glightboxCSS.href = themepath+'glightbox.min.css';
		document.head.append(glightboxCSS);

		setTimeout(function() { 
			var CFABlackLightbox = GLightbox({
				selector: 	'.glightbox-black',
				height:		'95vh'
			});
		},2000);

	}
}


// fix responsive image: srcset for fullwidth (.wp-block-image.alignfull) imgs
let fullscreenIMGs = document.querySelectorAll('.wp-block-image.alignfull img')
Array.from(fullscreenIMGs).forEach(function(el){
    el.sizes='(min-width: 768px) 100vw, 80vw';
})
