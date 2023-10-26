<?php
/**
 * Theme index file
 */
?>

<?php get_header(); ?>
<?php if (have_posts()) : ?>

<div id="post-area"><!--class="scroller"-->

<?php
$postnum=0;
$currentTS = time();
$stickies=[];



while (have_posts()) : the_post();
    
  if ( !in_array( $post->ID, $stickies ) ) { // check IDs: for duplicate sticky posts
    
    // check for available ads...
    if ($postnum % 2 == 0) {
      include( 'ads/sponsorposts.inc.php' );
    }

    $postnum++;
    
    // check for sponsores posts
    $isSponsored = get_field('sponsored_post',$post->ID);

    if ($isSponsored) {
      $sponsoredClass = 'sponsored';
    } else {
      $sponsoredClass = '';
    }


?>

    <article id="post-<?php the_ID(); ?>" <?php post_class($sponsoredClass); ?>>

       <?php
        $attachments = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));
          if ($attachments || has_post_thumbnail()) {
                if ( ! is_array($attachments) ) continue;
                $count = count($attachments);
                $first_attachment = array_shift($attachments);
                ?>
            <div class="pinbin-image newitem">
              <a href="<?php the_permalink(); ?>" class="left">
                <?php
                // check if the post has a Post Thumbnail assigned to it.
                $ll = '';
                if ($postnum>2) { $ll = ' loading="lazy"'; }
                if ( has_post_thumbnail() ) {
                  $imgsrc =  wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large' );
                } else {
                  $imgsrc =  wp_get_attachment_image_src($first_attachment->ID, 'large' );
                }
                echo '<img src="'.$imgsrc[0].'"'.$ll.' />';
                ?>
                <div class="pinbin-copy">
                  <p>
                    <?php
                    if (get_the_title()!='') :
                       echo '<strong>'.get_the_title().'</strong>';
                    endif;
                    if (get_field('author_name',$post->ID)) :
                       echo '<small>by '.get_field('author_name',$post->ID).'</small>';
                    endif;
                    if (has_excerpt($post->ID)) :
                    	echo '<span>'.get_the_excerpt().'</span>';
                    endif;
                    ?>
                  </p>
	              </div>
              </a>
            </div>
            <?php }
            else { ?>
             <div class="pinbin-text">
             <h2><a href="<?php the_permalink() ?>" class="left"><span><?php
                $excerpt = get_the_excerpt();
                echo string_limit_words($excerpt,25);
                ?></span> <br />continue...</a></h2>
            </div>
            <?php } ?>
      </article>

<?php 
    if (is_sticky($post->ID)) {
      $stickies[] = $post->ID;
    }
    
  }
endwhile; 
$stickiesJS = json_encode($stickies);
?>
</div>
<script> var stickies = <?php echo $stickiesJS ?>; </script>
<?php else : ?>

<article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title"><?php _e( 'Nothing Found', 'pinbin' ); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
          <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pinbin' ); ?></p>
          <?php get_search_form(); ?>
        </div><!-- .entry-content -->
</article><!-- #post-0 -->

<?php endif; ?>
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>

    <nav id="nav-below" class="navigation" role="navigation">
        <div class="view-previous"><?php next_posts_link( __( '&#171; Previous', 'pinbin' ) ) ?></div>
        <div class="view-next"><?php previous_posts_link( __( 'Next &#187;', 'pinbin' ) ) ?> </div>
    </nav>
<?php get_footer(); ?>
