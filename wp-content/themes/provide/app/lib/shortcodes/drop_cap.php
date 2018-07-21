<?php

class provide_drop_cap_VC_ShortCode extends provide_VC_ShortCode {

	public static function provide_drop_cap( $atts = null ) {
		$H = new provide_Helper();
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Drop Cap", 'provide' ),
				"base"     => "provide_drop_cap_output",
				"icon"     => 'drop_cap.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( "Drop Cap Word:", 'provide' ),
						"param_name"  => "dp",
						"description" => esc_html__( "Enter the Drop Cap Word.", 'provide' )
					),
					array(
						"type"        => "textarea",
						"heading"     => esc_html__( "Description:", 'provide' ),
						"param_name"  => "desc",
						"description" => esc_html__( "Enter the description for this section.", 'provide' )
					),
					array(
						"type" => "dropdown",

						"heading"     => esc_html__( 'Style', 'provide' ),
						"param_name"  => "style",
						"value"       => array(
							esc_html__( 'Dark Border', 'provide' )            => 'dropcaps-style dropcap-style1',
							esc_html__( 'Mono Border', 'provide' )            => 'dropcaps-style dropcap-style2',
							esc_html__( 'Mono Background', 'provide' )        => 'dropcaps-style dropcap-style3',
							esc_html__( 'Dark Background', 'provide' )        => 'dropcaps-style dropcap-style4',
							esc_html__( 'Verticle Dark Border', 'provide' )   => 'dropcaps-style dropcap-style5',
							esc_html__( 'Verticle Mono Border', 'provide' )   => 'dropcaps-style dropcap-style6',
							esc_html__( 'Dark', 'provide' )                   => 'dropcaps-style dropcap-style7',
							esc_html__( 'Mono', 'provide' )                   => 'dropcaps-style dropcap-style8',
							esc_html__( 'Gray Parallax', 'provide' )          => 'dropcaps-style bg-layer dropcap-style9',
							esc_html__( 'Dark Parallax', 'provide' )          => 'dropcaps-style bg-layer dropcap-style10',
							esc_html__( 'Mono Parallax', 'provide' )          => 'dropcaps-style bg-layer dropcap-style11',
							esc_html__( 'White with Dark Border', 'provide' ) => 'dropcaps-style dropcap-style12',
						),
						"description" => esc_html__( "Select style of this section", 'provide' )
					),
					array(
						"type"        => "attach_image",
						"heading"     => esc_html__( "Image:", 'provide' ),
						"param_name"  => "imgage",
						"description" => esc_html__( "Upload background image.", 'provide' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'dropcaps-style bg-layer dropcap-style9', 'dropcaps-style bg-layer dropcap-style10', 'dropcaps-style bg-layer dropcap-style11' )
						),
					),
				)
			);

			return apply_filters( 'provide_drop_cap_shortcode', $return );
		}
	}

	public static function provide_drop_cap_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		?>
		<div class="callus-toaction">
		<?php
	if ( $style == 'dropcaps-style bg-layer dropcap-style9' || $style == 'dropcaps-style bg-layer dropcap-style10' || $style == 'dropcaps-style bg-layer dropcap-style11' ):
		$bg = wp_get_attachment_image_src( $imgage, 'full' );
		?>
		<div class="<?php echo esc_attr( $style ) ?>"
		     style="background: url(<?php echo esc_url( $h->provide_set( $bg, '0' ) ) ?>)  no-repeat scroll center / cover">
		<?php else: ?>
		<div class="<?php echo esc_attr( $style ) ?>">
	<?php endif; ?>
		<p><strong><?php echo esc_html( $dp ) ?></strong><?php echo esc_html( $desc ) ?></p>
		</div>
		</div>
		<?php
		$output = ob_get_contents();
		ob_clean();

		return $output;
	}

}
	