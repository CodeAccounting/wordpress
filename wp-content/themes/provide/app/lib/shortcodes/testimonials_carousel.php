<?php

class provide_testimonials_carousel_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_testimonials_carousel($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Testimonials Carousel", 'provide'),
                "base" => "provide_testimonials_carousel_output",
                "icon" => 'provide_testimonials_carousel_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Number of Posts', 'provide'),
                        "param_name" => "number",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the number of posts to show.', 'provide')
                    )
                )
            );
            return apply_filters('provide_testimonials_carousel_output', $return);
        }
    }

    public static function provide_testimonials_carousel_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $counter = 0;
        $i = new provide_Imagify();
        $sizes = array('m' => '70x70', 'i' => '70x70', 'w' => '70x70');
        $args = array(
            'post_type' => 'pr_testimonial',
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'ignore_sticky_posts' => true,
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            ?>
            <div class="testimonials-carousel">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $content = $h->provide_m('metaContent');
                    $avatar = $h->provide_m('metaBG');
                    $address = $h->provide_m('metaAddress');
                    if (!empty($avatar)) {
                        $src = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $avatar, 'c', true);
                    }
                    ?>
                    <div class="testimonial-slide">
                        <blockquote>&quot;<?php echo esc_html($content) ?>&quot;</blockquote>
                        <div class="client-info"><h5><?php the_title() ?></h5> <span><?php echo esc_html($address) ?></span></div>
                        <?php if (!empty($avatar)): ?>
                            <img src="<?php echo esc_url($src) ?>" alt=""/>
                        <?php endif; ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
            provide_Media::provide_singleton()->provide_eq(array('owl'));
            $loop = (count($counter) > 1) ? 'true' : 'false';
            $jsOutput = "jQuery('.testimonials-carousel').owlCarousel({
                        autoplay:true,
                        smartSpeed:1000,
                        loop:true,
                        dots:true,
                        nav:false,
                        margin:0,
                        mouseDrag:true,
                        items:1,
                        singleItem:true,
                        autoplayHoverPause:true,		        
                        autoHeight:true,
                        animateIn:\"fadeIn\",
                        animateOut:\"fadeOut\"
                    });";
            wp_add_inline_script('owl', $jsOutput);
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
