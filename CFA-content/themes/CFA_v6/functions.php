<?php
/**
 * Pinbin functions
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */



// bots being bots trying to (wrongly) guess italian translations
// of posts written *BEFORE 2018/03/15*
function getOutYouFreakinBot() {
	
	// $reg = '/\/it\/((20[0-1][0-7]|2017)|(2018\/([01]([0-2])\/[0-2][0-4])))/';
	$reg = '/\/it\/((20[0-1][0-7]|2017))/';
	$url = $_SERVER["REQUEST_URI"];
	$subst = '/$1';
	$result = preg_match($reg, $url);

	// print_r($result);

	if ( $result != null ) :
	    $newurl = preg_replace($reg, $subst, $url);

	    // print_r($newurl);

	    wp_redirect( $newurl, 301 ); 
	    exit;

	endif;
     
}
add_action( 'template_redirect', 'getOutYouFreakinBot' );



if ( ! isset( $content_width ) )
	$content_width = 630; /* pixels */

/**
* Custom Theme Options
*/

if ( is_admin() && is_readable( get_template_directory() . '/options/theme-options.php' ) )
	require_once( get_template_directory() . '/options/theme-options.php' );

if ( ! function_exists( 'CFA_setup' ) ):

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */

function CFA_setup() {

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

		// post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size('summary-image', 300, 9999);
	add_image_size('detail-image', 750, 9999);


	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Buttercream, use a find and replace
	 * to change 'buttercream' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pinbin', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'main_nav' => __( 'Main Menu', 'pinbin' ),
		'manga-style' => 'Hover Menu'
	) );

}
endif;
add_action( 'after_setup_theme', 'CFA_setup' );

// adds async and/or defer to <script> tag
function add_async_forscript($url) {
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async"; 
}
function add_defer_forscript($url) {
    if (strpos($url, '#deferload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#deferload', '', $url);
    else
    	return str_replace('#deferload', '', $url)."'  defer='defer";
}
add_filter('clean_url', 'add_async_forscript', 11, 1);
add_filter('clean_url', 'add_defer_forscript', 11, 1);


if (!is_admin())
	add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );

	add_action( 'wp_enqueue_scripts', 'CFA_scripts' );

function wpdocs_theme_add_editor_styles() {
	add_editor_style( 'css/editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );



function CFA_scripts() {
	global $post;

	wp_deregister_script('jquery');
	wp_deregister_script('jquery-migrate');

	wp_enqueue_script( 'CFA-functions', get_template_directory_uri() . '/js/CFA_functions.js', array(), null, true );

	// wp_enqueue_style( 'style', get_stylesheet_uri(), '', '', 'all'  );

	if ($_GET['print'] && $_GET['print']=='enabled'){
		wp_enqueue_style( 'print', get_template_directory_uri() . "/print.css", 'style-css', '1.0', 'print' );
	}
	
	if (is_page('newsletter')) {
		wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.12.4.min.js', array( ), '', false);
		wp_register_script('jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate-1.4.1.min.js', array( 'jquery' ), '', false);
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-migrate' );

		if ( function_exists( 'wpcf7_enqueue_scripts') && function_exists( 'wpcf7_enqueue_styles' ) ) {
			wpcf7_enqueue_scripts();
			wpcf7_enqueue_styles();
		}
	}

}


// Remove JQuery migrate:
// https://www.infophilic.com/remove-jquery-migrate-wordpress/

function remove_jquery_migrate( $scripts ) {
	global $post;
	if ( !is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) { // Check whether the script has any dependencies
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

/**
 * wp_title() Filter for better SEO.
 *
 * Adopted from Twenty Twelve
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 *
 */
if ( !function_exists('pinbin_wp_title') && !defined( 'AIOSEOP_VERSION' ) ) :

	function pinbin_wp_title( $title, $sep ) {
		global $page, $paged;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( __( 'Page %s', 'pinbin' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'pinbin_wp_title', 10, 2 );

endif;







/* limite a X parole */
function string_limit_words($string, $word_limit) {
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

/* non voglio le thumbs nella gallery!! */
function CFA_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'li',
		'icontag'    => 'span',
		'captiontag' => 'h3',
		'columns'    => 1,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'li';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'span';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'h3';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>

			#{$selector} {
				width: 100%;
				max-width: 640px;
				margin: 0 auto;
				padding: 0;
				list-style:none;
			}
			#{$selector} .gallery-item {
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				width: 100%;
				max-width: 640px;
				height: auto;
				margin: 0 auto;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div class='container'>\n
	<div class='swiper-container CFAslider'>\n
	<ul id='$selector' class='gallery slider swiper-wrapper galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>\n\n";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$image_output = "<img data-src=\"";
		$image_output .= wp_get_attachment_image_src( $id, $size, false )[0];
		$image_output .= "\" alt=\"".$attachment->post_title."\" width=\"";
		$image_output .= wp_get_attachment_image_src( $id, $size, false )[1];
		$image_output .= "\" height=\"";
		$image_output .= wp_get_attachment_image_src( $id, $size, false )[2];
		$image_output .= "\" class=\"swiper-lazy\" />\n";
    	$image_output .= "<div class=\"swiper-lazy-preloader\"></div>";

		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='swiper-slide gallery-item item'>";
		$output .= "$image_output\n";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>\n";
		}
		$output .= "</{$itemtag}>\n\n";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '';
	}
	$output .= "\n\n
		</ul>\n";

	$frecce='no';
	foreach ( $attachments as $id => $attachment ) {
		$i++;
		if ($i>2):
			$frecce='ok';
		endif;
	}
	if($frecce=='ok') :

		$output .= "\n
		<div class=\"prevContainer\"></div>\n
		<div class=\"nextContainer\"></div>\n
		<div class=\"swiper-pagination\"></div>\n
		</div>\n\n";
		// $output .= "\n
		// <div class=\"swiper-pagination\"></div>\n
		// </div>\n\n";

	else:

		$output .= "</div>\n\n";

	endif;



	return $output;
}

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'CFA_gallery_shortcode');

add_filter('show_admin_bar', '__return_false');



/*
Remove wp-caption inline style width in WordPress 3.4 and up
http://wp-snippets.com/remove-wp-caption-inline-style-width-in-wordpress-3-4-and-up/
*/
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
 if ( ! isset( $attr['caption'] ) ) {
 if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
 $content = $matches[1];
 $attr['caption'] = trim( $matches[2] );
 }
 }
 $output = apply_filters('img_caption_shortcode', '', $attr, $content);
 if ( $output != '' )
 return $output;
 extract(shortcode_atts(array(
 'id' => '',
 'align' => 'alignnone',
 'width' => '',
 'caption' => ''
 ), $attr));
 if ( 1 > (int) $width || empty($caption) )
 return $content;
 if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
 return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
 . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

//////////////////////////////////////
//
// 27 jan 2016
// add real author, not WP author
// in Admin Post List
//
//////////////////////////////////////

//Add custom column
add_filter('manage_edit-post_columns', 'real_auth_head');
function real_auth_head($defaults) {
	$defaults['autore'] = __('Author');
	return $defaults;
}
//Add rows data
add_action( 'manage_post_posts_custom_column' , 'real_auth_column', 10, 2 );
function real_auth_column($column, $post_id ){
	switch ( $column ) {
		case 'autore':
		echo get_post_meta( $post_id , 'author_name' , true );
		break;
	}
}
// order appearance
function set_columns_order($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'autore' =>__('Author'),
        'categories' =>__('Categories'),
        'tags' =>__('Tags'),
        'date' => __('Date'),
        'gadwp_stats' => __('Analytics')
    );
}
add_filter('manage_post_posts_columns' , 'set_columns_order');


