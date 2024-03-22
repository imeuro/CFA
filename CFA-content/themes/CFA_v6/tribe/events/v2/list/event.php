<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
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
?>
<div class="tec-list-event">
	<a	class="tec-list-event-link"
		href="<?php echo esc_url( $event->permalink ); ?>"
		title="<?php echo esc_attr( $event->title ); ?>">


	
	<?php $this->template( 'list/event/featured-image', [ 'event' => $event ] ); ?>

	<div class="tec-list-event-text">
		
		<time class="tec-list-event-datetime" datetime="<?php echo $event->dates->start->format( 'Y-m-d' ) ?>">
			<span class="tribe-event-date-start">
				<?php echo $event->dates->start->format( 'j M Y' ) ?>
			</span>
			 - 
			<span class="tribe-event-date-end">
				<?php echo $event->dates->end->format( 'j M Y' ) ?>
			</span>	
		</time>

		<h3 class="tec-event-title"><?php echo $event->title; ?></h3>
		<p class="tec-event-venue">
			<?php
			$venue = $event->venues[0];
			if ( ! empty( $venue->city ) ) :
				echo esc_html( $venue->city );
			endif;

			if ( ! empty( $venue->country ) ):
				echo ', ' . esc_html( $venue->country );
			endif;

			?>
		</p>
	</div>
	</a>
</div>

