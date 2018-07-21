<?php

class provide_video_box_with_toggles_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_video_box_with_toggles($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Video Box With Toggle", 'provide'),
                "base" => "provide_video_box_with_toggles_output",
                "icon" => 'provide_video_box_with_toggles_output.png',
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
                        "heading" => esc_html__("Video Image", 'provide'),
                        "param_name" => "video_image",
                        "description" => esc_html__("Upload Image for this video.", 'provide')
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
                        'type' => 'param_group',
                        "heading" => esc_html__('Toggle\'s', 'provide'),
                        'param_name' => 'video_box_with_toggles',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Toggle Title', 'provide'),
                                "param_name" => "title",
                                "description" => esc_html__('Enter the title for this toggle.', 'provide')
                            ),
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__("Image:", 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__("Upload Image for this toggle.", 'provide')
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => esc_html__('Short Content', 'provide'),
                                "param_name" => "desc",
                                "description" => esc_html__('Enter the content for this toggle.', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_video_box_with_toggles_output', $return);
        }
    }

    public static function provide_video_box_with_toggles_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '125x82', 'i' => '125x82', 'w' => '125x82');
        $sizes2 = array('m' => '644x514', 'i' => '125x82', 'w' => '674x538');
        $toggles = json_decode(urldecode($video_box_with_toggles));
        $getVideoSrc = wp_get_attachment_image_src($video_image, 'full');
        if ($h->provide_set($getVideoSrc, '0') != '') {
            $videoImageSrc = $i->provide_thumb($sizes2, false, array(TRUE, TRUE, TRUE), $h->provide_set($getVideoSrc, '0'), 'c', true);
        } else {
            $videoImageSrc = '';
        }
        ?>
        <div class="provide-video-detail">
            <?php if (!empty($vimeo) OR !empty($youtube)): ?>
  				<div class="provide-video">
    				<?php if (!empty($videoImageSrc)): ?>
    					<img src="<?php echo esc_url($videoImageSrc) ?>" alt=""/>
    				<?php endif; ?>
    				<a class="play-video" id="play-button" href="javascript:void(0)" title=""><i class="fa fa-play-circle-o"></i></a> 
                    <a class="pause-video" id="pause-button" href="javascript:void(0)" title=""><i class="fa fa-pause-circle-o"></i></a>
    				<?php if(esc_attr($youtube) != ''): ?>
    					<iframe id="youtube" src="http://www.youtube.com/embed/<?php echo esc_attr($youtube) ?>?enablejsapi=1&html5=1" frameborder="0" allowfullscreen></iframe>
    					<script>
							var player;
							function onYouTubePlayerAPIReady() {
  								player = new YT.Player('youtube', {
    								events: {
      									'onReady': onPlayerReady
    								}
  								});
							}
							function onPlayerReady(event) {
								var playButton = document.getElementById("play-button");
  								playButton.addEventListener("click", function() {
    								player.playVideo();
  								});
  
  								var pauseButton = document.getElementById("pause-button");
  								pauseButton.addEventListener("click", function() {
    								player.pauseVideo();
  								});
  
							}

							// Inject YouTube API script
							var tag = document.createElement('script');
							tag.src = "//www.youtube.com/player_api";
							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						</script>
    				<?php elseif(esc_attr($vimeo) != '' && esc_attr($youtube) == ''): ?>
    					<iframe id="vimeo" src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo) ?>?title=0&byline=0&portrait=0"></iframe>
    				<?php endif; ?>
  				</div>
  			<?php endif;?>
		    
            <div class="provide-details">
                <h3><?php echo esc_html($title) ?></h3>
                <p><?php echo esc_html($desc) ?></p>

                <?php
                if (!empty($toggles) && count($toggles) > 0) {
                    ?>
                    <div class="provide-accordion toggle style2">
                        <?php
                        foreach ($toggles as $t) {
                            if ($h->provide_set($t, 'image') != '') {
                                $getSrc = wp_get_attachment_image_src($h->provide_set($t, 'image'), 'full');
                                $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                            }
                            ?>
                            <div class="toggle-item">
                                <h2><?php echo esc_html($h->provide_set($t, 'title')) ?></h2>
                                <div class="content">
                                    <?php
                                    if ($h->provide_set($getSrc, '0') != '') {
                                        echo '<img class="alignleft" src="' . esc_url($imgSrc) . '" alt=""/>';
                                    }
                                    ?>
                                    <p><?php echo esc_html($h->provide_set($t, 'desc')) ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
