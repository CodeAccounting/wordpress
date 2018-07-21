<?php

class provide_multiselect {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;
		return false;
	}

	public function __construct() {
		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			vc_add_shortcode_param( 'un-multiselect', array( $this, 'provide_multiselect_settings_field' ) );
		}
	}

	function provide_multiselect_settings_field( $settings, $value ) {
		$dependency = '';
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type = isset( $settings['type'] ) ? $settings['type'] : '';
		$class = isset( $settings['class'] ) ? $settings['class'] : '';
		if ( !is_array( $value ) ) {
			$checkVal = explode( ',', $value );
		} else {
			$checkVal = $value;
		}
		ob_start();
		?>
		<select multiple name="<?php echo esc_attr( $param_name ) ?>" <?php echo $dependency ?>
				class="wpb_vc_param_value wpb-ultiselect <?php echo esc_attr( $param_name . ' ' . $type . ' ' . $class . ' ' . $dependency ) ?>
				<?php
				echo esc_attr( $settings['param_name'] );
				echo ' ';
				echo esc_attr( $settings['type'] );
				?>_field">
			<?php
			$val = provide_set( $settings, 'value' );
			if ( !empty( $val ) ) {
				foreach ( $val as $k => $v ) {
					$selected = (in_array( $k, $checkVal )) ? 'selected' : '';
					echo '<option ' . $selected . ' value="' . $k . '">' . $v . '</option>';
				}
			}
			?>
		</select>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}
