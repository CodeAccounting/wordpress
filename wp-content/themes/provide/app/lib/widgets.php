<?php

class provide_Widgets
{

    static protected $_widgets = array(
        'about',
        'recent_posts',
        'recent_comments',
        'contact_form',
        'recent_posts_sidebar',
        'flickr_feed',
        'author_profile'
    );

    static public function register()
    {
        $widgets_ = array();
        foreach (self::$_widgets as $widget) {
            $widgets_[provide_Root . 'app/lib/widget/' . strtolower($widget) . '.php'] = $widget;
        }

        $widgets_ = apply_filters('provide_extend_widgets_', $widgets_);
        foreach ($widgets_ as $path => $register) {
            require_once($path);
            $widget_class = 'provide_' . $register . '_Widget';
            register_widget($widget_class);
        }
    }

}
