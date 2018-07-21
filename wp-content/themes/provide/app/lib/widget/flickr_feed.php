<?php

class provide_flickr_feed_Widget extends WP_Widget
{

    public $h;
    static private $counter = 0;

    public function __construct()
    {
        $this->h = new provide_Helper();
        $widget_ops = array(
            'description' => esc_html__('This widget is used to show flickr images.', 'provide')
        );
        $control_ops = array(
            'width' => 250,
            'height' => 350,
            'id_base' => 'provide-flickr-feed'
        );
        parent::__construct('provide-flickr-feed', esc_html__('Flickr Feed - Provide', 'provide'), $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $defaults = array('title' => esc_html__('Flickr Images', 'provide'), 'number' => '6', 'flickr_id' => '');
        $instance = wp_parse_args((array)$instance, $defaults);
        echo wp_kses($before_widget, true);
        $widgetTitle = esc_html($this->h->provide_set($instance, 'title'));
        $title = apply_filters('widget_title', ($widgetTitle == '') ? '' : $widgetTitle);
        echo wp_kses($before_title . $title . $after_title, true);
        if ($this->h->provide_set($instance, 'flickr_id') != '') {
            provide_Media::provide_singleton()->provide_eq(array('flicker'));
            ?>
            <div class="widget-wrapper">
                <div class="provide-flickr">
                    <div class="row" id="flickrcbox<?php echo esc_attr(self::$counter) ?>"></div>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('#flickrcbox<?php echo esc_js(self::$counter)?>').jflickrfeed({
                                limit: <?php echo esc_js($this->h->provide_set($instance, 'number')) ?>,
                                qstrings: {
                                    id: '<?php echo esc_js($this->h->provide_set($instance, 'flickr_id')) ?>'
                                },
                                itemTemplate: '<div class="col-md-4"><a target="_blank" href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></div>'
                            });
                        });
                    </script>
                </div><!-- Provide Flickr -->
            </div>
            <?php
        }
        self::$counter++;
        echo wp_kses($after_widget, true);
    }

    /* Store */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['number'] = $new_instance['number'];
        $instance['flickr_id'] = ($new_instance['flickr_id']) ? $new_instance['flickr_id'] : '';

        return $instance;
    }

    /* Settings */

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('Flickr Images', 'provide'), 'number' => '6', 'flickr_id' => '');
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Posts', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($instance['number']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>"><?php esc_html_e('Flickr ID', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr_id')); ?>" type="text" value="<?php echo esc_attr($instance['flickr_id']); ?>"/>
        </p>
        <?php
    }

}
