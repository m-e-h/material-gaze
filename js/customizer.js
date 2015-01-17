( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '#site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '#site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
				$( '#site-title, #site-description' ).css( {
					'color': to,
				} );
		} );
	} );

		/*
	 * Handles the Primary color for the theme.  This color is used for various elements and at different 
	 * shades. It must set an rgba color value to handle the "shades".
	 */
	wp.customize( 'color_primary', function( value ) {

		value.bind( function( to ) {
				$( '#menu-primary .search-form .search-toggle, .display-header-text #header' ).not( '#menu-secondary-items > li > a' ).css( {
					'background': to
				} );
			} );
		} );



} )( jQuery );