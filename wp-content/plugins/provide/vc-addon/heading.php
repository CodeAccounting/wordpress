<?php

/* /* sampel usege
  array(
  'type' => 'number',
  'class' => '',
  'edit_field_class' => 'vc_col-sm-4 items_to_show ult_margin_bottom',
  'heading' => __('On Desktop', 'dfd'),
  'param_name' => 'slides_on_desk',
  'value' => '5',
  'min' => '1',
  'max' => '25',
  'step' => '1',
  'description' => __('', 'dfd'),
  'group' => 'General',
  ),
 */
if ( ! class_exists( 'provide_heading' ) ) {

	class provide_heading {

		public function __call( $method, $args ) {
			echo esc_html__( "unknown method ", "provide" ) . $method;

			return false;
		}

		public function __construct() {
			if ( function_exists( 'vc_add_shortcode_param' ) ) {
				vc_add_shortcode_param( 'un-heading', array( $this, 'provide_heading_settings_field' ) );
			}
		}

		function provide_heading_settings_field( $settings, $value ) {
			$dependency = '';
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$text       = isset( $settings['text'] ) ? $settings['text'] : '';
			$output     = '<h4 ' . $dependency . ' class="wpb_vc_param_value ' . $class . '">' . $text . '</h4>';
			$output     .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value ultimate-param-heading ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" ' . $dependency . '/>';

			return $output;
		}

	}

}