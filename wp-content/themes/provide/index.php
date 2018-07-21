<?php
$provide_h = new provide_Helper();
$provide_h->provide_header();
$provide_opt = $provide_h->provide_opt();
$provide_h->provide_headerTop( get_the_ID() );
$provide_blog           = new provide_blog();
$provide_queried_object = get_queried_object();
if ( $provide_h->provide_set( $provide_queried_object, 'ID' ) ) {
	$provide_id      = $provide_h->provide_set( $provide_queried_object, 'ID' );
	$provide_status  = ( get_post_meta( $provide_id, 'metaHeader', true ) ) ? get_post_meta( $provide_id, 'metaHeader', true ) : $provide_h->provide_set( $provide_opt, 'optBlogHeader' );
	$provide_title   = ( get_post_meta( $provide_id, 'metaHeaderTitle', true ) ) ? get_post_meta( $provide_id, 'metaHeaderTitle', true ) : $provide_h->provide_set( $provide_opt, 'optBlogHeaderTitle' );
	$provide_sidebar = ( get_post_meta( $provide_id, 'metaSidebar', true ) ) ? get_post_meta( $provide_id, 'metaSidebar', true ) : "";
	$provide_layout  = ( get_post_meta( $provide_id, 'metaSidebarLayout' ) ) ? get_post_meta( $provide_id, 'metaSidebarLayout', true ) : "";
	$provide_column  = ( $provide_layout == "full" || $provide_layout == "none" ) ? "col-md-12" : 'col-md-9';
	$provide_bg      = ( get_post_meta( $provide_id, 'metaHeaderBg', true ) ) ? get_post_meta( $provide_id, 'metaHeaderBg', true ) : $provide_h->provide_set( $provide_h->provide_set( $provide_opt, 'optBlogHeaderBg' ), 'url' );
	$provide_theme   = $provide_h->provide_set( $provide_opt, 'optBlogTheme' );
} else {
	$provide_status  = ( $provide_h->provide_set( $provide_opt, 'optBlogHeader' ) ) ? $provide_h->provide_set( $provide_opt, 'optBlogHeader' ) : 'on';
	$provide_title   = ( $provide_h->provide_set( $provide_opt, 'optBlogHeaderTitle' ) ) ? $provide_h->provide_set( $provide_opt, 'optBlogHeaderTitle' ) : esc_html__( "Blog Posts", 'provide' );
	$provide_sidebar = ( $provide_h->provide_set( $provide_opt, 'optBlogSidebar' ) ) ? $provide_h->provide_set( $provide_opt, 'optBlogSidebar' ) : "primary-widget-area";
	$provide_layout  = ( $provide_h->provide_set( $provide_opt, 'optBlogLayout' ) ) ? $provide_h->provide_set( $provide_opt, 'optBlogLayout' ) : "right";
	$provide_column  = ( $provide_layout == "full" || $provide_layout == "none" ) ? "col-md-12" : 'col-md-9';
	$provide_bg      = '';
	$provide_theme   = $provide_h->provide_set( $provide_opt, 'optBlogTheme' );
}
if ( $provide_status == 'on' || $provide_status == '1' ):
	$i = new provide_Imagify();
	$sizes              = array( 'm' => '545x211', 'i' => '1001x211', 'w' => '1600x209' );
	if ( ! empty( $provide_bg ) ) {
		$provide_bgUrl = $i->provide_thumb( $sizes, false, array( true, true, true ), $provide_bg, 'c', true );
	} else {
		$provide_bgUrl = '';
	}
	$headerTransparent = $provide_h->provide_set( $provide_opt, 'optHeaderTransparent' );
	if ( $headerTransparent == '1' && $provide_h->provide_set( $provide_opt, 'optHeaderStyle' ) == '1' ) {
		$extraGap = 'extra-gap';
	} else {
		$extraGap = '';
	}
	?>
	<div class="pagetop <?php echo esc_attr( $extraGap ) ?>" style="background: url(<?php echo esc_url( $provide_bgUrl ) ?>) no-repeat scroll 0 0 / cover transparent">
		<div class="container">
			<?php
			if ( ! empty( $provide_title ) ):?>
				<h1><?php echo wp_kses( $provide_title, true ) ?></h1>
				<?php
			endif;
			if($provide_opt['optBreadcumbSetting'] == '1'){
				if ( function_exists( 'provide_breadcrumb' ) ) {
					new provide_WP_Breadcrumb();
				}
			}
			?>
		</div>
	</div>
	<?php
endif;
?>
	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<?php
					if ( $provide_layout == 'left' && ! empty( $provide_sidebar ) && is_active_sidebar( $provide_sidebar ) ) {
						echo '<div class="col-md-3"><div class="sidebar"> ';
						dynamic_sidebar( $provide_sidebar );
						echo '</div></div>';
					}
					?>
					<div class="<?php echo esc_attr( $provide_column ) ?> pro-col">
						<?php
						if ( $provide_theme == 'style1' ) {
							$provide_blog->provide_imageCoverBlogStyle();
						} else if ( $provide_theme == 'style2' ) {
							$provide_blog->provide_gridBlogStyle();
						} else if ( $provide_theme == 'style3' ) {
							$provide_blog->provide_listBlogStyle();
						}
						?>
					</div>
					<?php
					if ( $provide_layout == 'right' && ! empty( $provide_sidebar ) && is_active_sidebar( $provide_sidebar ) ) {
						echo '<div class="col-md-3"><div class="sidebar">';
						dynamic_sidebar( $provide_sidebar );
						echo '</div></div>';
					}
					?>
				</div>
			</div>
		</div>
	</section>
<?php
get_footer();
