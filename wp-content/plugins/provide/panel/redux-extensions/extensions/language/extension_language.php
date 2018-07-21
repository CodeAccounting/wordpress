<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'ReduxFramework_extension_language' ) ) {

	class ReduxFramework_extension_language extends ReduxFramework {

		protected $parent;
		public $field_name = 'language';
		public static $instance;

		public function __construct( $parent ) {
			$this->parent = $parent;
			if ( empty( $this->extension_dir ) ) {
				$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
			}
			self::$instance = $this;
			add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( $this, 'overload_field_path' ) );

			add_action( "wp_ajax_nopriv_provide_languageUpload", array( $this, 'provide_languageUpload' ) );
			add_action( "wp_ajax_provide_languageUpload", array( $this, 'provide_languageUpload' ) );

			add_action( "wp_ajax_nopriv_provide_deleteLanguageFile", array( $this, 'provide_deleteLanguageFile' ) );
			add_action( "wp_ajax_provide_deleteLanguageFile", array( $this, 'provide_deleteLanguageFile' ) );
		}

		static public function getInstance() {
			return self::$theInstance;
		}

		public function overload_field_path() {
			return dirname( __FILE__ ) . '/field_' . $this->field_name . '.php';
		}

		public function fetchLang() {
			$dir  = get_template_directory() . '/languages/';
			$data = @scandir( $dir );
			if ( ! $data ) {
				return array();
			}
			if ( $data && is_array( $data ) ) {
				unset( $data[0], $data[1] );
			}
			$return = array();
			foreach ( $data as $d ) {
				if ( substr( $d, - 3 ) == '.mo' ) {
					$name            = substr( $d, 0, ( strlen( $d ) - 3 ) );
					$return[ $name ] = $name;
				}
			}

			return $return;
		}

		public function provide_languageUpload() {
			if ( isset( $_POST['action'] ) && $_POST['action'] == 'provide_languageUpload' ) {
				$folder = get_template_directory() . '/languages/';
				if ( ! is_dir( $folder ) ) {
					mkdir( $folder );
				}
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active( 'provide/provide.php' ) ) {
					$langFolder = Plugin_ROOT . 'languages/';
					if ( ! is_dir( $langFolder ) ) {
						mkdir( $langFolder );
					}
				}
				if ( ! isset( $_FILES['language_file'] ) || ! is_uploaded_file( $_FILES['language_file']['tmp_name'] ) ) {
					wp_send_json( array( 'status' => false, 'msg' => 'No file to upload' ) );
				}
				$lang_name = $_FILES['language_file']['name'];
				$lang_temp = $_FILES['language_file']['tmp_name'];
				$file_path = $folder . $lang_name;
				if ( file_exists( $lang_temp, $file_path ) ) {
					@unlink( $lang_temp, $file_path );
				}
				if ( move_uploaded_file( $lang_temp, $file_path ) ) {
					$languages = $this->fetchLang();
					$list      = '';
					if ( count( $languages ) > 0 ) {
						foreach ( $languages as $k => $v ) {
							$list .= '<option value="' . $k . '">' . $v . '</option>';
						}
					}
					copy( $folder . $lang_name, $langFolder . $lang_name );
					wp_send_json( array( 'status' => true, 'msg' => $list ) );
				}
			}
		}

		public function provide_deleteLanguageFile() {
			if ( isset( $_POST['action'] ) && $_POST['action'] == 'provide_deleteLanguageFile' ) {
				$folder     = get_template_directory() . '/languages/';
				$file       = $_POST['file'];
				$langFolder = Plugin_ROOT . 'languages/';
				if ( file_exists( $folder . $file . '.mo' ) ) {
					@unlink( $folder . $file . '.mo' );
				}
				if ( file_exists( $langFolder . $file . '.mo' ) ) {
					@unlink( $langFolder . $file . '.mo' );
				}
				$languages = $this->fetchLang();
				$list      = '';
				if ( count( $languages ) > 0 ) {
					foreach ( $languages as $k => $v ) {
						$list .= '<option value="' . $k . '">' . $v . '</option>';
					}
				}
				wp_send_json( array( 'status' => true, 'msg' => $list ) );
			}
		}
	}
}