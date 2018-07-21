<?php
/*
 * Template Name:   Team Listing
 * */
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop( get_the_ID() );
$column = $h->provide_column( get_the_ID() );
$blog   = new provide_blog();
$i      = new provide_Imagify();
if ( $column == 'col-md-12' ) {
	$innerCol = 'col-md-3';
} else if ( $column == 'col-md-9' ) {
	$innerCol = 'col-md-4';
}
$sizes = array( 'm' => '322x367', 'i' => '343x391', 'w' => '270x308' );
?>
	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<?php $h->provide_themeLeftSidebar( get_the_ID() ) ?>
					<div class="<?php echo esc_attr( $column ) ?> pro-col">
						<?php
						$args  = array(
							'post_type'           => 'pr_team',
							'post_status'         => 'publish',
							'posts_per_page'      => ( $h->provide_set( $opt, 'optTeamPagination' ) != '' ) ? $h->provide_set( $opt, 'optTeamPagination' ) : get_option( 'posts_per_page' ),
							'ignore_sticky_posts' => false,
							'paged'               => ( isset( $wp_query->query['paged'] ) ) ? $wp_query->query['paged'] : 1,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							?>
							<div class="provide-team">
								<div class="row">
									<?php
									while ( $query->have_posts() ) {
										$query->the_post();
										$noThumb     = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : '';
										$designation = $h->provide_m( 'metaDesignation' );
										$social      = $h->provide_m( 'metaSocialProfiler' );
										?>
										<div class="<?php echo esc_attr( $innerCol ) ?>">
											<div class="provide-member wow flipInY" data-wow-delay="1000ms">
												<div class="member-img <?php echo esc_attr( $noThumb ) ?>">
													<?php
													if ( has_post_thumbnail() ) {
														echo wp_kses( $i->provide_thumb( $sizes, true, array( true, true, true ) ), true );
													}
													?>
													<?php if ( ! empty( $social ) && count( $social ) > 0 ): ?>
														<div class="social">
															<?php
															foreach ( $social as $s ) {
																echo '<a href="' . esc_url( $h->provide_set( $s, 'metaProfileLink' ) ) . '" title=""><i class="fa ' . esc_attr( $h->provide_set( $s, 'metaProfileIcon' ) ) . '"></i></a>';
															}
															?>
														</div>
													<?php endif; ?>
												</div>
												<h4><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
												<i><?php echo esc_html( $designation ) ?></i>
											</div><!-- Member -->
										</div>

										<?php
									}
									?>
								</div>
							</div>
							<?php
							$h->provide_pagi( array( 'total' => $query->max_num_pages ) );
							wp_reset_postdata();
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
