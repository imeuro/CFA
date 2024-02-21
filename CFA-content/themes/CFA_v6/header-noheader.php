<!DOCTYPE html>
<?php 
if (is_page('it') || get_post_type(get_the_ID()) == 'cfa_translations') : 
  $lang = 'IT'; 
  $lang_attr = "it-IT";
else: 
  $lang = 'EN'; 
  $lang_attr = "en-US";
endif; 
?>
<html lang="<?php echo $lang_attr;?>">

  <head>
    	<meta charset="<?php bloginfo('charset'); ?>" />
      <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
      <meta name="description" content="<?php
        if ( is_home() || is_page('it') ) : bloginfo('description');
        else :
          global $post;
          setup_postdata( $post );
          $post_desc = get_the_excerpt();
          $post_desc = str_replace('&nbsp; ','',$post_desc);
          echo $post_desc;
        endif;
      ?>">
      <meta name="language" content="<?php echo $lang; ?>">
      <title><?php wp_title('&#124;', true, 'right'); ?></title>

      <link rel="apple-touch-icon" sizes="180x180" href="https://www.conceptualfinearts.com/apple-touch-icon.png?v60b">
      <link rel="icon" type="image/png" sizes="32x32" href="https://www.conceptualfinearts.com/favicon-32x32.png?v60b">
      <link rel="icon" type="image/png" sizes="16x16" href="https://www.conceptualfinearts.com/favicon-16x16.png?v60b">
      <link rel="manifest" href="https://www.conceptualfinearts.com/site.webmanifest?v60b">
      <link rel="mask-icon" href="https://www.conceptualfinearts.com/safari-pinned-tab.svg?v60b" color="#5bbad5">
      <link rel="shortcut icon" href="https://www.conceptualfinearts.com/favicon.ico?v60b">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">

      <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/SometimesTimes-Regular.woff2" as="font" type="font/woff2" crossorigin>
      <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/NHaasGroteskDSStd-55Rg.woff2" as="font" type="font/woff2" crossorigin>

      <style>
        <?php include( get_template_directory().'/css/critical.min.css') ?>
        <?php include( get_template_directory().'/css/gallery.css') ?>
      </style>


      <link rel="profile" href="http://gmpg.org/xfn/11" />
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
      <?php wp_head(); ?>
  </head>

  <body <?php body_class('no-header'); ?>>


