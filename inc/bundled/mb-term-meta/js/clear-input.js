( function( $ ) {
	"use strict";

	/*
	 * Clear inputs value when added term.
	 */
	$( document ).on( 'ajaxSuccess', function( e, request, settings ) {
		if ( settings.data.indexOf( 'action=add-tag' ) < 0 ) {
			return;
		}

		// TinyMCE.
		if ( typeof tinyMCE !== 'undefined' ) {
			tinyMCE.activeEditor.setContent( '' );
		}

		$( '.rwmb-meta-box :input:visible' ).val( '' );

		// Range.
		$( '.rwmb-range + .rwmb-output' ).text( '' );

		// Media field.
		$( '.rwmb-image_advanced' ).trigger( 'media:reset' );

		// File upload.
		$( '.rwmb-media-list' ).html( '' );

		// Color picker field.
		$( '.rwmb-color' ).val( '' );
		$( '.rwmb-input .wp-color-result' ).css( 'background-color', '' );

		// Checkbox and radio.
		$( '.rwmb-meta-box :input:checkbox, .rwmb-meta-box :input:radio' ).prop( 'checked', false );

		// Clone field.
		$( '.rwmb-clone:not(:first-of-type)' ).remove();
	} );
} )( jQuery );
