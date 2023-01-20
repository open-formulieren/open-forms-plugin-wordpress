/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Generic components to built our edit component.
 * 
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/
 */
import {
	SelectControl,
	Placeholder,
	ExternalLink,
	Spinner,
} from '@wordpress/components';
import { Component } from '@wordpress/element';

/**
 * Custom icons.
 * 
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/icon/
 */
import OpenForms_OpenGemIcon from './icons';


class OpenForms_BlockEdit extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
			formList: [],
			loading: true
		}
	}
 
	componentDidMount() {
		this.runApiFetch();
	}
 
	runApiFetch() {
		wp.apiFetch({
			path: 'openforms/v1/forms',
		}).then(data => {
			this.setState({
				formList: data,
				loading: false
			});
		});
	}
 
	render() {
		const {
			formList,
			loading,
		} = this.state;

		const { attributes, setAttributes } = this.props;

		return(
			<Placeholder
				icon={ OpenForms_OpenGemIcon }
				label={ __( 'Open Forms', 'openforms' ) }
				isColumnLayout={ true }
			>

				{ loading ? (

					<Spinner />

				) : (
					<SelectControl
						help={ __( 'Select one of the available forms in Open Forms.', 'openforms' ) }
						label={ __( 'Form', 'openforms' ) }
						onChange={ ( formId ) => setAttributes( { formId } ) }
						value={ attributes.formId }
						options={ formList.map( ( formOption, i ) => {     
							return { value: formOption.slug, label: formOption.name }
						} ) }
					/>
				)}

				<ExternalLink
					href={ 'https://opengem.nl/producten/open-formulieren/' }
				>
					{ __( 'More information about Open Forms', 'openforms' ) }
				</ExternalLink>


			</Placeholder>

		);
 
	}
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function OpenForms_Edit( props ) {
	return (
		<p { ...useBlockProps() }>
			<OpenForms_BlockEdit { ...props }/>
		</p>
	);
}
