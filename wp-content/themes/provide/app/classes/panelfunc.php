<?php

class provide_Panelfunc {

	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;
		return false;
	}

	public function __clone() {
		trigger_error( esc_html__( 'Cloning the registry is not permitted', 'provide' ), E_USER_ERROR );
	}

}
