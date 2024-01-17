/* custom CFA Functions - SITEWIDE
================================================== */
var sw = document.body.clientWidth;
var bodyClasses = document.body.classList; // usage: bodyClasses.contains('my-class-name')
var ENV = window.location.host;
let devENV = null;
var basepath = '/cfa/';
if (ENV == 'localhost' || ENV == 'meuro.dev') {
	basepath = '/conceptualfinearts/cfa/';
	devENV = true;
}
var themepath = basepath+'CFA-content/themes/CFA_v6/';
var whitecurtain = document.getElementById('whitecurtain');
var modal = document.getElementById('modal');
var AltLang = document.getElementById('lang-switcher');
var header_v6 = document.getElementById('site-navigation');
var logo_v6 = document.getElementById('logo');
var menu_v6 = document.getElementById('header-menu');


////////////////////////////////////
// Sitewide Functions
////////////////////////////////////

// ext scripts/css loader
function CFALoader(objAttr, chainId = null, elementType = "script", target = document.body) {
	return new Promise(function (resolve, reject) {
	    let element = document.createElement(elementType);

	    for (const property in objAttr) {
	        element.setAttribute(property, objAttr[property]);
	    }
	    let path = objAttr.src || objAttr.href;
	    element.onload = () => {
	        resolve(element);
	        console.debug(`[CFALoader] ${path}\n`,  chainId + " - OK - Time: " + performance.now());
	    };
	    element.onerror = e => {
	        reject(
	            new Error(`[CFALoader] LOADING ERROR for: ${path}`)
	        );
	        console.debug(e);
	    };

	    target.appendChild(element);
	});
}

function wait(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}


// load additional js's
if ( bodyClasses.contains('home') || bodyClasses.contains('page-template-index_ita') || (bodyClasses.contains('archive') && !bodyClasses.contains('tribe-events-page-template') ) || bodyClasses.contains('search') ) {
	CFALoader({
		src: themepath+'js/jquery-1.12.4.min.js'
	}, "CFA_Home_Chain")
	.then( element => CFALoader({
			src: themepath+'js/jquery-migrate-1.4.1.min.js'
		}, "CFA_Home_Chain"))
	.then( element => CFALoader({
			src: themepath+'js/modernizr.custom.97074.js'
		}, "CFA_Home_Chain"))
	.then( element => CFALoader({
			src: themepath+'js/jquery.isotope.min.js'
		}, "CFA_Home_Chain"))
	.then( element => CFALoader({
			src: themepath+'js/jquery.hoverdir.js'
		}, "CFA_Home_Chain"))
	.then( element => CFALoader({
			src: themepath+'js/jquery.infinitescroll.min.js'
		}, "CFA_Home_Chain"))
	.then( element => CFALoader({
			// src: themepath+'js/CFA_functions_home.js'
			src: themepath+'js/CFA_functions_home.js?cb='+parseInt(Math.random()*1000000)
		}, "CFA_Home_Chain"))
} else {
	if (!bodyClasses.contains('tribe-events-page-template')) {
		CFALoader({
			src: themepath+'js/CFA_functions_foglia.js'
			// src: themepath+'js/CFA_functions_foglia.js?cb='+parseInt(Math.random()*1000000)
		}, "CFA_Foglia_Chain")
		.then( element => {
			if ( bodyClasses.contains('no-header') === false ) {
				bottomLinks(window);
				get_summary(window);
				ShowMeHome();
				injectMicrio();
				checkGallery();
				checkLightbox();
			}
		})
	}
}





// menu
if ( bodyClasses.contains('no-header') === false ) {
	const menubtn = document.getElementById('hambmenu');
	let topscroll = 0;
	menubtn.addEventListener('click', () => {
		if (bodyClasses.contains('fixd','single') === false) { 
			topscroll = document.scrollingElement.scrollTop;
		}
		document.getElementById('site-navigation').classList.toggle('menu-open');
		setTimeout(() => {
			if (bodyClasses.contains('single') === false) {
				document.body.classList.toggle('fixd');
				if (bodyClasses.contains('fixd') === false) { 
					document.scrollingElement.scrollTo(0,topscroll)
				}
			}
		},100)
	})
}


