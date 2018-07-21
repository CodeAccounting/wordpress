<?php

class provide_toggle {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;
		return false;
	}

	public function __construct() {
		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			vc_add_shortcode_param( 'un_toggle', array( $this, 'provide_toggle_settings_field' ) );
		}
	}

	function provide_toggle_settings_field( $settings, $value ) {
		$dependency = '';
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type = isset( $settings['type'] ) ? $settings['type'] : '';
		$options = isset( $settings['options'] ) ? $settings['options'] : '';
		$class = isset( $settings['class'] ) ? $settings['class'] : '';
		$default_set = isset( $settings['default_set'] ) ? $settings['default_set'] : false;
		$output = $checked = '';
		$un = uniqid( 'ultswitch-' . rand() );
		if ( is_array( $options ) && !empty( $options ) ) {
			foreach ( $options as $key => $opts ) {
				if ( $value == $key ) {
					$checked = "checked";
				} else {
					$checked = "";
				}
				$uid = uniqid( 'ultswitchparam-' . rand() );
				$output .= '<div class="vc-onoffswitch">
							<input type="checkbox" name="' . $param_name . '" value="' . $value . '" ' . $dependency . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ' . $dependency . ' vc-onoffswitch-checkbox chk-switch-' . $un . '" id="switch' . $uid . '" ' . $checked . '>
							<label class="vc-onoffswitch-label" for="switch' . $uid . '">
								<div class="vc-onoffswitch-inner">
									<div class="vc-onoffswitch-active">
										<div class="vc-onoffswitch-switch">' . $opts['on'] . '</div>
									</div>
									<div class="vc-onoffswitch-inactive">
										<div class="vc-onoffswitch-switch">' . $opts['off'] . '</div>
									</div>
								</div>
							</label>
						</div>';
				if ( isset( $opts['label'] ) )
					$lbl = $opts['label'];
				else
					$lbl = '';
				$output .= '<div class="chk-label">' . $lbl . '</div><br/>';
			}
		}

		if ( $default_set )
			$set_value = 'off';
		else
			$set_value = '';

		$output .= '<script type="text/javascript">
				jQuery("#switch' . $uid . '").change(function(){
					 
					 if(jQuery("#switch' . $uid . '").is(":checked")){
						jQuery("#switch' . $uid . '").val("' . $key . '");
						jQuery("#switch' . $uid . '").attr("checked","checked");
					 } else {
						jQuery("#switch' . $uid . '").val("' . $set_value . '");
						jQuery("#switch' . $uid . '").removeAttr("checked");
					 }
					
				});
			</script>';
		return $output;
	}

}
