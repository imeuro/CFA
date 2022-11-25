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
                $CFAlive_events = get_field('cfalive_events');
                for ($i=0; $i < count($CFAlive_events); $i++) {
                  $ci=$CFAlive_events[$i];
                  $prevLabel = $i>0 ? $CFAlive_events[$i-1]["cfalive_event_label"]["label"] : '';
                  $curLabel = $ci["cfalive_event_label"]["label"];

                  // print_r($prevLabel);
                  // print_r($curLabel);

                  if ( $prevLabel != $curLabel ) {
                    if ($i > 0) { echo '</div>';  } // closes prev wp-block-group
                    echo '<h2>'.$curLabel.'</h2>';
                    echo '<div class="wp-block-group">';
                  }
                  
                  if (!empty($ci["cfalive_event_gallery"])) {
                    echo substr($ci["cfalive_event_text"],0,-5); // no ending </p>
                    $urlgallery=$ci["cfalive_event_gallery"][0]->guid;
                    // echo '<br><a href="'.$urlgallery.'#lightbox" class="glightbox-black"><strong>Images</strong></a></p>';
                    echo '<br><a href="'.$urlgallery.'"><strong>Images</strong></a></p>';
                  } else {
                    echo $ci["cfalive_event_text"];
                  }

                  if ($i == count($CFAlive_events)) {
                    echo '</div>';
                  }

                }
                ?>
            </div>

                <?php // CFA LIVE ADDITIONAL PARAGRAPHS
                $cfalive_paragraphs = get_field('cfalive_paragraphs');

                // echo '<pre>'.$cfalive_paragraphs.'</pre>';
                for ($i=0; $i < count($cfalive_paragraphs); $i++) {
                  
                  $ci=$cfalive_paragraphs[$i]; 
                  if ($i<=1) {
                    echo '<h2>'.strtoupper($ci["cfalive_paragraph_title"]).'</h2>';
                    echo '<div class="wp-block-group">';
                  }

                  if ($ci['cfalive_paragraph_content'] && count($ci['cfalive_paragraph_content']) > 0) {
                    for ($p=0; $p < count($ci['cfalive_paragraph_content']); $p++) {
                      $cpi=$ci['cfalive_paragraph_content'][$p];
                      if (!empty($cpi["cfalive_paragraph_gallery_link"])) {
                        echo substr($cpi["cfalive_paragraph_text"],0,-5); // no ending </p>
                        $urlgallery=$cpi["cfalive_paragraph_gallery_link"][0]->guid;
                        echo '<br><a href="'.$urlgallery.'"><strong>Images</strong></a></p>';
                      } else {
                        echo $cpi["cfalive_paragraph_text"];
                      }
                    }
                  }
                  
                  if ($i==0 || $i == count($cfalive_paragraphs)) {
                    echo '</div>';
                  }

                }
                ?>
            </div>

         	</div>          
                
       </article>
       
		<?php endwhile; endif; ?>      
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>
<?php get_footer(); ?>
