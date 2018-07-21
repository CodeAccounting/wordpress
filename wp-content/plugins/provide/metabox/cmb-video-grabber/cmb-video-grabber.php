<?php

class provide_videograbber {
	const VERSION = '1';

	public function __construct() {
		require_once( trailingslashit( __DIR__ ) . 'class-grabber.php' );
		add_filter( 'cmb2_render_video_grabber', array( $this, 'render_video_grabber' ), 10, 5 );
		add_filter( 'cmb2_sanitize_video_grabber', array( $this, 'sanitize_video_grabber' ), 10, 4 );

		/*
		 * ajax request
		 * */
		add_action( "wp_ajax_nopriv_grabber", array( Grabber::Instance(), 'run' ) );
		add_action( "wp_ajax_grabber", array( Grabber::Instance(), 'run' ) );
	}

	public function render_video_grabber( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		$this->setup_admin_scripts();
		$isSingle = $field->args[ 'single' ];
		if ( $isSingle ) {
			echo '<input type="text" class="large-text" id="' . $field->args( 'id' ) . '" />';
			echo '<input type="button" data-type="single"  class="large-text single-grabber" id="btn-' . $field->args( 'id' ) . '" placeholder="' . esc_html( 'Grab Video', 'provide' ) . '" />';
		} else {
			echo '<textarea class="large-text single-grabber" id="' . $field->args( 'id' ) . '" placeholder="' . esc_html__( 'Enter the video url, For multiple please add "|" no space', 'provide' ) . '" ></textarea>';
			echo '<input type="button" data-type="multi" class="large-text multi-grabber" id="btn-' . $field->args( 'id' ) . '" value="' . esc_html( 'Grab Videos', 'provide' ) . '"/>';
		}
		ob_start();
		?>
		<div class="grabber-box">

		</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;

	}

	public function sanitize_video_grabber( $override_value, $value, $object_id, $field_args ) {
		if ( isset( $field_args[ 'split_values' ] ) && $field_args[ 'split_values' ] ) {
			if ( ! empty( $value[ 'latitude' ] ) ) {
				update_post_meta( $object_id, $field_args[ 'id' ] . '_latitude', $value[ 'latitude' ] );
			}

			if ( ! empty( $value[ 'longitude' ] ) ) {
				update_post_meta( $object_id, $field_args[ 'id' ] . '_longitude', $value[ 'longitude' ] );
			}

			if ( ! empty( $value[ 'address' ] ) ) {
				update_post_meta( $object_id, $field_args[ 'id' ] . '_address', $value[ 'address' ] );
			}
		}

		return $value;
	}

	public function setup_admin_scripts() {
		wp_register_script( 'provide-video-grabber', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ), self::VERSION );
		$translation_array = array(
			'ajax' => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( 'provide-video-grabber', 'grabber', $translation_array );
		wp_enqueue_script( 'provide-video-grabber' );
		wp_enqueue_style( 'pw-google-maps', plugins_url( 'css/style.css', __FILE__ ), array(), self::VERSION );
	}

}

new provide_videograbber();
