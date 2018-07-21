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

class provide_number {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;
		return false;
	}

	public function __construct() {
		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			vc_add_shortcode_param( 'un-number', array( $this, 'provide_number_settings_field' ) );
		}
	}

	function provide_number_settings_field( $settings, $value ) {
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type = isset( $settings['type'] ) ? $settings['type'] : '';
		$min = isset( $settings['min'] ) ? $settings['min'] : '';
		$max = isset( $settings['max'] ) ? $settings['max'] : '';
		$step = isset( $settings['step'] ) ? $settings['step'] : '';
		$suffix = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
		$class = isset( $settings['class'] ) ? $settings['class'] : '';
		$output = '<input type="number" min="' . $min . '" max="' . $max . '" step="' . $step . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
		return $output;
	}

}
