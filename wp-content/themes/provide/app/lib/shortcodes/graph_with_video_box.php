<?php

class provide_graph_with_video_box_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_graph_with_video_box($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Graph With Video Box", 'provide'),
                "base" => "provide_graph_with_video_box_output",
                "icon" => 'provide_graph_with_video_box_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__('Title', 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__('Enter the title for this service.', 'provide')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => esc_html__('Short Description', 'provide'),
                        "param_name" => "desc",
                        "description" => esc_html__('Enter the short description for this service.', 'provide')
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
                        "heading" => esc_html__('Graph Value', 'provide'),
                        'param_name' => 'graph_with_video_box',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__('Year', 'provide'),
                                "param_name" => "g_year",
                                "description" => esc_html__('Enter the year', 'provide')
                            ),
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__('Value', 'provide'),
                                "param_name" => "g_val",
                                "description" => esc_html__('Enter the start value', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_graph_with_video_box_output', $return);
        }
    }

    public static function provide_graph_with_video_box_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes2 = array('m' => '644x514', 'i' => '125x82', 'w' => '674x538');
        $graph = json_decode(urldecode($graph_with_video_box));
        $getVideoSrc = wp_get_attachment_image_src($video_image, 'full');
        if ($h->provide_set($getVideoSrc, '0') != '') {
            $videoImageSrc = $i->provide_thumb($sizes2, false, array(TRUE, TRUE, TRUE), $h->provide_set($getVideoSrc, '0'), 'c', true);
        } else {
            $videoImageSrc = '';
        }
        ?>
        <div class="row">
            <div class="col-md-7 pro-col">
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
			</div>
            <div class="col-md-5 pro-col">
                <div class="provide-progress">
                    <h3><?php echo esc_html($title) ?></h3>
                    <p><?php echo esc_html($desc) ?></p>
                    <div class="graph" id="vgraph<?php echo esc_attr(self::$counter) ?>"></div>
                </div>
            </div>
        </div>
        <?php
        if (!empty($graph) && count($graph) > 0) {
            provide_Media::provide_singleton()->provide_eq(array('morris'));
            $data = '';
            foreach ($graph as $g) {
                $data .= "{period: '" . $h->provide_set($g, 'g_year') . "', licensed: " . $h->provide_set($g, 'g_val') . "}," . PHP_EOL;
            }
            $jsOutput = "jQuery(function () {
                        Morris.Line({
                          element: 'vgraph" . esc_js(self::$counter) . "',
                          data: [
                                " . $data . "
                            ],
                          lineColors:['#2faf67'],
                          lineWidth:['4px'],
                          pointFillColors:['#FFF'],
                          pointStrokeColors:['#2faf67'],
                          xkey: 'period',
                        ykeys: ['licensed'],
                        labels: ['" . esc_js(esc_html__('Licensed', 'provide')) . "'],
                        resize: true
                        });
                    });";
            wp_add_inline_script('morris', $jsOutput);
        }
        self::$counter++;
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
