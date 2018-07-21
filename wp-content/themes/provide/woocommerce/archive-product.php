<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$h = new provide_Helper;
$h->provide_header();
$options = $h->provide_opt();

if(get_post_meta(get_option('woocommerce_shop_page_id'), 'metaHeader', true) == 'on') {
    $show_banner = get_post_meta(get_option('woocommerce_shop_page_id'), 'show_banner', true);
    $bg = get_post_meta(get_option('woocommerce_shop_page_id'), 'metaHeaderBg', true);
    $pagetitle = (get_post_meta(get_the_title(get_option('woocommerce_shop_page_id')), 'metaHeaderTitle', true));
    $sidebar = get_post_meta(get_option('woocommerce_shop_page_id'), 'metaSidebar', true);
    $layout = get_post_meta(get_option('woocommerce_shop_page_id'), 'metaSidebarLayout', true);
}else {
    $show_banner = 'off';
    $bg = '';
    $pagetitle = '';
    $sidebar = '';
    $layout = 'full';
}

if($show_banner == 'on') {
    $h->provide_banner($pagetitle, $bg);
}

$cols = ($layout != 'full' && is_active_sidebar($sidebar)) ? 'col-md-9 column' : 'col-md-12 column';
provide_Media::provide_singleton()->provide_eq(array('provide-isotope'));
?>

    

<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <?php if($layout == 'left' && is_active_sidebar($sidebar)) : ?>
                    <aside class="col-md-3 column">
                        <?php dynamic_sidebar($sidebar); ?>
                    </aside>
                <?php endif; ?>
                
                    <div class="<?php echo esc_attr($cols); ?>">
                        
                    <?php 
                        if (have_posts()) : 
                            ?>
                            <div class="filter-bar">
                                <?php
                            /**
                             * woocommerce_before_shop_loop hook.
                             *
                             * @hooked wc_print_notices - 10
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action('woocommerce_before_shop_loop');
                            ?>
                            </div>
                        
                            <?php
                            woocommerce_product_loop_start();
                            woocommerce_product_subcategories();
                            while (have_posts()) : the_post();
                                /**
                                 * woocommerce_shop_loop hook.
                                 *
                                 * @hooked WC_Structured_Data::generate_product_data() - 10
                                 */
                                do_action('woocommerce_shop_loop');
                                if($h->provide_set($options, 'product_style') != 'grid') {
                                    wc_get_template_part('content', 'masonary_product');
                                }else {
                                    wc_get_template_part('content', 'product');
                                }
                            endwhile; // end of the loop. 

                            woocommerce_product_loop_end(); 
                            /**
                             * woocommerce_after_shop_loop hook.
                             *
                             * @hooked woocommerce_pagination - 10
                             */
                            //do_action('woocommerce_after_shop_loop');
                        elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : 
                                /**
                                 * woocommerce_no_products_found hook.
                                 *
                                 * @hooked wc_no_products_found - 10
                                 */
                                do_action('woocommerce_no_products_found');
   

                        endif;
                                /**
                                 * woocommerce_after_main_content hook.
                                 *
                                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                                 */
                                do_action('woocommerce_after_main_content');
                           
                    ?>
                    
                    </div>
                    
                
                <?php if($layout == 'right' && is_active_sidebar($sidebar)) : ?>
                    <aside class="col-md-3 column">
                        <?php dynamic_sidebar($sidebar); ?>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php 
$script = '
    jQuery(document).ready(function() {
        jQuery(".view-btn-hover").on("click", function() {
            var productID = jQuery(this).attr("data-productid");
            var data = "action=quickView&productID="+productID;
            jQuery.ajax({
                data: data,
                url : provide.ajaxurl,
                type: "POST",
                success: function(response) {
                    jQuery("body").append(response);
                }
            });
            
        });
        return false;
    });
';
wp_add_inline_script("provide-script", $script);

?>
<?php get_footer('shop'); ?>
