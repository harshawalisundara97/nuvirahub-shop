( function () {
	'use strict';

	var toggle = document.querySelector( '.ns-shop-view-toggle' );
	var grid = document.querySelector( '.ns-shop-main ul.products' );
	if ( ! toggle || ! grid ) {
		return;
	}

	var STORAGE_KEY = 'nuvira-shop-view';

	function applyView( view ) {
		grid.classList.toggle( 'is-list-view', view === 'list' );
		toggle.querySelectorAll( '.ns-view-btn' ).forEach( function ( btn ) {
			btn.classList.toggle( 'is-active', btn.dataset.view === view );
		} );
	}

	toggle.addEventListener( 'click', function ( event ) {
		var btn = event.target.closest( '.ns-view-btn' );
		if ( ! btn ) {
			return;
		}
		applyView( btn.dataset.view );
		try {
			localStorage.setItem( STORAGE_KEY, btn.dataset.view );
		} catch ( e ) {}
	} );

	try {
		var saved = localStorage.getItem( STORAGE_KEY );
		if ( saved ) {
			applyView( saved );
		}
	} catch ( e ) {}
} )();
