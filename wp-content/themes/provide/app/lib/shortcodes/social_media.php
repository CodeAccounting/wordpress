<?php

class provide_social_media_VC_ShortCode extends provide_VC_ShortCode {

	public static function provide_social_media( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Social Media", 'provide' ),
				"base"     => "provide_social_media_output",
				"icon"     => 'provide_social_media_output.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Style:", 'provide' ),
						"param_name"  => "style",
						"value"       => array(
							esc_html__( 'Social Square Gray', 'provide' )             => 'socialmedia-btns social-square light-social',
							esc_html__( 'Social Square Dark', 'provide' )             => 'socialmedia-btns social-square dar-bg-social',
							esc_html__( 'Social Square Dark Border', 'provide' )      => 'socialmedia-btns social-square dar-bor-social',
							esc_html__( 'Social Square Mono BG', 'provide' )          => 'socialmedia-btns social-square thm-social',
							esc_html__( 'Social Square Colored Border', 'provide' )   => 'socialmedia-btns social-square col-bor-social',
							esc_html__( 'Social Square Colored BG', 'provide' )       => 'socialmedia-btns social-square col-bg-social',
							esc_html__( 'Social Circular Gray', 'provide' )           => 'socialmedia-btns social-radius light-social',
							esc_html__( 'Social Circular Dark', 'provide' )           => 'socialmedia-btns social-radius dar-bg-social',
							esc_html__( 'Social Circular Dark Border', 'provide' )    => 'socialmedia-btns social-radius dar-bor-social',
							esc_html__( 'Social Circular Mono BG', 'provide' )        => 'socialmedia-btns social-radius thm-social',
							esc_html__( 'Social Circular Colored Border', 'provide' ) => 'socialmedia-btns social-radius col-bor-social',
							esc_html__( 'Social Circular Colored BG', 'provide' )     => 'socialmedia-btns social-radius col-bg-social',
							esc_html__( 'Social Leaf Gray', 'provide' )               => 'socialmedia-btns social-halfradius light-social',
							esc_html__( 'Social Leaf Dark', 'provide' )               => 'socialmedia-btns social-halfradius dar-bg-social',
							esc_html__( 'Social Leaf Dark Border', 'provide' )        => 'socialmedia-btns social-halfradius dar-bor-social',
							esc_html__( 'Social Leaf Mono BG', 'provide' )            => 'socialmedia-btns social-halfradius thm-social',
							esc_html__( 'Social Leaf Colored Border', 'provide' )     => 'socialmedia-btns social-halfradius col-bor-social',
							esc_html__( 'Social Leaf Colored BG', 'provide' )         => 'socialmedia-btns social-halfradius col-bg-social',
						),
						"description" => esc_html__( "Select the style of the social media.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Facebook:", 'provide' ),
						"param_name"  => "fb",
						"description" => esc_html__( "Enter facebook link.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Google Plus:", 'provide' ),
						"param_name"  => "gp",
						"description" => esc_html__( "Enter google plus link.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Twitter:", 'provide' ),
						"param_name"  => "tw",
						"description" => esc_html__( "Enter twitter link.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Pinterest:", 'provide' ),
						"param_name"  => "pt",
						"description" => esc_html__( "Enter pinterest link.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Linkedin:", 'provide' ),
						"param_name"  => "lk",
						"description" => esc_html__( "Enter linkedin link.", 'provide' )
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Dribbble:", 'provide' ),
						"param_name"  => "dr",
						"description" => esc_html__( "Enter dribbble link.", 'provide' )
					)
				)
			);

			return apply_filters( 'provide_social_media_output', $return );
		}
	}

	public static function provide_social_media_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		?>
		<div class="socialmedia-div">
			<ul class="<?php echo esc_attr( $style ) ?>">
				<?php if ( ! empty( $fb ) ): ?>
					<li><a href="<?php echo esc_url( $fb ) ?>" title="" class="social-facebook"><i class="fa fa-facebook"></i></a>
					</li><?php endif; ?>
				<?php if ( ! empty( $gp ) ): ?>
					<li><a href="<?php echo esc_url( $gp ) ?>" title="" class="social-google"><i class="fa fa-google-plus"></i></a>
					</li><?php endif; ?>
				<?php if ( ! empty( $tw ) ): ?>
					<li><a href="<?php echo esc_url( $tw ) ?>" title="" class="social-twitter"><i class="fa fa-twitter"></i></a>
					</li><?php endif; ?>
				<?php if ( ! empty( $pt ) ): ?>
					<li><a href="<?php echo esc_url( $pt ) ?>" title="" class="social-pinterest"><i class="fa fa-pinterest-p"></i></a>
					</li><?php endif; ?>
				<?php if ( ! empty( $lk ) ): ?>
					<li><a href="<?php echo esc_url( $lk ) ?>" title="" class="social-linkedin"><i class="fa fa-linkedin"></i></a>
					</li><?php endif; ?>
				<?php if ( ! empty( $dr ) ): ?>
					<li><a href="<?php echo esc_url( $dr ) ?>" title="" class="social-dribbble"><i class="fa fa-dribbble"></i></a>
					</li><?php endif; ?>
			</ul>
		</div>
		<?php
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
