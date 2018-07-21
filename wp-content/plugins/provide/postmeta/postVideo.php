<?php

class provide_PostVideoMetabox
{

    public function __construct()
    {
        add_action('cmb2_admin_init', array($this, 'provide_RegisterMetabox'));
        add_filter('cmb2_show_on', array($this, 'showOn'), 10, 2);
    }

    public function provide_RegisterMetabox()
    {
        $settings = array(
            'id' => 'post_video_meta',
            'title' => esc_html__('Video Grabber', 'provide'),
            'object_types' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'show_on' => array('key' => 'post_format', 'value' => 'video'),
            'show_names' => TRUE,
        );
        $meta = new_cmb2_box($settings);
        $fields = $this->provide_fields();
        foreach ($fields as $field) {
            $meta->add_field($field);
        }
    }

    public function provide_fields()
    {
        return array(
            array(
                'name' => esc_html__('oEmbed', 'provide'),
                'desc' => esc_html__('Enter a youtube, twitter, or instagram URL. Supports services listed at ', 'provide') . '<a href="http://codex.wordpress.org/Embeds">' . esc_html__('here', 'provide') . '</a>.',
                'id' => 'metaVideoUrl',
                'type' => 'oembed',
            )
        );
    }


    public function showOn($display, $post_format)
    {
        if (!isset($post_format['show_on']['key'])) {
            return ($display);
        }
        $post_id = 0;
        // If we're showing it based on ID, get the current ID
        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        } elseif (isset($_POST['post_ID'])) {
            $post_id = $_POST['post_ID'];
        }
        if (!$post_id) {
            return $display;
        }
        $value = get_post_format($post_id);
        //print_r($value);exit;
        if (empty($post_format['show_on']['key'])) {
            return (bool)$value;
        }
        return $value == $post_format['show_on']['value'];
    }

}
