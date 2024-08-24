/**
 * File functions.js.
 *
 * Contains handlers for navigation, search and scroll to top button.
 */

( function( $ ) {
  "use strict";

  var body, masthead, menuToggle, headerMenu, menuPrimary, menuSecondary, resizeTimer, commentsToggle, commentsArea, resizeTimer;

  function initMainNavigation( container ) {
    // Add dropdown toggle that displays child menu items.
    var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false } )
      .append( karisScreenReaderText.icon )
      .append( $( '<span />', { 'class': 'screen-reader-text', text: karisScreenReaderText.expand } ) );

    // Add an icon for links with child elements.
    var linkIcon = $( '<span />', { 'class': 'dropdown-icon' } )
      .append( karisScreenReaderText.icon );

    container.find( '.menu-item-has-children > a' ).append( linkIcon ).after( dropdownToggle );

    // Set the active submenu dropdown toggle button initial state.
    container.find( '.current-menu-ancestor > button' )
      .addClass( 'toggled-on' )
      .attr( 'aria-expanded', 'true' )
      .find( '.screen-reader-text' )
      .text( karisScreenReaderText.collapse );
    // Set the active submenu initial state.
    container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

    container.find( '.dropdown-toggle' ).click( function( e ) {
      var _this            = $( this ),
          screenReaderSpan = _this.find( '.screen-reader-text' );

      e.preventDefault();
      _this.toggleClass( 'toggled-on' );
      _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

      _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

      screenReaderSpan.text( screenReaderSpan.text() === karisScreenReaderText.expand ? karisScreenReaderText.collapse : karisScreenReaderText.expand );
    } );
  }

  initMainNavigation( $( '.header__menu--primary' ) );
  initMainNavigation( $( '.header__menu--secondary' ) );

  masthead      = $( '#masthead' );
  menuToggle    = masthead.find( '#menu-toggle' );
  headerMenu    = masthead.find( '#header-menu' );
  menuPrimary   = masthead.find( '#menu-primary' );
  menuSecondary = masthead.find( '#menu-secondary' );

  // Enable menuToggle.
  ( function() {
    // Return early if menuToggle is missing.
    if ( ! menuToggle.length ) {
      return;
    }

    // Add an initial values for the attribute.
    menuToggle.add( menuPrimary ).add( menuSecondary ).attr( 'aria-expanded', 'false' );

    menuToggle.on( 'click.karis', function() {
      $( this ).add( headerMenu ).toggleClass( 'toggled-on' );

      $( this ).add( menuPrimary ).add( menuSecondary ).attr( 'aria-expanded', $( this ).add( menuPrimary ).add( menuSecondary ).hasClass( 'toggled-on' ) );
    } );
  } )();

  // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
  ( function() {
    if ( ! menuPrimary.length || ! menuPrimary.children().length ) {
      return;
    }

    // Toggle `focus` class to allow submenu access on tablets.
    function toggleFocusClassTouchScreen() {
      if ( window.innerWidth >= 960 ) {

        $( document.body ).on( 'touchstart.karis', function( e ) {
          if ( ! $( e.target ).closest( '.header__menu--primary li' ).length ) {
            $( '.sidebar__menu li' ).removeClass( 'focus' );
          }
        } );

        menuPrimary.find( '.menu-item-has-children > a' ).on( 'touchstart.karis', function( e ) {
          var el = $( this ).parent( 'li' );

          if ( ! el.hasClass( 'focus' ) ) {
            e.preventDefault();
            el.toggleClass( 'focus' );
            el.siblings( '.focus' ).removeClass( 'focus' );
          }
        } );

      } else {
        menuPrimary.find( '.menu-item-has-children > a' ).unbind( 'touchstart.karis' );
      }
    }

    if ( 'ontouchstart' in window ) {
      $( window ).on( 'resize.karis', toggleFocusClassTouchScreen );
      toggleFocusClassTouchScreen();
    }

    menuPrimary.find( 'a' ).on( 'focus.karis blur.karis', function() {
      $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
    } );
  } )();

  commentsToggle = $( '#show-comments-button' );
  commentsArea   = $( '#comments .comments-area__wrapper' );

  // Enable commentsToggle.
  ( function() {
    // Return early if commentsToggle is missing.
    if ( ! commentsToggle.length ) {
      return;
    }

    // Add an initial values for the attribute.
    commentsToggle.add( commentsArea ).attr( 'aria-expanded', 'false' );

    commentsToggle.on( 'click.karis', function() {
      $( this ).add( commentsArea ).toggleClass( 'toggled-on' );

      $( this ).add( commentsArea ).attr( 'aria-expanded', $( this ).add( commentsArea ).hasClass( 'toggled-on' ) );
    } );
  } )();

  // Shows comments area by certain anchors.
  function showCommentsByAnchor() {
    var anchor = window.location.hash.replace("#","");

    if ( ! anchor.length ) {
      return;
    }

    if ( anchor == "comments" || anchor == "respond" || anchor.includes("comment-") ) {
      $( '#comments .comments-area__wrapper' ).slideDown( 0 );
      $( '#show-comments-button' ).slideUp( 0 );
    }
  }

  // Init Featured Carousel.
  function initFeaturedCarousel() {
    var featuredContentArea, featuredCarousel;

    featuredContentArea = $( '#featured-content-area' );
    featuredCarousel    = featuredContentArea.find( '#featured-carousel' );

    if ( ! featuredCarousel.length ) {
      return;
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
  }

  // Init Masonry Content Layout.
  function initMasonryLayout() {
    var mainContent, masonryConteiner;

    mainContent      = $( '#primary' );
    masonryConteiner = mainContent.find( '#loop-masonry' );

    if ( ! masonryConteiner.length ) {
      return;
    }

    var $grid = $( '#loop-masonry > .grid' ).masonry( {
			itemSelector: '.grid__item--js',
			columnWidth: '.grid__item--js',
			percentPosition: true,
			initLayout: false,
		} );

    // layout Masonry after each image loads
		$grid.imagesLoaded().progress( function() {
			$grid.masonry( 'layout' );
		} );

		// add class to items after Masonry layout complete
		$grid.on( 'layoutComplete', function( event, laidOutItems ) {
			$( '.grid__item--js' ).each( function( i ) {
				setTimeout( function() {
					$( '.grid__item--js' ).eq( i ).addClass( 'grid__item--is-visible' );
				}, 200 * i );
			} );
		} );

		$grid.masonry();
  }

  // Get the browser's scrollbar size for alignfull elements.
  function scrollbarWidth() {
    var $outer = $( '<div>' ).css( { visibility: 'hidden', width: 100, overflow: 'scroll' } ).appendTo( 'body' ),
        widthWithScroll = $( '<div>' ).css( { width: '100%' } ).appendTo( $outer ).outerWidth();
    $outer.remove();
    var scrollbarWidth = 100 - widthWithScroll;

    document.documentElement.style.setProperty( '--scrollbar-width', scrollbarWidth + 'px' );
  }

  // Fire on document ready.
  $( document ).ready( function() {
    body = $( document.body );

    // Scroll to content.
    $( '#featured-content-area .button--scroll-to-content' ).on( 'click.karis', function() {
			$.scrollTo( $( '#content-area' ), {
				duration: 600
			} );
    } );

    // Init Featured Carousel.
    initFeaturedCarousel();

    // Init Masonry Content Layout.
    initMasonryLayout();

    // Show comments.
    $( '#show-comments-button' ).on( 'click.karis', function() {
      $( '#show-comments-button' ).slideUp( 100 );
      $( '#comments .comments-area__wrapper' ).slideDown( 200, function() {
  			$.scrollTo( $( '#comments .comments-area__wrapper' ), {
  				duration: 600,
          offset: { 'top': -48 }
  			} );
  		} );
    } );

    // Show comments by anchor.
    showCommentsByAnchor();

    // Scroll to comments.
    $( '.comments-link > a' ).on( 'click.karis', function() {
      $( '#comments .comments-area__wrapper' ).slideDown( 0 );
      $( '#show-comments-button' ).slideUp( 0 );
    } );

    // Search.
    $( '#menu-item-search > a' ).on( 'click.karis', function( event ) {
      event.preventDefault();
      $( '#search-overlay' ).addClass( 'search-overlay--open' );
      $( '#search-overlay input[type="search"]' ).focus();
    } );

    $( '#search-overlay, #search-overlay .button--close' ).on( 'click.karis keyup.karis', function( event ) {
      if ( event.target == this || event.target.className == 'button--close' || event.keyCode == 27 ) {
        $( this ).removeClass( 'search-overlay--open' );
      }
    } );

    // Get the browser's scrollbar size for alignfull elements.
    scrollbarWidth();

    $( window ).on( 'resize.karis', function() {
      clearTimeout( resizeTimer );
      resizeTimer = setTimeout( function() {
        scrollbarWidth();
      }, 300 );
    } );
  } );
} )( jQuery );
