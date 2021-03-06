/* custom CFA Functions
================================================== */

var sw = document.body.clientWidth;
var bodyClasses = document.body.classList; // bodyClasses.contains('my-class-name')
var ENV = window.location.host;
var basepath = '/cfa/';
if (ENV == 'localhost' || ENV == 'nas.imeuro.io' || ENV == 'www.meuro.dev') { basepath = '/conceptualfinearts/cfa/'; }
var themepath = basepath+'wp-content/themes/CFA_v51/';
var $container = jQuery('#post-area');
var whitecurtain = document.getElementById('whitecurtain');
var modal = document.getElementById('modal');
var Jmodal = jQuery('#modal');
var AltLang = document.getElementById('lang-switcher');
var JAltLang = jQuery('#lang-switcher');
var header_v5 = document.getElementById('site-navigation');
var logo_v5 = document.getElementById('logo');
var menu_v5 = document.getElementById('header-menu');
var modalSwiper = [];
var fogliaSwiper = '';
var BlockSwiper = [];
var curModalSwiper = [];



////////////////////////////////////
// HEADER resizabble allo scroll
////////////////////////////////////
var resizzabolHeader = function() {
	var me = this;

	me.init = function() {
		menu_v5.innerHTML = menu_v5.innerHTML+'<span class="shade"></span>';
		window.addEventListener('scroll', function() { me.scrolling(); });
	};
	me.shrink = function() {
		header_v5.classList.add('shrink');
		document.querySelector('#header-menu .shade').style.display = 'none';
	};
	me.expand = function() {
		header_v5.classList.remove('shrink')
		document.querySelector('#header-menu .shade').style.display = 'block';
	};
	me.scrolling = function() {
		if ( modal.classList.contains('empty') === true || bodyClasses.contains('single') === false ) {
			// console.log(header_v5.offsetTop);
			// console.log(logo_v5.offsetHeight);
			if( document.documentElement.scrollTop > logo_v5.offsetHeight ) {
				me.shrink();
			} else {
				me.expand();
			}
		} else { me.shrink(); }
	};
};
var eyesonHeader = new resizzabolHeader();
eyesonHeader.init();


// protect images - attempt
if (ENV != 'localhost') {
	document.addEventListener('contextmenu', event => event.preventDefault());
}


// Home: sballa larghezza delle immagini per creare un po' di casino.
var randomFromInterval = function(from,to) {
    return Math.floor(Math.random()*(to-from+1)+from);
};


// Home: sballa larghezza delle immagini per creare un po' di casino.
var randomFromInterval = function(from,to) {
    return Math.floor(Math.random()*(to-from+1)+from);
};


// ridimensiona layout dopo window load/resize
var okresize = function() {
	if (sw > 767) {

		jQuery('.newitem img').each(function() {
			var blockwidth = jQuery(this).width();
			var blockheight = jQuery(this).height();
			//console.log('pppp'+blockwidth);
			var percent;
			if (blockwidth === 0 ) {blockwidth = 640; }
			if (blockwidth>=480) {
				if (blockwidth>blockheight) {
					percent = randomFromInterval(0,5);
				} else {
					percent = randomFromInterval(0,30);
				}
			}
			var resizedwidth = blockwidth-((percent*blockwidth)/100);
			//console.log('resizedwidth: '+resizedwidth);
			jQuery(this).css('width',resizedwidth+'px');

			jQuery(this).parent().parent().removeClass('newitem');
		});

	}
};



////////////////////////////////////
// Sitewide Functions
////////////////////////////////////


document.addEventListener("DOMContentLoaded", function() {

	// Website Credits
	console.log("%c\n CONCEPTUAL FINE ARTS \n Powered by: Mauro Fioravanzi \n since oct 2013 \n",'background:#fff;color:#F7A420;font-weight:700');


	jQuery('#logo').click(function(){
	  if (Jmodal.children().length !== 0) {
      parent.update_url(basepath);
			Jmodal.addClass('hidden empty').delay(1000).html('');
	  } else {
			window.location.href = basepath;
		}
	});

});

jQuery(window).load(function(){
	console.log('done with page load.');

	// rimuovi whitecurtain at window loaded
	$container.imagesLoaded().done( function( instance ) {
		console.log('all images successfully loaded');
		whitecurtain.classList.add('transparent');

		setTimeout(function(){
			whitecurtain.classList.add('hidden')
			whitecurtain.classList.remove('transparent');
		},2000);

	}).fail( function() {
    console.log('all images loaded, at least one is broken');
		jQuery('#whitecurtain').fadeOut(2000); //anyway..
  });


});

