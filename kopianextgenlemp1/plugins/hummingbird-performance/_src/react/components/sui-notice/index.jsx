/**
 * External dependencies
 */
import React from 'react';
import classNames from 'classnames';

/**
 * Notice functional component.
 *
 * @param {string} message  Notice message.
 * @param {Array}  classes  Array of extra classes to use.
 * @param {Object} content  CTA content.
 * @return {*} Button component.
 * @constructor
 */
export default function Notice( { message, classes, content } ) {
	const combinedClasses = classNames( 'sui-notice', classes );

	return (
		<div className={ combinedClasses }>
			<p>{ message }</p>

			{ content &&
			<div className="sui-notice-buttons">
				{ content }
			</div>
			}
		</div>
	);
}
