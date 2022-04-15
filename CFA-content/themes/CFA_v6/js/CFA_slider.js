// Foglia: Swiper init (see also @ line #308: modalSwiper )
//===============================
var CFAslidersettings = {
	init: false,
	direction: 'horizontal',
	autoHeight: true,
	loop: true,
	keyboard: true,
	preloadImages: false,
	lazy: {
    	loadPrevNext: false,
    	// loadPrevNextAmount: 1,
    	loadOnTransitionStart: true
  	},
	fadeEffect: {
	crossFade: true
	},

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
		clickable: true
  },

  // Navigation arrows
  navigation: {
    nextEl: '.nextContainer',
    prevEl: '.prevContainer',
  }
};

function updateSwipeArea(SWname,delay) {
	setTimeout(function(){
		SWname.update();	
	},delay);
}



// Foglia: convert galleries to swipers
//===============================
function gallery2swiper () {
	Array.from(fogliaSwiper).forEach(function (element, index) {


		if (element.classList.contains('wp-block-gallery') === true) {

			var da_element = element;
			if (element.nodeName == 'FIGURE' && da_element.classList.contains('has-nested-images') === false) { // shit happens :(

				da_element = element.firstChild;
				da_element.classList.remove('blocks-gallery-grid');

			}

			// 'element' will be wrapped with a div.swiper-container.CFAslider
			var Swrapper = document.createElement('div');
			da_element.parentNode.insertBefore(Swrapper, da_element);
			Swrapper.appendChild(da_element);

			// div.swiper-container.CFAslider will be wrapped with a div.container
			var Swrapper2 = document.createElement('div');
			Swrapper.parentNode.insertBefore(Swrapper2, Swrapper);
			Swrapper2.appendChild(Swrapper);

			//reset and add some classes to make it work...
			Swrapper.className = '';
			da_element.className = '';
			Swrapper.classList.add('swiper-container','CFAslider');
			Swrapper2.classList.add('container');

			da_element.classList.add('swiper-wrapper','gutenberg-swiper-block');

			var Sslides = da_element.childNodes;
			Array.from(Sslides).forEach(function (e, i) {
				if (e.nodeName != "#text") {
					e.className = '';
					e.classList.add('swiper-slide', 'gallery-item');
					var Simg= e.querySelector('img');
					var Simgsrc = Simg.getAttribute('src');
					Simg.removeAttribute('src');
					Simg.setAttribute('data-src', Simgsrc);
					Simg.classList.add('swiper-lazy');
					var Sfig= e.querySelector('figure'); // to be removed
					if (Sfig && Sfig.length > 0) {
						Ssaveme=Sfig.innerHTML;
						e.innerHTML = Ssaveme;
					}
					var Sdida= e.querySelector('figcaption');
					if (Sdida && Sdida.length > 0) {
						Sdida.classList.add('gallery-caption');
					}
					var Sloader = document.createElement('div');
					e.appendChild(Sloader);
					Sloader.classList.add('swiper-lazy-preloader');
				}
			});


			// add the navigation bullets + arrows...
			var Snavigation = document.createElement('div');
			var SLarr = document.createElement('div');
			var SRarr = document.createElement('div');

			Swrapper.appendChild(Snavigation);
			Swrapper.appendChild(SLarr);
			Swrapper.appendChild(SRarr);

			Snavigation.classList.add('swiper-pagination');
			SLarr.classList.add('prevContainer');
			SRarr.classList.add('nextContainer');

			// aaaaand finally init dat shit
			BlockSwiper[index] = new Swiper (Swrapper, CFAslidersettings );
			BlockSwiper[index].on('init', function() { 
				updateSwipeArea(BlockSwiper[index],300); 
			});
			BlockSwiper[index].on('lazyImageReady', function () {
				console.log('lazyImageReady........');
			updateSwipeArea(BlockSwiper[index],100);
			});
			BlockSwiper[index].init();
			console.log(index+'init!');

		} else { // Legacy carousels with shortcodes
			var curSwiper = new Swiper (element, CFAslidersettings );
			curSwiper.on('init', function() { 
				updateSwipeArea(curSwiper,300); 
			});
			curSwiper.on('lazyImageReady', function () {
				updateSwipeArea(curSwiper,100);
			});	
			curSwiper.init();
		}
	});
}

