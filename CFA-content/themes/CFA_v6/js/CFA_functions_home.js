/* custom CFA Functions - HOME PAGE
================================================== */
var $container = jQuery('#post-area');
var Jmodal = jQuery('#modal');
var JAltLang = jQuery('#lang-switcher');


// Home: sballa larghezza delle immagini per creare un po' di casino.
var randomFromInterval = function(from,to) {
    return Math.floor(Math.random()*(to-from+1)+from);
};


// ridimensiona layout dopo window load/resize
if (typeof jQuery == "function") {
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
}

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

if (bodyClasses.contains('home') === true || bodyClasses.contains('archive') === true || bodyClasses.contains('search') === true || bodyClasses.contains('moreposts')) { // check classe in body

	if (typeof jQuery == "function") {

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
		          gutterWidth: 12
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

		if ( bodyClasses.contains('home') || bodyClasses.contains('page-template-index_ita') || bodyClasses.contains('archive') || bodyClasses.contains('search') ) {
			jQuery(window).load(function() {
				// effetto hover su immagini in hp (idem a #234)
				if(sw>1024){
					jQuery('article.post .pinbin-image, article.cfa_translations .pinbin-image').each( function() {
								jQuery(this).hoverdir({speed : 1000});
					});

				}
				okresize();


			    if (sw>767) {

					$container.isotope({
						layoutMode: 'spineAlign',
						//disable resizing
						resizable: false,
						spineAlign: {
							gutterWidth: 12
						}
					});
					setTimeout(function(){$container.isotope('reLayout');}, 3000);
				}
		  });

		  var pageNum = 0;
		  $container.infinitescroll({
		    loading: {
		      finished: undefined,
		      finishedMsg: "<em>No other items to load.</em>",
		      img: themepath+"images/cross-black.svg",
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
		}
	}
}


// parallaxx banner
const bgpic = document.querySelector("#exhibition-banner");
const text = document.querySelector("#exhibition-banner a");
if (bgpic) {
	document.addEventListener("mousemove", parallax);
}
// Magic happens here
function parallax(e) {
    let _w = window.innerWidth/2;
    let _h = window.innerHeight/2;
    let _mouseX = e.clientX;
    let _mouseY = e.clientY;
    let _depth1 = `${50 - (_mouseX - _w) * 0.01}% ${50 - (_mouseY - _h) * 0.01}%`;
    let _depth2 = `${50 - (_mouseY - _h) * 0.006}%`;
    let _depth3 = `${50 - (_mouseX - _w) * 0.003}%`;
    // let x = `${_depth3}, ${_depth2}, ${_depth1}`;
    let x = `${_depth1}`;
    let ty = `${_depth2}`;
    let tx = `${_depth3}`;
    // console.log(ty);
    bgpic.style.backgroundPosition = x;
    text.style.top = ty;
    text.style.left = tx;
}

/*
let getADS = () => {
	// read and inject advs in position:
	const adslot1 = document.querySelector('#post-area article:nth-child(2)');
	let sp1 = document.createElement("article");
	sp1.setAttribute('class','post type-post has-post-thumbnail hentry status-publish format-adv1 post-spinsert');
	sp1.setAttribute('id', 'advblock1');
	let sp2 = adslot1;
	let parentDiv = sp2.parentNode
	// Insert the new element into before sp2
	parentDiv.insertBefore(sp1, sp2)	

	const adslot2 = document.querySelector('#post-area article:nth-child(5)');
	let sp1_2 = document.createElement("article");
	sp1_2.setAttribute('class','post type-post has-post-thumbnail hentry status-publish format-adv2 post-spinsert');
	sp1_2.setAttribute('id', 'advblock2');
	let sp2_2 = adslot2;
	let parentDiv_2 = sp2_2.parentNode
	// Insert the new element into before sp2_2
	parentDiv_2.insertBefore(sp1_2, sp2_2)	

	const adslot3 = document.querySelector('#post-area article:nth-child(8)');
	let sp1_3 = document.createElement("article");
	sp1_3.setAttribute('class','post type-post has-post-thumbnail hentry status-publish format-adv3 post-spinsert');
	sp1_3.setAttribute('id', 'advblock3');
	let sp2_3 = adslot3;
	let parentDiv_3 = sp2_3.parentNode
	// Insert the new element into before sp2_3
	parentDiv_3.insertBefore(sp1_3, sp2_3)

	const adslot4 = document.querySelector('#post-area article:nth-child(11)');
	let sp1_4 = document.createElement("article");
	sp1_4.setAttribute('class','post type-post has-post-thumbnail hentry status-publish format-adv4 post-spinsert');
	sp1_4.setAttribute('id', 'advblock4');
	let sp2_4 = adslot4;
	let parentDiv_4 = sp2_4.parentNode
	// Insert the new element into before sp2_4
	parentDiv_4.insertBefore(sp1_4, sp2_4)
}
let injectADScont = (id) => {
	let adcont1;
	const target = document.getElementById(id);
	fetch(themepath+'/ads/'+id+'.php')
	  .then(response => response.text())
	  .then(text => target.innerHTML = text);
}
*/

let rotatespblocks = () => {
	const thearea = document.querySelector('#post-area');
	const theslots = thearea.querySelectorAll('.post-spinsert');
	let spblocks = Array.from(theslots);
	const original_spblocks = spblocks;
	// console.debug(spblocks);
	// console.debug('total: '+ original_spblocks.length);

	let original_positions = [];
	original_spblocks.forEach( function(el, i) {
		// zero-based sponsor positions
		original_positions[i] = Array.from(el.parentNode.children).indexOf(el);
	});
	spblocks.forEach( function(el, i) {
		el.remove();
	});
	// console.debug({original_positions});
	// console.debug({spblocks});

	original_positions.forEach( function(el, i) {
		// ne seleziono uno a caso da riassegnare:
		const selected = Math.floor(Math.random() * spblocks.length);
		console.debug(original_spblocks[selected].id+' va in posizione '+original_positions[i]);

		// aggiungo sponsor riassegnato al DOM 
		thearea.insertBefore(original_spblocks[selected],thearea.children[original_positions[i]]);

		// rimuovo sponsor riassegnato da spblocks[]
		spblocks.splice(selected, 1); 

	});

	if ($container.hasClass('isotope') === true) {
		$container.isotope( 'appended', jQuery( spblocks ) );
		setTimeout(function(){
			$container.isotope('reLayout');
		},500);
	}

}

document.addEventListener("DOMContentLoaded", function() {
  // getADS();
});


window.addEventListener("load", function() {
	logoTransition();
	rotatespblocks();
});

