<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

/* Add the child theme setup function to the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'material_gaze_theme_setup' );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function material_gaze_theme_setup() {

	/* Add a custom background to overwrite the defaults. */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'eeeeee',
			'default-image' => '',
		)
	);

	/* Add a custom header to overwrite the defaults. */
	add_theme_support( 
		'custom-header', 
		array(
			'default-text-color' => '212121',
			'default-image'      => '%2$s/images/headers/blue.jpg',
			'random-default'     => false,
		)
	);


	/* Register default headers. */
	register_default_headers(
		array(
			'blue' => array(
				'url'           => '%2$s/images/headers/blue.jpg',
				'thumbnail_url' => '%2$s/images/headers/blue-thumb.jpg',
				'description'   => __( 'default', 'material-gaze' )
			),
			'red' => array(
				'url'           => '%2$s/images/headers/red.jpg',
				'thumbnail_url' => '%2$s/images/headers/red-thumb.jpg',
				'description'   => __( 'red', 'material-gaze' )
			),
			'pyramid' => array(
				'url'           => '%2$s/images/headers/pyramid.jpg',
				'thumbnail_url' => '%2$s/images/headers/pyramid-thumb.jpg',
				'description'   => __( 'pyramid', 'material-gaze' )
			),
		)
	);
	/* Custom editor stylesheet. */
	add_editor_style( '//fonts.googleapis.com/css?family=RobotoDraft' );


	/* Filter to add custom default backgrounds (supported by the framework). */
	add_filter( 'hybrid_default_backgrounds', 'material_gaze_default_backgrounds' );

	/* Add a custom default color for the "primary" color option. */
	add_filter( 'theme_mod_color_primary', 'material_gaze_color_primary' );

	/* Load stylesheets. */
	add_action( 'wp_enqueue_scripts', 'material_gaze_enqueue_styles', 0 );
}

/**
 * Registers custom default backgrounds.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $backgrounds
 * @return array
 */
function material_gaze_default_backgrounds( $backgrounds ) {

	$new_backgrounds = array(
		'gray-square' => array(
			'url'           => '%2$s/images/backgrounds/gray-square.png',
			'thumbnail_url' => '%2$s/images/backgrounds/gray-square-thumb.png',
		),
		'blue-square' => array(
			'url'           => '%2$s/images/backgrounds/blue-square.png',
			'thumbnail_url' => '%2$s/images/backgrounds/blue-square-thumb.png',
		),
	);

	return array_merge( $new_backgrounds, $backgrounds );
}



/**
 * Add a default custom color for the theme's "primary" color option.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $hex
 * @return string
 */
function material_gaze_color_primary( $hex ) {
	return $hex ? $hex : '00bcd4';
}


function material_gaze_enqueue_styles() {
	wp_enqueue_style( 'material-gaze-fonts', '//fonts.googleapis.com/css?family=Roboto:100,300,400,500,400italic,700italic' );
}


add_action( 'wp_head', 'material_gaze_wp_head' );

function material_gaze_wp_head() {

	$style = '';
	$hex = get_theme_mod( 'color_primary', '' );

	$style .= "#menu-primary .search-form .search-toggle { background: #{$hex}; } ";

	echo "\n" . '<style type="text/css">' . trim( $style ) . '</style>' . "\n";
}