<?php

class provide_simple_gallery_carousel_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;
    public static function provide_simple_gallery_carousel($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Simple Gallery Carousel", 'provide'),
                "base" => "provide_simple_gallery_carousel_output",
                "icon" => 'provide_simple_gallery_carousel_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "attach_images",
                        "heading" => esc_html__("Images:", 'provide'),
                        "param_name" => "images",
                        "description" => esc_html__("Upload Images for this carousel", 'provide')
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Autoplay", 'provide' ),
                        "param_name"  => "autoplay",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "on/off autoplay carousel feature", 'provide' ),
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Navigation", 'provide' ),
                        "param_name"  => "navigation",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "hide/show carousel navigation", 'provide' ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Margin:", 'provide'),
                        "param_name" => "margin",
                        "description" => esc_html__("Enter margin between carousel items", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Items:", 'provide'),
                        "param_name" => "items",
                        "description" => esc_html__("Enter number of items to show in carousel", 'provide')
                    ),
                )
            );
            return apply_filters('provide_simple_gallery_carousel_output', $return);
        }
    }

    public static function provide_simple_gallery_carousel_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '300x200', 'i' => '352x272', 'w' => '246x190');
        $imageIds = explode(',', $images);
        
    ?>

        <?php if(!empty($imageIds) && count($imageIds) > 0) : ?>

            <div id="management-carousel-<?php echo esc_attr(self::$counter); ?>" class="management-carousel">
                <?php foreach ($imageIds as $id) : 
                    $getSrc = wp_get_attachment_image_src($id, 'full');
                    $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                ?>
                    <div class="item"><img src="<?php echo esc_url($imgSrc) ?>" alt=""/></div>
                <?php endforeach; ?>
            </div>
            
        <?php endif; ?>


    <?php
        provide_Media::provide_singleton()->provide_eq(array('owl'));
        $loop = (count($imageIds) > 1) ? 'true' : 'false';
        $autoplay = ($autoplay == 'on') ? 'true' : 'false';
        $navigation = ($navigation == 'on') ? 'true' : 'false';
        $margin = ($margin != '') ? $margin : '10';
        $items = ($items != '') ? $items : '6';
        $jsOutput = "jQuery('#management-carousel-" . self::$counter . "').owlCarousel({
                        autoplay:". esc_js($autoplay) .",
                        smartSpeed:1000,
                        loop:" . esc_js($loop) . ",
                        dots:true,
                        nav:". esc_js($navigation) .",
                        margin:". esc_js($margin) .",
                        mouseDrag:true,
                        items:". esc_js($items) .",
                        autoplayHoverPause:true,		        
                        autoHeight:true,
                        responsive :{
                            1200 :{items:". esc_js($items) ."},		   	
                            980 :{items:3},		   	
                            767 :{items:2,center:false,singleItem:true},		   	
                            480 :{items:2,center:false,singleItem:true},		   		
                            0 :{items:1,center:false,singleItem:true},		   	
                        }
                    });";
        wp_add_inline_script('owl', $jsOutput);
        self::$counter++;
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
