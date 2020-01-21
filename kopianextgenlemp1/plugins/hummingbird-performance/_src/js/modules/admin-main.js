/* global wphb */
/* global SUI */

/**
 * Internal dependencies
 */
import Fetcher from '../utils/fetcher';

( function( $ ) {
	'use strict';

	const WPHB_Admin = {
		modules: [],
		// Common functionality to all screens
		init() {
			// Dismiss notice via an ajax call.
			const notice = document.querySelector( '#wphb-dismissable > .sui-notice-dismiss' );

			if ( notice ) {
				notice.addEventListener( 'click', () => {
					const noticeId = notice.parentElement.getAttribute( 'data-id' );
					Fetcher.notice.dismiss( noticeId );
				} );
			}

			/**
			 * Clear log button clicked.
			 *
			 * @since 1.9.2
			 */
			$( '.wphb-logging-buttons' ).on( 'click', '.wphb-logs-clear', function( e ) {
				e.preventDefault();

				Fetcher.logger.clear( e.target.dataset.module )
					.then( ( response ) => {
						if ( 'undefined' === typeof response.success ) {
							return;
						}

						if ( response.success ) {
							WPHB_Admin.notices.show(
								'wphb-ajax-update-notice',
								true,
								'success',
								response.message
							);
						} else {
							WPHB_Admin.notices.show(
								'wphb-ajax-update-notice',
								true,
								'error',
								response.message
							);
						}
					} );
			} );

			/**
			 * Add recipient button clicked.
			 *
			 * On Performance and Uptime recipient modals.
			 *
			 * @since 1.9.3  Unified two handle both modules.
			 */
			$( '#add-recipient' ).on( 'click', function() {
				let module = '';
				let setting = 'reports';

				// Get the module name from URL.
				if ( window.location.search.includes( 'wphb-performance' ) ) {
					module = 'performance';
				} else if ( window.location.search.includes( 'wphb-uptime' ) ) {
					module = 'uptime';
					if ( window.location.search.includes( 'notifications' ) ) {
						setting = 'notifications';
					}
				}

				const reportingEmail = $( '#reporting-email' );
				const emailField = reportingEmail.closest( '.sui-form-field' );
				const email = reportingEmail.val();
				const name = $( '#reporting-first-name' ).val();

				// Remove errors.
				emailField.removeClass( 'sui-form-field-error' );
				emailField.find( '.sui-error-message' ).remove();

				Fetcher.common.addRecipient( module, setting, email, name )
					.then( ( response ) => {
						const userRow = $( '<div class="sui-recipient"/>' );

						if ( 'notifications' === setting ) {
							userRow.append( '<span class="sui-recipient-status"><i class="sui-icon-clock" aria-hidden="true"></i></span>' );
						}

						userRow.append( '<span class="sui-recipient-name"/>' );
						userRow.find( '.sui-recipient-name' ).append( response.name );

						userRow.append( $( '<span class="sui-recipient-email"/>' ).html( email ) );

						if ( 'notifications' === setting ) {
							userRow.append( $( '<button/>' ).attr( {
								class: 'sui-button-icon wphb-resend-recipient sui-tooltip',
								type: 'button',
								'data-tooltip': wphb.strings.resendEmail,
							} ).html( '<i class="sui-icon-send" aria-hidden="true"></i>' ) );
						}

						userRow.append( $( '<button/>' ).attr( {
							class: 'sui-button-icon wphb-remove-recipient',
							type: 'button',
						} ).html( '<i class="sui-icon-trash" aria-hidden="true"></i>' ) );

						$( '<input>' ).attr( {
							type: 'hidden',
							id: 'report-recipient',
							name: 'report-recipients[]',
							value: JSON.stringify( { email: response.email, name: response.name } ),
						} ).appendTo( userRow );

						$( '.sui-recipients' ).append( userRow );
						$( '#reporting-email' ).val( '' );
						$( '#reporting-first-name' ).val( '' );

						// Hide no recipients notification.
						$( '.wphb-no-recipients' ).slideUp();
						window.SUI.closeModal();

						// Hide the last notice.
						$( '#wphb-pending-sub-notice' ).hide();
						// Show confirm recipients notice.
						$( '#wphb-confirm-sub-notice' ).show();

						// Show notice to save settings.
						WPHB_Admin.notices.show(
							'wphb-ajax-update-notice',
							false,
							'info',
							name + wphb.strings.successRecipientAdded
						);
					} )
					.catch( ( error ) => {
						emailField.addClass( 'sui-form-field-error' );
						emailField.append( '<span class="sui-error-message"/>' );
						emailField.find( '.sui-error-message' ).append( error.message );
					} );
			} );

			const body = $( 'body' );

			/**
			 * Save report settings clicked (performance reports, uptime
			 * reports and uptime notifications).
			 */
			body.on( 'submit', '.wphb-report-settings', function( e ) {
				e.preventDefault();

				$( '#wphb-confirm-sub-notice' ).slideUp();

				$( this ).find( '.button' ).attr( 'disabled', 'disabled' );

				Fetcher.common
					.saveReportsSettings( this.dataset.module, $( this ).serialize() )
					.then( ( response ) => {
						if ( 'undefined' !== typeof response && response.success ) {
							if ( response.enabled ) {
								WPHB_Admin.notices.show(
									'wphb-ajax-update-notice',
									true,
									'success',
									wphb.strings.confirmRecipient
								);
							} else if ( '' !== response.notice ) {
								WPHB_Admin.notices.show(
									'wphb-ajax-update-notice',
									true,
									'success',
									response.notice
								);
							} else {
								window.location.search += '&updated=true';
							}
						} else {
							WPHB_Admin.notices.show(
								'wphb-ajax-update-notice',
								true,
								'error',
								wphb.strings.errorSettingsUpdate
							);
						}
					} );
			} );

			/**
			 * Remove recipient button clicked.
			 */
			body.on( 'click', '.wphb-remove-recipient', function() {
				$( this ).closest( '.sui-recipient' ).remove();

				const id = $( this ).attr( 'data-id' );
				const row = 'input[id="report-recipient"][value=' + id + ']';

				$( '.wphb-report-settings' ).find( row ).remove();

				if ( 0 === $( '.sui-recipient' ).length ) {
					$( '#wphb-pending-sub-notice' ).slideUp();
					$( '.wphb-no-recipients' ).slideDown();
				}
			} );

			/**
			 * Handle the show/hiding of the report schedule.
			 */
			$( '#chk1' ).on( 'click', function() {
				$( '.schedule-box' ).toggleClass( 'sui-hidden' );
			} );

			/**
			 * Schedule show/hide day of week.
			 */
			$( 'select[name="report-frequency"]' ).change( function() {
				const freq = $( this ).val();

				if ( '1' === freq ) {
					$( this ).closest( '.schedule-box' ).find( 'div.days-container' ).hide();
				} else {
					$( this ).closest( '.schedule-box' ).find( 'div.days-container' ).show();

					if ( '7' === freq ) {
						$( this ).closest( '.schedule-box' ).find( '[data-type="week"]' ).show();
						$( this ).closest( '.schedule-box' ).find( '[data-type="month"]' ).hide();
					} else {
						$( this ).closest( '.schedule-box' ).find( '[data-type="week"]' ).hide();
						$( this ).closest( '.schedule-box' ).find( '[data-type="month"]' ).show();
					}
				}
			} ).change();
		},

		initModule( module ) {
			if ( this.hasOwnProperty( module ) ) {
				this.modules[ module ] = this[ module ].init();
				return this.modules[ module ];
			}

			return {};
		},

		getModule( module ) {
			if ( typeof this.modules[ module ] !== 'undefined' ) {
				return this.modules[ module ];
			}
			return this.initModule( module );
		},
	};

	/**
	 * Admin notices.
	 */
	WPHB_Admin.notices = {
		init() {},
		/**
		 * Show notice.
		 *
		 * @since 1.8
		 *
		 * @param {string}  id       ID of notice element.
		 * @param {boolean} top      Scroll to top.
		 * @param {string}  type     Error or success.
		 * @param {string}  message  Message to display.
		 *
		 * @var {Array} wphb
		 */
		show( id, top = false, type = '', message = wphb.strings.successUpdate ) {
			const notice = $( '#' + id );

			if ( top ) {
				window.scrollTo( 0, 0 );
			}

			if ( '' !== type ) {
				// Remove set classes if doing multiple calls per page load.
				notice.removeClass( 'sui-notice-error' );
				notice.removeClass( 'sui-notice-success' );
				notice.removeClass( 'sui-notice-info' );
				notice.addClass( 'sui-notice-' + type );
			}

			notice.find( 'p' ).html( message );

			notice.slideDown();
			setTimeout( function() {
				notice.slideUp();
			}, 5000 );
		},
	};

	window.WPHB_Admin = WPHB_Admin;
}( jQuery ) );
