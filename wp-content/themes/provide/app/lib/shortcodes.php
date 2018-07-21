<?php

class provide_Shortcodes {

	static protected $_shortcodes = array(
		// home page one
		'services',
		'service_block',
		'simple_carousel',
		'our_features',
		'toggle',
		'our_portfolio',
		'price_table',
		'modern_team_carousel',
		'fun_fact_with_newsletter',
		'latest_news',
		'request_a_quote',
		'sponsors',
		// home page two
		'fancy_features',
		'services_style_2',
		'features_fancy_style',
		'our_team',
		'our_skills',
		'video_box_with_toggles',
		'our_portfolio_style2',
		'customer_services',
		'testimonials_carousel',
		'contact_us_with_social_box',
		'contact_us',
		'google_map',
		// home page three
		'services_with_video_box',
		'our_portfolio_style3',
		'business_graph',
		'product_information',
		'newsletter_with_video',
		// home page four
		'graph_with_video_box',
		// about us v1
		'image_with_text_block',
		// about us v2
		'bar_graph',
		'simple_feature_list',
		'verticle_spacing',
		// web elements
		'buttons',
		'toggles',
		'toggles_block',
		'tabs',
		'tabs_block',
		'social_media',
		'progress_bars',
		'progress_bars_block',
		'drop_cap',
		'full_width_video',
                'masonary_gallery',
                'overlay_blog',
                'simple_gallery_carousel',
                'modern_filtered_products',
                'simple_product_carousel',
	);

	static public function init() {
		define( 'provide_JS_COMPOSER_PATH', provide_Root . 'app/lib/shortcodes' );
		require_once provide_JS_COMPOSER_PATH . "/shortcode.php";
		self::_init_shortcodes();
		self::provide_nested_shortcodes();
	}

	static protected function _init_shortcodes() {
		if ( function_exists( 'vc_map' ) && function_exists( 'provide_shortcode_setup' ) ) {
			asort( self::$_shortcodes );
			foreach ( self::$_shortcodes as $shortcodes ) {
				require_once provide_JS_COMPOSER_PATH . '/' . $shortcodes . '.php';
				$class         = 'provide_' . ucfirst( $shortcodes ) . '_VC_ShortCode';
				$provide_name  = strtolower( 'provide_' . $shortcodes );
				$class_methods = get_class_methods( $class );
				if ( isset( $class_methods ) ) {
					foreach ( $class_methods as $shortcode ) {
						if ( $shortcode[0] != '_' && $shortcode != $provide_name ) {
							provide_shortcode_setup( $shortcode, array( $class, $shortcode ) );
							if ( function_exists( 'vc_map' ) ) {
								vc_map( call_user_func( array( $class, '_options' ), $provide_name ) );
							}
						}
					}
				}
			}
		}
	}

	static public function provide_nested_shortcodes() {
		require_once provide_JS_COMPOSER_PATH . "/nested_shortcodes.php";
	}

}
