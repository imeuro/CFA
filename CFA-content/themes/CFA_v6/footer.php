<?php
/**
 * The template for displaying the footer.
 */

?>



</div><!-- // close wrap div -->

<div id="modal" class="single hidden empty">
</div>

<?php wp_footer();
ob_end_flush();
 ?>

<?php /*
<!-- Facebook Pixel Code -->
<script>
setTimeout(function(){
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window,document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '508657780012788'); 
	fbq('track', 'PageView');
}, 3000);
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=508657780012788&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
*/ ?>
<!-- Google Tag Manager -->
<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5MLKFBX');
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MLKFBX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-592YDPY59J"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-592YDPY59J',{
  	'anonymize_ip': true
  });
</script>

<!-- Adsense -->
<script data-ad-client="ca-pub-9553887918833046" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<script type="module">
    import {getCLS, getFCP, getFID, getLCP} from 'https://unpkg.com/web-vitals?module';
    let addWebVitals = () => {
        getCLS(data => {
            console.debug("coreWebVitals cls",data);
            gtag('event', 'timing_complete', {
                'event_category': 'Performance',
                'name': 'cumulative-layout-shift',
                'value': Math.round(data.value*1000)
            });
        });
        getFCP(data => {
            console.debug("coreWebVitals fcp",data);
            gtag('event', 'timing_complete', {
                'event_category': 'Performance',
                'name': 'first-contentful-paint',
                'value': Math.round(data.value)
            });
        });
        getFID(data => {
            console.debug("coreWebVitals fid",data);
            gtag('event', 'timing_complete', {
                'event_category': 'Performance',
                'name': 'first-input-delay',
                'value': Math.round(data.value)
            });
        });
        getLCP(data => {
            console.debug("coreWebVitals lcp",data);
            gtag('event', 'timing_complete', {
                'event_category': 'Performance',
                'name': 'largest-contentful-paint',
                'value': Math.round(data.value)
            });
        });
    }
    addWebVitals();
</script>
</body>
</html>
