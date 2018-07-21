<?php

class provide_options {
	
	public function __call( $method, $args ) {
		echo esc_html__( "unknown method ", "provide" ) . $method;
		return false;
	}
	
	public function provide_title( $title = '' ) {
		return sprintf( esc_html__( '%s', 'provide' ), $title );
	}

	public function provide_desc( $desc = '' ) {
		return sprintf( esc_html__( '%s', 'provide' ), $desc );
	}

}
