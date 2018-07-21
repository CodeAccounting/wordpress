<?php

class provide_buttons_VC_ShortCode extends provide_VC_ShortCode {

	public static function provide_buttons( $atts = null ) {
		$H = new provide_Helper();
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Buttons", 'provide' ),
				"base"     => "provide_buttons_output",
				"icon"     => 'buttons.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Title:", 'provide' ),
						"param_name"  => "title",
						"description" => esc_html__( "Enter the title for this section.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Button link:", 'provide' ),
						"param_name"  => "btnlink",
						"description" => esc_html__( "Enter the button link.", 'provide' )
					),
					array(
						"type"        => "iconpicker",
						"heading"     => esc_html__( "Icon:", 'provide' ),
						"param_name"  => "icon",
						"description" => esc_html__( "Select the icon from the library.", 'provide' )
					),
					array(
						"type" => "dropdown",

						"heading"     => esc_html__( 'Style', 'provide' ),
						"param_name"  => "style",
						"value"       => array(
							esc_html__( 'Squared with Blue BG', 'provide' )          => 'btns blu-skin sml-radius',
							esc_html__( 'Squared with Dark BG', 'provide' )          => 'btns drk-skin sml-radius',
							esc_html__( 'Squared with Mono BG', 'provide' )          => 'btns thm-skin sml-radius',
							esc_html__( 'Squared with Dark Border', 'provide' )      => 'btns drk-bor-skin sml-radius',
							esc_html__( 'Squared with Mono Border', 'provide' )      => 'btns thm-bor-skin sml-radius',
							esc_html__( 'Fancy with Blue BG', 'provide' )            => 'btns btn2 blu-skin sml-radius',
							esc_html__( 'Fancy with Dark BG', 'provide' )            => 'btns btn2 drk-skin sml-radius',
							esc_html__( 'Fancy with Mono BG', 'provide' )            => 'btns btn2 thm-skin sml-radius',
							esc_html__( 'Fancy with Gray BG', 'provide' )            => 'btns btn2 lgt-skin sml-radius',
							esc_html__( 'Fancy with Dark Border', 'provide' )        => 'btns btn2 drk-bor-skin sml-radius',
							esc_html__( 'Half Rounded with Blue BG', 'provide' )     => 'btns blu-skin hlf-radius',
							esc_html__( 'Half Rounded with Dark BG', 'provide' )     => 'btns drk-skin hlf-radius',
							esc_html__( 'Half Rounded with Mono BG', 'provide' )     => 'btns thm-skin hlf-radius',
							esc_html__( 'Half Rounded with Dark Border', 'provide' ) => 'btns drk-bor-skin hlf-radius',
							esc_html__( 'Half Rounded with Mono Border', 'provide' ) => 'btns thm-bor-skin hlf-radius',
							esc_html__( 'Rounded with Blue BG', 'provide' )          => 'btns blu-skin ful-radius',
							esc_html__( 'Rounded with Dark BG', 'provide' )          => 'btns drk-skin ful-radius',
							esc_html__( 'Rounded with Mono BG', 'provide' )          => 'btns thm-skin ful-radius',
							esc_html__( 'Rounded with Dark Border', 'provide' )      => 'btns drk-bor-skin ful-radius',
							esc_html__( 'Rounded with Mono Border', 'provide' )      => 'btns thm-bor-skin ful-radius',
						),
						"description" => esc_html__( "Select style of this section", 'provide' )
					),
					array(
						"type" => "dropdown",

						"heading"     => esc_html__( 'Size', 'provide' ),
						"param_name"  => "size",
						"value"       => array(
							esc_html__( 'Small', 'provide' )   => 'sml-btn',
							esc_html__( 'Medium', 'provide' )  => 'mid-btn',
							esc_html__( 'Large', 'provide' )   => 'nth-lrg-btn',
							esc_html__( 'X Large', 'provide' ) => 'lrg-btn',
						),
						"description" => esc_html__( "Select button size", 'provide' )
					),
				)
			);

			return apply_filters( 'provide_buttons_shortcode', $return );
		}
	}

	public static function provide_buttons_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		$not = array(
			'btns btn2 blu-skin sml-radius',
			'btns btn2 drk-skin sml-radius',
			'btns btn2 thm-skin sml-radius',
			'btns btn2 lgt-skin sml-radius',
			'btns btn2 drk-bor-skin sml-radius'
		);
		?>
		<a href="<?php echo esc_url( $btnlink ) ?>" title="" class="<?php echo esc_attr( $style . ' ' . $size ) ?>">
			<?php if ( ! in_array( $style, $not ) ): ?>
				<i class="<?php echo esc_attr( $icon ) ?>"></i>
			<?php endif; ?>
			<?php echo esc_html( $title ) ?>
		</a>
		<?php
		$output = ob_get_contents();
		ob_clean();

		return $output;
	}

}
