<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Get sidebars */
$meta = get_post_meta(get_option('woocommerce_shop_page_id'));
$left_sidebar = false;
$right_sidebar = false;
$num_of_sidebars = 0;

if (isset($meta['sbg_selected_sidebar']) && isset($meta['sbg_selected_sidebar'][0]) && $meta['sbg_selected_sidebar'][0] != '0' ) {
    $left_sidebar = $meta['sbg_selected_sidebar'][0];
    $num_of_sidebars++;
}

if (isset($meta['sbg_selected_sidebar_replacement']) && isset($meta['sbg_selected_sidebar_replacement'][0]) && $meta['sbg_selected_sidebar_replacement'][0] != '0' ) {
    $right_sidebar = $meta['sbg_selected_sidebar_replacement'][0];
    $num_of_sidebars++;
}

/* Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

get_header( 'shop' ); ?>

<div class="container"><div class="row" id="site-content">

	<?php if( $left_sidebar ): ?>
        <aside class="sidebar col-md-3">
            <ul>
                <?php dynamic_sidebar($left_sidebar); wp_reset_query(); ?>
            </ul>
        </aside>   
	<?php endif; ?>

	<section class="col-md-<?php echo 12-$num_of_sidebars*3; ?>">

		<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

		<?php if ( have_posts() ) : ?>

			<div class="woocommerce-before-loop"><?php do_action( 'woocommerce_before_shop_loop' );?></div> 

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>

		<?php
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			//do_action( 'woocommerce_sidebar' );
		?>

	</section>

	<?php if( $right_sidebar ): ?>
        <aside class="sidebar col-md-3">
            <ul>
                <?php dynamic_sidebar($right_sidebar); wp_reset_query(); ?>
            </ul>
        </aside>   
	<?php endif; ?>
</div></div>

<?php get_footer( 'shop' ); ?>