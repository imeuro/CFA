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

              <div class="wp-block-group">
                <?php 
                $CFAlive_events = get_field('cfalive_events');
                for ($i=0; $i < count($CFAlive_events); $i++) {
                  
                  $ci=$CFAlive_events[$i]; 
                  if ($i<=1) {
                    echo '<h2>'.$ci["cfalive_event_label"]["label"].'</h2>';
                  }
                  
                  echo $ci["cfalive_event_text"];
                  if (!empty($ci["cfalive_event_gallery"])) {
                    $urlgallery=$ci["cfalive_event_gallery"][0]->guid;
                    echo '<a href="'.$urlgallery.'"><strong>Images</strong></a>';
                  }

                }
                echo "<pre>";
                //print_r($CFAlive_events);
                echo "</pre>";


                ?>
            </div>

         	</div>          
                
       </article>
       
		<?php endwhile; endif; ?>      
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>
<?php get_footer(); ?>
