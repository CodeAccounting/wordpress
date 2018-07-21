<?php

class provide_simple_product_carousel_VC_ShortCode extends provide_VC_ShortCode {

    public static function provide_simple_product_carousel($atts = NULL) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Simple Product Carousel", 'provide'),
                "base" => "provide_simple_product_carousel_output",
                "icon" => 'provide_simple_product_carousel_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Number of Product', 'provide'),
                        "param_name" => "number",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the number of product to show.', 'provide')
                    ),
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__('Category', 'provide'),
                        "param_name" => "category",
                        "value" => (new provide_Helper())->provide_get_the_terms(array('product_cat')),
                        "description" => esc_html__('Select product category to show', 'provide')
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Sort By:", 'provide'),
                        "param_name" => "sorting",
                        "value" => array_flip(array(
                            'popular' => esc_html__('Popular Products', 'provide'),
                            'best_seller' => esc_html__('Best Selling Products', 'provide'),
                            'by_price' => esc_html__('Sort by Price', 'provide'),
                            'onsale' => esc_html__('OnSale Products', 'provide'),
                            'featued' => esc_html__('Featured Products', 'provide'),
                            'date' => esc_html__('Order by Date', 'provide'),
                            'name' => esc_html__('Order by Name', 'provide'),
                            'rand' => esc_html__('Random Products', 'provide'),
                                )
                        ),
                        "description" => esc_html__("Choose product sorting order.", 'provide')
                    ),
                )
            );
            return apply_filters('provide_simple_product_carousel_output', $return);
        }
    }

    public static function provide_simple_product_carousel_output($atts = NULL, $content = NULL) {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '265x340', 'i' => '265x340', 'w' => '265x340');
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'ignore_sticky_posts' => true,
        );
        $cats = explode(',', $category);
        if (!empty($cats) && $h->provide_set($cats, 0) != '') {
            $args['tax_query'] = array(array('taxonomy' => 'product_cat', 'field' => 'id', 'terms' => (array) $cats));
        }
        $args = array_merge($args, $h->provide_product_orderby($sorting));
        $query = new WP_Query($args);
        ?>

        <?php if($query->have_posts()) : ?>
            <div class="product-carousel">
                <?php 
                    while($query->have_posts()) : $query->the_post(); 
                    global $product;
                ?>
                <div class="product-item wow fadeIn" data-wow-delay="0.1s">
                    <div class="product-item-thumb">
                        <?php echo $i->provide_thumb($sizes, true, array(true, true, true)); ?>
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
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
                        

        <?php
        (new provide_Media())->provide_eq(array('slick'));
        $script = '
            jQuery(document).on("ready", function($) {
                jQuery(".product-carousel").slick({
                    dots: false,
                    arrows: true,
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 2,
                    responsive: [
                    {
                  breakpoint: 980,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 767,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 520,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
              ]
            });
            
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

        });';
        wp_add_inline_script('slick', $script);
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
