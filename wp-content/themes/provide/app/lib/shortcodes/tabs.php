<?php

class provide_tabs_VC_ShortCode extends provide_VC_ShortCode {

	static $counter = 0;

	public static function provide_tabs( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"                    => esc_html__( "Tabs", 'provide' ),
				"base"                    => "provide_tabs_output",
				"icon"                    => 'provide_tabs_output.png',
				"category"                => esc_html__( 'Provide', 'provide' ),
				"as_parent"               => array( 'only' => 'provide_tabs_block_output' ),
				"content_element"         => true,
				"show_settings_on_create" => true,
				"is_container"            => true,
				"params"                  => array(
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Style:", 'provide' ),
						"param_name"  => "style",
						"value"       => array(
							esc_html__( 'Tabs With Coloured Buttons In Center', 'provide' ) => 'tabs1 tabs-styles',
							esc_html__( 'Tabs With Buttons On Left Hand', 'provide' )       => 'tabs2 tabs-styles',
							esc_html__( 'Tabs With Creative Style', 'provide' )             => 'tabs3 tabs-styles',
							esc_html__( 'Tabs Verticle With White BG', 'provide' )          => 'tabs4 tabs-styles',
							esc_html__( 'Tabs Verticle With Gray BG', 'provide' )           => 'tabs4 gray-bg tabs-styles',
							esc_html__( 'Tabs Verticle Dark Coloured', 'provide' )          => 'tabs4 bg-img tabs-styles',
						),
						"description" => esc_html__( "Select the style of the tabs.", 'provide' )
					),
					array(
						"type"        => "attach_image",
						"heading"     => esc_html__( "Parrallax Image:", 'provide' ),
						"param_name"  => "background",
						"description" => esc_html__( "Upload image for this style.", 'provide' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'tabs4 bg-img tabs-styles' ),
						),
					)
				)
			);

			return apply_filters( 'provide_tabs_output', $return );
		}
	}

	public static function provide_tabs_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		provide_Media::provide_singleton()->provide_eq( array( 'bootstrap' ) );
		global $shortcode_tabs;
		$shortcode_tabs = array();
		do_shortcode( $content );
		$tabs_nav     = '';
		$tabs_content = '';
		$tabs_count   = count( $shortcode_tabs );
		$i            = 0;
		$i2           = 0;
		$colone       = explode( ' ', $style );
		$last         = self::$counter;
		if ( $style == 'tabs4 bg-img tabs-styles' ) {
			$bg = wp_get_attachment_url( $background, 'full' );
			echo '<div class="' . esc_attr( $style ) . '" style="background: url(' . esc_url( $bg ) . ') no-repeat scroll center / cover">';
		} else {
			echo ' <div class="' . esc_attr( $style ) . '">';
		}
		if ( $tabs_count > 0 ) {
			echo '<ul class="nav nav-tabs">';
			foreach ( $shortcode_tabs as $tab ) {
				$active = ( $i == 0 ) ? 'active' : '';
				?>
				<li class="<?php echo esc_attr( $active ) ?>">
					<a href="#tabs1-tab<?php echo esc_attr( $i . $last ) ?>" data-toggle="tab">
						<i class="<?php echo esc_attr( $h->provide_set( $tab, 'icon' ) ) ?>"></i>
						<?php echo esc_html( $h->provide_set( $tab, 'title' ) ) ?>
					</a>
				</li>
				<?php
				$i ++;
			}
			echo '</ul>';
			echo '<div class="tab-content">';
			foreach ( $shortcode_tabs as $tab ) {
				$active = ( $i2 == 0 ) ? 'in active' : '';
				?>
				<div class="tab-pane fade <?php echo esc_attr( $active ) ?>"
				     id="tabs1-tab<?php echo esc_attr( $i2 . $last ) ?>">
					<p><?php echo esc_html( $h->provide_set( $tab, 'content' ) ) ?></p>
				</div>
				<?php
				$i2 ++;
			}
			echo '</div>';
		}
		echo '</div>';
		self::$counter ++;
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
