jQuery( document ).ready( function ( $ ) {
	"use strict";

	// Toggle "Display Settings" for page template
	$( '#page_template' ).on( 'change', function () {
		handlePageTemplateChanges( $( this ).val() );
	} ).trigger( 'change' );

	/**
	 * Handle template change event.
	 */
	function handlePageTemplateChanges( template ) {
		if ( template == 'templates/homepage.php' ) {
			$( '#full-screen-display-settings' ).hide();
			$( '#display-settings' ).show().find( '.rwmb-field.page_header_heading' ).slideUp().nextAll().slideUp();
		} else if ( template === 'templates/full-screen.php' ) {
			$( '#display-settings' ).hide();
			$( '#full-screen-display-settings' ).show();
		} else {
			$( '#full-screen-display-settings' ).hide();
			$( '#display-settings' ).show().find( '.rwmb-field.page_header_heading' ).slideDown().nextAll().slideDown();
			$( '#top_spacing, #bottom_spacing, #custom_layout, #hide_page_header' ).trigger( 'change' );
		}
	}

	// Show/hide settings for post format when choose post format
	var $format = $( '#post-formats-select' ).find( 'input.post-format' ),
		$formatBox = $( '#post-format-settings' );

	$format.on( 'change', function () {
		var type = $format.filter( ':checked' ).val();

		handlePostFormatChanges( type );
	} );
	$format.filter( ':checked' ).trigger( 'change' );

	/**
	 * Handle post format change event.
	 */
	function handlePostFormatChanges( format ) {
		$formatBox.hide();
		if ( $formatBox.find( '.rwmb-field' ).hasClass( format ) ) {
			$formatBox.show();
		}

		$formatBox.find( '.rwmb-field' ).slideUp();
		$formatBox.find( '.' + format ).slideDown();
	}

	// Show/hide settings for custom layout settings
	$( '#custom_layout' ).on( 'change', function () {
		if ( $( this ).is( ':checked' ) ) {
			$( '.rwmb-field.custom-layout' ).slideDown();
		}
		else {
			$( '.rwmb-field.custom-layout' ).slideUp();
		}
	} ).trigger( 'change' );

	// Toggle page header fields
	$( '#hide_page_header' ).on( 'change', function () {
		var $el = $( this );

		if ( $el.is( ':checked' ) ) {
			$( '.rwmb-field.page-header-field' ).slideUp();
			$( '.rwmb-field.hide-page-title' ).slideDown();
		} else {
			$( '.rwmb-field.page-header-field' ).slideDown();
			$( '.rwmb-field.hide-page-title' ).slideUp();
		}
	} ).trigger( 'change' );

	// Toggle header fields
	$( '#site_header_bg' ).on( 'change', function () {
		var $el = $( this );

		if ( 'white' == $el.val() ) {
			$( '.rwmb-field.site_header_text_color' ).slideUp();
		} else {
			$( '.rwmb-field.site_header_text_color' ).slideDown();
		}
	} ).trigger( 'change' );

	// Toggle spacing fields
	$( '#top_spacing, #bottom_spacing' ).on( 'change', function() {
		var $el = $( this );

		if ( 'custom' === $el.val() ) {
			$el.closest( '.rwmb-field' ).next( '.custom-spacing' ).slideDown();
		} else {
			$el.closest( '.rwmb-field' ).next( '.custom-spacing' ).slideUp();
		}
	} ).trigger( 'change' );

	/**
	 * This section for Gutenberg
	 */
	if ( typeof window.wp.data !== 'undefined' ) {
		var editor = wp.data.select( 'core/editor' );

		if ( editor ) {
			var currentTemplate = editor.getEditedPostAttribute( 'template' ),
				currentFormat = editor.getEditedPostAttribute( 'format' ),
				firstFire = false;

			wp.data.subscribe( function() {
				var template = editor.getEditedPostAttribute( 'template' ),
					format = editor.getEditedPostAttribute( 'format' );

				// Use this variable to run the theme check after editor loaded fully.
				if ( ! firstFire ) {
					handlePageTemplateChanges( template );
					handlePostFormatChanges( format );
					firstFire = true;
				}

				if ( currentTemplate !== template ) {
					handlePageTemplateChanges( template );
					currentTemplate = template;
				}

				if ( currentFormat !== format ) {
					handlePostFormatChanges( format );
					currentFormat = format;
				}
			} );

			// Run once again after page loaded to make sure all conditionals work correctly.
			$( window ).on( 'load', function() {
				handlePageTemplateChanges( currentTemplate );
				handlePostFormatChanges( currentFormat );
			} );
		}
	}
} );
