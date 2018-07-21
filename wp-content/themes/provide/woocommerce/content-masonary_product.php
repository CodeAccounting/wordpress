<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

$imagify = new provide_Imagify();
$sizes = array('m' => '370x390', 'i' => '370x390', 'w' => '370x390');
global $product;
$h = new provide_Helper();
?>
<div class="col-md-4 col-sm-6 col-xs-6 col-mr-12 wow fadeIn" data-wow-delay="0.1s">
    <div class="product-item">
        <div class="product-item-thumb">
            <?php echo $imagify->provide_thumb($sizes, true, array(true, true, true)); ?>
            <ul>
                <li><?php echo $h->provide_add_to_cart('', '', provide_Uri. 'partial/images/cart-icon.png'); ?></li>
                <li><a class="view-btn-hover quick-view-btn" data-productid="<?php echo get_the_ID(); ?>" title=""><img src="<?php echo esc_url(provide_Uri.'partial/images/view-icon.png'); ?>" alt="" /></a></li>
            </ul>
        </div>
        <div class="product-info">
            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <div class="prices">
                <?php echo balanceTags($product->get_price_html()); ?>
            </div>
        </div>
    </div><!-- Product Item -->
</div>
