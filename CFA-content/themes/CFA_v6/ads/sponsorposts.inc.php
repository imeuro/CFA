<?php
$pagenum = get_query_var('paged') ? get_query_var('paged') : 1 ;

// carico uno sponsor con status publish * che ha sponsor_end_date > oggi *
$sponsorposts = get_posts(array(
  'numberposts' => 1,
  'post_status' => 'publish',
  'post_type'   => 'cfa_sponsors',
  'offset'     => $sponsornum,
  'meta_key'          => 'sponsor_end_date',
  'orderby'           => 'meta_value_num',
  'order'             => 'asc',
  'meta_query'    => array(
    'relation'      => 'AND',
    array(
      'key'       => 'sponsor_end_date',
      'compare'   => '>=',
      'value'     => date( 'Ymd' ),
    )
  ),
));
if (!empty($sponsorposts)) {
  foreach ($sponsorposts as $sponsorpost) {
   // echo '<pre>';
   // print_r($sponsorposts);
   // echo '</pre>';
  //$sponsorpost = $sponsorposts[0];
  $sponsorpics = get_field('sponsor_pics',$sponsorpost->ID);
  $sponsorlogo = get_field('sponsor_logo',$sponsorpost->ID);
  $sponsorStart = get_field('sponsor_start_date',$sponsorpost->ID);
  $sponsorEnd = get_field('sponsor_end_date',$sponsorpost->ID);

    if (($currentTS > $sponsorStart && $currentTS < $sponsorEnd ) && $pagenum === 1) {
      ?>
      <article id="spblock-<?php echo $sponsorpost->post_name; ?>" class="post type-post has-post-thumbnail hentry status-publish format-adv3 post-spinsert">
        <div class="spb newitem">
        <a href="<?php echo get_field('sponsor_url',$sponsorpost->ID); ?>?cid=CFAsponsor" target="_blank" rel="nofollow noopener" class="left">
            <div class="spi">
              <?php foreach ($sponsorpics as $sponsorpic) {
                
                $ll = '';
                if ($sponsornum>1) { $ll = ' loading="lazy"'; }

                $sponsorpicsrc =  wp_get_attachment_image_src($sponsorpic["sponsor_pic"]["ID"], 'large' );
                echo '<img src="'.$sponsorpicsrc[0].'"'.$ll.' width="'.$sponsorpicsrc[1].'" height="'.$sponsorpicsrc[2].'" id="splink-'. $sponsorpost->post_name.'" />';
              }
              ?>
            </div>
            <?php if ($sponsorlogo): ?>
              <div class="spc" id="<?php echo $sponsorpost->post_title ?>">
                <p><img src="<?php echo $sponsorlogo; ?>" /></p>
              </div>
            <?php endif ?>
        </a>
        </div>  
      </article>
    <?php
    }

  }
}
$sponsornum++;
 ?>
