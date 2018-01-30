jQuery( function () {
	"use strict";

	if ( typeof tinyMCE === 'undefined' ) {
		return;
	}

	setTimeout( function () {
		var editors = tinyMCE.editors;

		for ( var i in editors ) {
			editors[i].on( 'change', editors[i].save );
		}
	}, 500 );
} );
