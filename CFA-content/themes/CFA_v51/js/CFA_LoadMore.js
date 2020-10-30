// foglia: load the posts in homepage as the user approaches the end of page
document.body.classList.add('moreposts');
const postareaTarget = document.getElementById('wrap');
let postareaDiv,
	fillnonce = null;


let LoadHPCont = () => {
	fetch(basepath) // fetch homepage URL
    .then(function(response) {
        return response.text()
    })
    .then(function(html) {

    	// get the article list
		let parser = new DOMParser();
		let doc = parser.parseFromString(html, "text/html");
		let HPDOM = doc.querySelector('#post-area').innerHTML;

		// create container div
		postareaDiv = document.createElement('div');
		postareaDiv.id = 'post-area';
		postareaDiv.classList.add('append-posts');
		postareaTarget.append(postareaDiv);


		// listen scroll pos and fill the div
		const scrolltrigger = document.documentElement.scrollHeight - document.documentElement.clientHeight - 1500; // 500px before bottom
		document.addEventListener('scroll', function() {
			if (!fillnonce) {
				setTimeout(function() { 
					if (document.documentElement.scrollTop >= scrolltrigger && !fillnonce){

						if (sw>767) {
							// libs for isotope with require.js
							requirejs(['jquery-1.12.4.min'], function(jquery) {
								requirejs(['jquery.isotope.min', 'jquery.hoverdir'], function(isotope, hoverdir) {
									requirejs(['CFA_functions_home'], function(functions_home) {

										// fill the div
										postareaDiv.innerHTML = HPDOM;

										// make it look good
										

											// start hoverdir
											jQuery('article.post .pinbin-image, article.cfa_translations .pinbin-image').each( function() {
												jQuery(this).hoverdir({speed : 1000});
											});


											setTimeout(function() { 
												// start isotope layout
												jQuery('#post-area').isotope({
													layoutMode: 'spineAlign',
													resizable: false,
													spineAlign: {
													  gutterWidth: 10
													}
												});
											},500);

											// setTimeout(function(){
											// 	jQuery('#post-area.isotope').isotope('reLayout');
											// },2500);

											// is every image loaded? yes -> reLayout
											loadhammer();
										

									});
								});
							});

						} else {
							// fill the div
							postareaDiv.innerHTML = HPDOM;
						}

						fillnonce = true;
					}

				},500);
			}
		});
    })
    .catch(function(err) {  
        console.log('Failed to fetch page: ', err);
    });
}

loadhammer = () => {
	let isLoaded = [];
	let postareaDivImgs = postareaDiv.querySelectorAll('img');
	if (postareaDivImgs.length > 0) {
		setInterval( () => {
			Array.from(postareaDivImgs).forEach( (img,i) => {
				isLoaded[i] = img.complete && img.naturalHeight !== 0;
			})
			// console.debug(isLoaded);
			if (isLoaded.every((v)=> v === true)) {
				setTimeout(function(){
					jQuery('#post-area.isotope').isotope('reLayout');
				},500);
				clearInterval(loadhammer);
			}
		}, 1000 );
	}
}

window.addEventListener("load", function() {
 // ...
 LoadHPCont();
});