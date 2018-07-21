<?php

class provide_ajax {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;

		return false;
	}

	public function __construct() {
		$requests = array(
			'widgetContactForm' => 'provide_widgetContactForm',
			'funFactNewsletter' => 'provide_funFactNewsletter',
			'requestAQuote'     => 'provide_requestAQuote',
			'cuwsbContactForm'  => 'provide_cuwsbContactForm',
			'videoNewsletter'   => 'provide_videoNewsletter',
			'mainContactForm'   => 'provide_mainContactForm',
                        'quickView'         => 'provide_quickview'
		);
		if ( ! empty( $requests ) && count( $requests ) > 0 ) {
			foreach ( $requests as $key => $request ) {
				add_action( "wp_ajax_nopriv_$key", array( $this, $request ) );
				add_action( "wp_ajax_$key", array( $this, $request ) );
			}
		}
	}
        
        public function provide_quickview() {
            if ( isset( $_POST['action'] ) && $_POST['action'] == 'quickView' ) {
                (new provide_response())->provide_quickview( $_POST );
                exit;
            }
	}

	public function provide_mainContactForm() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'mainContactForm' ) {
			provide_mainContactFormResponse( $_POST );
			exit;
		}
	}

	public function provide_widgetContactForm() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'widgetContactForm' ) {
			provide_widgetContactFormResponse( $_POST );
			exit;
		}
	}

	public function provide_cuwsbContactForm() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'cuwsbContactForm' ) {
			provide_cuwsbContactFormResponse( $_POST );
			exit;
		}
	}

	public function provide_funFactNewsletter() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'funFactNewsletter' ) {
			provide_response::provide_singleton()->provide_funFactNewsletter( $_POST );
			exit;
		}
	}

	public function provide_requestAQuote() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'requestAQuote' ) {
			provide_response::provide_singleton()->provide_requestAQuote( $_POST );
			exit;
		}
	}

	public function provide_videoNewsletter() {
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'videoNewsletter' ) {
			provide_response::provide_singleton()->provide_videoNewsletter( $_POST );
			exit;
		}
	}

}
