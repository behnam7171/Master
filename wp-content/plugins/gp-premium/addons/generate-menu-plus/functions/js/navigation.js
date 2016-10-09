jQuery(window).load(function($) {
	
	var resizeTimer, sf, mobile;
    sf = jQuery('ul.sf-menu');
	mobile = jQuery( '.menu-toggle' );
	
	// Build a function that disables and enables superfish when needed
	function generateResizeNavigation() {
        if( ! mobile.is( ':visible' ) && !sf.hasClass('sf-js-enabled') ) {
			if (typeof jQuery.fn.superfish !== 'undefined' && jQuery.isFunction(jQuery.fn.superfish)) {
				// you only want SuperFish to be re-enabled once (sf.hasClass)
				sf.superfish({
					delay:       500,                            // one second delay on mouseout
					animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
					speed:       'fast',                          // faster animation speed
					cssArrows:   false
				});
			}
        } else if ( mobile.is( ':visible' ) ) {
			if (typeof jQuery.fn.superfish !== 'undefined' && jQuery.isFunction(jQuery.fn.superfish)) {
				// smaller screen, disable SuperFish
				sf.superfish('destroy');
			}
        }
    };
	
	// Add dropdown toggle that display child menu items.
	jQuery( '.main-navigation .page_item_has_children > a, .main-navigation .menu-item-has-children > a' ).after( '<a href="#" class="dropdown-toggle" aria-expanded="false"><i class="fa fa-caret-down"></i></a>' );
	
	if (typeof jQuery.fn.superfish !== 'undefined' && jQuery.isFunction(jQuery.fn.superfish)) {
		// When we resize the browser, check to see which dropdown type we should use
		jQuery(window).resize(function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(generateResizeNavigation, 250);
		});
		
		// Check to see which dropdown type we should use
		if ( mobile.is( ':visible' ) ) {
			generateResizeNavigation();
		}
	}
	
	// Build the mobile button that displays the dropdown menu
	jQuery( 'nav .dropdown-toggle' ).click( function( e ) {
		var _this = jQuery( this );
		e.preventDefault();
		_this.toggleClass( 'toggle-on' );
		_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
		_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		_this.html( _this.html() === '<i class="fa fa-caret-down"></i>' ? '<i class="fa fa-caret-up"></i>' : '<i class="fa fa-caret-down"></i>' );
			return false;
	} );
});