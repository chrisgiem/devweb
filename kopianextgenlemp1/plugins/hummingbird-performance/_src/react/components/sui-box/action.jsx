/**
 * External dependencies
 */
import React from 'react';

/**
 * SUI actions component.
 * Actions can go either to the sui-header or sui-footer of Box component.
 */
export default class Action extends React.Component {
	render() {
		const classes = 'sui-actions-' + this.props.type;
		return <div className={ classes }>{ this.props.content }</div>;
	}
}
