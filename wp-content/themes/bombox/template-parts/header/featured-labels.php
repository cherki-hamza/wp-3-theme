<?php
/**
 * The template part for displaying featured labels navigation
 *
 * @package BoomBox_Theme
 * @since   2.0.0
 * @version 2.0.0
 * @var $template_helper Boombox_Featured_Labels_Template_Helper Template Helper
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( has_nav_menu( 'featured_labels' ) ) {
	$template_helper = Boombox_Template::init( 'featured-labels' );
	$template_options = $template_helper->get_options();

	if( $template_options['is_visible'] ) {
		wp_nav_menu( array(
			'theme_location' => 'featured_labels',
			'menu_class'     => '',
			'container'      => false,
			'depth'          => 1,
			'items_wrap'     => '<div class="container bb-featured-menu bb-scroll-area bb-stretched-full no-gutters '
		. $template_options['class'] . '"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
			'walker'         => new Boombox_Walker_Featured_Labels_Nav_Menu(),
		) );
	}
}