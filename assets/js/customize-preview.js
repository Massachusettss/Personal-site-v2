/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";

  var style = $( '#karis-color-scheme-css' ),
		api = wp.customize;

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="karis-color-scheme-css" />' )
												.find( '#karis-color-scheme-css' );
	}

	// Site title
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site__title > a' ).text( to );
		} );
	} );

	// Site description
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site__description' ).text( to );

			if ( ! to.length ) {
				$( '.featured--site-info' ).removeClass( 'featured--has-site-description' );
			} else {
				$( '.featured--site-info' ).addClass( 'featured--has-site-description' );
			}
		} );
	} );

	// Footer copyright text.
	api( 'copyright_text', function( value ) {
		value.bind( function( to ) {
			// Update copyright text
			$( '.copyright__text' ).text( to );
		} );
	} );

	// Color Scheme.
	api( 'color_scheme', function( value ) {
		value.bind( function( to ) {
			// Update color scheme body class
			$( 'body' )
				.removeClass( 'color-scheme--default' )
				.addClass( 'color-scheme--' + to );
		} );
	} );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Collect information from customize-controls.js about which sections are opening.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'featured-content-area-highlight', function( data ) {
      // Only on the first page of front page.
      if ( ! $( 'body' ).hasClass( 'featured--enabled' ) ) {
        return;
      }

			// When the section is expanded, show content placeholder.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'highlight-featured-content-area' );
			// If we've left the panel, hide the placeholder.
			} else {
				$( 'body' ).removeClass( 'highlight-featured-content-area' );
			}
		} );

		// Initially hide the post navigation placeholder on load.
		$( '.post-navigation--placeholder' ).hide();

		api.preview.bind( 'post-navigation-highlight', function( data ) {
			// Only on the single post.
			if ( ! $( 'body' ).hasClass( 'single-post' ) ) {
				return;
			}

			// When the section is expanded, show the placeholder.
			if ( true === data.expanded ) {
				$( '.post-navigation--placeholder' ).slideDown( 200 );
			// If we've left the panel, hide the placeholder.
			} else {
				$( '.post-navigation--placeholder' ).slideUp( 200 );
			}
		} );

		// Initially hide the related posts placeholder on load.
		$( '.related-posts--placeholder' ).hide();

		api.preview.bind( 'related-posts-highlight', function( data ) {
			// Only on the single post.
			if ( ! $( 'body' ).hasClass( 'single-post' ) ) {
				return;
			}

			// When the section is expanded, show the placeholder.
			if ( true === data.expanded ) {
				$( '.related-posts--placeholder' ).slideDown( 200 );
			// If we've left the panel, hide the placeholder.
			} else {
				$( '.related-posts--placeholder' ).slideUp( 200 );
			}
		} );
	} );

	// Work with featured area settings
	api.bind( 'preview-ready', function() {
		// Init wide featured posts carousel only if it selected.
		api.preview.bind( 'featured-carousel-selected', function() {
			api.selectiveRefresh.bind( 'partial-content-rendered', function() {
				if ( $( '#featured-carousel' ).hasClass( 'slick-initialized' ) ) {
					$( '#featured-carousel' ).slick( 'unslick' );
				}

				$( '#featured-carousel' ).slick( {
					dots: false,
					autoplay: true,
					autoplaySpeed: 10000,
					fade: true,
					cssEase: 'ease-in-out',
          adaptiveHeight: true,
          prevArrow: $('#featured-content-area .carousel__arrow--prev'),
    			nextArrow: $('#featured-content-area .carousel__arrow--next'),
				} );
			} );
		} );
	} );
} )( jQuery );
