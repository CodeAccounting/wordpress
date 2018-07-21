<?php
require_once get_template_directory() . '/app/init.php';
provide_ThemeInit::provide_singleton()->init();


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);



add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 15);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 30);

//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


//add_filter('woocommerce_add_to_cart_fragments', 'provide_add_to_cart_ajax_btn');
function provide_add_to_cart_ajax_btn($fragments) { 
        global $woocommerce;
        ob_start();
    ?>
        
        <span class="cart-lists-btn">
            <?php echo esc_html__('Cart :', 'provide'); ?>  
            <strong><?php echo "( ".WC()->cart->get_cart_total()." ) "; ?></strong>
        </span>
        
    <?php 
        (new provide_Helper())->provide_cart_dropdown(); 
        $fragments['.cart-lists-btn'] = ob_get_clean();
        return $fragments;
    }