// protect images - attempt
// if (ENV == 'www.conceptualfinearts.com') {
// 	document.addEventListener('contextmenu', event => event.preventDefault());
// }

let appendENV = (env) => {
	if (typeof devENV !== 'undefined' && devENV !== null) {
		let divEnv = document.createElement('div');
		let cssENV = document.createElement('style');
		cssENV.innerHTML = `
			.env-revealer {
				position: fixed;
				top: 50%;
				z-index: 1400;
				right: -60px;
				transform: rotate(-90deg);
				color: #444;
				font-size: 14px;
				line-height: 16px;
				background: #fff;
				padding: 10px 10px;
				font-weight: 700;
				width: auto;
				text-align: center;
				text-transform: uppercase;
				border-radius: 2px 0 0 2px;
			}
		`;
		divEnv.setAttribute('class', 'env-revealer');
		divEnv.innerHTML = "🛠️ "+env+" 🛠️";
		document.head.appendChild(cssENV);
		document.body.appendChild(divEnv)
		
	}
}

const PageReveal = () => {
	const WC = document.getElementById('whitecurtain');
	if (WC != null) {
		WC.classList.add('prehidden');
		setTimeout(() => {
			WC.classList.add('hidden');
			WC.classList.remove('prehidden')
		},500);
	}
}


let exhiDiv,postareaDivName,initialpostareaDivTop,postareaDivTop,svgbottom,blackMask,whiteMask = '';
const logoTransition = () => {
	exhiDiv = document.getElementById('exhibition-banner');
	if (exhiDiv) 
		{ postareaDivName = 'exhibition-banner'; } 
	else 
		{ postareaDivName = 'post-area'; }
	svgbottom = logo_v6.firstElementChild.getBoundingClientRect().y + logo_v6.firstElementChild.getBoundingClientRect().height;
	if (document.getElementById(postareaDivName)) {
		initialpostareaDivTop = document.getElementById(postareaDivName).getBoundingClientRect().top;
		const logoattack = initialpostareaDivTop-svgbottom;

		document.addEventListener('scroll', function() {
			postareaDivTop = document.getElementById(postareaDivName).getBoundingClientRect().top;
			// console.debug('postareaDivTop:'+postareaDivTop);
			// console.debug('document.scrollingElement.scrollTop:' + document.scrollingElement.scrollTop);
			//blacklogo
			blackMask = document.querySelector('.blacklogo');
			if ((document.scrollingElement.scrollTop > logoattack) && postareaDivTop > 0) {
				blackMask.setAttribute('y', postareaDivTop - svgbottom );
			} else if (document.scrollingElement.scrollTop <= logoattack) {
				blackMask.setAttribute('y', 0);
			} else if (postareaDivTop <= 0 ) {
				blackMask.setAttribute('y', logo_v6.offsetTop-svgbottom );
			}
			//whitelogo
			whiteMask = document.querySelector('.whitelogo');
			if ((document.scrollingElement.scrollTop > postareaDivTop - svgbottom) && postareaDivTop > 0) {
				whiteMask.setAttribute('y', (svgbottom-logo_v6.offsetTop)-(svgbottom - postareaDivTop) );
			} else if (postareaDivTop <= 0) {
				whiteMask.setAttribute('y',0);
			} else if (document.scrollingElement.scrollTop <= logoattack) {
				whiteMask.setAttribute('y', svgbottom-logo_v6.offsetTop );
			}
		});
	}

	document.querySelector('.WLOGO').addEventListener('click', function(){
			window.location.href = basepath;
	});

}

document.addEventListener("DOMContentLoaded", function() {
	// Website Credits
	console.log("%c\n CONCEPTUAL FINE ARTS rev. 6 \n © 2013-"+new Date().getFullYear()+" - all rights reserved \n",'background:#fff;color:#F7A420;font-weight:700');

	appendENV(ENV);

});

window.addEventListener("load", function() {
	console.debug('done with page load.');
	console.debug('typeof jQuery: '+typeof jQuery);
	PageReveal();
});
