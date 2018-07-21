<?php

define( 'TH_MEGAMENU_ROOT_PATH', plugin_dir_path( __FILE__ ) );
define( 'TH_MEGAMENU_ROOT_URL', plugin_dir_url( __FILE__ ) );
define( 'TH_MEGAMENU_MAIN_FILE', TH_MEGAMENU_ROOT_PATH . 'main.php' );
define( 'TH_MEGAMENU_BUILDER_ENTRY_URL', admin_url( 'admin.php?page=cr-megamenu-builder' ) );
define( 'TH_MEGAMENU_META_KEY', '_th_megamenu_' );
define( 'TH_MEGAMENU_OPTION_KEY', 'cr-megamenu-megaed-menus' );
define( 'TH_MEGAMENU_TMP_WIDGET_OPTION', 'cr-megamenu-tmp-widget-settings' );

// Text domain for TH MegaMenu plugin
define( 'TH_MEGAMENU_TEXTDOMAIN', 'cr-megamenu' );

// Define absolute path of shortcodes folder
define( 'TH_MEGAMENU_LAYOUT_PATH', TH_MEGAMENU_ROOT_PATH . 'includes/shortcode/layout' );
define( 'TH_MEGAMENU_ELEMENT_PATH', TH_MEGAMENU_ROOT_PATH . 'shortcodes' );
define( 'TH_MEGAMENU_ELEMENT_URL', TH_MEGAMENU_ROOT_URL . 'shortcodes' );

// Define nonce ID
define( 'TH_MEGAMENU_NONCE', 'th_nonce_check' );

// Define product identified name
define( 'TH_MEGAMENU_IDENTIFIED_NAME', 'th_megamenu' );

// Define URL to load element editor
define( 'TH_MEGAMENU_URL', admin_url( 'admin.php?cr-mm-gadget=edit-element' ) );

// Define Custom Post Type name
define( 'TH_MEGAMENU_POST_TYPE_NAME', 'th_megamenu_profile' );

// Define absolute path of templates folder
define( 'TH_MEGAMENU_TPL_PATH', TH_MEGAMENU_ROOT_PATH . 'templates' );

//// Register extra path and class suffix with class auto-loader
TH_Megamenu_Loader::register( TH_MEGAMENU_ROOT_PATH . 'includes', 'TH_Megamenu_' );
TH_Megamenu_Loader::register( TH_MEGAMENU_ROOT_PATH . 'includes/plugin', 'TH_Megamenu_' );
