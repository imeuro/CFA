<?php
/**
 * Single post template
 */

?>
<?php get_header(); ?>

	<?php if (have_posts()) : 
    while (have_posts()) : the_post(); 

  // check for sponsores posts
  $isSponsored = get_field('sponsored_post',$post->ID);

  if ($isSponsored) {
    $sponsoredClass = 'sponsored ';
  } else {
    $sponsoredClass = '';
  }

?>

   		<article id="post-<?php the_ID(); ?>" <?php post_class($sponsoredClass.'scroller'); ?>>

        <div class="pinbin-copy single-pinbin-copy">

          <?php
        if (!get_field('author_name',$post->ID)) :  // old format ?>
          <h1><?php the_title(); ?></h1>
        <?php else :  // new format ?>
          <h1><?php the_title(); ?></h1>
          <div class="post-data">
            <small class="author">
            <?php if (get_field('author_link_int',$post->ID)) {
              $authPostID = get_field('author_link_int',$post->ID);
              ?>
              <a href="<?php echo get_permalink($authPostID[0]); ?>" title="View <?php echo get_field('author_name',$post->ID); ?>'s bio"><?php the_field('author_name',$post->ID); ?></a>
            <?php } elseif (get_field('author_link_ext',$post->ID)) { ?>
              <a href="http://<?php the_field('author_link_ext',$post->ID); ?>" title="View <?php echo get_field('author_name',$post->ID); ?>'s bio"><?php the_field('author_name',$post->ID); ?></a>
            <?php } else { ?>
              <?php the_field('author_name',$post->ID); ?>
            <?php } ?>
            </small>
          </div>
        <?php endif; ?>

        <div class="clear"></div>

					<?php if (has_excerpt()): ?>
						<div class="container excerpt-container">
							<?php the_excerpt(); ?>
						</div>
					<?php endif; ?>
          
          <?php if (get_field('display_automatic_summary')): ?>
            <div class="container summary-container"></div>
          <?php endif; ?>

          <?php the_content('Read more'); ?>

          <div class="clear"></div>

          <p class="post-pubdate"><?php echo get_post_modified_time('F j, Y'); ?></p>

          <div class="clear"></div>

        </div>


        <div class="posttags"><?php the_tags('<h3 class="posttags-title">Tags:</h3> ',', ',' '); ?></div>

        <div class="clear"></div>

        <div class="share-link">
          <ul class="share-link-buttons-list">
            <li class="share-link-buttons">
              <a href="mailto:?Subject=<?php echo urlencode(get_the_title()) ?>&amp;Body=Hi,%20I%20found%20this%20article%20and%20thought%20you%20might%20like%20this:%20<?php echo urlencode(get_permalink()) ?>" class="share-link-email" title="Share via Email" rel="nofollow">
                <img alt="Share via Email" width="48" height="48" src="<?php echo get_template_directory_uri(); ?>/images/noun_ML.svg">
              </a>
            </li>
            <li class="share-link-buttons share-link-buttons-print">
              <a class="share-link-print" href="?print=enabled" target="_blank" rel="nofollow noopener" title="Print this Page">
                <img alt="Print this Page" width="48" height="48" src="<?php echo get_template_directory_uri(); ?>/images/noun_PR.svg">
              </a>
            </li>
          </ul>
        </div>

        <div class="clear"></div>

      </article>

  	<?php endwhile; 
  endif; ?>

<?php get_footer(); ?>
