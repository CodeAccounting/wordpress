<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
if ( ! class_exists( 'provide_CustomizerCss' ) ) {

	class provide_CustomizerCss {

		public function __construct() {

			// Setup some base variables for the plugin
			$this->basename       = plugin_basename( __FILE__ );
			$this->directory_path = plugin_dir_path( __FILE__ );
			$this->directory_url  = plugins_url( dirname( $this->basename ) );
		}

		public function do_hooks() {
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		}

		public function add_menu_page() {
			add_submenu_page( 'themes.php', esc_html__( 'Style.css Editor', 'provide' ), esc_html__( 'Style.css Editor  ', 'provide' ), 'edit_theme_options', 'provide-css-editor', array( $this, 'custom_css_page' ) );
		}

		public function custom_css_page() {
			if ( ! empty( $_POST['wds_custom_css'] ) ) {
				file_put_contents( get_template_directory() . '/partial/css/style.css', $_POST['wds_custom_css'] );
			}

			$wds_custom_css = file_get_contents( get_template_directory_uri() . '/partial/css/style.css' );

			echo "<form method='POST'>";

			wp_nonce_field( 'wds_custom_css_nonce' );

			echo "<table class='form-table'>\n";
			echo "<tr><th>" . esc_html__( 'Provide Style.css Editor', 'provide' ) . "</th><td><textarea  rows='25' cols='100' name='wds_custom_css'>{$wds_custom_css}</textarea></td></tr>\n";
			echo "</td></tr>\n";
			echo "</table>";
			echo "<p><input type='submit' class='button-primary' value='" . esc_html__( 'Save', 'provide' ) . "' /></p></form>";
		}

	}

	$_GLOBALS['provide_CustomizerCss'] = new provide_CustomizerCss;
	$_GLOBALS['provide_CustomizerCss']->do_hooks();
}
*/