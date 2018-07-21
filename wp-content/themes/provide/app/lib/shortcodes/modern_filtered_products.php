<?php

class provide_modern_filtered_products_VC_ShortCode extends provide_VC_ShortCode {

    public static function provide_modern_filtered_products($atts = NULL) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Modern Filtered Products", 'provide'),
                "base" => "provide_modern_filtered_products_output",
                "icon" => 'provide_modern_filtered_products_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Number of Product', 'provide'),
                        "param_name" => "number",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the number of product to show from each category.', 'provide')
                    ),
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__('Category', 'provide'),
                        "param_name" => "category",
                        "value" => (new provide_Helper())->provide_get_the_terms(array('product_cat')),
                        "description" => esc_html__('Select product category to show in filter', 'provide')
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
            return apply_filters('provide_modern_filtered_products_output', $return);
        }
    }

    public static function provide_modern_filtered_products_output($atts = NULL, $content = NULL) {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $imagify = new provide_Imagify();
        $sizes = array(
            array('m' => '270x348', 'i' => '270x348', 'w' => '270x348'),
            array('m' => '270x348', 'i' => '270x348', 'w' => '270x348'),
            array('m' => '270x348', 'i' => '270x348', 'w' => '570x348'),
            array('m' => '270x348', 'i' => '270x348', 'w' => '570x348'),
            array('m' => '270x348', 'i' => '270x348', 'w' => '270x348'),
            array('m' => '270x348', 'i' => '270x348', 'w' => '270x348'),
        );
        $cols = array(
            'col-md-3 col-sm-6 col-xs-6 col-mr-12', 
            'col-md-3 col-sm-6 col-xs-6 col-mr-12', 
            'col-md-6 col-sm-6 col-xs-6 col-mr-12',
            'col-md-6 col-sm-6 col-xs-6 col-mr-12',
            'col-md-3 col-sm-6 col-xs-6 col-mr-12', 
            'col-md-3 col-sm-6 col-xs-6 col-mr-12'
        );
        $cats = explode(',', $category);
        $counter = 0;
        ?>

      
        <div class="products-filters">
            <?php if(!empty($cats) && !in_array('', $cats)) : ?>
            <section id="options wow fadeIn">
                <div class="option-isotop">
                    <ul id="filter" class="option-set" data-option-key="filter">
                        <li><a href="#all" data-option-value="*" class="selected"><span><?php echo esc_html__("MOST WANTED", "provide"); ?></span></a></li>
                        <?php 
                            foreach($cats as $cat) :
                                $term =get_term($cat);
                                $term_name = $h->provide_set($term, 'name');
                                $term_id = $h->provide_set($term, 'term_id');
                                $term_slug = $h->provide_set($term, 'slug');
                        ?>
                        <li><a href="#term-<?php echo esc_attr($term_id); ?>" data-option-value=".<?php echo esc_attr($term_slug); ?>"><span><?php echo esc_html($term_name); ?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section><!-- FILTER BUTTONS -->
            <?php endif; ?>
            <?php if(!empty($cats)) : ?>
            <div class="row">
                <div class="masonary">
                    <?php 
                        foreach($cats as $cat) : 
                            $args = array(
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'posts_per_page' => $number,
                                'ignore_sticky_posts' => true,
                                'tax_query' => array(
                                    array(
                                      'taxonomy'  =>  'product_cat',
                                      'field'   =>  'id',
                                      'terms'   => $cat,
                                    ),
                                ),
                            );
                            $args = array_merge($args, $h->provide_product_orderby($sorting));
                            $query = new WP_Query($args);
                    
                        while($query->have_posts()) : $query->the_post(); 
                        global $product;
                    ?>
                    <div class="<?php $h->provide_get_post_categories(get_the_ID(), 'product_cat', true); echo esc_attr($cols[$counter]); ?>">
                        <div class="product-item wow fadeIn" data-wow-delay="0.<?php echo esc_attr($counter); ?>s">
                            <div class="product-item-thumb">
                                <?php echo $imagify->provide_thumb($sizes[$counter], true, array(true, true, true)); ?>
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
                    </div>
                    <?php endwhile; wp_reset_postdata(); endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
                       


        <?php
        (new provide_Media())->provide_eq(array('provide-isotope'));
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
        wp_add_inline_script('provide-isotope', $script);
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
