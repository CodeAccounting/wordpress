<?php
/*
 * Template Name:   Testimonial Listing
 * */
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop( get_the_ID() );
$column = $h->provide_column( get_the_ID() );
$blog   = new provide_blog();
$i      = new provide_Imagify();
if ( $column == 'col-md-12' ) {
	$innerCol = 'col-md-4';
} else if ( $column == 'col-md-9' ) {
	$innerCol = 'col-md-6';
}
$sizes = array( 'm' => '70x70', 'i' => '70x70', 'w' => '70x70' );
?>
	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<?php $h->provide_themeLeftSidebar( get_the_ID() ) ?>
					<div class="<?php echo esc_attr( $column ) ?> pro-col">
						<?php
						$args  = array(
							'post_type'           => 'pr_testimonial',
							'post_status'         => 'publish',
							'posts_per_page'      => ( $h->provide_set( $opt, 'optTestimonialPagination' ) != '' ) ? $h->provide_set( $opt, 'optTestimonialPagination' ) : get_option( 'posts_per_page' ),
							'ignore_sticky_posts' => false,
							'paged'               => ( isset( $wp_query->query['paged'] ) ) ? $wp_query->query['paged'] : 1,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							?>
							<div class="testimonail-page">
								<div class="row">
									<?php
									while ( $query->have_posts() ) {
										$query->the_post();
										$content = $h->provide_m( 'metaContent' );
										$avatar  = $h->provide_m( 'metaBG' );
										$address = $h->provide_m( 'metaAddress' );
										if ( ! empty( $avatar ) ) {
											$src = $i->provide_thumb( $sizes, false, array( true, true, true ), $avatar, 'c', true );
										}
										?>
										<div class="<?php echo esc_attr( $innerCol ) ?>">
											<div class="testimonial-slide">
												<blockquote>&quot;<?php echo esc_html( $content ) ?>&quot;</blockquote>
												<div class="client-info"><h5><?php the_title() ?></h5> <span><?php echo esc_html( $address ) ?></span></div>
												<?php if ( ! empty( $avatar ) ): ?>
													<img src="<?php echo esc_url( $src ) ?>" alt=""/>
												<?php endif; ?>
											</div>

										</div>
										<?php
									}
									$h->provide_pagi( array( 'total' => $query->max_num_pages ) );
									wp_reset_postdata();
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php $h->provide_themeRightSidebar( get_the_ID() ) ?>
				</div>
			</div>
		</div>
	</section>
<?php
get_footer();
