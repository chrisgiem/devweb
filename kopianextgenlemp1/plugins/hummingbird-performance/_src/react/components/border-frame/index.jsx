/**
 * External dependencies
 */
import React from 'react';
import classNames from 'classnames';

/**
 * Internal dependencies
 */
import './style.scss';

/**
 * Functional BorderFrame component.
 *
 * @param {Object} elements
 * @param {Object} header
 * @param {Array}  Extra classes.
 * @return {*} List component.
 * @constructor
 */
export default function BorderFrame( { elements, header, extraClasses } ) {
	const items = Object.values( elements ).map( ( element, id ) => {
		return (
			<div className="table-row" key={ id }>
				<div className="wphb-caching-summary-item-type">{ element.label }</div>
				<div>{ element.details }</div>
			</div>
		);
	} );

	const classes = classNames( 'wphb-border-frame', extraClasses );

	return (
		<div className={ classes }>
			{ header &&
			<div className="table-header">
				<div className="wphb-caching-summary-heading-type">{ header[ 0 ] }</div>
				<div className="wphb-caching-summary-heading-status">{ header[ 1 ] }</div>
			</div>
			}
			{ items }
		</div>
	);
}
