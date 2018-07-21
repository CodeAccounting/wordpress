<?php

class provide_recent_posts_sidebar_Widget extends WP_Widget
{

    public $h;

    public function __construct()
    {
        $this->h = new provide_Helper();
        $widget_ops = array(
            'description' => esc_html__('This widget is used to show recent posts.', 'provide')
        );
        $control_ops = array(
            'width' => 250,
            'height' => 350,
            'id_base' => 'provide-recent-posts-sidebar'
        );
        parent::__construct('provide-recent-posts-sidebar', esc_html__('Recent Posts Sidebar - Provide', 'provide'), $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $defaults = array('title' => esc_html__('RECENT POST', 'provide'), 'number' => '3', 'category' => '', 'title_limit' => '25');
        $instance = wp_parse_args((array)$instance, $defaults);
        echo wp_kses($before_widget, true);
        $widgetTitle = esc_html($this->h->provide_set($instance, 'title'));
        $title = apply_filters('widget_title', ($widgetTitle == '') ? '' : $widgetTitle);
        echo wp_kses($before_title . $title . $after_title, true);
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'showposts' => $this->h->provide_set($instance, 'number')
        );
        if ($this->h->provide_set($instance, 'category') != '') {
            $args['category_name'] = implode(',', $this->h->provide_set($instance, 'category'));
        }
        $query = new WP_Query($args);
        $sizes = array('m' => '77x80', 'i' => '77x80', 'w' => '77x80');
        $limit = (int)( $this->h->provide_set( $instance, 'title_limit' ) !== '' ) ? $this->h->provide_set( $instance, 'title_limit' ) : 30;
        if ($query->have_posts()) {
            echo '<div class="widget-wrapper"><div class="sidebar-posts">';
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <div class="side-post">
                    <?php
                    if (has_post_thumbnail()) {
                        $i = new provide_Imagify();
                        echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                    }
                    ?>
                    <div class="sidepost-inner">
                        <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php echo substr( get_the_title(), 0, $limit ) ?></a></h3>
                        <i><?php $this->h->provide_date(true, 'd M') ?></i>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
            echo '</div></div>';
        }
        echo wp_kses($after_widget, true);
    }

    /* Store */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['title_limit'] = $new_instance['title_limit'];
        $instance['number'] = $new_instance['number'];
        $instance['category'] = ($new_instance['category']) ? $new_instance['category'] : '';

        return $instance;
    }

    /* Settings */

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('RECENT POST', 'provide'), 'number' => '3', 'category' => '', 'title_limit' => '25');
        $instance = wp_parse_args((array)$instance, $defaults);
        $options = $this->h->provide_cat(array('taxonomy' => 'category', 'hide_empty' => true), true);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title_limit' ) ); ?>"><?php esc_html_e( 'Title Character Limit', 'provide' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_limit' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title_limit'] ); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Posts', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($instance['number']); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Select Categories', 'provide'); ?>:</label>
            <select multiple="multiple" class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>[]">
                <?php
                if (!empty($options) && count($options) > 0) {
                    foreach ($options as $key => $val) {
                        $selected = (in_array($key, $options)) ? 'selected="selected"' : '';
                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                    }
                }
                ?>

            </select>
        </p>
        <?php
    }

}