// update the url if you click on a post
function scan_urls() {
  var link = jQuery('div.pinbin-image a');
  link.each(function() {
    jQuery(this).click(function() {
      update_url( jQuery(this).attr('href') );
    });
  });
}

function update_url(getUrl) {
  var stateObj = window.location.href;
  history.pushState(stateObj, '', getUrl);
}

window.addEventListener('popstate', function(event) {
  //window.location.reload();
});



////////////////////////////////////
// Foglia / Foglia in Modal Functions
////////////////////////////////////



// Foglia: actions at window load
//===============================

jQuery(window).load(function(){
	console.log('done with page load.');
	jQuery('article.post .pinbin-image').addClass('newitem');
	okresize();

	jQuery('.archive-month-container').isotope({
		columnWidth: 160
	});

	// Foglia: init that fantastic lightbox!
	//===============================
	ThatFabulousLightbox();


  	// Foglia: LAZYLOAD (actually is unveil.js)
	//===============================
	jQuery("img.unveil").unveil();

});


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

if ((bodyClasses.contains('single') || bodyClasses.contains('page') ) && document.querySelector('.CFAslider, .wp-block-gallery') !== null) {

	fogliaSwiper = document.querySelectorAll('.CFAslider, .wp-block-gallery');

	Array.from(fogliaSwiper).forEach(function (element, index) {


		if (element.classList.contains('wp-block-gallery') === true) {

			var da_element = element;
			if (element.nodeName == 'FIGURE') { // shit happens :(

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
				e.className = '';
				e.classList.add('swiper-slide', 'gallery-item');
				var Simg= e.querySelector('img');
				var Simgsrc = Simg.getAttribute('src');
				Simg.removeAttribute('src');
				Simg.setAttribute('data-src', Simgsrc);
				Simg.classList.add('swiper-lazy');
				var Sfig= e.querySelector('figure'); // to be removed
				Ssaveme=Sfig.innerHTML;
				e.innerHTML = Ssaveme;
				var Sdida= e.querySelector('figcaption');
				Sdida.classList.add('gallery-caption');
				var Sloader = document.createElement('div');
				e.appendChild(Sloader);
				Sloader.classList.add('swiper-lazy-preloader');
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

// Foglia: handle printing event
//===============================
if (window.location.search.substr(1) == "print=enabled") {
	
	var destroyFogliaswiper = function() {
    if (typeof fogliaSwiper == 'object'){ 
				fogliaSwiper.destroy();
				console.log('fogliaswiper destroyed.');
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
	// if (bodyClasses.contains('single') || bodyClasses.contains('page') || bodyClasses.contains('modal-open')) { 
		// there will be a flag in backend, adding a specific class to body, which enables auto summary (Table Of Contents) functionality

		var Sumheaders=document.querySelectorAll('.pinbin-copy h2,.pinbin-copy h3,.pinbin-copy h4');
		if (Sumheaders.length > 1) {

			var ToC = document.createElement('nav');
			ToC.classList.add('table-of-content');
			ToC.setAttribute('role', 'navigation');
			
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
var goTopLink = function(context) {
	if (bodyClasses.contains('single') || bodyClasses.contains('page') || bodyClasses.contains('modal-open')) {
		var Uplink = document.createElement('button');
		Uplink.setAttribute('id','uplink');
		Uplink.classList.add('hidden');
		document.getElementsByTagName('body')[0].appendChild(Uplink);
		Uplink.addEventListener("click",function() { 
			scrollTo(document.getElementsByTagName('body')[0],context);
		});
		context.addEventListener('scroll', function() {
			if (document.documentElement.scrollTop > 500) {
				Uplink.classList.remove('hidden');
			} else {
				Uplink.classList.add('hidden');
			}
		});
	}
}

document.addEventListener("DOMContentLoaded", function() {
  goTopLink(window);
  get_summary(window);
});


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

// prepare for that fantastic lightbox!
//===============================

// Vanilla JS equivalent of jQuery .load()
function AjaxGetPage(url, what, where, TheCallback) {
    var cached=sessionStorage[url];
    if(!what){what="body";} // default to grabbing body tag
    if(where && where.split){where=document.querySelector(where);}
    if(!where){where=document.querySelector(what);}
    if(cached){return where.innerHTML=cached;}
    var request = new XMLHttpRequest();
    // request.responseType='document';

    request.onreadystatechange = function() {
	  if(request.readyState === 4) {
	    where.innerHTML = 'fetching content...';
	    if(request.status === 200) { 
	      where.innerHTML = request.responseText;
	    } else {
	      where.innerHTML = 'An error occurred during your request: ' +  request.status + ' ' + request.statusText;
	    } 
	  }
	}
	request.addEventListener('load', TheCallback(request.status), false);
    request.open("GET", url, true);
    request.send();
    return request;
}


function ThatFabulousLightbox() {
	if (bodyClasses.contains('single')) {
		// Array.from(document.querySelectorAll('.posttags a')).forEach(function(el){
		// 	el.attr('target','_parent'); // ???
		// });
	}
	else {
		jQuery('article.post:not(.type-post-patrons)').click(function(e) {

			e.preventDefault();

			var theUrl = jQuery(this).find('div > a').attr('href');
			console.log('loading contents from: '+theUrl);
			if (theUrl) {

				var theID = jQuery(this).attr('id');
				console.log('theID: '+theID);

				eyesonHeader.shrink();
				modal.classList.remove('hidden');

				var modalCallBack = function(status) {

					parent.update_url(theUrl);
					modal.classList.remove('empty');
					document.body.classList.add('modal-open');

					// update links to translated versions
					jQuery('#site-navigation #lang-switcher').load(theUrl+" #lang-switcher *");

					goTopLink(modal);
					get_summary(modal);


					// chiudi tutto
					jQuery('#logo').click(function(){
						// console.debug('click logo');
						parent.update_url(basepath);
						modal.classList.add('hidden');
						modal.classList.add('empty');
						document.body.classList.remove('modal-open');
						setTimeout(function(){
							console.log('rimosso content');
							modal.innerHTML = '';
							eyesonHeader.scrolling();
						},2000);

						var uplinkbtn = document.getElementById("uplink");
							uplinkbtn.parentNode.removeChild(uplinkbtn);


					});

					// modal: Swiper init (see also @ line #348: fogliaSwiper )
					if (document.querySelector('.CFAslider, .wp-block-gallery') !== null) {
						modalSwiper = document.querySelectorAll('#modal .CFAslider, #modal .wp-block-gallery');

						console.debug(modalSwiper);

						Array.from(modalSwiper).forEach(function (element, index) {

							if (element.classList.contains('wp-block-gallery') === true) {

								var da_element = element;
								if (element.nodeName == 'FIGURE') { // shit happens :(

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
									e.className = '';
									e.classList.add('swiper-slide', 'gallery-item');
									var Simg= e.querySelector('img');
									var Simgsrc = Simg.getAttribute('src');
									Simg.removeAttribute('src');
									Simg.setAttribute('data-src', Simgsrc);
									Simg.classList.add('swiper-lazy');
									var Sfig= e.querySelector('figure'); // to be removed
									Ssaveme=Sfig.innerHTML;
									e.innerHTML = Ssaveme;
									var Sdida= e.querySelector('figcaption');
									Sdida.classList.add('gallery-caption');
									var Sloader = document.createElement('div');
									e.appendChild(Sloader);
									Sloader.classList.add('swiper-lazy-preloader');
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

								// console.debug(Swrapper);
								// console.debug(CFAslidersettings);
								// console.debug(modalSwiper[index]);


								// aaaaand finally init dat shit
								curModalSwiper[index] = new Swiper (Swrapper, CFAslidersettings );
								curModalSwiper[index].on('init', function() { 
									updateSwipeArea(curModalSwiper[index],300); 
								});
								curModalSwiper[index].on('lazyImageReady', function () {
									console.log('lazyImageReady........');
								updateSwipeArea(curModalSwiper[index],100);
								});
								curModalSwiper[index].init();
								console.log(index+'init!');

							} else { // Legacy carousels with shortcodes
								curModalSwiper[index] = new Swiper (element, CFAslidersettings );
								curModalSwiper[index].on('init', function() { 
									updateSwipeArea(curModalSwiper,300); 
								});
								curModalSwiper[index].on('lazyImageReady', function () {
									updateSwipeArea(curModalSwiper,100);
								});	
								curModalSwiper[index].init();
							}

						});
					}
				}

				// actually load the article content into the modal
				AjaxGetPage(theUrl,"#"+theID,modal,modalCallBack);

				/*
				Jmodal.load( theUrl+" #"+theID, function( response, status, xhr ) {
					// console.debug(status);

					if ( status == "success" ) {

						parent.update_url(theUrl);
						modal.classList.remove('empty');
						document.body.classList.add('modal-open');

						// update links to translated versions
						jQuery('#site-navigation #lang-switcher').load(theUrl+" #lang-switcher *");

						goTopLink(modal);
						get_summary(modal);


						// chiudi tutto
						jQuery('#logo').click(function(){
							// console.debug('click logo');
							parent.update_url(basepath);
							modal.classList.add('hidden');
							modal.classList.add('empty');
							document.body.classList.remove('modal-open');
							setTimeout(function(){
								console.log('rimosso content');
								modal.innerHTML = '';
								eyesonHeader.scrolling();
							},2000);

							var uplinkbtn = document.getElementById("uplink");
  							uplinkbtn.parentNode.removeChild(uplinkbtn);


						});

						// modal: Swiper init (see also @ line #348: fogliaSwiper )
						if (document.querySelector('.CFAslider, .wp-block-gallery') !== null) {
							modalSwiper = document.querySelectorAll('#modal .CFAslider, #modal .wp-block-gallery');

							console.debug(modalSwiper);

							Array.from(modalSwiper).forEach(function (element, index) {

								if (element.classList.contains('wp-block-gallery') === true) {

									var da_element = element;
									if (element.nodeName == 'FIGURE') { // shit happens :(

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
										e.className = '';
										e.classList.add('swiper-slide', 'gallery-item');
										var Simg= e.querySelector('img');
										var Simgsrc = Simg.getAttribute('src');
										Simg.removeAttribute('src');
										Simg.setAttribute('data-src', Simgsrc);
										Simg.classList.add('swiper-lazy');
										var Sfig= e.querySelector('figure'); // to be removed
										Ssaveme=Sfig.innerHTML;
										e.innerHTML = Ssaveme;
										var Sdida= e.querySelector('figcaption');
										Sdida.classList.add('gallery-caption');
										var Sloader = document.createElement('div');
										e.appendChild(Sloader);
										Sloader.classList.add('swiper-lazy-preloader');
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

									// console.debug(Swrapper);
									// console.debug(CFAslidersettings);
									// console.debug(modalSwiper[index]);


									// aaaaand finally init dat shit
									curModalSwiper[index] = new Swiper (Swrapper, CFAslidersettings );
									curModalSwiper[index].on('init', function() { 
										updateSwipeArea(curModalSwiper[index],300); 
									});
									curModalSwiper[index].on('lazyImageReady', function () {
										console.log('lazyImageReady........');
									updateSwipeArea(curModalSwiper[index],100);
									});
									curModalSwiper[index].init();
									console.log(index+'init!');

								} else { // Legacy carousels with shortcodes
									curModalSwiper[index] = new Swiper (element, CFAslidersettings );
									curModalSwiper[index].on('init', function() { 
										updateSwipeArea(curModalSwiper,300); 
									});
									curModalSwiper[index].on('lazyImageReady', function () {
										updateSwipeArea(curModalSwiper,100);
									});	
									curModalSwiper[index].init();
								}

							});
						}

					}

					if ( status == "error" ) {
						var msg = "<div class=\"post type-post type-404\"><h2>"+ xhr.status + ' ' + xhr.statusText +"</h2><p>Apologies, the article at "+theUrl+" is not available</p>\n<p>You'll be redirected to the home page in 5 seconds.</p></div>";
						Jmodal.html( header + msg  );
						setTimeout(function(){
							modal.classList.add('hidden empty');
						},5000);
						setTimeout(function(){
							modal.innerHTML('');
						},500);

					}
				});
				*/
			}

		});

	}
}






////////////////////////////////////
// Homepage/Archives Functions
////////////////////////////////////

// make home ITA as close as possible to home ENG
if (bodyClasses.contains('page-template-index_ita') === true) {
	bodyClasses.remove('page');
	bodyClasses.add('home');
	bodyClasses.add('home-ITA');
}


// Home: sballa larghezza delle immagini per creare un po' di casino.
function randomFromInterval(from,to) {
    return Math.floor(Math.random()*(to-from+1)+from);
}

if (bodyClasses.contains('home') === true || bodyClasses.contains('archive') === true) { // check classe in body

	// Home: custom layout mode: spineAlign
	//===============================

	if (sw>767) {
		jQuery.Isotope.prototype._spineAlignReset = function() {
		  this.spineAlign = {
		    colA: 0,
		    colB: 0
		  };
		};

		jQuery.Isotope.prototype._spineAlignLayout = function( $elems ) {
		  var instance = this,
		      props = this.spineAlign,
		      gutterWidth = Math.round( this.options.spineAlign && this.options.spineAlign.gutterWidth ) || 0,
		      centerX = Math.round(this.element.width() / 2);


		  $elems.each(function(){
		    var $this = jQuery(this),
		        isColA = props.colA <= props.colB,
		        x = isColA ?
		          centerX - ( $this.outerWidth(true) + gutterWidth / 2 ) : // left side
		          centerX + gutterWidth / 2, // right side
		        y = isColA ? props.colA : props.colB;
		    instance._pushPosition( $this, x, y );
		    props[( isColA ? 'colA' : 'colB' )] += $this.outerHeight(true);
		  });
		};


		jQuery.Isotope.prototype._spineAlignGetContainerSize = function() {
		  var size = {};
		  size.height = this.spineAlign[( this.spineAlign.colB > this.spineAlign.colA ? 'colB' : 'colA' )];
		  return size;
		};

		jQuery.Isotope.prototype._spineAlignResizeChanged = function() {

		  return true;
		};
	}

	// Home: actions at window resize
	//===============================

	jQuery(window).resize(function() {
	  sw = document.body.clientWidth;
	  //console.log(sw);

	  if (sw>767) {
	      jQuery('#post-area').isotope({
	        layoutMode: 'spineAlign',
	        //disable resizing
	        resizable: false,
	        spineAlign: {
	          gutterWidth: 10
	        }
	      });

	      setTimeout(function(){
	        jQuery('#post-area.isotope').isotope('reLayout');
	      },1000);
	  } else if (sw<=767 && sw>640) {
	    jQuery('#post-area.isotope').isotope('destroy');
	  } else if (sw<=640) {
	    jQuery('#post-area.isotope').isotope('destroy');
	  }
	});

	// Home: actions at window load
	//===============================

	jQuery(window).load(function(){

		// effetto hover su immagini in hp (idem a #234)
		if(sw>1024){
			jQuery('article.post .pinbin-image, article.cfa_translations .pinbin-image').each( function() {
						jQuery(this).hoverdir({speed : 1000});
			});

		}
		okresize();

		$container.imagesLoaded().done( function( instance ) {

	    if (sw>767) {

	      $container.isotope({
	        layoutMode: 'spineAlign',
	        //disable resizing
	        resizable: false,
	        spineAlign: {
	          gutterWidth: 10
	        }
	      });
	      $container.isotope('reLayout');


	    }
	  });
	  
	  var pageNum = 0;
	  $container.infinitescroll({
	    loading: {
	      finished: undefined,
	      finishedMsg: "<em>No other items to load.</em>",
	      img: themepath+"images/tiny_red.gif",
	      msg: null,
	      msgText: "",
	      selector: null,
	      speed: 'fast',
	      start: undefined
	    },
	    state: {
	      isDuringAjax: false,
	      isInvalidPage: false,
	      isDestroyed: false,
	      isDone: false, // For when it goes all the way through the archive.
	      isPaused: false,
	      currPage: 1
	    },
	    navSelector  : '#nav-below',    // selector for the paged navigation
	    nextSelector : '#nav-below .view-previous a',  // selector for the NEXT link (to page 2)
	    itemSelector : '.post',     // selector for all items you'll retrieve
	    animate      : false,
	    extraScrollPx: 250,
	    bufferPx     : 50,
	    errorCallback: function(){$container.isotope('reLayout');}
	  },
	  // call Isotope as a callback
	  function( newElements ) {
	  	newElements.forEach(function(item, index) {
		 if (newElements[index].classList.contains('no-results')) {
		 		item.classList.add('hidden');
		 		newElements[0].innerHTML='<p>Sorry, no other post available.</p>'
		 		newElements[0].classList.remove('hidden');
		  		$container.infinitescroll('destroy');
		  }
	  	})
	  	
	    pageNum++;

		if(sw>1024){
	      jQuery('article.post .pinbin-image').each( function() {
	        jQuery(this).hoverdir({speed : 1000});
	      });
		}

	    okresize();

	    scan_urls();

		ThatFabulousLightbox();

	    if (jQuery("#post-area").hasClass('isotope')) {
	      $container.children('.newitem').hide();
				jQuery('.post-patrons').each(function(i){
					if (i >= 1) {
						jQuery(this).parent().remove();
					}
				});
	      $container.children('.newitem').fadeIn(500);
	      $container.isotope( 'appended', jQuery( newElements ) );
	      setTimeout(function(){$container.isotope('reLayout');}, 1000);
	    }

		var trackerName = ga.getAll()[0].get('name');
		ga(trackerName + '.send', 'pageview', '/scroll/'+pageNum);
	    //ga('send', 'pageview', '/scroll/'+pageNum);
	    console.log('scroll/'+pageNum);
	  });



	});
}
