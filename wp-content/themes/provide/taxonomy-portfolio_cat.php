<?php
global $wp_query;
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

if ( $column == 'col-md-12' ) {
	$sizes = array( 'm' => '322x292', 'i' => '356x323', 'w' => '290x263' );
} else if ( $column == 'col-md-9' ) {
	$sizes = array( 'm' => '322x292', 'i' => '356x323', 'w' => '287x261' );
}
$lightBox = array( 'm' => '94x85', 'i' => '94x85', 'w' => '94x85' );
provide_Media::provide_singleton()->provide_eq( array( 'html5lightbox', 'provide-isotope' ) );
?>
	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<?php $h->provide_themeLeftSidebar( get_the_ID() ) ?>
					<div class="<?php echo esc_attr( $column ) ?> pro-col">
						<?php
						if ( have_posts() ) {
							?>
							<div class="projects style3">
								<div class="row">
									<div class="masonary">
										<?php
										while ( have_posts() ) {
											the_post();
											$noThumb     = ( ! has_post_thumbnail() ) ? 'no-thumbnail' : '';
											$gallery     = $h->provide_m( 'metaGallery' );
											$fullSrc     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
											$lightBoxUrl = ( has_post_thumbnail() ) ? $i->provide_thumb( $lightBox, false, array( true, true, true ), $h->provide_set( $fullSrc, '0' ), 'c', true ) : '';
											?>
											<div class="<?php echo esc_attr( $innerCol ) ?>">
												<div class="provide-project style3 wow fadeInDown <?php echo esc_attr( $noThumb ) ?>">
													<?php
													if ( has_post_thumbnail() ) {
														echo wp_kses( $i->provide_thumb( $sizes, true, array( true, true, true ) ), true );
													}
													?>
													<div class="project-hover">
														<h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
														<div class="project-links">
															<a href="<?php the_permalink() ?>" title=""><i class="fa fa-link"></i></a>
															<a class="html5lightbox" data-thumbnail="<?php echo esc_url( $lightBoxUrl ) ?>" data-group="set1" title="<?php the_title() ?>" href="<?php echo esc_url( $h->provide_set( $fullSrc, '0' ) ) ?>">
																<i class="fa fa-search"></i>
															</a>
														</div>
													</div>
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
									$h->provide_pagi( array( 'total' => $wp_query->max_num_pages ) );
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
