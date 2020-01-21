import Fetcher from '../utils/fetcher';

( function( $ ) {
	WPHB_Admin.dashboard = {
		module: 'dashboard',

		init: function() {
			if ( wphbDashboardStrings )
				this.strings = wphbDashboardStrings;

			$( '.wphb-performance-report-item' ).click( function() {
				const url = $( this ).data( 'performance-url' );
				if ( url ) {
					location.href = url;
				}
			} );

			$( '#dismiss-cf-notice' ).click( function( e ) {
				e.preventDefault();
				Fetcher.notice.dismissCloudflareDash();
				const cloudFlareDashNotice = $( '.cf-dash-notice' );
				cloudFlareDashNotice.slideUp();
				cloudFlareDashNotice.parent().addClass( 'no-background-image' );
			} );

			return this;
		},

		/**
		 * Skip quick setup.
		 */
		skipSetup() {
			Fetcher.dashboard.skipSetup()
				.then( () => {
					location.reload();
				} );
		},

		/**
		 * Run performance test after quick setup.
		 */
		runPerformanceTest() {
			window.SUI.closeModal(); // Hide wphb-quick-setup-modal.
			// Show performance test modal
			window.SUI.openModal( 'run-performance-test-modal', 'wpbody-content', undefined, false );

			// Run performance test
			window.WPHB_Admin.getModule( 'performance' ).performanceTest( this.strings.finishedTestURLsLink );
		},
	};
}( jQuery ) );
