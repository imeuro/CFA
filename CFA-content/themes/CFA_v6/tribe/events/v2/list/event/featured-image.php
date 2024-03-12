<?php
/**
 * View: List View - Single Event Featured Image
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/featured-image.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( ! $event->thumbnail->exists ) {
	return;
} ?>

<img src="<?php echo esc_url( $event->thumbnail->full->url ); ?>" <?php if ( ! empty( $event->thumbnail->alt ) ) : ?>
	alt="<?php echo esc_attr( $event->thumbnail->alt ); ?>"
<?php else : // We need to ensure we have an empty alt tag for accessibility reasons if the user doesn't set one for the featured image ?>
	alt="event image"
<?php endif; ?>
<?php if ( ! empty( $event->thumbnail->title ) ) : ?>
	title="<?php echo esc_attr( $event->thumbnail->title ); ?>"
<?php endif; ?>
class="tec-list-event-image"
width="<?php echo esc_attr( $event->thumbnail->full->width ); ?>"
height="<?php echo esc_attr( $event->thumbnail->full->height ); ?>"/>