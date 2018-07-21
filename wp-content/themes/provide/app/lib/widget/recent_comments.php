<?php

class provide_recent_comments_Widget extends WP_Widget
{

    public $h;

    public function __construct()
    {
        $this->h = new provide_Helper();
        $widget_ops = array(
            'description' => esc_html__('This widget is used to show recent comments.', 'provide')
        );
        $control_ops = array(
            'width' => 250,
            'height' => 350,
            'id_base' => 'provide-recent-comments'
        );
        parent::__construct('provide-recent-comments', esc_html__('Recent Comments - Provide', 'provide'), $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $defaults = array('title' => esc_html__('RECENT COMMENTS', 'provide'), 'number' => '3');
        $instance = wp_parse_args((array)$instance, $defaults);
        echo wp_kses($before_widget, true);
        $widgetTitle = esc_html($this->h->provide_set($instance, 'title'));
        $title = apply_filters('widget_title', ($widgetTitle == '') ? '' : $widgetTitle);
        echo wp_kses($before_title . $title . $after_title, true);
        $args = array(
            'number' => $this->h->provide_set($instance, 'number'),
            'status' => 'approve',
            'post_status' => 'publish'
        );
        $commentsLink = get_comments($args);
        if (is_array($commentsLink) && $commentsLink) {
            echo '<div class="news-widget">';
            foreach ((array)$commentsLink as $c) {
                if ($c->comment_ID) {
                    ?>
                    <div class="news">
                        <div class="news-detail">
                            <h5><a href="<?php echo esc_url(get_comment_link($c)) ?>" title="<?php echo get_the_title($c->comment_post_ID) ?>"><?php echo get_the_title($c->comment_post_ID) ?></a></h5>
                            <span><?php echo date('M d - Y', strtotime($c->comment_date)) ?></span>
                        </div>
                    </div>
                    <?php
                }
            }
            echo '</div>';
        }
        echo wp_kses($after_widget, true);
    }

    /* Store */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['number'] = $new_instance['number'];

        return $instance;
    }

    /* Settings */

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('RECENT COMMENTS', 'provide'), 'number' => '3');
        $instance = wp_parse_args((array)$instance, $defaults);
        $options = $this->h->provide_cat(array('taxonomy' => 'category', 'hide_empty' => true), true);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Comments', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($instance['number']); ?>"/>
        </p>
        <?php
    }

}
