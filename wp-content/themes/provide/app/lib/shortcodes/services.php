<?php

class provide_services_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_services($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Services", 'provide'),
                "base" => "provide_services_output",
                "icon" => 'provide_services_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "as_parent" => array('only' => 'provide_service_block_output'),
                "content_element" => TRUE,
                "show_settings_on_create" => TRUE,
                "is_container" => TRUE,
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
                    )
                )
            );
            return apply_filters('provide_services_output', $return);
        }
    }

    public static function provide_services_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        global $shortcodeServices;
        $shortcodeServices = array();
        do_shortcode($content);
        $count = count($shortcodeServices);
        ?>
        <div class="detailed-title">
            <h2><?php echo esc_html($title) ?></h2>
            <p><?php echo esc_html($desc) ?></p>
        </div>
        <?php
        if ($count > 0) {
            ?>
            <div class="provide-services">
                <div class="row masonary">
                    <?php
                    foreach ($shortcodeServices as $item) {
                        $imgSrc = wp_get_attachment_image_src($h->provide_set($item, 'icon'), 'full');
                        ?>
                        <div class="col-md-3">
                        	<?php if($h->provide_set($item, 'link') != ''): ?>
                            <a href="<?php echo esc_html($h->provide_set($item, 'link')) ?>" title="<?php echo esc_html($h->provide_set($item, 'title')) ?>">
                            <?php endif; ?>
                            <div class="service wow fadeInDown">
                                <span>
                                    <?php if ($h->provide_set($imgSrc, '0') != ''): ?>
                                        <img src="<?php echo esc_url($h->provide_set($imgSrc, '0')) ?>" alt=""/>
                                    <?php endif; ?>
                                </span>
                                <h4><?php echo esc_html($h->provide_set($item, 'title')) ?></h4>
                                <p><?php echo esc_html($h->provide_set($item, 'content')) ?></p>
                            </div><!-- Service -->
                            <?php if($h->provide_set($item, 'link') != ''): ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
