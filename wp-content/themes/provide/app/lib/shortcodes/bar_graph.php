<?php

class provide_bar_graph_VC_ShortCode extends provide_VC_ShortCode {
	static $counter = 0;

	public static function provide_bar_graph( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Bar Graph", 'provide' ),
				"base"     => "provide_bar_graph_output",
				"icon"     => 'provide_bar_graph_output.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						'type'                    => 'param_group',
						"heading"                 => esc_html__( 'Graph Value', 'provide' ),
						'param_name'              => 'bar_graph',
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								"type"        => "dropdown",
								"heading"     => esc_html__( 'Graph Data', 'provide' ),
								"param_name"  => "graph_data",
								"value"       => array(
									esc_html__( 'MON', 'rescue' ) => 'MON',
									esc_html__( 'TUE', 'rescue' ) => 'TUE',
									esc_html__( 'WED', 'rescue' ) => 'WED',
									esc_html__( 'THU', 'rescue' ) => 'THU',
									esc_html__( 'FRI', 'rescue' ) => 'FRI',
									esc_html__( 'SAT', 'rescue' ) => 'SAT',
									esc_html__( 'SUN', 'rescue' ) => 'SUN'
								),
								"description" => esc_html__( 'Select value from the drop down', 'provide' )
							),
							array(
								"type"        => "un-number",
								"heading"     => esc_html__( 'First Value', 'provide' ),
								"param_name"  => "f_val",
								"description" => esc_html__( 'Enter the First  value', 'provide' )
							),
							array(
								"type"        => "un-number",
								"heading"     => esc_html__( 'End Value', 'provide' ),
								"param_name"  => "e_val",
								"description" => esc_html__( 'Enter the end value', 'provide' )
							),
						)
					),
				)
			);

			return apply_filters( 'provide_bar_graph_output', $return );
		}
	}

	public static function provide_bar_graph_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		$graph = json_decode( urldecode( $bar_graph ) );
		if ( ! empty( $graph ) && count( $graph ) > 0 ) {
			provide_Media::provide_singleton()->provide_eq( array( 'morris' ) );
			echo '<div class="graph" id="bar_graph' . self::$counter . '"></div>';
			$data = '';
			foreach ( $graph as $g ) {
				$data .= "{x: '" . $h->provide_set( $g, 'year' ) . "', y: " . $h->provide_set( $g, 's_val' ) . ", z: " . $h->provide_set( $g, 'e_val' ) . "}," . PHP_EOL;
			}
			$jsOutput = "jQuery(function () {
                        Morris.Bar({
                            element: 'bar_graph" . esc_js( self::$counter ) . "',
                            data: [
                                " . $data . "
                            ],
                            xkey: 'x',
	                        ykeys: ['y', 'z'],
                            barColors:['#43b4ae','#e95d53'],
                            hideHover:true,
                            gridTextColor:'#dedddd',
                            gridTextSize:'17',
                            stacked: true,
                            labels: ['" . esc_js( esc_html__( 'Visits', 'provide' ) ) . "', '" . esc_js( esc_html__( 'Profits', 'provide' ) ) . "']
                        });
                    });";
			wp_add_inline_script( 'morris', $jsOutput );
		}
		self::$counter ++;
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
