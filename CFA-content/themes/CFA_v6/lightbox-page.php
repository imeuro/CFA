<?php /*
Template Name: lightbox-page
*/ ?>

<?php get_header('noheader'); ?>
<style type="text/css">
	.page-template-lightbox-page,
	.page-template-lightbox-page article,
	.page-template-lightbox-page article .container {
		background: #000;
	    height: 100vh;
	    width: 100vw;
	    margin: 0;
	}
	.page-template-lightbox-page .blocks-gallery-grid,
	.page-template-lightbox-page .wp-block-gallery {
		display: block;
		margin: 0;
		padding: 0;
	}
	.page-template-lightbox-page ul.swiper-wrapper {
	    margin: 0;
	    padding: 0;
	    list-style: none;
	    width: 100vw;
	}
	.page-template-lightbox-page li.swiper-slide {
	    text-align: center;
		max-height: 100vh;
		max-width: 100vw;
		width: auto;
	}
	.page-template-lightbox-page .swiper-slide img {
		max-height: 95vh;
		max-width: 100vw;
		width: auto;
		margin: 0 auto;
	}
	.page-template-lightbox-page .swiper-slide figcaption {
		color: #fff;
		margin: 5px;
		font-size: 12px;
		line-height: 13px;
		font-family: 'NeueHaasGroteskDisp Std',sans-serif;
		font-weight: 400;
		font-style: normal;
	}
	.page-template-lightbox-page .swiper-pagination-bullets {
		position: absolute;
		bottom: 35px;
	}
	.page-template-lightbox-page .swiper-pagination-bullet-active {
	    background-color: #FFCC33;
	}
</style>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
   		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
       			<div class="pinbin-copy container">
           		   <?php the_content(); ?>                 
         		</div>          
       </article>
		<?php endwhile; endif; ?>      
<?php get_footer('nofooter'); ?>
