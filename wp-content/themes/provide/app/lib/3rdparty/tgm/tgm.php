<?php

require_once provide_Root . 'app/lib/3rdparty/tgm/activation.php';

add_action( 'tgmpa_register', 'provide_register_required_plugins' );

function provide_register_required_plugins() {
	$plugins = array(
		array(
                    'name'               => esc_html__( 'Visual Composer', 'provide' ),
                    'slug'               => 'js_composer',
                    'source'             => get_template_directory() . '/app/lib/3rdparty/tgm/plugins/js_composer.zip',
                    'required'           => true,
                    'version'            => '5.4.5',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => 'http://wpbakery.com/',
		),
		array(
                    'name'               => esc_html__( 'Revolution Slider', 'provide' ),
                    'slug'               => 'revslider',
                    'source'             => get_template_directory() . '/app/lib/3rdparty/tgm/plugins/revslider.zip',
                    'required'           => true,
                    'version'            => '5.4.6.4',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => 'https://revolution.themepunch.com/',
		),
		array(
                    'name'               => esc_html__( 'Provide', 'provide' ),
                    'slug'               => 'provide',
                    'source'             => get_template_directory() . '/app/lib/3rdparty/tgm/plugins/provide.zip',
                    'required'           => true,
                    'version'            => '2.0',
                    'force_activation'   => false,
                    'force_deactivation' => false,
                    'external_url'       => 'http://provide.bitlers.com/',
		),
		array(
                    'name'     => esc_html__( 'Contact Form 7', 'provide' ),
                    'slug'     => 'contact-form-7',
                    'required' => false
		),
                array(
                    'name'     => esc_html__( 'Woocommerce', 'provide' ),
                    'slug'     => 'woocommerce',
                    'required' => true
		),
	);

	$config = array(
		'id'           => 'provide',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
