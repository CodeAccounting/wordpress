<?php

class provide_fun_fact_with_newsletter_VC_ShortCode extends provide_VC_ShortCode {
	static $counter = 0;

	public static function provide_fun_fact_with_newsletter( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Fun Fact With Newsletter", 'provide' ),
				"base"     => "provide_fun_fact_with_newsletter_output",
				"icon"     => 'provide_fun_fact_with_newsletter_output.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "un_toggle",
						"heading"     => esc_html__( "Newsletter Box", 'provide' ),
						"param_name"  => "newsletter",
						'value'       => 'off',
						'default_set' => false,
						'options'     => array(
							'on' => array(
								'on'  => esc_html__( 'Yes', 'provide' ),
								'off' => esc_html__( 'No', 'provide' ),
							),
						),
						"description" => esc_html__( "Enable Newsletter Box.", 'provide' ),
					),
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Counter Style", 'provide' ),
						"param_name"  => "counter_style",
						"value"       => array(
							esc_html__( 'Light', 'provide' ) => '',
							esc_html__( 'Dark', 'provide' )  => 'style2',
						),
						"description" => esc_html__( "Select style from the list", 'provide' )
					),
					array(
						'type'                    => 'param_group',
						"heading"                 => esc_html__( 'Fun Facts', 'provide' ),
						'param_name'              => 'fun_facts',
						"show_settings_on_create" => true,
						'params'                  => array(
							array(
								"type"        => "textfield",
								"heading"     => esc_html__( 'Fun Fact Number', 'provide' ),
								"param_name"  => "fn_number",
								"description" => esc_html__( 'Enter the number for this fun fact', 'provide' )
							),
							array(
								"type"        => "textfield",
								"heading"     => esc_html__( 'FunFact Name', 'provide' ),
								"param_name"  => "fu_name",
								"description" => esc_html__( 'Enter the name of this fun fact', 'provide' )
							),
							array(
								"type"        => "attach_image",
								"heading"     => esc_html__( "Icon ", 'provide' ),
								"param_name"  => "fu_icon",
								"description" => esc_html__( "Upload transparent icon image for this fun fact.", 'provide' )
							)
						)
					),
				)
			);

			return apply_filters( 'provide_fun_fact_with_newsletter_output', $return );
		}
	}

	public static function provide_fun_fact_with_newsletter_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		provide_Media::provide_singleton()->provide_eq( array( 'provide-counter' ) );
		ob_start();
		$funFacts = json_decode( urldecode( $fun_facts ) );
		if ( ! empty( $funFacts ) && count( $funFacts ) > 0 ) {
			?>
            <div class="provide-counters <?php echo esc_attr( $counter_style ) ?>">
                <div class="row">
					<?php
					foreach ( $funFacts as $f ):
						$imgSrc = wp_get_attachment_image_src( $h->provide_set( $f, 'fu_icon' ), 'full' );
						?>
                        <div class="col-md-3">
                            <div class="counter">
								<?php if ( $h->provide_set( $imgSrc, '0' ) != '' ): ?>
                                    <img src="<?php echo esc_url( $h->provide_set( $imgSrc, '0' ) ) ?>" alt=""/>
								<?php endif; ?>
                                <div class="counter-inner">
                                    <strong class="count"><?php echo esc_html( $h->provide_set( $f, 'fn_number' ) ) ?></strong>
                                    <span><?php echo esc_html( $h->provide_set( $f, 'fu_name' ) ) ?></span>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
			<?php
			$jsOutput = "jQuery('.count').counterUp({
                            time: 1000
                        });";
			wp_add_inline_script( 'provide-counter', $jsOutput );
		}
		if ( $newsletter == 'on' ) {
			$opt    = $h->provide_opt();
			$apiKey = $h->provide_set( $opt, 'optMailchimpApiKey' );
			$listId = $h->provide_set( $opt, 'optMailchimpListId' );
			?>
            <div class="newsletter">
				<?php if ( empty( $apiKey ) && empty( $listId ) ) {
					echo '<p>' . esc_html__( 'Please Enter MailChimp API key & List id in theme options', 'provide' ) . '</p>';
				} else {
					?>
                    <div class="log"></div>
                    <form id="funfact_newletter">
                        <input id="newsletter_email" type="text" placeholder="<?php esc_html_e( 'Subscribe to our newsletter', 'provide' ) ?>" autocomplete="off"/>
                        <button id="funfact_newletter_button"><i class="fa fa-paper-plane"></i></button>
                    </form>
					<?php
				}
				?>
            </div>
			<?php
		}
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
