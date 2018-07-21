<?php

class provide_simple_carousel_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_simple_carousel($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Simple Carousel", 'provide'),
                "base" => "provide_simple_carousel_output",
                "icon" => 'provide_simple_carousel_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title:", 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__("Enter the title for this section.", 'provide')
                    ),
                    array(
                        "type" => "attach_images",
                        "heading" => esc_html__("Images:", 'provide'),
                        "param_name" => "images",
                        "description" => esc_html__("Upload Images for this carousel", 'provide')
                    )
                )
            );
            return apply_filters('provide_simple_carousel_output', $return);
        }
    }

    public static function provide_simple_carousel_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '322x249', 'i' => '352x272', 'w' => '246x190');
        $imageIds = explode(',', $images);
        if (!empty($title)) {
            ?>
            <div class="col-md-5 pro-col">
                <h2 class="white-title"><?php echo esc_html($title) ?></h2>
            </div>
            <?php
        }
        if (!empty($imageIds) && count($imageIds) > 0) {
            echo '<div class="col-md-7 pro-col"><div id="management-carousel' . self::$counter . '" class="management-carousel">';
            foreach ($imageIds as $id) {
                $getSrc = wp_get_attachment_image_src($id, 'full');
                $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                echo '<div class="item"><img src="' . esc_url($imgSrc) . '" alt=""/></div>';
            }
            echo '</div></div>';
        }
        provide_Media::provide_singleton()->provide_eq(array('owl'));
        $loop = (count($imageIds) > 1) ? 'true' : 'false';
        $jsOutput = "jQuery('#management-carousel" . self::$counter . "').owlCarousel({
                        autoplay:true,
                        smartSpeed:1000,
                        loop:" . esc_js($loop) . ",
                        dots:true,
                        nav:false,
                        margin:10,
                        mouseDrag:true,
                        items:3,
                        autoplayHoverPause:true,		        
                        autoHeight:true,
                        responsive :{
                            1200 :{items:3},		   	
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
