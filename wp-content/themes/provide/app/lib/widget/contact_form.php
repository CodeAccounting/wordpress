<?php

class provide_contact_form_Widget extends WP_Widget
{

    public $h;

    public function __construct()
    {
        $this->h = new provide_Helper();
        $widget_ops = array(
            'description' => esc_html__('This widget is used to show contact form.', 'provide')
        );
        $control_ops = array(
            'width' => 250,
            'height' => 350,
            'id_base' => 'provide-contact-form'
        );
        parent::__construct('provide-contact-form', esc_html__('Contact Form - Provide', 'provide'), $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $defaults = array('title' => esc_html__('CONTACT US', 'provide'), 'btn_text' => esc_html__('SEND', 'provide'), 'receiving_email' => 'admin@domain.com');
        $instance = wp_parse_args((array)$instance, $defaults);
        echo wp_kses($before_widget, true);
        $widgetTitle = esc_html($this->h->provide_set($instance, 'title'));
        $title = apply_filters('widget_title', ($widgetTitle == '') ? '' : $widgetTitle);
        echo wp_kses($before_title . $title . $after_title, true);
        ?>
        <div class="contact-form">
            <div class="log"></div>
            <form id="widget-contact-form">
                <input type="hidden" id="receiver" value="<?php echo esc_attr($this->h->provide_set($instance, 'receiving_email')) ?>"/>
                <input type="text" id="name" placeholder="<?php esc_html_e('Name', 'provide') ?>"/>
                <input type="email" id="email" placeholder="<?php esc_html_e('Email Address', 'provide') ?>"/>
                <input type="text" id="subject" placeholder="<?php esc_html_e('Subject', 'provide') ?>"/>
                <textarea id="msg" placeholder="<?php esc_html_e('Message', 'provide') ?>"></textarea>
                <button id="submit-form" type="submit"><?php echo esc_html($this->h->provide_set($instance, 'btn_text')) ?></button>
            </form>
        </div>
        <?php
        echo wp_kses($after_widget, true);
    }

    /* Store */

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['btn_text'] = $new_instance['btn_text'];
        $instance['receiving_email'] = $new_instance['receiving_email'];

        return $instance;
    }

    /* Settings */

    public function form($instance)
    {
        $defaults = array('title' => esc_html__('CONTACT US', 'provide'), 'btn_text' => esc_html__('SEND', 'provide'), 'receiving_email' => 'admin@domain.com');
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('btn_text')); ?>"><?php esc_html_e('Button Text', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('btn_text')); ?>" name="<?php echo esc_attr($this->get_field_name('btn_text')); ?>" type="text" value="<?php echo esc_attr($instance['btn_text']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('receiving_email')); ?>"><?php esc_html_e('Receiving Email Address', 'provide'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('receiving_email')); ?>" name="<?php echo esc_attr($this->get_field_name('receiving_email')); ?>" type="text" value="<?php echo esc_attr($instance['receiving_email']); ?>"/>
        </p>
        <?php
    }

}
