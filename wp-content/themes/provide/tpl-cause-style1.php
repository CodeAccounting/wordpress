<?php
/*
 * Template Name:   Cause Listing Style 1
 * */
$h = new rescue_Helper();
$h->rescue_header();
$opt = $h->rescue_opt();
$h->rescue_headerTop( get_the_ID() );
$column = $h->rescue_column( get_the_ID() );
$blog   = new rescue_blog();
$i      = new rescue_Imagify();
if ( $column == 'col-md-12' ) {
	$innerCol = 'col-md-4';
} else {
	$innerCol = 'col-md-6';
}

if ( $column == 'col-md-12' ) {
	$sizes = array( 'm' => '322x235', 'i' => '715x521', 'w' => '350x255' );
} else if ( $column == 'col-md-9' ) {
	$sizes = array( 'm' => '322x235', 'i' => '715x521', 'w' => '540x255' );
}
wp_enqueue_script( array( 'rescue-isotope' ) );
?>
    <section>
        <div class="block gray">
            <div class="container">
                <div class="row">
					<?php $h->rescue_themeLeftSidebar( get_the_ID() ) ?>
                    <div class="<?php echo esc_attr( $column ) ?>">
						<?php
						$args  = array(
							'post_type'           => 'res-cause',
							'post_status'         => 'publish',
							'posts_per_page'      => ( $h->rescue_set( $opt, 'optPortfolioPagination' ) != '' ) ? $h->rescue_set( $opt, 'optPortfolioPagination' ) : get_option( 'posts_per_page' ),
							'ignore_sticky_posts' => false,
							'paged'               => ( isset( $wp_query->query['paged'] ) ) ? $wp_query->query['paged'] : 1,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							?>
                            <div class="remove-ext">
                                <div class="row">
                                    <div class="masonry">
										<?php
										while ( $query->have_posts() ) {
											$query->the_post();
											$noThumb  = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : '';
											$donation = $h->rescue_m( 'metaDonation' );
											?>
                                            <div class="<?php echo esc_html( $innerCol ) ?> flt-itm tb1 tb2">
                                                <div class="cause-box1 style2">
                                                    <div class="cause-thumb">
                                                        <a href="<?php the_permalink() ?>" title="" itemprop="url">
															<?php
															if ( has_post_thumbnail() ) {
																echo wp_kses( $i->rescue_thumb( $sizes, true, array( true, true, true ) ), true );
															}
															?>
                                                        </a>
                                                    </div>
                                                    <div class="cause-info">
                                                        <h2 itemprop="headline"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" itemprop="url"><?php the_title() ?></a></h2>
                                                        <span class="cate"><a href="#" title="" itemprop="url">Eco</a>, <a href="#" title="" itemprop="url">Energy</a>, <a href="#" title="" itemprop="url">Solar</a></span>
                                                        <p itemprop="description"><?php echo wp_trim_words( get_the_content(), 10, '' ) ?></p>
                                                        <span class="dnt-gl"><?php esc_html_e( 'Donation Goal:', 'rescue' ) ?> <span class="price"><?php echo esc_html( $donation ) ?></span></span>
                                                    </div>
                                                </div>
                                            </div>
											<?php
										}
										?>
                                    </div>
									<?php
									$h->rescue_pagi( array( 'total' => $query->max_num_pages ) );
									wp_reset_postdata();
									?>
                                </div>
                            </div>
							<?php
						}
						?>
                    </div>
					<?php $h->rescue_themeRightSidebar( get_the_ID() ) ?>
                </div>
            </div>
        </div>
    </section>
<?php
$h->rescue_pageFooter();
get_footer();
