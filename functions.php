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
			'default-color' => 'E5E5E5',
			'default-image' => '',
		)
	);

	/* Add a custom header to overwrite the defaults. */
	add_theme_support( 
		'custom-header', 
		array(
			'default-text-color' => '252525',
			'default-image'      => '',
			'random-default'     => false,
		)
	);

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
	return $hex ? $hex : '2759e5';
}


function material_gaze_enqueue_styles() {
	wp_enqueue_style( 'material-gaze-fonts', '//fonts.googleapis.com/css?family=RobotoDraft:regular,bold,italic,thin,light,bolditalic,black,medium' );
}

add_action( 'customize_register', 'mg_customize_register' );

	function mg_customize_register( $wp_customize ) {
		/* Add a new setting for this color. */
		$wp_customize->add_setting(
			'color_secondary',
			array(
				'default'              => apply_filters( 'theme_mod_color_secondary', '' ),
				'type'                 => 'theme_mod',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color_no_hash',
				'sanitize_js_callback' => 'maybe_hash_hex_color',
				'transport'            => 'postMessage',
			)
		);
		/* Add a control for this color. */
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'custom-colors-secondary',
				array(
					'label'    => esc_html__( 'secondary Color', 'stargazer' ),
					'section'  => 'colors',
					'settings' => 'color_secondary',
					'priority' => 10,
				)
			)
		);
	}
