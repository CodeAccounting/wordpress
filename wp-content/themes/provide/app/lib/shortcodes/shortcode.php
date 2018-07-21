<?php

abstract class provide_VC_ShortCode {

	public static function _options( $method ) {
		$called_class = get_called_class();
		return $called_class::$method( 'provide_Shortcodes_Map' );
	}

}
