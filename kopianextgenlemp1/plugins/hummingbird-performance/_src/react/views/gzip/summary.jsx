/**
 * External dependencies
 */
import React from 'react';
import classNames from 'classnames';

/**
 * WordPress dependencies
 */
import { __, sprintf } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Action from '../../components/sui-box/action';
import BorderFrame from '../../components/border-frame';
import Box from '../../components/sui-box';
import Button from '../../components/sui-button';
import Notice from '../../components/sui-notice';
import Tag from '../../components/sui-tag';
import Tooltip from '../../components/sui-tooltip';

/**
 * GzipSummary component.
 *
 * @since 2.1.1
 */
class GzipSummary extends React.Component {
	/**
	 * Generate the status tag for Gzip compression, based on the number of active
	 * elements (HTML, JavaScrip, CSS).
	 *
	 * @param {Object}  status      Gzip compression status object.
	 * @param {boolean} successTag  On success show a tick tag.
	 * @return {*} Gzip compression status.
	 */
	static getStatus( status, successTag = false ) {
		let gzipCompression;

		if ( successTag ) {
			gzipCompression = <Tag />;
		}

		const failedGzip = GzipSummary.getFailedItems( status );

		if ( 0 < failedGzip.length ) {
			gzipCompression = <Tag value={ failedGzip.length } type="warning" />;
		}

		return gzipCompression;
	}

	/**
	 * Get an array of failed items.
	 *
	 * @param {Object} items  Gzip compression statues.
	 * @return {Array} Array of items.
	 */
	static getFailedItems( items ) {
		return Object.values( items ).filter( ( item ) => {
			return ! item || 'privacy' === item;
		} );
	}

	/**
	 * Check problems that might be related to bad configuration.
	 *
	 * @return {*}  Notice.
	 */
	checkExternalProblems() {
		if ( this.props.loading ) {
			return;
		}

		if ( this.props.data.htaccess_writable && ! this.props.data.htaccess_written ) {
			return;
		}

		// There must be another plugin/server config that is setting its own gzip stuff.
		if ( 3 !== Object.keys( this.props.status ).length || 0 < GzipSummary.getFailedItems( this.props.status ).length ) {
			const message = (
				<React.Fragment>
					<p>{ __( 'Gzip is not working properly:', 'wphb' ) }</p>
					<p>
						{ __( 'Your server may not have the "deflate" module enabled (mod_deflate for Apache, ngx_http_gzip_module for NGINX). Contact your host. If deflate is enabled, ask why all .htaccess or nginx.conf compression rules are not being applied. If re-checking and restarting does not resolve, please check with your host or', 'wphb' ) }&nbsp;
						<Button text={ __( 'open a support ticket.', 'wphb' ) } url={ this.props.link.support.forum } target="blank" />
					</p>
				</React.Fragment>
			);

			return <Notice message={ message } classes="sui-notice-error" />;
		}
	}

	/**
	 * Get content for the component.
	 *
	 * @return {Object}  Module content.
	 */
	getContent() {
		const failedGzip = GzipSummary.getFailedItems( this.props.status );

		let classes = 'sui-notice-warning';

		// Get the tooltips and icons.
		let text = sprintf(
			__( '%d of your compression types are inactive. Configure compression for all files types below.', 'wphb' ),
			failedGzip.length
		);

		const privacyFail = Object.values( failedGzip ).filter( ( item ) => {
			return 'privacy' === item;
		} );

		if ( 1 === privacyFail.length ) {
			classes = 'sui-notice-info';
			text = sprintf(
				__( "GZip compression is currently active for %d/3 types. We've detected you have Privacy Mode active which prevents us from accurately detecting whether HTML compression is active or not. You can re-check this when you've disabled Privacy Mode.", 'wphb' ),
				failedGzip.length
			);
		} else if ( 0 === failedGzip.length ) {
			classes = 'sui-notice-success';
			text = __( 'Gzip compression is currently active. Good job!', 'wphb' );
		}

		// Build the items array.
		const items = Object.entries( this.props.status ).map( ( item ) => {
			let label = __( 'Inactive', 'wphb' );
			let tag = 'warning';

			if ( item[ 1 ] ) {
				label = __( 'Active', 'wphb' );
				tag = 'success';
			}

			let type = item[ 0 ].toLowerCase();
			const classnames = classNames( 'wphb-filename-extension', 'wphb-filename-extension-' + type );

			if ( 'javascript' === type ) {
				type = 'js';
			}

			const labelData = (
				<React.Fragment>
					<span className={ classnames }>{ type }</span>
					<span className="wphb-filename-extension-label">{ item[ 0 ] }</span>
				</React.Fragment>
			);

			let tooltipText = sprintf(
				__( 'Gzip compression is %1$s for %2$s', 'wphb' ),
				label.toLowerCase(),
				item[ 0 ]
			);

			if ( 'privacy' === item[ 0 ] ) {
				tooltipText = __( 'While Privacy Mode is active, we can’t accurately detect if HTML compression is active and working. Re-check this once you’ve disabled Privacy Mode.', 'wphb' );
			}

			const tagComponent = <Tag value={ label } type={ tag } />;

			return {
				label: labelData,
				details: <Tooltip text={ tooltipText } data={ tagComponent } classes={ [ 'sui-tooltip-constrained' ] } />,
			};
		} );

		return (
			<React.Fragment>
				{ this.checkExternalProblems() }

				<p>
					{ __( 'Gzip compresses your web pages and style sheets before sending them over to the browser. This drastically reduces transfer time since the files are much smaller.', 'wphb' ) }
				</p>

				<Notice message={ text } classes={ classes } />

				<BorderFrame
					header={ [ __( 'File type', 'wphb' ), __( 'Current status', 'wphb' ) ] }
					elements={ items }
					extraClasses={ [ 'two-columns' ] }
				/>
			</React.Fragment>
		);
	}

	/**
	 * Render component.
	 *
	 * @return {*} GzipSummary component.
	 */
	render() {
		const gzip = GzipSummary.getStatus( this.props.status );

		const rightAction = (
			<React.Fragment>
				<span className="label-notice-inline sui-hidden-xs sui-hidden-sm">
					{ __( 'Made changes?', 'wphb' ) }
				</span>
				<Button
					text={ __( 'Re-check status', 'wphb' ) }
					onClick={ this.props.onUpdate }
					classes={ [ 'sui-button', 'sui-button-ghost' ] }
					icon="sui-icon-update"
				/>
			</React.Fragment>
		);

		const headerActions = (
			<React.Fragment>
				{ gzip && <Action type="left" content={ gzip } /> }
				<Action type="right" content={ rightAction } />
			</React.Fragment>
		);

		return (
			<Box
				loading={ this.props.loading }
				title={ __( 'Status', 'wphb' ) }
				headerActions={ headerActions }
				content={ this.getContent() }
			/>
		);
	}
}

export default GzipSummary;
