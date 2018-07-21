<?php

class provide_customer_services_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_customer_services($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Customer Services", 'provide'),
                "base" => "provide_customer_services_output",
                "icon" => 'provide_customer_services_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title", 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__("Enter the title for this section.", 'provide')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => esc_html__("Description", 'provide'),
                        "param_name" => "desc",
                        "description" => esc_html__("Enter the description for this section.", 'provide')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Side Image", 'provide'),
                        "param_name" => "side_image",
                        "description" => esc_html__("Upload side image for this section.", 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Services', 'provide'),
                        'param_name' => 'customer_services',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Title', 'provide'),
                                "param_name" => "title",
                                "description" => esc_html__('Enter the title for this service.', 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Short Description', 'provide'),
                                "param_name" => "desc",
                                "description" => esc_html__('Enter the short description for this service.', 'provide')
                            ),
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__("Image", 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__("Upload Image for this service.", 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_customer_services_output', $return);
        }
    }

    public static function provide_customer_services_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $services = json_decode(urldecode($customer_services));
        $counter = 1;
        ?>
        <div class="row">
            <div class="col-md-8 pro-col">
                <div class="provide-modern-services">
                    <h2><?php echo esc_html($title) ?></h2>
                    <p><?php echo esc_html($desc) ?></p>
                    <?php if (!empty($services) && count($services) > 0): ?>
                        <div class="modern-services-carousel">
                            <?php foreach ($services as $service): ?>
                                <div class="modern-service">
                                    <i><?php echo esc_html($counter) ?></i>
                                    <div class="modern-icon">
                                        <span>
                                            <?php
                                            if ($h->provide_set($service, 'image')) {
                                                $iconSrc = wp_get_attachment_image_src($h->provide_set($service, 'image'), 'full');
                                                echo '<img src="' . esc_url($h->provide_set($iconSrc, '0')) . '" alt=""/>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="mod-inner">
                                        <h3><?php echo esc_html($h->provide_set($service, 'title')) ?></h3>
                                        <p><?php echo esc_html($h->provide_set($service, 'desc')) ?></p>
                                    </div>
                                </div>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-4 pro-col">
                <?php
                if (!empty($side_image)):
                    $getSrc = wp_get_attachment_image_src($side_image, 'full');
                    ?>
                    <div class="special-mockup"><img src="<?php echo esc_url($h->provide_set($getSrc, '0')) ?>" alt=""/></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        provide_Media::provide_singleton()->provide_eq(array('owl'));
        $loop = (count($services) > 1) ? 'true' : 'false';
        $jsOutput = "jQuery('.modern-services-carousel').owlCarousel({
                            autoplay:true,
                            smartSpeed:1000,
                            loop:true,
                            dots:true,
                            nav:false,
                            margin:50,
                            mouseDrag:true,
                            items:2,
                            autoplayHoverPause:true,		        
                            autoHeight:true,
                            responsive :{
                                1200 :{items:2},		   	
                                980 :{items:2},		   	
                                767 :{items:2},		   	
                                480 :{items:2},		   		
                                0 :{items:1}
                            }
                        });";
        wp_add_inline_script('owl', $jsOutput);
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
