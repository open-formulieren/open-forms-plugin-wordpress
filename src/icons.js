/**
 * Allow raw icons to be created.
 * 
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/icon/
 */
import { Icon } from '@wordpress/components';

/**
 * Open Gemeente Intiatief logo.
 */
const OpenGemIcon = () => (
	<Icon
		icon={
			<svg class="logo__image" height="48px" version="1.1" viewBox="0 0 48 48" width="48px">
				<g fill="none"><rect class="logo__square" fill="#04A5BB" height="48" rx="6.72" width="48" x="-1.84741111e-13" y="0"></rect><ellipse class="logo__circle logo__circle--big" cx="24" cy="24" opacity="0.2" rx="17.2" ry="17" stroke="#FFFFFF" stroke-width="3.44064"></ellipse><ellipse class="logo__circle logo__circle--medium" cx="24" cy="24" opacity="0.4" rx="10.4" ry="10" stroke="#FFFFFF" stroke-width="3.44064"></ellipse><ellipse class="logo__circle logo__circle--small" cx="24" cy="24" opacity="0.6" rx="3.4" ry="3" stroke="#FFFFFF" stroke-width="3.44064"></ellipse></g>
			</svg>
		}
	/>
);

export default OpenGemIcon;