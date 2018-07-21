<?php

class provide_progress_bars_block_VC_ShortCode extends provide_VC_ShortCode {

	public static function provide_progress_bars_block( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"                    => esc_html__( "Progress Bar Block", 'provide' ),
				"base"                    => "provide_progress_bars_block_output",
				"icon"                    => 'provide_progress_bars_block.png',
				"category"                => esc_html__( 'Provide', 'provide' ),
				"as_child"                => array( 'only' => 'provide_progress_bars_output' ),
				"content_element"         => true,
				"show_settings_on_create" => true,
				"is_container"            => true,
				"params"                  => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Title:", 'provide' ),
						"param_name"  => "title",
						"description" => esc_html__( "Enter the title for this section.", 'provide' )
					),
					array(
						"type"        => "un-number",
						"heading"     => esc_html__( "Number:", 'provide' ),
						"param_name"  => "number",
						"description" => esc_html__( "Enter the number of this section.", 'provide' )
					)
				)
			);

			return apply_filters( 'provide_progress_bars_block_shortcode', $return );
		}
	}

	public static function provide_progress_bars_block_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		global $progress_bar;
		$progress_bar[] = array( 'title' => $title, 'number' => $number );
	}

}
