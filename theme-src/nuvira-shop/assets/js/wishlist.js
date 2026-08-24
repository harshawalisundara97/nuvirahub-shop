/**
 * Wishlist toggle — AJAX add/remove, no page reload. No build step,
 * no dependencies.
 */
( function () {
	'use strict';

	if ( typeof nuviraWishlist === 'undefined' ) {
		return;
	}

	document.addEventListener( 'click', function ( event ) {
		var button = event.target.closest( '.ns-wishlist-toggle' );
		if ( ! button ) {
			return;
		}
		event.preventDefault();

		var productId = button.getAttribute( 'data-product-id' );
		if ( ! productId ) {
			return;
		}

		var body = new URLSearchParams();
		body.set( 'action', 'nuvira_toggle_wishlist' );
		body.set( 'nonce', nuviraWishlist.nonce );
		body.set( 'product_id', productId );

		fetch( nuviraWishlist.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString(),
		} )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( json ) {
				if ( ! json.success ) {
					return;
				}
				button.classList.toggle( 'is-active', json.data.in_wishlist );
				button.setAttribute( 'aria-pressed', json.data.in_wishlist ? 'true' : 'false' );

				var badges = document.querySelectorAll( '.ns-wishlist-count' );
				badges.forEach( function ( badge ) {
					badge.textContent = json.data.count;
				} );
			} );
	} );
}() );
