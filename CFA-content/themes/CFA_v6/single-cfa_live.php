<?php get_header('noheader'); ?>
	<a id="uplink" href="<?php echo get_permalink('12830') ?>">CFAlive</a>
	<?php if (have_posts()) : 
		while (have_posts()) : the_post(); ?>
   		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
     
				<div class="pinbin-copy container">
					<h1><?php the_title(); ?></h1>

					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; 
	endif; ?>      
<?php get_footer('nofooter'); ?>
