<?php
/**
 * View: List View Nav Today Button
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/nav/today.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @var string $today_url The URL to the today page.
 *
 * @version 5.0.1
 *
 */
?>
<li class="tec-nav--today">
	<a
		href="<?php echo esc_url( $today_url ); ?>"
		class="tec-nav-link tec-nav-link--today"
		data-js="tribe-events-view-link"
		aria-label="<?php echo esc_attr( $today_title ); ?>"
		title="<?php echo esc_attr( $today_title ); ?>"
	>
		<?php echo esc_html( $today_label ); ?>
	</a>
</li>
