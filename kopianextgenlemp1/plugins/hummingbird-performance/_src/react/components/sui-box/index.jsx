/**
 * External dependencies
 */
import React from 'react';
import PropTypes from 'prop-types';
import classNames from 'classnames';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import './style.scss';

/**
 * Box component.
 */
export default class Box extends React.Component {
	/**
	 * Generate header.
	 * @param {string} title          Box title.
	 * @param {string} icon           Icon name to use, false for no icon.
	 * @param {Action} headerActions  Action component.
	 * @return {*} Box header.
	 */
	static boxHeader( title = '', icon = '', headerActions = null ) {
		const iconClass = 'sui-icon-' + icon;

		return (
			<React.Fragment>
				<h3 className="sui-box-title">
					{ icon &&
					<i className={ iconClass } aria-hidden="true" />
					} { title }
				</h3>

				{ headerActions }
			</React.Fragment>
		);
	}

	/**
	 * Render component.
	 * @return {*} Box component.
	 */
	render() {
		const boxHeader = Box.boxHeader(
			this.props.title,
			this.props.icon,
			this.props.headerActions,
		);

		return (
			<div className={ classNames( 'sui-box', this.props.boxClass ) }>
				<div className={ classNames( 'wphb-loading-overlay', { 'wphb-loading': this.props.loading } ) }>
					<i className="sui-icon-loader sui-loading" aria-hidden="true" />
					<p>{ __( 'Fetching latest data...', 'wphb' ) }</p>
				</div>

				<div className="sui-box-header">
					{ boxHeader }
				</div>

				<div className="sui-box-body">
					{ this.props.content }
				</div>

				{ this.props.footerActions &&
				<div className="sui-box-footer">
					{ this.props.footerActions }
				</div>
				}
			</div>
		);
	}
}

Box.propTypes = {
	boxClass: PropTypes.string,
	title: PropTypes.string,
	icon: PropTypes.string,
	headerActions: PropTypes.element,
	content: PropTypes.element,
	footerActions: PropTypes.element,
};
