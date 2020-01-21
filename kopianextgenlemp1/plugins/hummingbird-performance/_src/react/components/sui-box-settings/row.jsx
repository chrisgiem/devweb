/**
 * External dependencies
 */
import React from 'react';

/**
 * Functional SettingsRow (sui-box-settings-row) component.
 *
 * @param {string} label
 * @param {string} description
 * @param {Object} content
 * @return {*} SettingsRow component.
 * @constructor
 */
export default function SettingsRow( { label, description, content } ) {
	return (
		<div className="sui-box-settings-row">
			<div className="sui-box-settings-col-1">
				<span className="sui-settings-label">{ label }</span>
				<span className="sui-description">{ description }</span>
			</div>
			<div className="sui-box-settings-col-2">
				{ content }
			</div>
		</div>
	);
}
