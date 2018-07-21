<?php
/* Get all widgets */
function get_all_widgets() {
    $dir = get_template_directory() . '/anps-framework/widgets';
    if ($handle = opendir($dir)) {
        $arr = array();
        // Get all files and store it to array
        while (false !== ($entry = readdir($handle))) {
            $explode_entry = explode('.', $entry);
            if($explode_entry[1]=='php') {
                $arr[] = $entry;
            }
        }
        closedir($handle); 
      
        /* Remove widgets, ., .. */
        unset($arr[remove_widget('widgets.php', $arr)]); 
        return $arr;
    }
}
/* Remove widget function */
function remove_widget($name, $arr) {
    return array_search($name, $arr);
}
/* Include all widgets */ 
foreach(get_all_widgets() as $item) {
    $item_file = get_template_directory() . '/anps-framework/widgets/'.$item;
    if( file_exists( $item_file ) ) {
        include_once $item_file;
    }
} 
/** Register sidebars by running widebox_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'anps_widgets_init');
function anps_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Sidebar', 'accounting'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'accounting'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Secondary Sidebar', 'accounting'),
        'id' => 'secondary-widget-area',
        'description' => __('Secondary widget area', 'accounting'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Top bar left', 'accounting'),
        'id' => 'top-bar-left',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'accounting'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Top bar right', 'accounting'),
        'id' => 'top-bar-right',
        'description' => __('Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'accounting'),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    $above_nav_bar = get_option('anps_above_nav_bar', '0');
    if ($above_nav_bar=='1') { 
        register_sidebar(array(
            'name' => __('Above navigation bar', 'accounting'),
            'id' => 'above-navigation-bar',
            'description' => __('This is a bar above main navigation. Can only contain Text, Search, Custom menu and WPML Languge selector widgets', 'accounting'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $prefooter = get_option('prefooter');
    if($prefooter=="on") {
        $prefooter_columns = get_option('prefooter_style', '4');
        if($prefooter_columns=='2' || $prefooter_columns=='5' || $prefooter_columns=='6') {
            register_sidebar(array(
                'name' => __('Prefooter column 1', 'accounting'),
                'id' => 'prefooter-1',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter column 2', 'accounting'),
                'id' => 'prefooter-2',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        } elseif($prefooter_columns=='3') {
            register_sidebar(array(
                'name' => __('Prefooter column 1', 'accounting'),
                'id' => 'prefooter-1',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter column 2', 'accounting'),
                'id' => 'prefooter-2',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter column 3', 'accounting'),
                'id' => 'prefooter-3',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        } elseif($prefooter_columns=='4' || $prefooter_columns=='0') {
            register_sidebar(array(
                'name' => __('Prefooter column 1', 'accounting'),
                'id' => 'prefooter-1',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter column 2', 'accounting'),
                'id' => 'prefooter-2',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
            register_sidebar(array(
                'name' => __('Prefooter column 3', 'accounting'),
                'id' => 'prefooter-3',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => __('Prefooter column 4', 'accounting'),
                'id' => 'prefooter-4',
                'description' => __('This wiget area displays before footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
                'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            )); 
        }
    }
    $footer_columns = get_option('footer_style', '4');
    if($footer_columns=='2') {
        register_sidebar(array(
            'name' => __('Footer column 1', 'accounting'),
            'id' => 'footer-1',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer column 2', 'accounting'),
            'id' => 'footer-2',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
    } elseif($footer_columns=='3') {
        register_sidebar(array(
            'name' => __('Footer column 1', 'accounting'),
            'id' => 'footer-1',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer column 2', 'accounting'),
            'id' => 'footer-2',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer column 3', 'accounting'),
            'id' => 'footer-3',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($footer_columns=='4' || $footer_columns=='0') {
        register_sidebar(array(
            'name' => __('Footer column 1', 'accounting'),
            'id' => 'footer-1',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer column 2', 'accounting'),
            'id' => 'footer-2',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )); 
        register_sidebar(array(
            'name' => __('Footer column 3', 'accounting'),
            'id' => 'footer-3',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Footer column 4', 'accounting'),
            'id' => 'footer-4',
            'description' => __('This wiget area displays in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    $copyright_footer = get_option('copyright_footer', '1');
    if($copyright_footer=="1" || $copyright_footer=="0") {
        register_sidebar(array(
            'name' => __('Copyright footer column 1', 'accounting'),
            'id' => 'copyright-1',
            'description' => __('This wiget area displays below all content in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    } elseif($copyright_footer=="2") {
        register_sidebar(array(
            'name' => __('Copyright footer column 1', 'accounting'),
            'id' => 'copyright-1',
            'description' => __('This wiget area displays below all content in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __('Copyright footer column 2', 'accounting'),
            'id' => 'copyright-2',
            'description' => __('This wiget area displays below all content in footer. For more information and to set different number of widget areas, please check "Theme options" -> "Page setup".', 'accounting'),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
    /* Large above menu */
    register_sidebar(array(
        'name' => esc_html__('Large above menu', 'accounting'),
        'id' => 'large-above-menu',
        'description' => esc_html__('Large above menu.', 'accounting'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}