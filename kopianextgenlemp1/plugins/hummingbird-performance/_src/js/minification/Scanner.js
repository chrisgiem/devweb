/* global WPHB_Admin */
import Fetcher from '../utils/fetcher';

const MinificationScanner = ( totalSteps, currentStep ) => {
	totalSteps = parseInt( totalSteps );
	currentStep = parseInt( currentStep );
	let cancelling = false;

	const obj = {
		scan() {
			const remainingSteps = totalSteps - currentStep;
			if ( currentStep !== 0 ) {
				// Scan started on a previous page load
				step( remainingSteps );
			} else {
				Fetcher.minification.startCheck()
					.then( () => {
						step( remainingSteps );
					} );
			}
		},
		cancel() {
			cancelling = true;
			return Fetcher.minification.cancelScan();
		},
		getProgress() {
			if ( cancelling ) {
				return 0;
			}
			const remainingSteps = totalSteps - currentStep;
			return Math.min( Math.round( ( parseInt( ( totalSteps - remainingSteps ) ) * 100 ) / totalSteps ), 99 );
		},
		// Overridable functions
		onFinishStep( progress ) {},
		onFinish( response ) {
			WPHB_Admin.minification.updateProgressBar( 100 );

			if ( 'undefined' !== typeof response.assets_msg ) {
				jQuery( '.wphb-assets-modal' ).find( '#assetsFound' ).html( response.assets_msg );
			}

			window.SUI.closeModal(); // Hide the check-files-modal modal.
			window.SUI.openModal( 'wphb-assets-modal', 'wpbody-content', undefined, false );
		},
	};

	/**
	 * Execute a scan step recursively
	 *
	 * Private to avoid overrdings
	 *
	 * @param {number} remainingSteps
	 */
	const step = function( remainingSteps ) {
		if ( remainingSteps >= 0 ) {
			currentStep = totalSteps - remainingSteps;
			Fetcher.minification.checkStep( currentStep )
				.then( () => {
					remainingSteps = remainingSteps - 1;
					obj.onFinishStep( obj.getProgress() );
					step( remainingSteps );
				} );
		} else {
			Fetcher.minification.finishCheck()
				.then( ( response ) => {
					obj.onFinish( response );
				} );
		}
	};

	return obj;
};

export default MinificationScanner;
