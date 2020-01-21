/* global SUI */
/**
 * External dependencies
 */
import React from 'react';

/**
 * Select component.
 */
export default class Select extends React.Component {
	/**
	 * Share UI actions need to be performed manually for elements.
	 * They should be done in this method.
	 */
	componentDidMount() {
		this.$el = jQuery( this.el );
		SUI.suiSelect( this.$el );
		this.$el.on( 'change', this.props.onChange );
	}

	/**
	 * Render component.
	 * @return {React.Component}  Select component.
	 */
	render() {
		const selectOptions = this.props.items.map( ( item, id ) => {
			const isSelected = item[ 0 ] === this.props.selected;

			return (
				<option value={ item[ 0 ] } selected={ isSelected ? 'selected' : '' } key={ id }>
					{ item[ 1 ] }
				</option>
			);
		} );

		return (
			<React.Fragment>
				<label htmlFor={ this.props.selectId } className="sui-label">{ this.props.label }</label>
				<select name={ this.props.selectId } id={ this.props.selectId } ref={ ( el ) => this.el = el }>
					{ selectOptions }
				</select>
			</React.Fragment>
		);
	}
}

/**
 * Default props.
 *
 * @param {string} selectId  Select ID. Will be also used as class and htmlFor in the label.
 * @param {string} label     Label text.
 * @param {Array}  items     List of items for the select.
 * @param {string} selected  Selected item.
 *
 * @type {{selectId: string, label: string, items: {}, selected: string}}
 */
Select.defaultProps = {
	selectId: '',
	label: '',
	items: {},
	selected: '',
};
