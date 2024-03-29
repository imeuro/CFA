// Foglia: Swiper init (see also @ line #308: modalSwiper )
//===============================
var CFAslidersettings = {
	init: false,
	direction: 'horizontal',
	autoHeight: false,
	loop: true,
	keyboard: true,
	preloadImages: true,
  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
		clickable: true,
		type: "fraction",
		renderFraction: function (currentClass, totalClass) {
      return 'Image <span class="' + currentClass + '"></span>' +
              ' of ' +
              '<span class="' + totalClass + '"></span>';
  	}
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
			Swrapper.id = 'CFAslider-'+index;
			Swrapper.dataset.id = 'CFAslider-'+index;
			Swrapper2.classList.add('outer-swiper-container','container');

			da_element.classList.add('swiper-wrapper','gutenberg-swiper-block');

			var Sslides = da_element.childNodes;
			Array.from(Sslides).forEach(function (e, i) {
				if (e.nodeName != "#text") {
					e.className = '';
					e.classList.add('swiper-slide', 'gallery-item');
					var Simg= e.querySelector('img');
					var Simgsrc = Simg.getAttribute('src');

					var Sfig= e.querySelector('figure'); // to be removed
					if (Sfig && Sfig.length > 0) {
						Ssaveme=Sfig.innerHTML;
						e.innerHTML = Ssaveme;
					}
					var Sdida= e.querySelector('figcaption');
					if (Sdida && Sdida.length > 0) {
						Sdida.classList.add('gallery-caption');
					}
				}
			});


			// add the navigation bullets + arrows...
			var Stoolwrapper = document.createElement('div');
			var Snavigation = document.createElement('div');
			var SLarr = document.createElement('div');
			var SRarr = document.createElement('div');

			if(document.body.classList.contains('single-cfa_live')) {
				Stoolwrapper.classList = 'swiper-tools';
				Swrapper.parentNode.prepend(Stoolwrapper)
				Stoolwrapper.prepend(SRarr);
				Stoolwrapper.prepend(SLarr);
				Stoolwrapper.prepend(Snavigation);
			} else {

				Swrapper.appendChild(Snavigation);
				Swrapper.appendChild(SLarr);
				Swrapper.appendChild(SRarr);		
			}


			Snavigation.classList.add('swiper-pagination');
			SLarr.classList.add('prevContainer');
			SRarr.classList.add('nextContainer');

			// aaaaand finally init dat shit
			BlockSwiper[index] = new Swiper (Swrapper, CFAslidersettings );
			BlockSwiper[index].init();
			console.log(index+'init!');

			BlockSwiper[index].on('init', function() { 
				updateSwipeArea(BlockSwiper[index],300); 
			});
			BlockSwiper[index].on('lazyImageReady', function () {
				console.log('lazyImageReady........');
				updateSwipeArea(BlockSwiper[index],100);
				// updateSwipeArea(BlockSwiper[index],4000);
				setTimeout(() => {
					BlockSwiper[index].update();
					console.debug('lazyImageReady cautionary resize...')
				}, 4000);
			});
			BlockSwiper[index].on('slideChangeTransitionEnd', function() { 
				updateSwipeArea(BlockSwiper[index],500); 
				console.debug(BlockSwiper[index].el)
			});

			

		} else { // Legacy carousels with shortcodes
			var curSwiper = new Swiper (element, CFAslidersettings );
			curSwiper.on('init', function() { 
				updateSwipeArea(curSwiper,300); 
			});
			curSwiper.on('lazyImageReady', function () {
				updateSwipeArea(curSwiper,500);
			});	
			curSwiper.init();
		}
	});
}

