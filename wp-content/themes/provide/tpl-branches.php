<?php
/*
 * Template Name:   Branches Listing
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
if ( $column == 'col-md-12' ) {
	$sizes = array( 'm' => '322x171', 'i' => '343x181', 'w' => '370x196' );
} else if ( $column == 'col-md-9' ) {
	$sizes = array( 'm' => '267x135', 'i' => '720x364', 'w' => '420x196' );
}
?>
	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<?php $h->provide_themeLeftSidebar( get_the_ID() ) ?>
					<div class="<?php echo esc_attr( $column ) ?> pro-col">
						<?php
						$args  = array(
							'post_type'           => 'pr_branches',
							'post_status'         => 'publish',
							'posts_per_page'      => ( $h->provide_set( $opt, 'optBranchesPagination' ) != '' ) ? $h->provide_set( $opt, 'optBranchesPagination' ) : get_option( 'posts_per_page' ),
							'ignore_sticky_posts' => false,
							'paged'               => ( isset( $wp_query->query['paged'] ) ) ? $wp_query->query['paged'] : 1,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							?>
							<div class="provide-branches">
								<div class="row">
									<?php
									while ( $query->have_posts() ) {
										$query->the_post();
										$noThumb      = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : '';
										$contactTime  = $h->provide_m( 'metaContactTime' );
										$contactEmail = $h->provide_m( 'metaContactEmail' );
										$address      = $h->provide_m( 'metaAddress' );
										?>
										<div class="<?php echo esc_attr( $innerCol ) ?>">
											<div class="branch">
												<div class="branch-img <?php echo esc_attr( $noThumb ) ?>">
													<?php
													if ( has_post_thumbnail() ) {
														echo wp_kses( $i->provide_thumb( $sizes, true, array( true, true, true ) ), true );
													}
													?>
												</div>
												<h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
												<?php if ( ! empty( $contactTime ) || ! empty( $contactEmail ) ): ?>
													<ul>
														<?php if ( ! empty( $contactTime ) ): ?>
															<li>
																<strong><?php esc_html_e( 'Contact Time', 'provide' ) ?></strong><span><?php echo esc_html( $contactTime ) ?></span>
															</li>
														<?php endif; ?>
														<?php if ( ! empty( $contactEmail ) ): ?>
															<li>
																<strong><?php esc_html_e( 'Contact Email', 'provide' ) ?></strong><span><?php echo esc_html( $contactEmail ) ?></span>
															</li>
														<?php endif; ?>
													</ul>
													<?php
												endif;
												if ( $h->provide_set( $address, 'address' ) != '' ):
													?>
													<span class="add"><i class="fa fa-map-marker"></i> <?php echo esc_html( $h->provide_set( $address, 'address' ) ) ?></span>
												<?php endif; ?>
											</div><!-- Branch -->
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
