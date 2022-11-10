<?php /*
Template Name: CFAlive-gallery
*/ ?>

<?php get_header('noheader'); ?>
<style type="text/css">
	.page-template-cfalive-gallery article,
	.page-template-cfalive-gallery,
	.page-template-cfalive-gallery article .container {
		background: #000;
	    height: 100vh;
	    width: 100vw;
	    margin: 20px 0;
	}
	.page-template-cfalive-gallery article .container {
		display: flex;
		flex-flow: column nowrap;
		align-items: center;
	}

	.page-template-cfalive-gallery figure { 
		margin: 0; 
		text-align: center;
		width: 100%;
		margin-bottom: 40px;
	}

	.page-template-cfalive-gallery figure img { 
		width: 100%;
		height: auto;
	}

	.page-template-cfalive-gallery figcaption {
		display: none;
	}
	.page-template-cfalive-gallery #uplink {
		outline: none;
		position: fixed;
		top: 40px;
		left: 40px;
		width: 50px;
		height: 50px;
		background: transparent;
		border: none;
		border-radius: 8px;
		z-index: 10;
		opacity: .75;
		transition: opacity 150ms ease-in-out;
		margin: 0;
		padding: 0;
		cursor: pointer;
		background-color: #000;
		transform: rotate(-90deg); 
	}

	.page-template-cfalive-gallery #uplink:hover { opacity: 1 }
	.page-template-cfalive-gallery #uplink:before,
	.page-template-cfalive-gallery #uplink:after {
		content: "";
		position: absolute;
		top: 22px;
		left: 12px;
		width: 15px;
		height: 1px;
		border-radius: 0;
		background-color: #fff;
		transform: rotate(-50deg);
		display: inline-block;
	}
	.page-template-cfalive-gallery #uplink:after {
		left: initial;
		right: 13px;
		transform: rotate(50deg);
	}

	@media all and (min-width: 768px) {

	}
</style>
	<a id="uplink" href="<?php echo get_permalink('12830') ?>"></a>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
   		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
       			<div class="pinbin-copy container">
           		   <?php the_content(); ?>                 
         		</div>          
       </article>
		<?php endwhile; endif; ?>      
<?php get_footer('nofooter'); ?>
