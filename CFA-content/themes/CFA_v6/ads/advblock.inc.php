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
  $advStart = get_field('sponsor_start_date',$advpost->ID);
  $advEnd = get_field('sponsor_end_date',$advpost->ID);
  ?>
  <?php 

    
  if (($currentTS > $advStart && $currentTS < $advEnd ) && $pagenum === 1) {
    ?>
    <article id="ADVblock-<?php echo $advpost->post_title; ?>" class="post type-post has-post-thumbnail hentry status-publish format-adv3 post-ad-insert">
      <div class="adv-block newitem">
      <a href="<?php echo get_field('sponsor_url',$advpost->ID); ?>?cid=CFA" target="_blank" rel="nofollow noopener" class="left">
          <div class="adv-image">
            <?php foreach ($advpics as $advpic) {
              $advpicsrc =  wp_get_attachment_image_src($advpic["sponsor_pic"]["ID"], 'large' );
              echo '<img src="'.$advpicsrc[0].'" loading="lazy" />';
            }
            ?>
          </div>
          <div class="adv-copy" id="<?php echo $advpost->post_title ?>">
            <p><img src="<?php echo get_field('sponsor_logo',$advpost->ID); ?>" loading="lazy" /></p>
          </div>
      </a>
      </div>  
    </article>
  <?php
  }
}

 ?>
