<?php
$pagenum = get_query_var('paged') ? get_query_var('paged') : 1 ;

$advposts = get_posts(array(
  'numberposts' => 1,
  'post_status' => 'publish',
  'post_type'   => 'cfa_sponsors',
  'meta_key'    => 'sponsor_position',
  'meta_value'  => $postnum
));
if (!empty($advposts)) {
  $advpost = $advposts[0];
  $advpics = get_field('sponsor_pics',$advpost->ID);
  $advlogo = get_field('sponsor_logo',$advpost->ID);
  $advStart = get_field('sponsor_start_date',$advpost->ID);
  $advEnd = get_field('sponsor_end_date',$advpost->ID);
  ?>
  <?php 

    
  if (($currentTS > $advStart && $currentTS < $advEnd ) && $pagenum === 1) {
    ?>
    <article id="spblock-<?php echo $advpost->post_name; ?>" class="post type-post has-post-thumbnail hentry status-publish format-adv3 post-spinsert">
      <div class="spb newitem">
      <a href="<?php echo get_field('sponsor_url',$advpost->ID); ?>?cid=CFAsponsor" target="_blank" rel="nofollow noopener" class="left">
          <div class="spi">
            <?php foreach ($advpics as $advpic) {
              $advpicsrc =  wp_get_attachment_image_src($advpic["sponsor_pic"]["ID"], 'large' );
              echo '<img src="'.$advpicsrc[0].'" loading="lazy" id="splink-<?php echo $advpost->post_name; ?>" />';
            }
            ?>
          </div>
          <?php if ($advlogo): ?>
            <div class="spc" id="<?php echo $advpost->post_title ?>">
              <p><img src="<?php echo $advlogo; ?>" loading="lazy" /></p>
            </div>
          <?php endif ?>
      </a>
      </div>  
    </article>
  <?php
  }
}

 ?>
