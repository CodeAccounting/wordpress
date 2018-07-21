<?php

class provide_newsletter_with_video_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_newsletter_with_video($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Newsletter With Video", 'provide'),
                "base" => "provide_newsletter_with_video_output",
                "icon" => 'provide_newsletter_with_video_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__('Title', 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__('Enter the title for this section.', 'provide')
                    ),
                    
					 array(
                        "type" => "textfield",
                        "heading" => esc_html__("Youtube Video ID", 'provide'),
                        "param_name" => "youtube",
                        "description" => esc_html__("Enter the youtube video id.", 'provide')
                    ),
					array(
                        "type" => "textfield",
                        "heading" => esc_html__("Vimeo Video ID", 'provide'),
                        "param_name" => "vimeo",
                        "description" => esc_html__("Enter the vimeo video id.", 'provide')
                    ),
					
					array(
                        "type" => "textfield",
                        "heading" => esc_html__("Button Text", 'provide'),
                        "param_name" => "btn_text",
                        "value" => esc_html__('Subscribe', 'provide'),
                        "description" => esc_html__("Enter the button text.", 'provide')
                    ),
                )
            );
            return apply_filters('provide_newsletter_with_video_output', $return);
        }
    }

    public static function provide_newsletter_with_video_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        provide_Media::provide_singleton()->provide_eq(array('html5lightbox'));
        ob_start();
        $opt = $h->provide_opt();
        $apiKey = $h->provide_set($opt, 'optMailchimpApiKey');
        $listId = $h->provide_set($opt, 'optMailchimpListId');
        ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 pro-col">
                <div class="provide-subscribe">
                    
					<?php if (!empty($youtube)): ?>
                    	<a class="html5lightbox" href="https://www.youtube.com/watch?v=<?php echo esc_attr($youtube) ?>?title=0&byline=0&portrait=0" title=""><i class="fa fa-play"></i></a>
                    <?php elseif(!empty($vimeo) && $youtube == ''): ?>	
                        <a class="html5lightbox" href="https://player.vimeo.com/video/<?php echo esc_attr($vimeo) ?>?title=0&byline=0&portrait=0" title=""><i class="fa fa-play"></i></a>
                    <?php endif; ?>
                    
                    <h3><?php echo esc_html($title) ?></h3>

                    <?php if (empty($apiKey) && empty($listId)) {
                        echo '<p>' . esc_html__('Please Enter MailChimp API key & List id in theme options', 'provide') . '</p>';
                    } else {
                        ?>
                        <div class="log"></div>
                        <form id="v_newsletter" class="newsletter-form">
                            <input type="text" id="v_newsletter_email" placeholder="<?php esc_html_e('Subscribe Your Email', 'provide') ?>"/>
                            <button id="v_newsletter_button" type="submit"><?php echo esc_html($btn_text) ?></button>
                        </form>
                        <?php
                    }
                    ?>
                </div><!-- provide Subscribe -->
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
