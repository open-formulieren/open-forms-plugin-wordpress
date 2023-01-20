/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';


/**
 * Internal dependencies
 */
import OpenForms_Edit from './edit';
import metadata from './block.json';

/**
 * Custom icons.
 * 
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/icon/
 */
import OpenForms_OpenGemIcon from './icons';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: OpenForms_Edit,
	icon: OpenForms_OpenGemIcon,
	attributes: {
		formId: {
		  	default: '',
		  	type: 'string',
		},
	  },
} );