add_filter('xmlrpc_enabled', '__return_false');

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// MAILPOET STUFF (newsletter)
function mpoet_get_undo_unsubscribe(){
	if(class_exists('WYSIJA') && !empty($_REQUEST['wysija-key'])){
		$undo_paramsurl = array(
		 'wysija-page'=>1,
		 'controller'=>'confirm',
		 'action'=>'undounsubscribe',
		 'wysija-key'=>$_REQUEST['wysija-key']
	 	);

		$model_config = WYSIJA::get('config','model');
        	$link_undo_unsubscribe = WYSIJA::get_permalink($model_config->getValue('confirmation_page'),$undo_paramsurl);
		$undo_unsubscribe = str_replace(array('[link]','[/link]'), array('<a href="'.$link_undo_unsubscribe.'">','</a>'),'<strong>'.__('You made a mistake? [link]Undo unsubscribe[/link].',WYSIJA)).'</strong>';
		return $undo_unsubscribe;
	 }
	return '';
}

add_shortcode('mailpoet_undo_unsubscribe', 'mpoet_get_undo_unsubscribe');



// shortcode to insert
function tagline_shortcode() {
		$count_posts = wp_count_posts();
		$doubled_posts = str_split($count_posts->publish * 2);
		$split_count_posts = '';
		foreach ($doubled_posts as $number) {
			$split_count_posts .= "<span>".$number."</span>";
		}
		$short_txt = '<span class="CFA_headline"><span class="postcount">'.$split_count_posts.'</span></span>';

    return $short_txt;
}
add_shortcode('CFA_tagline', 'tagline_shortcode');


// define the wpseo_opengraph_show_publish_date callback
function r2o_overwrite_yoast_publish_date( $content ) {
    $date = new DateTime(get_post_modified_time('c',true));
    $date->setTimezone(new DateTimeZone(get_option('timezone_string')));
    return $date->format('c');
};
add_filter( 'wpseo_og_article_published_time', 'r2o_overwrite_yoast_publish_date', 90, 2 );

function CFA_change_pubdate( $data ) { 
  $data['datePublished'] = get_post_modified_time('c',true); 
  return $data; 
}
add_filter( 'wpseo_schema_article', 'CFA_change_pubdate' );
add_filter( 'wpseo_schema_webpage', 'CFA_change_pubdate' );



add_theme_support( 'align-wide' );

// rimuove stupide immagini scaled:
// https://hollypryce.com/disable-image-scaling-wordpress/
add_filter( 'big_image_size_threshold', '__return_false' );

add_filter('jpeg_quality', function($arg){return 100;});


// add capability to upload svg or other mime types
// https://www.elegantthemes.com/blog/wordpress/how-to-fix-the-sorry-this-file-type-is-not-permitted-for-security-reasons-error-in-wordpress
function CFA_mime_types( $mimes ) {
	// New allowed mime types.
	$mimes['svg'] = 'image/svg+xml';
	// Remove a mime type.
	unset( $mimes['exe'] );
	return $mimes;
}
add_filter( 'upload_mimes', 'CFA_mime_types' );

// remove block-library/style.css:
// /cfa/wordpress/wp-includes/css/dist/block-library/style.min.css?ver=5.5.3
// /cfa/CFA-content/plugins/wysija-newsletters/css/validationEngine.jquery.css?ver=2.14
function remove_block_library_css() {
wp_dequeue_style( 'wp-block-library' ); 
wp_dequeue_style( 'validate-engine-css' ); 
}
add_action( 'wp_enqueue_scripts', 'remove_block_library_css' );

// disable wp-embed.min.js
// https://wordpress.stackexchange.com/questions/211701/what-does-wp-embed-min-js-do-in-wordpress-4-4
function disable_wpembedJS(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'disable_wpembedJS' );

