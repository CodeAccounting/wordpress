<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$h = new provide_Helper;
$h->provide_header();
$options = $h->provide_opt();

if(get_post_meta(get_the_ID(), 'show_banner', true) == 'on') {
    $show_banner = get_post_meta(get_the_ID(), 'show_banner', true);
    $bg = get_post_meta(get_the_ID(), 'header_bg', true);
    $pagetitle = get_the_title(get_the_ID());
}else {
    $show_banner = $h->provide_set($options, 'show_product_single_banner');
    $pagetitle = $h->provide_set($options, 'product_single_title');
    $bg = $h->provide_set($h->provide_set($options, 'product_single_banner'), 'url');
}

if($show_banner == 'on' || $show_banner) {
    $h->provide_banner($pagetitle, $bg);
}

?>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
        <?php while ( have_posts() ) : the_post(); ?>

                <?php wc_get_template_part( 'content', 'single-product' ); ?>

        <?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
                
            </div>
        </div>
    </div>
</section>
<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
