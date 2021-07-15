<?php
/*
Plugin Name: CFA customizations
Plugin URI: http://imeuro.io/
Description: Custom functions&features on Conceptualfinearts.com - mainly post translations related but who knows...
Version: 1.0
Author: Mauro Fioravanzi
Author URI: http://imeuro.io/
*/

if( ! defined( 'ABSPATH') ) { exit; }

include('inc/custom-post-types-fields-taxonomies.php');
include('inc/backend-functions.php');
include('inc/blocks-functions.php');

function get_langswitcherDOM() {

	$ldom = '';
	global $post;

	if (is_home() || is_front_page() || is_archive() || is_search() || is_page('it')) {
		$ldom .= '<li><a href="'.home_url('/').'" data-lang="EN">EN</a>';
		$ldom .= '<a href="'.home_url('/it/').'" data-lang="IT">IT</a></li>';
	} elseif ( is_single() || is_page() ) {
		$translationID = get_field('translation',$post->ID)[0];
		$translationURL = get_permalink($translationID);
		// var_dump($translationURL);
		// var_dump($post);

		if ( $translationID !== null ) {
			if ( 'cfa_translations' == get_post_type() || $post->post_parent == '95535' ) :
				$ldom .= '<li><a href="'.$translationURL.'" data-lang="EN">EN</a>';
				$ldom .= '<span data-lang="IT">IT</span></li>';
			else : 
				$ldom .= '<li><span data-lang="EN">EN</span>';
				$ldom .= '<a href="'.$translationURL.'" data-lang="IT">IT</a></li>';
			endif;
		} else {
			return;
		}
	}
	return $ldom;
}


function exclude_category( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		//$query->set( 'category__not_in', 2381 ); // cat. Online Exhibitions, ma non va bene...

		$current_meta = array($query->get('meta_query'));
		// aggiungiamo filtro per includere posts 
		// senza CF display_banner
		// oppure CF display_banner NON settato a 1
		$custom_meta = array(
			'relation' => 'OR',
			array(
				'key' => 'display_banner',
				'compare' => 'NOT EXISTS'
			),
			array(
				'key' => 'display_banner',
				'type' => 'BINARY',
				'value' => '1',
				'compare' => '!='
			)
		);
		$meta_query = $current_meta = $custom_meta;
		$query->set('meta_query', array($meta_query));	
	}
}
add_action( 'pre_get_posts', 'exclude_category' );



function getOutYouFreakinBot() {
	// bots being bots trying to (wrongly) guess italian translations
	// of posts written *BEFORE 2018/03/15*

	$reg = '/\/it\/((20[0-1][0-7]|2017)|(2018\/([01]([0-2])\/[0-2][0-4])))/';
	$url = $_SERVER["REQUEST_URI"];
	$subst = '/$1';
	$result = preg_match($reg, $url);

	// print_r($result);

	if ( $result != null ) :
	    $newurl = preg_replace($reg, $subst, $url);

	    print_r($newurl);

	    wp_redirect( $newurl, 301 ); 
	    exit;

	endif;
     
}
add_action( 'template_redirect', 'getOutYouFreakinBot' );
?>