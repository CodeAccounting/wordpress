<?php

class provide_toggles_block_VC_ShortCode extends provide_VC_ShortCode {

	static $counter = 0;

	public static function provide_toggles_block( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"                    => esc_html__( "Toggles Block", 'provide' ),
				"base"                    => "provide_toggles_block_output",
				"icon"                    => 'provide_toggles_block_output.png',
				"category"                => esc_html__( 'Provide', 'provide' ),
				"as_child"                => array( 'only' => 'provide_toggles_output' ),
				"content_element"         => true,
				"show_settings_on_create" => true,
				"is_container"            => true,
				"params"                  => array(
					array(
						'type'        => 'iconpicker',
						'heading'     => esc_html__( 'Icon', 'provide' ),
						'param_name'  => 'icon',
						'description' => esc_html__( 'Select icon from library.', 'provide' ),
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Title:", 'provide' ),
						"param_name"  => "title",
						"description" => esc_html__( "Enter the title.", 'provide' )
					),
					array(
						"type"        => "textarea",
						"heading"     => esc_html__( "Description:", 'provide' ),
						"param_name"  => "content",
						"description" => esc_html__( "Enter the description.", 'provide' )
					)
				)
			);

			return apply_filters( 'provide_toggles_block_output', $return );
		}
	}

	public static function provide_toggles_block_output( $atts = null, $content = null ) {
		$icon = $title = '';
		extract( shortcode_atts( array(
			'icon'  => '',
			'title' => ''
		), $atts ) );
		global $toggles;
		$toggles[] = array( 'icon' => $icon, 'title' => $title, 'content' => trim( do_shortcode( $content ) ) );
	}

}
