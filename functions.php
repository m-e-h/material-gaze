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
			'default-text-color' => 'ffffff',
			'default-image'      => '%2$s/images/headers/blue.jpg',
			'random-default'     => false,
			'wp-head-callback'   => 'material_gaze_custom_header_wp_head',
		)
	);

	/* Add Site Logo. By first087 (https://github.com/first087) */
	// Declare theme support for Site Logo.
	add_theme_support( 'site-logo', array(
		'header-text' => array(
			'site-title',
			'site-description',
		),
	) );

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
		)
	);

	/* Custom editor stylesheet. */
	add_editor_style( '//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,700|Roboto+Condensed:400,300,700' );
	/* Filter to add custom default backgrounds (supported by the framework). */
	add_filter( 'hybrid_default_backgrounds', 'material_gaze_default_backgrounds' );
	/* Add a custom default color for the "primary" color option. */
	add_filter( 'theme_mod_color_primary', 'material_gaze_color_primary' );
	/* Load stylesheets. */
	add_action( 'wp_enqueue_scripts', 'material_gaze_enqueue_styles', 0 );
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
	return $hex ? $hex : '2196F3';
}

function material_gaze_enqueue_styles() {
	wp_enqueue_style( 'material-gaze-fonts', '//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,700|Roboto+Condensed:400,300,700' );
}

add_action( 'wp_head', 'material_gaze_wp_head' );
function material_gaze_wp_head() {
	$style = '';
	$hex = get_theme_mod( 'color_primary', '' );
	$style .= "#menu-primary .search-form .search-toggle, .display-header-text #header { background: #{$hex}; } ";
	$style .= "input[type='date']:focus, input[type='datetime']:focus, input[type='datetime-local']:focus, input[type='email']:focus, input[type='month']:focus, input[type='number']:focus, input[type='password']:focus, input[type='search']:focus, input[type='tel']:focus, input[type='text']:focus, input[type='time']:focus, input[type='url']:focus, input[type='week']:focus,
textarea:focus, select:focus { border-bottom-color: #{$hex}; box-shadow: 0 1px 0 0 #{$hex}; } ";
	echo "\n" . '<style type="text/css">' . trim( $style ) . '</style>' . "\n";
}

function material_gaze_custom_header_wp_head() {
	if ( !display_header_text() )
		return;
	$hex = get_header_textcolor();
	if ( empty( $hex ) )
		return;
	$style = "body.custom-header #branding, #site-title { color: #{$hex}; }";
	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function material_gaze_customize_preview_js() {
	wp_enqueue_script( 'material_gaze_customizer', trailingslashit( CHILD_THEME_URI ) .  'js/customizer.js', array( 'customize-preview' ), '20130508', true );
}

add_action( 'customize_preview_init', 'material_gaze_customize_preview_js' );
