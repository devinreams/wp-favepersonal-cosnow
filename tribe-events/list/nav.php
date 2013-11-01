<?php 
/**
 * List View Nav Template
 * This file loads the list view navigation.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/nav.php 
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<h3 class="tribe-events-visuallyhidden"><?php _e( 'Events List Navigation', 'tribe-events-calendar' ) ?></h3>
<ul class="tribe-events-sub-nav">
	<!-- Left Navigation -->
	<li class="tribe-events-nav-previous tribe-events-nav-left tribe-events-past">
		<?php echo get_previous_posts_link() ?>
	</li><!-- .tribe-events-nav-previous -->

	<!-- Right Navigation -->
	<li class="tribe-events-nav-next tribe-events-nav-right">
		<?php echo get_next_posts_link() ?>
	</li><!-- .tribe-events-nav-previous -->
</ul>