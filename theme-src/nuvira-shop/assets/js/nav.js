/**
 * Mobile menu toggle — opens/closes the primary nav under the header's
 * hamburger button. No build step, no dependencies.
 */
( function () {
	'use strict';

	var toggle = document.querySelector( '.ns-menu-toggle' );
	var nav = document.getElementById( 'ns-primary-nav' );

	if ( ! toggle || ! nav ) {
		return;
	}

	toggle.addEventListener( 'click', function () {
		var isOpen = nav.classList.toggle( 'ns-nav--open' );
		toggle.classList.toggle( 'is-open', isOpen );
		toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
	} );

	nav.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( 'a' ) && nav.classList.contains( 'ns-nav--open' ) ) {
			nav.classList.remove( 'ns-nav--open' );
			toggle.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		}
	} );
}() );
