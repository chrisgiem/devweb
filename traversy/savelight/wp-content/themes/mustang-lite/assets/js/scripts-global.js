/**
 * Theme Frontend Scripts
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.2
 *
 * CONTENT:
 * - 10) Basics
 * - 20) Special slider
 * - 30) Header, navigation and topbar
 * - 40) Masonry footer
 * - 50) Masonry gallery
 * - 60) YouTube embed fix
 * - 70) Image lightbox
 * - 80) Tabbed widget
 * - 90) Appear animations
 * - 100) Row video background
 * - 110) Columns tweaks
 * - 120) WooCommerce floating cart
 */





jQuery( function() {



	/**
	 * 10) Basics
	 */

		/**
		 * Variables setup
		 */

			wmMasonryLayoutCompensation = 1; /* Masonry testimonials layout compensation */



		/**
		 * Tell CSS that JS is enabled...
		 */

			jQuery( '.no-js' ).removeClass( 'no-js' );



		/**
		 * Posts filtering setup (also a fix for animation glitches)
		 */

			if ( jQuery().isotope ) {

				var $filterThis = jQuery( '.filter-this' );

				$filterThis
					.isotope( { transitionDuration : 0 } );

				jQuery( window )
					.on( 'resize orientationchange', function( e ) {

						setInterval( function() {

							$filterThis
								.isotope( 'layout' );

						}, 100 );

					} );

			} // /isotope



		/**
		 * IE8 fixes
		 */

			jQuery( '.lie8 img[height]' ).removeAttr( 'height' );



		/**
		 * Top of page button
		 */

			if ( jQuery( '.top-of-page' ).length ) {

				jQuery( '.top-of-page' ).hide();

				/**
				 * Commenting out the scrolling as it is being
				 * taken of in "One page navigation" section.
				 */
				/*
				if ( 1024 < document.body.clientWidth ) {
					jQuery( '.top-of-page, a[href="#top"]' ).on( 'click', function( e ) {
							e.preventDefault();
							jQuery( 'html, body' ).animate( { scrollTop: 0 }, 400 );
						} );
				}
				*/

				jQuery( window ).scroll( function() {

					var scrollPosition = jQuery( window ).scrollTop();

					if ( 200 < scrollPosition ) {
						jQuery( '.top-of-page' ).fadeIn();
					} else {
						jQuery( '.top-of-page' ).fadeOut();
					}

				} );

			}



		/**
		 * High DPI logo
		 */

			function wmIsHighDPI() {
				var mediaQuery = '(-webkit-min-device-pixel-ratio: 1.5),(min--moz-device-pixel-ratio: 1.5),(-moz-min-device-pixel-ratio: 1.5),(-o-min-device-pixel-ratio: 3/2),(min-device-pixel-ratio: 1.5),(min-resolution: 144dpi),(min-resolution: 1.5dppx)';

				return ( window.devicePixelRatio > 1 || ( window.matchMedia && window.matchMedia( mediaQuery ).matches ) );
			} // /wmIsHighDPI

			var $logo = jQuery( '.logo img' );

			if ( wmIsHighDPI() && $logo.data( 'hidpi' ) ) {
				$logo.attr( 'src', $logo.data( 'hidpi' ) );
			}



		/**
		 * Remove empty paragraphs from Contact Form 7 plugin output
		 */

			jQuery( '.wpcf7 p, .wpcf7 span' ).each( function() {
				var $this = jQuery( this );

				if ( '' == jQuery.trim( $this.html() ) ) {
					$this.remove();
				}
			} );



	/**
	 * 20) Special slider
	 */

		if ( jQuery( 'body' ).hasClass( 'slider-enabled') ) {

			var wmSlider       = jQuery( '#slider' ),
			    wmHeaderOffset = wmSlider.outerHeight();

			wmSlider.imagesLoaded( function() {

				var wpAdminBar     = jQuery( '#wpadminbar' ),
				    wpAdminBarPos  = wpAdminBar.offset(), //Compensate for when using an LCT Admin Bar on Bottom plugin
				    wmSliderTop    = ( wpAdminBar.length && ! wpAdminBarPos.top ) ? ( wpAdminBar.outerHeight() ) : ( 0 ),
				    wmSliderLeft   = wmSlider.offset().left;

				wmHeaderOffset = wmSlider.outerHeight();

				jQuery( window ).on( 'resize orientationchange', function( e ) {
					wmHeaderOffset = wmSlider.outerHeight();
					if ( jQuery( 'body' ).hasClass( 'boxed' ) ) {
						wmSliderLeft = jQuery( '.website-container' ).offset().left;
						wmSlider.css( { left : wmSliderLeft } );
					}
				} );

				jQuery( '.website-container' ).css( 'padding-top', wmHeaderOffset );

				wmSlider.css( { position : 'fixed', left : wmSliderLeft, top : wmSliderTop, zIndex : 0 } );

				jQuery( window ).on( 'scroll', function( e ) {
					var wmSliderOpacityOffset = wmHeaderOffset / 3, //Number of pixels from top of the page, where the slider should start fading out
					    wmSliderOpacitySlow   = 2, //Slowdown coeficient
					    wmSliderOpacity       = 100 - ( ( jQuery( window ).scrollTop() - wmSliderOpacityOffset ) * 100 / wmHeaderOffset / wmSliderOpacitySlow );

					if ( 0 > wmSliderOpacity ) {
						wmSliderOpacity = 0;
					} else if ( 100 < wmSliderOpacity ) {
						wmSliderOpacity = 100;
					}

					jQuery( '.slider-fade-out #slider > .slider-content' ).css( 'opacity', wmSliderOpacity / 100 );

					wmSlider.css( 'top', ( wmSliderTop - ( jQuery( window ).scrollTop() * .5 ) ) + 'px' );

				} );

			} );

		}



	/**
	 * 30) Header, navigation and topbar
	 */

		/**
		 * Sticky header
		 *
		 * @version  1.1
		 */

			var wmHeader = jQuery( '#header' );

			if ( jQuery( 'body' ).hasClass( 'sticky-header' ) && wmHeader.length ) {

				var wmHeaderPosition      = wmHeader.position(),
				    wmTopbarHeight        = jQuery( '#topbar' ).outerHeight( true ),
				    wmHeaderHeightInitial = wmHeader.outerHeight();

				if ( ! jQuery( 'body' ).hasClass( 'sticky-header-global' ) ) {
					wmHeader.wrap( '<div class="header-wrapper">' );
				}

				function wmStickyHeader() {
					var wmScrolled         = jQuery( window ).scrollTop(),
					    wmHeaderTop        = ( typeof wmHeaderOffset !== 'undefined' ) ? ( wmHeaderOffset ) : ( wmHeaderPosition.top ),
					    wmContainerPadding = 0;

					if ( ( wmHeaderTop + wmHeader.outerHeight() ) < wmScrolled ) {
						wmContainerPadding = wmHeaderTop + wmHeaderHeightInitial - wmTopbarHeight;
						wmHeader.parent().addClass( 'is-sticky' );
					} else {
						wmContainerPadding = ( 0 > wmHeaderTop - wmTopbarHeight ) ? ( 0 ) : ( wmHeaderTop - wmTopbarHeight );
						wmHeader.parent().removeClass( 'is-sticky' );
					}

					jQuery( '.website-container' ).css( 'padding-top', Math.round( wmContainerPadding ) );
				} // /wmStickyHeader

				jQuery( window ).on( 'scroll resize orientationchange', function( e ) {
					wmStickyHeader();
				} );

			}



		/**
		 * Search form
		 */

			jQuery( '.form-search input[type="text"], .bbp-search-form input[type="text"]' ).attr( 'x-webkit-speech', 'x-webkit-speech' );

			jQuery( '#menu-search' ).on( 'click', 'a', function( e ) {

				var wmSearchForm = jQuery( this ).attr( 'href' );

				jQuery( wmSearchForm ).show();
				jQuery( wmSearchForm + ' input[type="text"]' ).focus();

				e.preventDefault();

			} );

			jQuery( '.form-close' ).on( 'click', function( e ) {

				jQuery( this ).parent().hide();

				e.preventDefault();

			} );



		/**
		 * One page navigation
		 *
		 * Actually, this applies smooth scroll for every anchor link.
		 */

				var wmHeaderHeight = ( jQuery( 'body' ).hasClass( 'sticky-header' ) ) ? ( wmHeader.outerHeight() ) : ( 0 ),
				    wmLastSection  = wmCurrentSection = wmSectionId = '',
				    wmSections     = jQuery( '.wm-row[id]' );

				//Offset
					jQuery( window ).on( 'resize orientationchange', function( e ) {
						wmHeaderHeight = wmHeader.outerHeight();
					} );

				//Clicking the navigation
					jQuery( 'body' ).on( 'click', 'a[href^="#"]', function( e ) {

							// Requirements check

								// Do nothing when editing page with Beaver Builder

									if ( jQuery( 'html' ).hasClass( 'fl-builder-edit' ) ) {
										e.preventDefault();
										return;
									}


							// Helper variables

								var $this         = jQuery( this ),
								    $anchor       = $this.not( '.mobile-nav' ).attr( 'href' ),
								    $scrollObject = jQuery( 'html, body' ),
								    wmScrollSpeed = ( 1024 >= document.body.clientWidth ) ? ( 0 ) : ( 600 );


							// Processing

								if (
										'#' !== $this.attr( 'href' )
										&& ! $this.data( 'tab' )
										&& ! $this.data( 'filter' )
										&& ! $this.hasClass( 'no-scroll-link' )
									) {

									e.preventDefault();

									if (
											$this.hasClass( 'inner' )
											&& ! jQuery( e.target ).is( '.expander' )
											&& jQuery( 'body' ).hasClass( 'responsive-design' )
										) {
										wmToggleMobileNavigation();
									}

									if ( $anchor && '#' !== $anchor ) {
										$scrollObject.stop().animate( {
												scrollTop : jQuery( $anchor ).offset().top - wmHeaderHeight + 2 + 'px'
											}, wmScrollSpeed );
									}

								}

						} );

			if ( jQuery( 'body' ).hasClass( 'page' ) ) {

				//Scrolling the window
					jQuery( window ).scroll( function() {
						var wmFromTop = jQuery( this ).scrollTop() + wmHeaderHeight;

						wmCurrentSection = wmSections.map( function() {
								var $this = jQuery( this );

								if ( $this.offset().top < wmFromTop ) {
									return $this;
								}
							} );
						wmCurrentSection = wmCurrentSection[ wmCurrentSection.length - 1 ];

						wmSectionId = ( wmCurrentSection && wmCurrentSection.length ) ? ( wmCurrentSection[0].id ) : ( '' );

						if ( wmLastSection !== wmSectionId ) {
							wmLastSection = wmSectionId;
							jQuery( '#nav-main li' ).removeClass( 'active-menu-item' );
							jQuery( '#nav-main li a[href="#' + wmSectionId + '"]' ).parent().addClass( 'active-menu-item' );
						}
					} );

			}



		/**
		 * Mobile navigation
		 */

			if ( jQuery( 'body' ).hasClass( 'responsive-design' ) ) {

				//Add closing menu button directly into the menu
					jQuery( '<a href="#nav-main" class="mobile-nav"></a>' ).insertBefore( '#nav-main > .menu' );

				/**
				 * Toggle mobile navigation
				 */
				function wmToggleMobileNavigation () {

					var wmMobileNav      = jQuery( '#nav-main' ),
					    wmRTLPosition    = ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) ? ( 'left' ) : ( 'right' ),
					    wmMobileNavMove  = ( '-500px' === wmMobileNav.css( wmRTLPosition ) ) ? ( 0 ) : ( -500 ),
					    wmHeaderZindex   = jQuery( '.header-wrapper' ).css( 'z-index' );

					if ( 0 === wmMobileNavMove ) {
						jQuery( '.header-wrapper' ).css( { zIndex : 999999 } );
					} else {
						jQuery( '.header-wrapper' ).css( { zIndex : wmHeaderZindex } );
					}

					if ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) {
						wmMobileNav.stop().animate( { left : wmMobileNavMove }, 200 );
					} else {
						wmMobileNav.stop().animate( { right : wmMobileNavMove }, 200 );
					}

				} // /wmToggleMobileNavigation

				//Mobile navigation toggle button action
					wmHeader.on( 'click', '.mobile-nav', function( e ) {

						e.preventDefault();

						wmToggleMobileNavigation();

					} );

				//Submenu expanders
					jQuery( '<span class="expander"></span>' )
						.appendTo( '#nav-main .menu-item-has-children > .inner' );

					jQuery( '#nav-main' )
						.on( 'click', '.expander', function( e ) {

							e.preventDefault();

							var $this      = jQuery( this ),
							    wmIsMega   = $this.closest( '.menu-item' ).hasClass( 'megamenu' ),
							    wmNotHover = ! $this.is( ':hover' );

							if ( 1024 >= document.body.clientWidth ) {
								wmNotHover = true;
							}

							if ( wmNotHover ) {

								if ( wmIsMega ) {
									$this.closest( '.menu-item' ).find( '> .sub-menu, .empty-menu-item > .sub-menu' ).slideToggle( 200 );
								} else {
									$this.parent( '.inner' ).next( '.sub-menu' ).slideToggle( 200 );
								}

							}

						} );

			} // /responsive-design



		/**
		 * Topbar
		 */

			var wmTopbarExtra = jQuery( '#topbar-extra' );

			wmTopbarExtra.on( 'click', '.topbar-extra-switch', function( e ) {

				wmTopbarExtra.toggleClass( 'open' ).find( '.wrap-inner' ).slideToggle();

				e.preventDefault();

			} );



	/**
	 * 40) Masonry footer
	 */

		if ( jQuery().masonry && 1 < jQuery( '.footer-widgets.masonry-enabled' ).data( 'columns' ) ) {

			var $wmFooterWidgets = jQuery( '#footer .footer-widgets-container' );

			$wmFooterWidgets.addClass( 'masonry-this with-margin' ).find( '> .widget' ).addClass( 'wm-column with-margin width-1-' + jQuery( '.footer-widgets.masonry-enabled' ).data( 'columns' ) );

			$wmFooterWidgets.imagesLoaded( function() {

				$wmFooterWidgets.masonry( {
						itemSelector : '.widget',
						isRTL        : ( 'rtl' == jQuery( 'html' ).attr( 'dir' ) ), // Masonry 2 compatibility (pre WP v3.9)
						isOriginLeft : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) // Masonry 3+
					} );

			} );

		} // /masonry



	/**
	 * 50) Masonry gallery
	 */

		if ( jQuery().masonry ) {

			var $wmGallery = jQuery( '.gallery.masonry-container' );

			$wmGallery.imagesLoaded( function() {

				$wmGallery.masonry( {
						itemSelector : 'figure',
						isRTL        : ( 'rtl' == jQuery( 'html' ).attr( 'dir' ) ), // Masonry 2 compatibility (pre WP v3.9)
						isOriginLeft : ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) ) // Masonry 3+
					} );

			} );

		} // /masonry



	/**
	 * 60) YouTube embed fix
	 */

		jQuery( 'iframe[src*="youtube.com"]' ).each( function( item ) {

			var srcAtt = jQuery( this ).attr( 'src' );

			if ( -1 == srcAtt.indexOf( '?' ) ) {
				srcAtt += '?wmode=transparent';
			} else {
				srcAtt += '&amp;wmode=transparent';
			}

			jQuery( this ).attr( 'src', srcAtt );

		} );



	/**
	 * 70) Image lightbox
	 */

		if ( jQuery().prettyPhoto && jQuery( 'body' ).hasClass( 'theme-lightbox-enabled' ) ) {

			var wmThumbsLinks        = 'a[href*=".gif"], a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".mov"], a[href*=".swf"], .lightbox, a.modal, a[data-modal], a[data-target="modal"], a[rel^="prettyPhoto"], a[rel^="lightbox"]',
			    wmPrettyPhotoOptions = {
			    		deeplinking        : false,
							overlay_gallery    : false,
							show_title         : false,
							slideshow          : 6000,
							social_tools       : false,
							theme              : 'pp_webman',
							opacity            : '0.8',
							default_width      : 800,
							default_height     : 450,
							horizontal_padding : 0,
							ie6_fallback       : false,
							markup             : '<div class ="pp_pic_holder"><div class="ppt">&nbsp;</div><div class="pp_content_container"><div class="pp_content"><div class="pp_loaderIcon"></div><div class="pp_fade"><a class="pp_close" href="#">Close</a><a href="#" class="pp_expand" title="Expand the image">Expand</a><div class="pp_nav"><a href="#" class="pp_arrow_previous">Previous</a><p class="currentTextHolder">0/0</p><a href="#" class="pp_arrow_next">Next</a></div><div class="pp_hoverContainer"><a class="pp_next" href="#">next</a><a class="pp_previous" href="#">previous</a></div><div id="pp_full_res"></div><div class="pp_details"><p class="pp_description"></p></div></div></div></div></div><div class="pp_overlay"></div>'
						};

			//WooCommerce support
				// jQuery( '.product > .images a' ).attr( 'rel', 'prettyPhoto[product-gallery]' );

			jQuery( '.gallery, .tiled-gallery, .wm-slideshow' ).each( function() {
				var $this           = jQuery( this ),
				    wmGalleryImages = $this.find( wmThumbsLinks ),
				    wmGalleryID     = 'gallery' + Math.floor( ( Math.random() * 100 ) + 1 );

				wmGalleryImages.attr( {
						rel   : 'prettyPhoto[' + wmGalleryID + ']',
						title : function() {
								return jQuery( this ).find( 'img' ).attr( 'title' );
							}
					} );
			} );

			jQuery( wmThumbsLinks ).not( '.no-lightbox' ).addClass( 'cursor-zoom-in' ).prettyPhoto( wmPrettyPhotoOptions );
			jQuery( 'a[rel^="prettyPhoto"]' ).prettyPhoto( wmPrettyPhotoOptions );

		} // /prettyPhoto



	/**
	 * 80) Tabbed widget
	 *
	 * IMPORTANT: Supports only one instance of the widget on a page!
	 */

		jQuery( '<ul class="wm-tab-links"></ul>' ).prependTo( '.wm-tabbed-widgets.wm-tabs' );

		jQuery( '.wm-tabbed-widgets.wm-tabs > .wm-item' ).each( function() {
				var $this            = jQuery( this ),
				    wmWidgetTabId    = $this.attr( 'id' ),
				    wmWidgetTabTitle = $this.find( '.tab-title' ).html();

				if ( ! wmWidgetTabTitle ) {
					wmWidgetTabTitle = '-';
				}

				jQuery( '<li><a href="#' + wmWidgetTabId + '" data-tab="#' + wmWidgetTabId + '">' + wmWidgetTabTitle + '</a></li>' ).appendTo( '.wm-tabbed-widgets > .wm-tab-links' );
			} );



	/**
	 * 90) Appear animations
	 */

		//Viewport animations
			if (
					jQuery().appear
					&& jQuery( '.wm-progress, [class*="animation-"]' ).length
				) {

				/**
				 * Set initial CSS
				 */

					jQuery( '.wm-progress.animated .wm-progress-bar' ).css( 'width', 0 );



				/**
				 * In viewport
				 */

					jQuery( '.wm-progress.animated:in-viewport' ).each( function() {
							var $this = jQuery( this );

							$this.find( '.wm-progress-bar' ).animate( { 'width' : $this.data( 'progress' ) + '%' }, 2000 );
						} );

					jQuery( '[class*="animation-"]:in-viewport' ).each( function() {
							var $this        = jQuery( this ),
							    wmAllClasses = $this.attr( 'class' );

							/**
							 * Animate.css support
							 *
							 * @link  http://daneden.github.io/animate.css/
							 *
							 * Set the class of "animation-ANIMATION_TYPE" on the element.
							 * This JavaScript will change the class to animation when element
							 * is in vieport.
							 */
							$this.attr( 'class', wmAllClasses.replace( 'animation-', 'animated ' ) );
						} );



				/**
				 * Progress bar
				 */

					jQuery( '.wm-progress.animated' ).appear().each( function() {
							var $this = jQuery( this );

							$this.on( 'appear', function( e ) {
								$this.find( '.wm-progress-bar' ).animate( { 'width' : $this.data( 'progress' ) + '%' }, 1000 );
							} );
						} );



				/**
				 * CSS animation classes
				 */

					jQuery( '[class*="animation-"]' ).appear().each( function() {
							var $this        = jQuery( this ),
							    wmAllClasses = $this.attr( 'class' );

							$this.on( 'appear', function( e ) {
								/**
								 * Animate.css support
								 *
								 * @link  http://daneden.github.io/animate.css/
								 *
								 * Set the class of "animation-ANIMATION_TYPE" on the element.
								 * This JavaScript will change the class to animation when element
								 * is in vieport.
								 */
								$this.attr( 'class', wmAllClasses.replace( 'animation-', 'animated ' ) );
							} );
					} );

			} // /appear



	/**
	 * 100) Row video background
	 */

		if ( jQuery( '.wm-section > .wm-row-video' ).length ) {

			var wmVideoBg = jQuery( '.wm-section > .wm-row-video .media-container' );

			function wmVideoBgStretch () {
				wmVideoBg.find( '.wp-video' ).css( {
						width  : wmVideoBg.outerWidth(),
						height : wmVideoBg.outerHeight()
					} );

				wmVideoBg.each( function() {
					var $this           = jQuery( this ),
					    wmSectionWidth  = $this.closest( '.wm-section' ).outerWidth(),
					    wmSectionHeight = $this.closest( '.wm-section' ).outerHeight();

					if ( wmSectionHeight > $this.outerHeight() ) {
						$this.find( '> .wp-video' ).css( {
								width  : wmSectionHeight / 9 * 16,
								height : wmSectionHeight
							} );
						$this.css( {
								width  : wmSectionHeight / 9 * 16,
								height : wmSectionHeight
							} ).closest( '.wm-video' ).css( {
								left   : 0 - ( ( wmSectionHeight / 9 * 16 ) - wmSectionWidth ) / 2,
								top    : 0,
								margin : 0
							} );
					}
				} );
			} // /wmVideoBgStretch

			wmVideoBgStretch();

			jQuery( window ).on( 'resize orientationchange', function( e ) {
				wmVideoBgStretch();
			} );

		}



	/**
	 * 110) Columns tweaks
	 */

		//Uniform column height

			var wmColumnHeightContainers = jQuery( '.wm-section, .vc_row_inner-shortcode, .match-column-height .wm-row' );

			wmColumnHeightContainers.imagesLoaded( function() {

				function wmSetColumnHeight () {

					wmColumnHeightContainers.children( '.wm-column' ).css( { height : 'auto' } );

					if ( 800 < document.body.clientWidth ) {

						wmColumnHeightContainers.each( function() {
							var $this = jQuery( this );

							$this.children( '.wm-column' ).not( '.width-1-1' ).css( { height : $this.outerHeight() } );
						} );

					}

				} // /wmSetColumnHeight

				wmSetColumnHeight();

				jQuery( window ).on( 'resize orientationchange', function( e ) {
					wmSetColumnHeight();
				} );

			} );

		//Extend column background
			if ( jQuery( 'body' ).hasClass( 'page-layout-sections' ) ) {
				jQuery( '.extend-bg-before, .extend-background-before, .extend-bg-after, .extend-background-after' ).closest( '.wm-section' ).addClass( 'overflow-hidden' );
			}



	/**
	 * 120) WooCommerce floating cart
	 */

		if ( jQuery( '#floating-cart-switch' ).length ) {

			/*
			jQuery( '#floating-cart-switch' ).on( 'click', function( e ) {
					e.preventDefault();
				} );
			*/

			jQuery( 'body' ).bind( 'added_to_cart', function() {
					jQuery( '#floating-cart' ).css( 'z-index', 99999 );

					jQuery( '#floating-cart-switch' ).animate( { fontSize : '1.28em', marginTop : '1em' }, 400, function() {
							jQuery( this ).animate( { fontSize : '1em', marginTop : 0 }, 400 );
							jQuery( '#floating-cart' ).css( 'z-index', 999 );
						} );
				} );

		}



} );
