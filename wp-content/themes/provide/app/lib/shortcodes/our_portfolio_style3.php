<?php

class provide_our_portfolio_style3_VC_ShortCode extends provide_VC_ShortCode {
	static private $counter = 0;

	public static function provide_our_portfolio_style3( $atts = null ) {
		if ( $atts == 'provide_Shortcodes_Map' ) {
			return array(
				"name"     => esc_html__( "Our Portfolio Style 3", 'provide' ),
				"base"     => "provide_our_portfolio_style3_output",
				"icon"     => 'provide_our_portfolio_style3_output.png',
				"category" => esc_html__( 'Provide', 'provide' ),
				"params"   => array(
					array(
						"type"        => "un-number",
						"heading"     => esc_html__( 'Number of Posts', 'provide' ),
						"param_name"  => "number",
						'min'         => '1',
						'max'         => '100',
						'step'        => '1',
						"description" => esc_html__( 'Enter the number of posts to show.', 'provide' )
					),
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Sort By:", 'provide' ),
						"param_name"  => "sorting",
						"value"       => array_flip( array(
								''              => '',
								'random'        => esc_html__( 'Random posts', 'provide' ),
								'asc_title'     => esc_html__( 'Alphabetical A-Z', 'provide' ),
								'desc_title'    => esc_html__( 'Alphabetical Z-A', 'provide' ),
								'author'        => esc_html__( 'Posted by author', 'provide' ),
								'commented'     => esc_html__( 'Most commented posts', 'provide' ),
								'today'         => esc_html__( 'Today posts', 'provide' ),
								'today_rand'    => esc_html__( 'Random posts today', 'provide' ),
								'weekly'        => esc_html__( 'Weekly posts', 'provide' ),
								'weekly_random' => esc_html__( 'Random posts from last 7 days', 'provide' ),
								'upcoming'      => esc_html__( 'Future upcoming posts', 'provide' ),
								'popular'       => esc_html__( 'Most popular posts', 'provide' ),
								'reviewed'      => esc_html__( 'Highest rated (review) posts', 'provide' ),
								'featured'      => esc_html__( 'Featured', 'provide' ),
							)
						),
						"description" => esc_html__( "Choose Sorting by.", 'provide' )
					),
					array(
						"type"        => "un_toggle",
						"heading"     => esc_html__( "View All", 'provide' ),
						"param_name"  => "view_all",
						'value'       => 'off',
						'default_set' => false,
						'options'     => array(
							'on' => array(
								'on'  => esc_html__( 'Yes', 'provide' ),
								'off' => esc_html__( 'No', 'provide' ),
							),
						),
						"description" => esc_html__( "Enable view all bottom bar.", 'provide' ),
					),
					array(
						"type"        => "textfield",
						"heading"     => esc_html__( 'View All Text', 'provide' ),
						"param_name"  => "v_text",
						"description" => esc_html__( 'Enter the text of view all', 'provide' ),
						'dependency'  => array(
							'element' => 'view_all',
							'value'   => array( 'on' )
						),
					),
					array(
						"type"        => "dropdown",
						"heading"     => esc_html__( "Page Link", 'provide' ),
						"param_name"  => "v_link",
						"value"       => array_flip( ( new provide_Helper() )->provide_posts( 'page' ) ),
						"description" => esc_html__( "Select the page for view all portfolio", 'provide' ),
						'dependency'  => array(
							'element' => 'view_all',
							'value'   => array( 'on' )
						),
					),
				)
			);

			return apply_filters( 'provide_our_portfolio_style3_output', $return );
		}
	}

	public static function provide_our_portfolio_style3_output( $atts = null, $content = null ) {
		include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
		ob_start();
		$i         = new provide_Imagify();
		$sizes     = array(
			array( 'm' => '322x292', 'i' => '356x323', 'w' => '334x256' ),
			array( 'm' => '322x292', 'i' => '356x323', 'w' => '672x256' ),
			array( 'm' => '322x292', 'i' => '356x323', 'w' => '334x256' )
		);
		$colsArray = array( 'col-md-3', 'col-md-6', 'col-md-3' );
		$lightBox  = array( 'm' => '94x85', 'i' => '94x85', 'w' => '94x85' );
		$counter   = 0;
		?>
		<div class="projects style2">
			<div class="row">
				<?php
				$args  = array(
					'post_type'           => 'pr_portfolio',
					'post_status'         => 'publish',
					'posts_per_page'      => $number,
					'ignore_sticky_posts' => false,
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					?>
					<div class="projects style3">
						<div class="row">
							<div id="masonary_isotop<?php echo esc_attr( self::$counter ) ?>" class="masonary">
								<?php
								while ( $query->have_posts() ) {
									$query->the_post();
									$noThumb     = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : '';
									$fullSrc     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
									$lightBoxUrl = ( has_post_thumbnail() ) ? $i->provide_thumb( $lightBox, false, array( true, true, true ), $h->provide_set( $fullSrc, '0' ), 'c', true ) : '';
									?>
									<div class="<?php echo esc_attr( $colsArray[ $counter ] ) ?>">
										<div class="provide-project style2<?php echo esc_attr( $noThumb ) ?>">
											<?php
											if ( has_post_thumbnail() ) {
												echo wp_kses( $i->provide_thumb( $sizes[ $counter ], true, array( true, true, true ) ), true );
											}
											?>
											<div class="project-hover">
												<div class="project-links">
													<a href="<?php the_permalink() ?>" title=""><i class="fa fa-link"></i></a>
													<a class="html5lightbox" data-thumbnail="<?php echo esc_url( $lightBoxUrl ) ?>" data-group="set1" title="<?php the_title() ?>" href="<?php echo esc_url( $h->provide_set( $fullSrc, '0' ) ) ?>">
														<i class="fa fa-search"></i>
													</a>
												</div>
												<h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
											</div>
										</div>
									</div>
									<?php
									$counter ++;
									if ( $counter == '3' ) {
										$counter = 0;
									}
								}
								wp_reset_postdata();
								?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		if ( $view_all == 'on' ):
			$link = ( ! empty( $v_link ) ) ? get_page_link( $v_link ) : '';
			?>
			<a class="huge-btn style2" href="<?php echo esc_url( $link ) ?>" title=""><?php echo esc_html( $v_text ) ?> <i class="fa fa-arrows-h"></i></a>
			<?php
		endif;

		provide_Media::provide_singleton()->provide_eq( array( 'html5lightbox', 'provide-isotope' ) );
		$jsOutput = "jQuery(window).load(function(){
            setTimeout(function(){
                jQuery('#masonary_isotop" . esc_js( self::$counter ) . "').isotope('destroy');
                //jQuery('#masonary_isotop" . esc_js( self::$counter ) . "').isotope(); 
            }, 1000);
            setTimeout(function(){
                //jQuery('#masonary_isotop" . esc_js( self::$counter ) . "').isotope('destroy');
                jQuery('#masonary_isotop" . esc_js( self::$counter ) . "').isotope(); 
            }, 1200);
        })";
		//wp_add_inline_script( 'provide-isotope', $jsOutput );
		self::$counter ++;
		$output = ob_get_contents();
		ob_clean();

		return do_shortcode( $output );
	}

}
