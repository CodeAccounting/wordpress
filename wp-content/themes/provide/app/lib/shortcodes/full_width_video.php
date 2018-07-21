<?php

class provide_full_width_video_VC_ShortCode extends provide_VC_ShortCode {

    public static function provide_full_width_video($atts = NULL) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Full Width Video", 'provide'),
                "base" => "provide_full_width_video_output",
                "icon" => 'provide_full_width_video_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Video Image", 'provide'),
                        "param_name" => "video_image",
                        "description" => esc_html__("Upload Image for this video.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__('Youtube Video ID', 'provide'),
                        "param_name" => "youtube",
                        "description" => esc_html__('Enter the youtube video id of this feature', 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__('Vimeo Video ID', 'provide'),
                        "param_name" => "vimeo",
                        "description" => esc_html__('Enter the vimeo video id of this feature', 'provide')
                    ),
                )
            );
            return apply_filters('provide_full_width_video_output', $return);
        }
    }

    public static function provide_full_width_video_output($atts = NULL, $content = NULL) {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        //$sizes2 = array('m' => '644x514', 'i' => '125x82', 'w' => '674x538');
        $getVideoSrc = wp_get_attachment_image_src($video_image, 'full');
        if ($h->provide_set($getVideoSrc, '0') != '') {
            $videoImageSrc = $i->provide_thumb('full', false, array(TRUE, TRUE, TRUE), $h->provide_set($getVideoSrc, '0'), 'c', true);
        } else {
            $videoImageSrc = '';
        }
        $ramID_play = uniqid();
        $ramID_plause = uniqid();
        $ramID_yt_player = uniqid();
        ?>

        <div class="row">
        <?php if (!empty($vimeo) OR ! empty($youtube)): ?>
                <div class="provide-video style2">
                <?php if (!empty($videoImageSrc)): ?>
                        <img src="<?php echo esc_url($videoImageSrc) ?>" alt=""/>
                    <?php endif; ?>
                    <a class="play-video" id="<?php echo $ramID_play; ?>" href="javascript:void(0)" title=""><i class="fa fa-play-circle-o"></i></a> 
                    <a class="pause-video" id="<?php echo $ramID_plause; ?>" href="javascript:void(0)" title=""><i class="fa fa-pause-circle-o"></i></a>
            <?php if (esc_attr($youtube) != ''): ?>
                        <iframe id="<?php echo $ramID_yt_player; ?>" src="http://www.youtube.com/embed/<?php echo esc_attr($youtube) ?>?enablejsapi=1&html5=1" frameborder="0" allowfullscreen></iframe>
                        <script>
                            var player;

                            function onYouTubePlayerAPIReady() {
                                player = new YT.Player('<?php echo $ramID_yt_player; ?>', {
                                    events: {
                                        'onReady': onPlayerReady
                                    }
                                });
                            }

                            function onPlayerReady(event) {

                                var playButton = document.getElementById("<?php echo $ramID_play; ?>");
                                playButton.addEventListener("click", function () {
                                    player.playVideo();
                                });

                                var pauseButton = document.getElementById("<?php echo $ramID_plause; ?>");
                                pauseButton.addEventListener("click", function () {
                                    player.pauseVideo();
                                });

                            }

                            // Inject YouTube API script
                            var tag = document.createElement('script');
                            tag.src = "//www.youtube.com/player_api";
                            var firstScriptTag = document.getElementsByTagName('script')[0];
                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        </script>
            <?php elseif (esc_attr($vimeo) != '' && esc_attr($youtube) == ''): ?>
                        <iframe id="vimeo" src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo) ?>?title=0&byline=0&portrait=0"></iframe>
                    <?php endif; ?>
                </div>
                    <?php endif; ?>
        </div>
            <?php
            $output = ob_get_contents();
            ob_clean();
            return do_shortcode($output);
        }

    }
    