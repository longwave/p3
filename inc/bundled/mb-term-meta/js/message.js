( function ( $ ) {
	"use strict";

	/*
	 * Show message when added term.
	 */
	$( document ).on( 'ajaxSuccess', function( e, request, settings ) {
		if ( settings.data.indexOf( 'action=add-tag' ) < 0 ) {
			return;
		}

		// Add added term message.
		$( '#addtag p.submit' ).before( '<div id="mb-term-meta-message" class="updated"><p><strong>' + MBTermMeta.addedMessage + '</strong></p></div>' );

		setTimeout( function () {
			$( '#mb-term-meta-message' ).fadeOut();
		}, 2000 );
	});
})( jQuery );
