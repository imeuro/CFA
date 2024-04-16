<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();
$website_title = tribe_events_get_venue_website_title();

?>


<h2 class="tribe-events-single-section-title"> <?php echo esc_html( tribe_get_venue_label_singular() ) ?> </h2>
<p>
	<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>
	<strong
		class="tribe-common-a11y-visual-hide"
		aria-label="<?php echo sprintf(
			/* Translators: %1$s is the customizable venue term, e.g. "Venue". %2$s is the customizable event term in lowercase, e.g. "event". %3$s is the customizable venue term in lowercase, e.g. "venue". */
			esc_html_x( '%1$s name: This represents the name of the %2$s %3$s.', 'the-events-calendar' ),
			tribe_get_venue_label_singular(),
			tribe_get_event_label_singular_lowercase(),
			tribe_get_venue_label_singular_lowercase()
		) ; ?>"
	>
		<?php // This element is only present to ensure we have a valid HTML, it'll be hidden from browsers but visible to screenreaders for accessibility. ?>
	</strong>
	
	<strong class="tribe-venue"> <?php echo tribe_get_venue() ?> </strong>
	<?php if ( tribe_address_exists() ) : ?>
			<strong
				class="tribe-common-a11y-visual-hide"
				aria-label="<?php echo sprintf(
					/* Translators: %1$s is the customizable venue term, e.g. "Venue". %2$s is the customizable event term in lowercase, e.g. "event". %3$s is the customizable venue term in lowercase, e.g. "venue". */
					esc_html_x( '%1$s address: This represents the address of the %2$s %3$s.', 'the-events-calendar' ),
					tribe_get_venue_label_singular(),
					tribe_get_event_label_singular_lowercase(),
					tribe_get_venue_label_singular_lowercase()
				) ; ?>"
			>
				<?php // This element is only present to ensure we have a valid HTML, it'll be hidden from browsers but visible to screenreaders for accessibility. ?>
			</strong>
			<span class="tribe-venue-location">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if ( tribe_show_google_map_link() ) : ?>
						<span><?php echo tribe_get_map_link_html(); ?></span>
					<?php endif; ?>
				</address>
			</span>
		
	<?php endif; ?>

	<?php if ( ! empty( $phone ) ): ?>
			<strong class="tribe-venue-tel-label"> <?php esc_html_e( 'Phone', 'the-events-calendar' ) ?> </strong>
			<span class="tribe-venue-tel"> <?php echo $phone ?> </span>
	<?php endif ?>

	<?php if ( ! empty( $website ) ): ?>
			<?php if ( ! empty( $website_title ) ): ?>
				<strong class="tribe-venue-url-label"> <?php echo esc_html( $website_title ) ?> </strong>
			<?php else: ?>
				<strong
					class="tribe-common-a11y-visual-hide"
					aria-label="<?php echo sprintf(
						/* Translators: %1$s is the customizable venue term, e.g. "Venue". %2$s is the customizable event term in lowercase, e.g. "event". %3$s is the customizable venue term in lowercase, e.g. "venue". */
						esc_html_x( '%1$s website title: This represents the website title of the %2$s %3$s.', 'the-events-calendar' ),
						tribe_get_venue_label_singular(),
						tribe_get_event_label_singular_lowercase(),
						tribe_get_venue_label_singular_lowercase()
					) ; ?>"
				>
					<?php // This element is only present to ensure we have a valid HTML, it'll be hidden from browsers but visible to screenreaders for accessibility. ?>
				</strong>
			<?php endif ?>
			<strong class="tribe-venue-url"> <?php echo $website ?> </strong>
	<?php endif ?>

	<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
</p>