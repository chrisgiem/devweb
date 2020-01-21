/**
 * External dependencies
 */
import React from 'react';
import classNames from 'classnames';

/**
 * Button functional component.
 *
 * @param {string}  text      Button text.
 * @param {string}  url       URL link.
 * @param {Array}   classes   Button class.
 * @param {string}  id        Button ID.
 * @param {string}  icon      SUI icon class.
 * @param {string}  target    Target __blank?
 * @param {boolean} disabled  Disabled or not.
 * @param {*}       onClick   onClick callback.
 * @return {*} Button component.
 * @constructor
 */
export default function Button( { text, url, classes, id, icon, target, disabled = false, onClick } ) {
	if ( icon ) {
		icon = <i className={ icon } aria-hidden="true" />;
	}

	let rel;
	if ( 'blank' === target ) {
		rel = 'noopener noreferrer';
	}

	return (
		<a className={ classNames( classes ) } href={ url } id={ id } target={ target } rel={ rel } disabled={ disabled } onClick={ onClick }>
			{ icon }
			{ text }
		</a>
	);
}
