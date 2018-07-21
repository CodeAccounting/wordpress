<?php

class provide_masonary_gallery_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_masonary_gallery($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Masonary Gallery", 'provide'),
                "base" => "provide_masonary_gallery_output",
                "icon" => 'provide_masonary_gallery_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "attach_images",
                        "heading" => esc_html__('Gallery', 'provide'),
                        "param_name" => "gallery",
                        "description" => esc_html__('Upload images to show gallery', 'provide')
                    ),
                )
            );
            return apply_filters('provide_masonary_gallery_output', $return);
        }
    }

    public static function provide_masonary_gallery_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        provide_Media::provide_singleton()->provide_eq(array('html5lightbox', 'provide-isotope'));
        ob_start();
        $i = new provide_Imagify();
        $sizes = array(
            array('m' => '370x438', 'i' => '370x438', 'w' => '370x438'),
            array('m' => '370x528', 'i' => '370x528', 'w' => '370x528'),
            array('m' => '370x367', 'i' => '370x367', 'w' => '370x367'),
            array('m' => '370x367', 'i' => '370x367', 'w' => '370x367'),
            array('m' => '370x227', 'i' => '370x227', 'w' => '370x227'),
            array('m' => '370x438', 'i' => '370x438', 'w' => '370x438'),
            array('m' => '370x340', 'i' => '370x340', 'w' => '370x340'),
            array('m' => '370x476', 'i' => '370x476', 'w' => '370x476'),
            array('m' => '370x340', 'i' => '370x340', 'w' => '370x340'),
        );
        $galleries = explode(',', $gallery);
        $counter = 0;
        ?>

        
        <?php if(!empty($galleries) && count($galleries) > 0) : ?>
                <div class="portfolio-sec">
                    <div class="row">
                        <div class="masonary">
                            <?php 
                                foreach($galleries as $g): 
                                    $url = $h->provide_set(wp_get_attachment_image_src($g, 'full'), '0');
                                    $thumb = $i->provide_thumb($sizes[$counter], false, array(TRUE, TRUE, TRUE), $url, 'c', true);
                                    $image_info = get_post($g);
                            ?>
                            <div class="illustrate col-md-4 col-sm-6 col-xs-6">
                                <div class="portfolio-work hover2">
                                    <?php  ?>
                                    <img src="<?php echo esc_url($thumb); ?>" alt="" />
                                    <div class="portfolio-detail-box">
                                        <div class="portfolio-hover">
                                            <div class="portfolio-infos">
                                                <a class="html5lightbox" data-thumbnail="<?php echo esc_url($thumb); ?>" href="<?php echo esc_url($url); ?>" data-group="portfolio-set" title="Image 6">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                <h2><?php echo esc_html(provide_set($image_info, 'post_title')); ?></h2>
                                                <div class="portfolio-tags">
                                                    <span><?php echo esc_html(provide_set($image_info, 'post_excerpt')); ?></span>
                                                </div>
                                                <div class="line-zigzag"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                if($counter == 8) $counter = -1;
                                $counter++; endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
        <?php endif; ?>
                            

        <?php
        provide_Media::provide_singleton()->provide_eq(array('provide-isotope', 'html5lightbox'));
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
