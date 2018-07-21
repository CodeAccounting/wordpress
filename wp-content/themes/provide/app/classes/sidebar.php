<?php

class provide_sidebar
{

    private static $instance;

    public function init()
    {
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $footer_widget_column = ($h->provide_set($opt, 'optFooterWidgtColumn')) ? $h->provide_set($opt, 'optFooterWidgtColumn') : 'col-md-3';
        $sidebars = array(
            'primary-widget-area' => array(
                'name' => esc_html__('Primary Widget Area', 'provide'),
                'desc' => esc_html__('The primary widget area', 'provide'),
                'before_widget' => '<div id="%1$s" class="%2$s widget wow fadeInRight">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>',
            ),
            'footer-widget-area' => array(
                'name' => esc_html__('Footer Widget Area', 'provide'),
                'desc' => esc_html__('Footer widget area', 'provide'),
                'before_widget' => '<div id="%1$s" class="%2$s '. $footer_widget_column .'"><div class="widget">',
                'after_widget' => '</div></div>',
                'before_title' => '<h4 class="widget-title">',
                'after_title' => '</h4>',
            ),
        );

        $sidebars = apply_filters('provide_extendSidebar', $sidebars);
        provide_ThemeInit::provide_singleton()->provide_storeSetting(array_keys($sidebars), 'wp_registered_sidebars');
        foreach ($sidebars as $type => $sidebar) {
            if ((new provide_Helper())->provide_set($sidebar, 'name') != '') {
                register_sidebar(
                    array(
                        'name' => (new provide_Helper())->provide_set($sidebar, 'name'),
                        'id' => $type,
                        'description' => (new provide_Helper())->provide_set($sidebar, 'desc'),
                        'before_widget' => (new provide_Helper())->provide_set($sidebar, 'before_widget'),
                        'after_widget' => (new provide_Helper())->provide_set($sidebar, 'after_widget'),
                        'before_title' => (new provide_Helper())->provide_set($sidebar, 'before_title'),
                        'after_title' => (new provide_Helper())->provide_set($sidebar, 'after_title'),
                    )
                );
            }
        }

        // dynamic sidebar generator
        $dynamicSidebar = (new provide_Helper())->provide_set($opt, 'optDynamicSidebar');
        if (!empty($dynamicSidebar) && count($dynamicSidebar) > 0) {
            foreach ($dynamicSidebar as $s) {
                if ($s != '') {
                    register_sidebar(
                        array(
                            'name' => $s,
                            'id' => str_replace(' ', '-', strtolower($s)),
                            'description' => $s,
                            'before_widget' => '<div id="%1$s" class="%2$s widget wow fadeInRight">',
                            'after_widget' => '</div>',
                            'before_title' => '<h4 class="widget-title">',
                            'after_title' => '</h4>',
                        )
                    );
                }
            }
        }
    }

    public static function provide_singleton()
    {
        if (!isset(self::$instance)) {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }

        return self::$instance;
    }

}
