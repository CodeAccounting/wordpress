<?php

class provide_meta_Heading {

	/**
	 * Current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_action( 'cmb2_render_heading', array( $this, 'render' ), 10, 5 );
		add_action( 'cmb2_sanitize_heading', array( $this, 'sanitize' ), 10, 2 );
	}

	/**
	 * Add a CMB custom field to allow for the selection FontAwesome Icon
	 */
	public function render( $field, $escaped_value, $object_id, $object_type, $field_type ) {
		?>
		<h1><?php echo esc_html( $field_type->field->args['heading'] ) ?></h1>
		<?php
	}

	/**
	 * Sanitize icon class name
	 */
	public function sanitize( $sanitized_val, $val ) {
		if ( !empty( $val ) ) {
			return sanitize_html_class( $val );
		}
		return $sanitized_val;
	}

}

new provide_meta_Heading();
