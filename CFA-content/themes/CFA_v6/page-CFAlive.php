<?php
/**
Template Name: CFAlive
*/

?>

<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       
   		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php if ( has_post_thumbnail() ) { ?>			
				<div class="pinbin-image"><?php the_post_thumbnail( 'medium' );  ?></div>
        <?php } ?>    
             
       			<div class="pinbin-copy container">
              <h1><?php the_title(); ?></h1>
              <?php the_content(); ?> 

              
                <?php // CFA LIVE EVENTS
                function get_live_events($status,$translation) {
                  $ev_query_args = array(
                    'post_type' => 'cfa_live',
                    'post_status' => 'publish',
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'posts_per_page' => '99',
                    'tax_query' => array(
                      '0' => array(
                        'taxonomy' => 'event_label',
                        'field' => 'slug',
                        'terms' => array($status),
                        'operator' => 'IN',
                      ),
                    ),
                  );

                  // The Query
                  $ev_query = new WP_Query( $ev_query_args );
                  $ev_res = '';
                  $i = 0;
                

                  // The Loop
                  if ( $ev_query->have_posts() ) {
                    while ( $ev_query->have_posts() ) {
                      $ev_query->the_post();
                      //print_r($ev_query);

                      global $post;
                      $blocks = parse_blocks( $post->post_content );
                      


                      if ($i==0) {
                        $ev_res .= '<h2>'. strtoupper( $status ) .'</h2><div class="wp-block-group">';
                      }
                      $ev_res .= '<p><a href="'.get_permalink().'"><strong>'.get_the_title().'</strong><br>';
                      foreach( $blocks as $block ) {
                        if( 'core/paragraph' === $block['blockName'] ) {
                          $ev_res .= strip_tags(render_block( $block ), '<br>');
                        break;
                        }
                      }
                      $ev_res .= '</a></p>';



                      
                      $i++;

                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();
                  } else {
                    // no posts found
                  }

                    echo $ev_res .'</div>';
  
                }


                get_live_events('upcoming','in programma');
                get_live_events('current','in mostra');
                get_live_events('past','precedenti');
                get_live_events('specials','progetti');


                ?>
            </div>

         	</div>          
                
       </article>
       
		<?php endwhile; endif; ?>      
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>
<?php get_footer(); ?>
