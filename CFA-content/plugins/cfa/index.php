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


// disable image srcset on frontend
function disable_wp_responsive_images() {
	return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');


// tribe events: replace wording 
/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
 
/**
 * Put your custom text here in a key => value pair
 * Example: 'Text you want to change' => 'This is what it will be changed to'.
 * The text you want to change is the key, and it is case-sensitive.
 * The text you want to change it to is the value.
 * You can freely add or remove key => values, but make sure to separate them with a comma.
 * This example changes the label "Venue" to "Location", "Related Events" to "Similar Events", and "(Now or date) onwards" to "Calendar - you can discard the dynamic portion of the text as well if desired.
*/
function tribe_replace_strings() {
  $custom_text = [
    'Upcoming' => 'On View',
    // 'Related %s' => 'Similar %s',
    // '%s onwards' => 'Calendar',
  ];
  return $custom_text;
}
 
function tribe_custom_theme_text ( $translation, $text, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
  // String replacement.
  $custom_text = tribe_replace_strings();
  // If we don't have replacement text in our array, return the original (translated) text.
  if ( empty( $custom_text[$translation] ) ) {
    return $translation;
  }
  return $custom_text[$translation];
}
 
 
 
function tribe_custom_theme_text_plurals ( $translation, $single, $plural, $number, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
  /** If you want to use the number in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   */
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  if ( 1 === $number ) {
    return tribe_custom_theme_text ( $translation, $single, $domain );
  } else {
    return tribe_custom_theme_text ( $translation, $plural, $domain );
  }
}
 
 
 
function tribe_custom_theme_text_with_context ( $translation, $text, $context, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
  /** If you want to use the context in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
   * if ( 'edit' === strtolower( $context ) ) {
   *    return $translation;
   * } elseif( 'view' === strtolower( $context ) ) {
   *    return "Tribe";
   * }
   *
   * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
   */
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  return tribe_custom_theme_text ( $translation, $text, $domain );
}
function tribe_custom_theme_text_plurals_with_context ( $translation, $single, $plural, $number, $context, $domain ) {
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! check_if_tec_domains( $domain ) ) {
    return $translation;
  }
  /**
   * If you want to use the context in your logic, this is where you'd do it.
   * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
   * Example (here, we don't want to do anything when the context is "edit", but if it's "view" we want to change it to "Tribe"):
   * if ( 'edit' === strtolower( $context ) ) {
   *    return $translation;
   * } elseif( 'view' === strtolower( $context ) ) {
   *    return "cat";
   * }
   *
   * You'd do something as well here for singular/plural. This could get complicated quickly if it has to interact with context as well.
   * Example:
   * if ( 1 === $number ) {
   *    return "cat";
   * } else {
   *    return "cats";
   * }
   * Feel free to use the same logic we use in tribe_custom_theme_text() above for key => value pairs for this logic.
   */
  // If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
  if ( 1 === $number ) {
    return tribe_custom_theme_text ( $translation, $single, $domain );
  } else {
    return tribe_custom_theme_text ( $translation, $plural, $domain );
  }
}
function check_if_tec_domains( $domain ) {
  $is_tribe_domain = strpos( $domain, 'tribe-' ) === 0;
  $is_tec_domain   = strpos( $domain, 'the-events-' ) === 0;
  $is_event_domain = strpos( $domain, 'event-' ) === 0;
  // If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
  if ( ! $is_tribe_domain && ! $is_tec_domain && ! $is_event_domain ) {
    return false;
  }
  return true;
}
// Base.
add_filter( 'gettext', 'tribe_custom_theme_text', 20, 3 );
// Plural-aware translations.
add_filter( 'ngettext', 'tribe_custom_theme_text_plurals', 20, 5 );
// Translations with context.
add_filter( 'gettext_with_context', 'tribe_custom_theme_text_with_context', 20, 4 );
// Plural-aware translations with context.
add_filter( 'ngettext_with_context', 'tribe_custom_theme_text_plurals_with_context', 20, 6 );
?>