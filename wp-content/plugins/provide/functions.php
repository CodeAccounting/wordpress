<?php

function provide_get_categories($arg = false, $slug = false, $vp = false, $all = false)
{
    global $wp_taxonomies;
    $categories = get_categories($arg);
    $cats = array();
    if (provide_set($arg, 'show_all') && $vp)
        $cats[] = array('value' => 'all', 'label' => esc_html__('All Categories', 'provide'));
    elseif (provide_set($arg, 'show_all'))
        $cats['all'] = esc_html__('All Categories', 'provide');
    if (!provide_set($categories, 'errors')) {
        foreach ($categories as $category) {
            if ($vp) {
                $key = ($slug) ? $category->slug : $category->term_id;
                $cats[] = array('value' => $key, 'label' => $category->name);
            } else {
                $key = ($slug) ? $category->slug : $category->term_id;
                $cats[$key] = $category->name;
            }
        }
    }
    return $cats;
}

if (!function_exists('provide_set')) {
    function provide_set($var, $key, $def = '')
    {
        if (!$var) {
            return FALSE;
        }
        if (is_object($var) && isset($var->$key)) {
            return $var->$key;
        } elseif (is_array($var) && isset($var[$key])) {
            return $var[$key];
        } elseif ($def) {
            return $def;
        } else {
            return FALSE;
        }
    }
}

function provide_posts($post_type)
{
    $result = array();
    $args = array('post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => -1,);
    $posts = get_posts($args);
    if ($posts) {
        foreach ($posts as $post) {
            $result[$post->ID] = $post->post_title;
        }
    }

    return $result;
}

function provide_sidebar()
{
    $registerSidebar = get_option('sidebars_widgets');
    array_pop($registerSidebar);
    array_shift($registerSidebar);
    $result = array();
    $keys = array_keys($registerSidebar);
    foreach ($keys as $key) {
        $remove = str_replace('-', ' ', $key);
        $result[$key] = ucwords($remove);
    }

    return $result;
}

$page = isset($_GET['page']) ? $_GET['page'] : '';
if ($page != 'themeOptions') {
    add_action('admin_enqueue_scripts', 'provide_renderExtScripts');
}

function provide_renderExtScripts()
{
    $style = array(
        'ext-fontawesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css',
        'ext-iconbox' => 'metabox/css/iconbox.css'
    );
    foreach ($style as $name => $file) {
        $handle = 'provide-' . $name;
        wp_enqueue_style($handle, provide_url($file), array(), '', 'all');
    }

    $scripts = array(
        'ext-icon-box-scroll' => 'metabox/js/social_media_scroll.min.js',
        'ext-icon-box-script' => 'metabox/js/scripts.js'
    );
    foreach ($scripts as $name => $file) {
        $handle = 'provide-' . $name;
        wp_enqueue_script($handle, provide_url($file), array(), '', 'all');
    }
}

function provide_url($url = '')
{
    if (strpos($url, 'http') === 0 || strpos($url, 'https') === 0) {
        return $url;
    }

    return PLUGIN_URI . ltrim($url, '/');
}

function provide_IconBoxIcons()
{
    //delete_transient( 'provide_iconbox' );
    if (FALSE === ($icons = get_transient('provide_iconbox'))) {
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before/';
        $subject = wp_remote_get('https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css');
        preg_match_all($pattern, wp_remote_retrieve_body($subject), $matches, PREG_SET_ORDER);
        $icons = array();
        foreach ($matches as $match) {
            $icons[] = 'fa ' . $match[1];
        }
        set_transient('provide_iconbox', $icons, 60 * 60 * 24);
    }

    return $icons;
}


if (!function_exists('provide_userIp')) {
    function provide_userIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return apply_filters('wpb_get_ip', $ip);
    }
}

if (!function_exists('provide_decrypt')) {

    function provide_decrypt($param)
    {
        return base64_decode($param);
    }

}

if (!function_exists('provide_encrypt')) {

    function provide_encrypt($param)
    {
        return base64_encode($param);
    }

}
if (!function_exists('provide_insta')) {

    function provide_insta()
    {
        require_once 'Instagram.php';
    }

}