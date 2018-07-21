<?php

class Autoload {

	static protected $directories = array();
	static protected $aliases = array();
	static protected $mappings = array();
	static private $_initialized = false;
	static private $_ext = '.php';

	static public function register() {
		if ( !self::$_initialized ) {
			$in_spl_autoload = false;
			if ( spl_autoload_functions() ) {
				foreach ( spl_autoload_functions() as $loader ) {
					if(is_array($loader ) && __CLASS__=== $loader[0]){
					//if ( $loader[0] == __CLASS__ ) {
						$in_spl_autoload = true;
						continue;
					}
				}
			}
			if ( !$in_spl_autoload ) {
				spl_autoload_register( array( __CLASS__, 'load' ) );
				self::$_initialized = true;
			}
		}
	}

	static public function unregister() {
		if ( self::$_initialized ) {
			spl_autoload_unregister( array( __CLASS__, 'load' ) );
			self::$_initialized = false;
		}
	}

	static public function load( $class ) {
		if ( !self::$_initialized ) {
			self::register();
		}

		if ( isset( self::$aliases[$class] ) ) {
			return class_alias( self::$aliases[$class], $class );
		} elseif ( isset( self::$mappings[$class] ) ) {
			return require self::$mappings[$class];
		}
		return self::_load( $class );
	}

	public static function alias( $class = null, $alias = null ) {
		self::$aliases[$alias] = $class;
	}

	static public function map( $mappings = array(), $dir = null ) {
		if ( !is_array( $mappings ) ) {
			$mappings = array( $mappings => $dir );
		}
		self::$mappings = array_merge( self::$mappings, $mappings );
	}

	static public function directories( $directories = array() ) {
		if ( !empty( $directories ) ) {
			$directories = self::_dirFormat( $directories );
			self::$directories = array_unique( array_merge( self::$directories, $directories ) );
		}
	}

	static public function directory( $directory = null ) {
		self::directories( $directory );
	}

	static private function _load( $class ) {
		$name = str_replace( array( '\\' ), '/', $class );
		foreach ( self::$directories as $directory ) {
			if ( file_exists( $path = $directory . strtolower( str_replace( 'provide_', '', $name ) ) . self::$_ext ) ) {
				return require $path;
			}
		}

		$message = __CLASS__ . ' :: Class "' . $class . '" not found';
	}

	static private function _dirFormat( $directories = array() ) {
		return array_map( array( __CLASS__, '_dirFormatSlashed' ), (array) $directories );
	}

	static protected function _dirFormatSlashed( $directory = '' ) {
		return rtrim( $directory, '/' ) . '/';
	}

}
