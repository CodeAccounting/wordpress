<?php

class provide_toggles_VC_ShortCode extends provide_VC_ShortCode {

	static $counter = 0;

	public static function provide_toggles( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"                    => esc_html__( "Toggles", 'provide' ),
				"base"                    => "provide_toggles_output",
				"icon"                    => 'provide_toggles_output.png',
				"category"                => esc_html__( 'Provide', 'provide' ),
				"as_parent"               => array( 'only' => 'provide_toggles_block_output' ),
				"content_element"         => true,
				"show_settings_on_create" => true,
				"is_container"            => true,
				"params"                  => array(
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Style:", 'provide' ),
						"param_name"  => "style",
						"value"       => array(
							__( 'Style 1', 'provide' )                            => 'toggle',
							__( 'Dark & Gray Style 1', 'provide' )                => 'toggle toggle-style2',
							__( 'Dark & Gray Style 2', 'provide' )                => 'toggle toggle-style3',
							__( 'Coloured & Light Gray Strip', 'provide' )        => 'toggle toggle-style4',
							__( 'Coloured & Dark Gray Strip', 'provide' )         => 'toggle toggle-style4 toggle-style5',
							__( 'Simple White With Coloured Buttons', 'provide' ) => 'toggle toggle-style4 toggle-style6',
							__( 'Simple White With Coloured Border', 'provide' )  => 'toggle toggle-style7',
							__( 'Fully Coloured with dark Strip', 'provide' )     => 'toggle toggle-style8',
							__( 'Fully Coloured with Gray Strip', 'provide' )     => 'toggle toggle-style8 toggle-style9',
						),
						"description" => esc_html__( "Select the style for this toggle.", 'provide' )
					)
				)
			);

			return apply_filters( 'provide_toggles_output', $return );
		}
	}

	public static function provide_toggles_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		global $toggles;
		$toggles = array();
		do_shortcode( $content );
		$count = count( $toggles );
		?>
		<div class="<?php echo esc_attr( $style ) ?>" id="toggle<?php echo esc_attr( self::$counter ) ?>">
			<?php
			if ( $count > 0 ) {
				$counter = 0;
				foreach ( $toggles as $toggle ) {
					$active = ( $counter == 0 ) ? 'active' : '';
					?>
					<div class="toggle-item <?php echo esc_attr( $active ) ?>">
						<h2 class="<?php echo esc_attr( $active ) ?>">
							<i class="<?php echo esc_attr( $h->provide_set( $toggle, 'icon' ) ) ?>"></i>
							<?php echo esc_html( $h->provide_set( $toggle, 'title' ) ) ?>
							<?php if ( $style == 'toggle' || $style == 'toggle toggle-style2' || $style == 'toggle toggle-style3' ): ?>
								<span><i class="fa fa-angle-up"></i></span>
							<?php endif; ?>
						</h2>
						<div class="content">
							<div class="simple-text">
								<p><?php echo esc_html( $h->provide_set( $toggle, 'content' ) ) ?></p>
							</div>
						</div>
					</div>
					<?php
					$counter ++;
				}
			}
			?>
		</div>
		<?php ob_start(); ?>
		jQuery(document).ready(function ($) {
		'use strict';

		$('#toggle<?php echo esc_js( self::$counter ) ?> .content').hide();
		$('#toggle<?php echo esc_js( self::$counter ) ?> h3:first').addClass('active').next().slideDown(500).parent().addClass("activate");
		$('#toggle<?php echo esc_js( self::$counter ) ?> h3').on("click", function () {
		if ($(this).next().is(':hidden')) {
		$('#toggle<?php echo esc_js( self::$counter ) ?> h3').removeClass('active').next().slideUp(500).removeClass('animated zoomIn').parent().removeClass("activate");
		$(this).toggleClass('active').next().slideDown(500).addClass('animated zoomIn').parent().toggleClass("activate");
		return false;
		}
		});
		});
		<?php
		$jsOutput = ob_get_contents();
		ob_end_clean();
		wp_add_inline_script( 'provide-script', $jsOutput );
		self::$counter ++;
		$output = ob_get_contents();
		ob_clean();

		return $output;
	}

}
