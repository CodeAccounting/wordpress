<?php

$nested = array(
	'provide_services_output'      => 'provide_service_block_output',
	'provide_toggles_output'       => 'provide_toggles_block_output',
	'provide_tabs_output'          => 'provide_tabs_block_output',
	'provide_progress_bars_output' => 'provide_progress_bars_block_output'
);

if ( $nested ) {
	foreach ( $nested as $parent => $child ) {
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			if ( function_exists( 'provide_nested_shortcode' ) ) {
				provide_nested_shortcode( "class WPBakeryShortCode_{$parent} extends WPBakeryShortCodesContainer{}" );
			}
		}
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			if ( function_exists( 'provide_nested_shortcode' ) ) {
				provide_nested_shortcode( "class WPBakeryShortCode_{$child} extends WPBakeryShortCode{}" );
			}
		}
	}
}




