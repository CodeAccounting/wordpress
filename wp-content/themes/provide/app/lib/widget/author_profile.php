<?php

class provide_author_profile_Widget extends WP_Widget
{

    public $h;

    public function __construct()
    {
        $this->h = new provide_Helper();
        $widget_ops = array(
            'description' => esc_html__('This widget is used to show author profile.', 'provide')
        );
        $control_ops = array(
            'width' => 250,
            'height' => 350,
            'id_base' => 'provide-author-profile'
        );
        parent::__construct('provide-author-profile', esc_html__('Author Profile - Provide', 'provide'), $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $defaults = array('title' => esc_html__('ABOUT ME', 'provide'), 'user' => '');
        $instance = wp_parse_args((array)$instance, $defaults);
        echo wp_kses($before_widget, true);
        $widgetTitle = esc_html($this->h->provide_set($instance, 'title'));
        $title = apply_filters('widget_title', ($widgetTitle == '') ? '' : $widgetTitle);
        echo wp_kses($before_title . $title . $after_title, true);
        $author = $this->h->provide_set($this->h->provide_set($instance, 'user'), '0');
        ?>
        <div class="widget-wrapper">
            <div class="aboutme-widget">
                <?php echo wp_kses($this->h->provide_avatar(array('m' => '121x120', 'i' => '121x120', 'w' => '121x120'), $author), true) ?>
                <?php if (get_the_author_meta('description', $author) != ''): ?>
                    <p><?php echo get_the_author_meta('description', $author); ?></p>
                <?php endif; ?>
                <?php if (get_the_author_meta('metaDesignation', $author) != ''): ?>
                    <span><?php echo esc_html(get_the_author_meta('metaDesignation', $author)) ?></span>
                <?php endif; ?>
                <div class="simple-social">
                    <?php if (get_the_author_meta('metaFB', $author) != ''): ?>
                        <a href="<?php echo esc_url(get_the_author_meta('metaFB', $author)) ?>" title=""><i class="fa fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if (get_the_author_meta('metaGB', $author) != ''): ?>
                        <a href="<?php echo esc_url(get_the_author_meta('metaGB', $author)) ?>" title=""><i class="fa fa-google-plus"></i></a>
                    <?php endif; ?>
                    <?php if (get_the_author_meta('metaTW', $author) != ''): ?>
                        <a href="<?php echo esc_url(get_the_author_meta('metaTW', $author)) ?>" title=""><i class="fa fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (get_the_author_meta('metaLK', $author) != ''): ?>
                        <a href="<?php echo esc_url(get_the_author_meta('metaLK', $author)) ?>" title=""><i class="fa fa-linkedin"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        echo wp_kses($after_widget, true);
    }

    /* Store */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['user'] = ($new_instance['user']) ? $new_instance['user'] : '';

        return $instance;
    }

    /* Settings */

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('ABOUT ME', 'provide'), 'user' => '');
        $instance = wp_parse_args((array)$instance, $defaults);
        $options = $this->h->provide_userList();
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('user')); ?>"><?php esc_html_e('Select Author', 'provide'); ?>:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('user')); ?>" name="<?php echo esc_attr($this->get_field_name('user')); ?>[]">
                <?php
                if (!empty($options) && count($options) > 0) {
                    foreach ($options as $key => $val) {
                        $selected = ($key == $instance['user']) ? 'selected="selected"' : '';
                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                    }
                }
                ?>

            </select>
        </p>
        <?php
    }

}
