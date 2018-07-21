<?php

class AnpsImage extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'AnpsImages', 'AnpsThemes - Images', array('description' => __('Choose a image to show on page', 'accounting'),)
        );
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'image' => ''));

        $image = $instance['image'];
        $title = $instance['title'];
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title", 'accounting'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <?php $images = get_children('post_type=attachment&post_mime_type=image'); ?>

        <select id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>">
            <option value="">Select an image</option>
            <?php foreach ($images as $item) : ?>
                <option <?php if ($item->ID == $image) {
                    echo 'selected="selected"';
                } ?> value="<?php echo esc_attr($item->ID); ?>"><?php echo esc_html($item->post_title); ?></option>
        <?php endforeach; ?>
        </select>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image'] = $new_instance['image'];
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        
        echo $before_widget;
        ?>

        <?php if(isset($instance['title']) && $instance['title'] != '') : ?>
            <h3 class="widget-title"><?php echo esc_html($instance['title']); ?></h3>
        <?php endif; ?>

        <?php echo wp_get_attachment_image($instance['image'], 'full'); ?>

        <?php
        echo $after_widget;
    }

}

add_action( 'widgets_init', create_function('', 'return register_widget("AnpsImage");') );
