/* global WPHB_Admin */
/* global wphb */

/**
 * Internal dependencies
 */
import Fetcher from '../utils/fetcher';

( function( $ ) {
	'use strict';

	WPHB_Admin.advanced = {
		module: 'advanced',

		init() {
			const self = this,
				systemInfoDropdown = $( '#wphb-system-info-dropdown' ),
				hash = window.location.hash;

			/**
			 * Process form submit for advanced tools forms
			 */
			$( '#wphb-db-delete-all, .wphb-db-row-delete' ).on( 'click', function( e ) {
				e.preventDefault();
				self.showModal( e.target.dataset.entries, e.target.dataset.type );
			} );

			/**
			 * Process form submit for advanced tools forms
			 */
			$( 'form[id="advanced-db-settings"], form[id="advanced-general-settings"]' ).on( 'submit', function( e ) {
				e.preventDefault();

				const spinner = $( this ).parent().find( '.sui-icon-loader' );
				spinner.removeClass( 'sui-hidden' );

				Fetcher.advanced.saveSettings( $( this ).serialize(), e.target.id )
					.then( ( response ) => {
						spinner.addClass( 'sui-hidden' );
						if ( 'undefined' !== typeof response && response.success ) {
							// Schedule cleanup.
							if ( 'advanced-db-settings' === e.target.id ) {
								Fetcher.advanced.scheduleCleanup();
							}
							WPHB_Admin.notices.show( 'wphb-notice-advanced-tools', true, 'success' );
						} else {
							WPHB_Admin.notices.show( 'wphb-notice-advanced-tools', true, 'error', wphb.strings.errorSettingsUpdate );
						}
					} );
			} );

			/**
			 * Show/hide schedule for database cleanup.
			 */
			$( 'input[id="scheduled_cleanup"]' ).on( 'change', function() {
				$( '.schedule-box' ).toggle();
			} );

			/**
			 * Show initial system information table.
			 */
			$( '#wphb-system-info-php' ).removeClass( 'sui-hidden' );
			if ( hash ) {
				const system = hash.replace( '#', '' );
				$( '.wphb-sys-info-table' ).addClass( 'sui-hidden' );
				$( '#wphb-system-info-' + system ).removeClass( 'sui-hidden' );
				systemInfoDropdown.val( system ).trigger( 'sui:change' );
			}

			/**
			 * Show/hide system information tables on dropdown change.
			 */
			systemInfoDropdown.change( function( e ) {
				e.preventDefault();
				$( '.wphb-sys-info-table' ).addClass( 'sui-hidden' );
				$( '#wphb-system-info-' + $( this ).val() ).removeClass( 'sui-hidden' );
				location.hash = $( this ).val();
			} );

			/**
			 * Paste default values to url strings option.
			 *
			 * @since 1.9.0
			 */
			$( '#wphb-adv-paste-value' ).on( 'click', function( e ) {
				e.preventDefault();
				const urlStrings = $( 'textarea[name="url_strings"]' );
				if ( '' === urlStrings.val() ) {
					urlStrings.val( urlStrings.attr( 'placeholder' ) );
				} else {
					urlStrings.val( urlStrings.val() + '\n' + urlStrings.attr( 'placeholder' ) );
				}
			} );

			/**
			 * Toggle woo cart fragments settings.
			 *
			 * @since 2.2.0
			 */
			const fragmentsToggle = document.getElementById( 'cart_fragments' );
			if ( fragmentsToggle ) {
				fragmentsToggle.addEventListener( 'change', function( e ) {
					e.preventDefault();
					$( '#cart_fragments_desc' ).toggle();
				} );
			}

			return this;
		},

		/**
		 * Show the modal window asking if a user is sure he wants to delete the db records.
		 *
		 * @param {string} items Number of records to delete.
		 * @param {string} type  Data type to delete from db (See data-type element for each row in the code).
		 */
		showModal( items, type ) {
			const dialog = wphb.strings.db_delete + ' ' + items + ' ' + wphb.strings.db_entries + '? ' + wphb.strings.db_backup;
			const modal = $( '.wphb-database-cleanup-modal' );

			modal.find( 'p' ).html( dialog );
			modal.find( '.wphb-delete-db-row' ).attr( 'data-type', type );

			window.SUI.openModal( 'wphb-database-cleanup-modal', 'wpbody-content', undefined, false );
		},

		/**
		 * Process database cleanup (both individual and all entries).
		 *
		 * @param {string} type Data type to delete from db (See data-type element for each row in the code).
		 */
		confirmDelete( type ) {
			window.SUI.closeModal();

			let row;
			const footer = $( '.box-advanced-db .sui-box-footer' );

			if ( 'all' === type ) {
				row = footer;
			} else {
				row = $( '.box-advanced-db .wphb-border-frame' ).find( 'div[data-type=' + type + ']' );
			}

			const spinner = row.find( '.sui-icon-loader' );
			const button = row.find( '.wphb-db-row-delete' );

			spinner.removeClass( 'sui-hidden' );
			button.addClass( 'sui-hidden' );

			Fetcher.advanced.deleteSelectedData( type )
				.then( ( response ) => {
					WPHB_Admin.notices.show( 'wphb-notice-advanced-tools', false, 'success', response.message );
					spinner.addClass( 'sui-hidden' );
					button.removeClass( 'sui-hidden' );

					for ( const prop in response.left ) {
						if ( 'total' === prop ) {
							const leftString = wphb.strings.deleteAll + ' (' + response.left[ prop ] + ')';
							footer.find( '.wphb-db-delete-all' ).html( leftString );
							footer.find( '#wphb-db-delete-all' ).attr( 'data-entries', response.left[ prop ] );
						} else {
							const itemRow = $( '.box-advanced-db div[data-type=' + prop + ']' );
							itemRow.find( '.wphb-db-items' ).html( response.left[ prop ] );
							itemRow.find( '.wphb-db-row-delete' ).attr( 'data-entries', response.left[ prop ] );
						}
					}
				} )
				.catch( ( error ) => {
					WPHB_Admin.notices.show( 'wphb-notice-advanced-tools', false, 'error', error );
					spinner.addClass( 'sui-hidden' );
				} );
		},
	};
}( jQuery ) );
