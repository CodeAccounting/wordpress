<?php

$optName = provide_OPT;
$theme = wp_get_theme();
$args = array(
    'default_show' => FALSE,
    'disable_tracking' => FALSE,
    'opt_name' => $optName,
    'use_cdn' => FALSE,
    'display_name' => 'Provide',
    'display_version' => FALSE,
    'page_slug' => 'themeOptions',
    'page_title' => esc_html__('Theme Options', 'provide'),
    'update_notice' => FALSE,
    'admin_bar' => TRUE,
    'menu_type' => 'submenu',
    'menu_title' => esc_html__('Theme Options', 'provide'),
    'allow_sub_menu' => TRUE,
    'page_parent' => 'themes.php',
    'page_parent_post_type' => '',
    'customizer' => TRUE,
    'default_mark' => '*',
    'google_api_key' => '',
    'class' => 'provide',
    'hints' => array(
        'icon_position' => 'right',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'light',
            'shadow' => '1',
            'rounded' => '1',
            'style' => 'youtube',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'duration' => '500',
                'event' => 'mouseover mouseenter click',
            ),
            'hide' => array(
                'effect' => 'fade',
                'duration' => '500',
                'event' => 'mouseleave unfocus',
            ),
        ),
    ),
    'output' => TRUE,
    'output_tag' => TRUE,
    'settings_api' => TRUE,
    'cdn_check_time' => '1440',
    'compiler' => TRUE,
    'global_variable' => provide_GLOBEL,
    'page_permissions' => 'manage_options',
    'save_defaults' => TRUE,
    'show_import_export' => FALSE,
    'open_expanded' => FALSE,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => TRUE,
    'hide_reset' => TRUE,
    'async_typography' => TRUE,
);
Redux::setArgs($optName, $args);

$files = glob(provide_Root . 'app/lib/options/*.php');
if (!empty($files) && count($files) > 0) {
    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        require_once provide_Root . 'app/lib/options/' . (new provide_Helper)->provide_set($fileInfo, 'filename') . '.php';
    }
}

$filesArray = provide_ThemeInit::provide_singleton()->provide_getSetting('optionsArray');
if (!empty($filesArray) && count($filesArray) > 0) {
    $optionsArray = array();
    foreach ($filesArray as $parent => $option) {
        $siplit = explode('_', $parent, 2);
        $class = 'provide_' . (new provide_Helper())->provide_set($siplit, '0') . ucfirst((new provide_Helper())->provide_set($siplit, '1'));
        $getMethods = get_class_methods($class);
        $method = (new provide_Helper())->provide_set($getMethods, '3');
        $getProperties = get_class_vars($class);
        $mainMenuRun = new $class;
        $title = $mainMenuRun->__get('title');
        $desc = $mainMenuRun->__get('desc');
        $icon = $mainMenuRun->__get('icon');
        $id = $mainMenuRun->__get('ids');
        $menu = array(
            'title' => $title,
            'id' => $id,
            'desc' => $desc,
            'fields' => (new $class())->$method()
        );
        if (!empty($icon)) {
            $menu['icon'] = 'el ' . $icon;
        }
        Redux::setSection($optName, $menu);

        if (is_array($option) && !empty($option)) {
            foreach ($option as $subMenu) {
                $siplit = explode('_', $subMenu, 2);
                $class = 'provide_' . (new provide_Helper())->provide_set($siplit, '0') . ucfirst((new provide_Helper())->provide_set($siplit, '1'));
                $getMethods = get_class_methods($class);
                $method = (new provide_Helper())->provide_set($getMethods, '3');
                $getProperties = get_class_vars($class);
                $innerMenuRun = new $class;
                $title = $innerMenuRun->__get('title');
                $desc = $innerMenuRun->__get('desc');
                $icon = $innerMenuRun->__get('icon');
                $id = $innerMenuRun->__get('ids');
                $innerMenu = array(
                    'title' => $title,
                    'id' => $id,
                    'desc' => $desc,
                    'subsection' => true,
                    'fields' => (new $class())->$method()
                );
                if (!empty($icon)) {
                    $menu['icon'] = 'el ' . $icon;
                }
                Redux::setSection($optName, $innerMenu);
            }
        }
    }
}
