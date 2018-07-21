<?php

class provide_services_with_video_box_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_services_with_video_box($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Services With Video Box", 'provide'),
                "base" => "provide_services_with_video_box_output",
                "icon" => 'provide_services_with_video_box_output.png',
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
                        "heading" => esc_html__('Services', 'provide'),
                        'param_name' => 'services_list',
                        "show_settings_on_create" => true,
                        'params' => array(
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
                                "heading" => esc_html__("Image:", 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__("Upload Image for this service.", 'provide')
                            ),
							array(
                                "type" => "textfield",
                                "heading" => esc_html__('Link', 'provide'),
                                "param_name" => "link",
                                "description" => esc_html__('Enter the link for this service.', 'provide')
                            ),
                        )
                    ),
                )
            );
            return apply_filters('provide_services_with_video_box_output', $return);
        }
    }

    public static function provide_services_with_video_box_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes2 = array('m' => '644x514', 'i' => '125x82', 'w' => '674x538');
        $services = json_decode(urldecode($services_list));
        $getVideoSrc = wp_get_attachment_image_src($video_image, 'full');
        if ($h->provide_set($getVideoSrc, '0') != '') {
            $videoImageSrc = $i->provide_thumb($sizes2, false, array(TRUE, TRUE, TRUE), $h->provide_set($getVideoSrc, '0'), 'c', true);
        } else {
            $videoImageSrc = '';
        }
        ?>

<div class="expertise">
  <?php if (!empty($vimeo) OR !empty($youtube)): ?>
  <div class="provide-video">
    <?php if (!empty($videoImageSrc)): ?>
    <img src="<?php echo esc_url($videoImageSrc) ?>" alt=""/>
    <?php endif; ?>
    <a class="play-video" id="play-button" href="javascript:void(0)" title=""><i class="fa fa-play-circle-o"></i></a> <a class="pause-video" id="pause-button" href="javascript:void(0)" title=""><i class="fa fa-pause-circle-o"></i></a>
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
  <?php
            endif;
            if (!empty($services) && count($services) > 0) {
                ?>
  <div class="provide-services">
    <div class="row masonary">
      <?php
                        foreach ($services as $s) {
                            ?>
      <div class="col-md-6">
        <?php if($h->provide_set($s, 'link') != ''): ?>
        <a href="<?php echo esc_html($h->provide_set($s, 'link')) ?>" title="<?php echo esc_html($h->provide_set($s, 'title')) ?>">
        <?php endif; ?>
        <div class="service wow fadeInDown"> <span>
          <?php
                                        if ($h->provide_set($s, 'image') != '') {
                                            $getSrc = wp_get_attachment_image_src($h->provide_set($s, 'image'), 'full');
                                            echo '<img src="' . esc_url($h->provide_set($getSrc, '0')) . '" alt="">';
                                        }
                                        ?>
          </span>
          <h4><?php echo esc_html($h->provide_set($s, 'title')) ?></h4>
          <p><?php echo esc_html($h->provide_set($s, 'desc')) ?></p>
        </div>
        <!-- Service -->
        <?php if($h->provide_set($s, 'link') != ''): ?>
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
            ?>
</div>
<?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}




