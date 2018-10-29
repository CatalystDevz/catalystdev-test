<?php
/**
 * Template Name: Business Template
 *
 * Displays the Business Template of the theme.
 * @package Enliven
 */

get_header();

echo '<div class="enl-pb-widget-area">';

if ( is_active_sidebar( 'business-sidebar' ) ) {
	dynamic_sidebar( 'business-sidebar' );
}

echo '</div>';

get_footer();

?>