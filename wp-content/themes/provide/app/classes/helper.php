<?php

class provide_Helper {

    private static $instance;

    public function provide_set($var, $key, $def = '') {
        if (!$var) {
            return false;
        }
        if (is_object($var) && isset($var->$key)) {
            return $var->$key;
        } elseif (is_array($var) && isset($var[$key])) {
            return $var[$key];
        } elseif ($def) {
            return $def;
        } else {
            return false;
        }
    }

    function provide_add_to_cart($label = '', $class = '', $image = '', $icon = '') {
        global $product;
        $add_to_cart = '';
        if ($product->is_purchasable() && $product->is_in_stock()) {
            if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes') {
                $add_to_cart = 'add_to_cart_button ajax_add_to_cart';
            } else {
                $add_to_cart = 'add_to_cart_button';
            }
        }
        if($label != '') {
            $inner = $label;
        }elseif($image != '') {
            $inner = '<img src="'. $image .'" alt="" />';
        }elseif($icon != '') {
            $inner = '<i class="'. $icon .'"></i>';
        }else {
            $inner = $label;
        }
        //$inner = ($image) ? '<img src="'. $image .'" alt="" />' : $label;

        $output = apply_filters('woocommerce_loop_add_to_cart_link', 
                sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="' . $class . ' %s product_type_%s">' . $inner . '</a>', esc_url($product->add_to_cart_url()), esc_attr($product->get_id()), esc_attr($product->get_sku()), $add_to_cart, esc_attr($product->get_type()), esc_html($product->add_to_cart_text())
                ), $product);
        return $output;
    }
    
    public function provide_get_the_terms($taxonomy = 'product_cat') {
        $terms = get_terms($taxonomy);
        $list = array();
        if(!empty($terms)) {
            foreach($terms as $term) {
                $list[$this->provide_set($term, 'term_id')] = $this->provide_set($term, 'name');
            }
        }
        return $list;
    }
    
    public function provide_product_orderby($orderby) {
    global $woocommerce;
    $args = array();
    switch ($orderby) {
        case 'popular':
        case 'best_seller':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'by_price':
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
            break;
        case 'onsale':
            $args['meta_query'][] = array(
                'relation' => 'OR',
                array(
                    'key' => '_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                ),
                array(
                    'key' => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',
                    'type' => 'numeric'
                )
            );
            break;
        case 'featued':
            $args['meta_query'][] = array(
                'key' => '_featured',
                'value' => 'yes'
            );
            break;
        case 'date':
            $args['orderby'] = 'date';
            break;
        case 'name':
            $args['orderby'] = 'name';
            break;
        case 'ID':
            $args['orderby'] = 'ID';
            break;
        default :
            $args['orderby'] = 'rand';
    }
        return $args;
    }
    
    public function provide_r($data) {
        echo '<pre>';
        print_r($data);
        exit;
    }

    public function provide_m($key, $id = '') {
        if (empty($id)) {
            $id = get_the_ID();
        }

        return ( get_post_meta($id, $key, true) ) ? get_post_meta($id, $key, true) : '';
    }

    public function provide_userList() {
        $userList = array();
        $allUsers = get_users(array('role__in' => array('administrator', 'author', 'contributor', 'editor')));
        if (!empty($allUsers) && count($allUsers) > 0) {
            foreach ($allUsers as $user) {
                $userList[$user->data->ID] = $user->data->display_name;
            }
        }

        return $userList;
    }

    public function provide_avatar($size = array(), $id = '') {
        $i = new provide_Imagify();
        if (!empty($id)) {
            $id = get_the_ID();
        }
        $customUserAvatar = get_the_author_meta('metaProfilePic', $id);
        if (!empty($customUserAvatar)) {
            return $i->provide_thumb($size, false, array(true, true, true), $customUserAvatar);
        } else {
            return get_avatar(get_the_author_meta($id), $this->provide_set($size, '0'));
        }
    }

    public function provide_url($url = '') {
        if (strpos($url, 'http') === 0) {
            return $url;
        }

        return provide_Uri . 'partial/' . ltrim($url, '/');
    }

    public function provide_cat($arg = array(), $slug = false, $all = false) {
        $categories = get_categories($arg);
        $cats = array();
        if ($all) {
            $cats['all'] = esc_html__('All Categories', 'provide');
        }
        if (!self::provide_set($categories, 'errors')) {
            foreach ($categories as $category) {
                $key = ( $slug ) ? $category->slug : $category->term_id;
                $cats[$key] = $category->name;
            }
        }

        return $cats;
    }

    public function provide_get_post_categories($postID, $taxonomy, $echo = true) {
        $post_terms = wp_get_post_terms($postID, $taxonomy);
        if (!empty($post_terms)) {
            $i = 1;
            foreach ($post_terms as $pterm) {
                if($echo) {
                    echo esc_html($pterm->slug.' ');
                }else {
                    $list[] = $pterm->slug;
                }
                $i++;
            }
            
            if($echo != true) {
                return $list;
            }
        }
    }
    
    public function provide_trems($arg = array(), $slug = false, $all = false) {
        $categories = get_terms(array(
            'taxonomy' => $arg['taxonomy'],
            'hide_empty' => false,
                ));
        $cats = array();
        if ($all) {
            $cats['all'] = esc_html__('All Categories', 'provide');
        }
        if (!self::provide_set($categories, 'errors')) {
            foreach ($categories as $category) {
                $key = ( $slug ) ? $category->slug : $category->term_id;
                $cats[$key] = $category->name;
            }
        }

        return $cats;
    }

    public function provide_check($check) {
        if (!empty($check) && count($check) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function provide_opt() {
        return get_option(provide_OPT);
    }

    public function provide_colorScheme($value = '', $value2 = '') {
        ob_start();
        include( provide_Root . 'partial/css/color.css' );
        $content = ob_get_contents();
        ob_end_clean();
        if (empty($value)) {
            return $content;
        } else {
            $colorContent = str_replace('#00abc9', $value, $content);
            $colorContent .= str_replace('#eeb013', $value2, $colorContent);

            return $colorContent;
        }
    }

    public function provide_sidebar() {
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

    public function provide_header() {
        $opt = ( new provide_Helper())->provide_opt();
        $header = ( ( new provide_Helper())->provide_set($opt, 'optHeaderStyle') ) ? ( new provide_Helper())->provide_set($opt, 'optHeaderStyle') : '';
        get_header($header);
    }

    public function provide_headerTop($id) {
        add_filter('get_the_archive_title', array($this, 'provide_ThemeTitles'));
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $status = '';
        $headerTransparent = $h->provide_set($opt, 'optHeaderTransparent');
        if ($headerTransparent == '1' && $h->provide_set($opt, 'optHeaderStyle') == '1') {
            $extraGap = 'extra-gap';
        } else {
            $extraGap = '';
        }
        if (function_exists('provide_breadcrumb')) {
            provide_breadcrumb();
        }
        if (is_archive()) {
            $status = ( $h->provide_set($opt, 'optArchiveHeader') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'optArchiveHeaderTitle') != '' ) ? $h->provide_set($opt, 'optArchiveHeaderTitle') : get_the_archive_title();
            $hasBg = $h->provide_set($opt, 'optArchiveHeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_author()) {
            $status = ( $h->provide_set($opt, 'optAuthorHeader') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'optAuthorHeaderTitle') != '' ) ? $h->provide_set($opt, 'optAuthorHeaderTitle') : get_the_archive_title();
            $hasBg = $h->provide_set($opt, 'optAuthorHeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_category()) {
            $status = ( $h->provide_set($opt, 'optCategoryHeader') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'optCategoryHeaderTitle') != '' ) ? $h->provide_set($opt, 'optCategoryHeaderTitle') : get_the_archive_title();
            $hasBg = $h->provide_set($opt, 'optCategoryHeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_tag()) {
            $status = ( $h->provide_set($opt, 'optTagHeader') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'optTagHeaderTitle') != '' ) ? $h->provide_set($opt, 'optTagHeaderTitle') : get_the_archive_title();
            $hasBg = $h->provide_set($opt, 'optTagHeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_search()) {
            $status = ( $h->provide_set($opt, 'optSearchHeader') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'optSearchHeaderTitle') != '' ) ? $h->provide_set($opt, 'optSearchHeaderTitle') : get_the_archive_title();
            $hasBg = $h->provide_set($opt, 'optSearchHeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_404()) {
            $status = ( $h->provide_set($opt, 'opt404Header') == '1' ) ? 'on' : '';
            $title = ( $h->provide_set($opt, 'opt404HeaderTitle') != '' ) ? $h->provide_set($opt, 'opt404HeaderTitle') : '';
            $hasBg = $h->provide_set($opt, 'opt404HeaderBg');
            $bg = $h->provide_set($hasBg, 'url');
        }
        if (is_single() || is_page() ) {
            $status = get_post_meta($id, 'metaHeader', true);
            if (is_page()) {
                $title = ( get_post_meta($id, 'metaHeaderTitle', true) ) ? get_post_meta($id, 'metaHeaderTitle', true) : get_the_title();
            } else {
                $title = ( get_post_meta($id, 'metaHeaderTitle', true) ) ? get_post_meta($id, 'metaHeaderTitle', true) : '';
            }
            $bg = get_post_meta($id, 'metaHeaderBg', true);
        }
//        if (!is_home()) {
//            $status = 'on';
//            $bg = '';
//        }
        if ($status == 'on'):
            $i = new provide_Imagify();
            $sizes = array('m' => '545x211', 'i' => '1001x211', 'w' => '1600x209');
            $bgUrl = $i->provide_thumb($sizes, false, array(true, true, true), $bg, 'c', true);
            ?>
            <div class="pagetop <?php echo esc_attr($extraGap) ?>" style="background: url(<?php echo esc_url($bgUrl) ?>) no-repeat scroll 0 0 / cover transparent">
                <div class="container">
            <?php if (!empty($title)): ?>
                        <h1><?php echo wp_kses($title, true) ?></h1>
                        <?php
                    endif;
                    if ($h->provide_set($opt, 'optBreadcumbSetting') == '1') {
                        if (function_exists('provide_breadcrumb')) {
                            new provide_WP_Breadcrumb();
                        }
                    }
                    ?>
                </div>
            </div>
                    <?php
                endif;
            }
            
   function provide_add_to_cart_button($label = '', $class = '', $image = false) {
        global $product;
        $add_to_cart = '';
        if ($product->is_purchasable() && $product->is_in_stock()) {
            if (get_option('woocommerce_enable_ajax_add_to_cart') == 'yes') {
                $add_to_cart = 'add_to_cart_button ajax_add_to_cart';
            } else {
                $add_to_cart = 'add_to_cart_button';
            }
        }
        if($image) {
            $path = provide_Uri. 'partial/images/cart-icon.png';
            $inner = '<img src="'. $path .'" alt="" />';
        }else {
            $inner = $label;
        }
        $output = apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="' . $class . ' %s product_type_%s">' . $inner . '</a>', esc_url($product->add_to_cart_url()), esc_attr($product->get_id()), esc_attr($product->get_sku()), $add_to_cart, esc_attr($product->get_type()), esc_html($product->add_to_cart_text())
                ), $product);
        return $output;
    }

    public function provide_ThemeTitles($title) {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        } else {
            $title = $title;
        }

        return $title;
    }

    public function provide_themeLeftSidebar($id = '', $optlayout = '', $optsidebar = '', $class = '') {
        if (get_post_meta($id, 'metaSidebarLayout', true) != 'full' && get_post_meta($id, 'metaSidebar', true) != '') {
            $layout = get_post_meta($id, 'metaSidebarLayout', true);
            $sidebar = get_post_meta($id, 'metaSidebar', true);
            if ($layout == 'left' && !empty($sidebar) && is_active_sidebar($sidebar)) {
                echo '<div class="col-md-3"><div class="sidebar ' . $class . '">';
                dynamic_sidebar($sidebar);
                echo '</div></div>';
            }
        } else {
            $opt = ( new provide_Helper())->provide_opt();
            $h = new provide_Helper();
            $layout = $h->provide_set($opt, $optlayout);
            $sidebar = $h->provide_set($opt, $optsidebar);
            if ($layout == 'left' && !empty($sidebar) && is_active_sidebar($sidebar)) {
                echo '<div class="col-md-3"><div class="sidebar ' . $class . '">';
                dynamic_sidebar($sidebar);
                echo '</div></div>';
            }
        }
    }

    public function provide_themeRightSidebar($id = '', $optlayout = '', $optsidebar = '', $class = '') {
        if (get_post_meta($id, 'metaSidebarLayout', true) != 'full' && get_post_meta($id, 'metaSidebar', true) != '') {
            $layout = get_post_meta($id, 'metaSidebarLayout', true);
            $sidebar = get_post_meta($id, 'metaSidebar', true);
            if ($layout == 'right' && !empty($sidebar) && is_active_sidebar($sidebar)) {
                echo '<div class="col-md-3"><div class="sidebar ' . $class . '">';
                dynamic_sidebar($sidebar);
                echo '</div></div>';
            }
        } else {
            $opt = ( new provide_Helper())->provide_opt();
            $h = new provide_Helper();
            $layout = $h->provide_set($opt, $optlayout);
            $sidebar = $h->provide_set($opt, $optsidebar);
            if ($layout == 'right' && !empty($sidebar) && is_active_sidebar($sidebar)) {
                echo '<div class="col-md-3"><div class="sidebar ' . $class . '">';
                dynamic_sidebar($sidebar);
                echo '</div></div>';
            }
        }
    }

    public function provide_column($id = '', $optlayout = '', $optsidebar = '') {
        if (get_post_meta($id, 'metaSidebarLayout', true) != 'full' && get_post_meta($id, 'metaSidebar', true) != '') {
            $layout = get_post_meta($id, 'metaSidebarLayout', true);
            $sidebar = get_post_meta($id, 'metaSidebar', true);
            if (!empty($layout) && $layout != 'full' && !empty($sidebar)) {
                return 'col-md-9';
            } else {
                return 'col-md-12';
            }
        } else {
            $opt = ( new provide_Helper())->provide_opt();
            $h = new provide_Helper();
            $layout = $h->provide_set($opt, $optlayout);
            $sidebar = $h->provide_set($opt, $optsidebar);
            if (!empty($layout) && $layout != 'full' && !empty($sidebar)) {
                return 'col-md-9';
            } else {
                return 'col-md-12';
            }
        }
    }

    public function provide_date($echo = true, $format = '') {
        if ($format != '') {
            $dateFormat = $format;
        } else {
            $dateFormat = get_option('post_format');
        }
        if ($echo === true) {
            echo get_the_date($dateFormat);
        } else {
            return get_the_date($dateFormat);
        }
    }

    public function provide_dateLink($echo = true) {
        $year = get_the_time('Y');
        $month = get_the_time('m');
        $day = get_the_time('d');
        if ($echo === true) {
            echo get_day_link($year, $month, $day);
        } else {
            return get_day_link($year, $month, $day);
        }
    }

    public function provide_authorLink($echo = true) {
        if ($echo === true) {
            echo get_author_posts_url(get_the_author_meta('ID'));
        } else {
            return get_author_posts_url(get_the_author_meta('ID'));
        }
    }

    public function provide_comments($id, $echo = true) {
        if ($echo === true) {
            echo esc_html($this->provide_restyleText(get_comments_number($id)));
        } else {
            return $this->provide_restyleText(get_comments_number($id));
        }
    }

    public function provide_get_terms($taxonomy, $number = 3, $format = '', $anchor = true, $seprator = ', ') {
        global $post;
        $counter = 1;
        $terms = get_the_terms($post->ID, $taxonomy);
        if (!empty($terms) && count($terms) > 0) {
            $countTerm = count($terms);
            foreach ($terms as $term) {
                $sep = ( $counter == $countTerm ) ? '' : $seprator;
                if ($counter == $number) {
                    break;
                }
                if ($anchor == 1) {
                    if (!empty($format)) {
                        echo '<' . $format . '><a href="' . esc_url(get_term_link($term->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'provide'), $term->slug)) . '">' . $term->name . '</a>' . $sep . ' </' . $format . '>';
                    } else {
                        echo '<a href="' . esc_url(get_term_link($term->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(__("View all posts in %s", 'provide'), $term->slug)) . '">' . $term->name . '</a>' . $sep;
                    }
                } else {
                    echo esc_html($term->name) . $sep . ' ';
                }
                $counter ++;
            }
        }
    }

    public function provide_getTags() {
        $tags = get_the_tags();
        if ($tags):
            foreach ($tags as $tag):
                echo '<a href="' . esc_url(get_tag_link($this->provide_set($tag, 'term_id'))) . '" title="' . esc_attr($this->provide_set($tag, 'slug')) . '">' . esc_html($this->provide_set($tag, 'name')) . '</a>';
            endforeach;
        endif;
    }

    function provide_restyleText($n, $precision = 1) {
        if ($n < 900) {
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return ' ' . $n_format . $suffix;
    }

    function provide_socialShare($shares = array(), $color = false, $show_title = false, $list = false) {
        $permalink = get_permalink(get_the_ID());
        $titleget = get_the_title();
        if (in_array('facebook', $shares)) {
            echo ( $list === true ) ? '<li>' : '';
            ?>
    <a onClick="window.open('http://www.facebook.com/sharer.php?u=<?php echo esc_url($permalink); ?>', 'Facebook', 'width=600,height=300,left=' + (screen.availWidth / 2 - 300) + ',top=' + (screen.availHeight / 2 - 150) + '');
                        return false;" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($permalink); ?>" class="facebook" style="transition-delay: 0ms;">
        <i class="fa fa-facebook"></i><?php echo ( $show_title ) ? "<span>Facebook</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('twitter', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a onClick="window.open('http://twitter.com/share?url=<?php echo esc_url($permalink); ?>&amp;text=<?php echo str_replace(" ", "%20", $titleget); ?>', 'Twitter share', 'width=600,height=300,left=' + (screen.availWidth / 2 - 300) + ',top=' + (screen.availHeight / 2 - 150) + '');
                        return false;" href="http://twitter.com/share?url=<?php echo esc_url($permalink); ?>&amp;text=<?php echo str_replace(" ", "%20", $titleget); ?>" class="twitter" style="transition-delay: 50ms;">
        <i class="fa fa-twitter"></i><?php echo ( $show_title ) ? "<span>Twitter</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('google-plus', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a onClick="window.open('https://plus.google.com/share?url=<?php echo esc_url($permalink); ?>', 'Google plus', 'width=585,height=666,left=' + (screen.availWidth / 2 - 292) + ',top=' + (screen.availHeight / 2 - 333) + '');
                        return false;" href="https://plus.google.com/share?url=<?php echo esc_url($permalink); ?>" class="google-plus">
        <i class="fa fa-google-plus"></i><?php echo ( $show_title ) ? "<span>Google Plus</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('reddit', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a onClick="window.open('http://reddit.com/submit?url=<?php echo esc_url($permalink); ?>&amp;title=<?php echo str_replace(" ", "%20", $titleget); ?>', 'Reddit', 'width=617,height=514,left=' + (screen.availWidth / 2 - 308) + ',top=' + (screen.availHeight / 2 - 257) + '');
                        return false;" href="http://reddit.com/submit?url=<?php echo esc_url($permalink); ?>&amp;title=<?php echo str_replace(" ", "%20", $titleget); ?>" class="reddit">
        <i class="fa fa-reddit"></i><?php echo ( $show_title ) ? "<span>Reddit</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('linkedin', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a onClick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($permalink); ?>', 'Linkedin', 'width=863,height=500,left=' + (screen.availWidth / 2 - 431) + ',top=' + (screen.availHeight / 2 - 250) + '');
                        return false;" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($permalink); ?>" class="linkedin">
        <i class="fa fa-linkedin"></i><?php echo ( $show_title ) ? "<span>Linkedin</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('pinterest', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());' class="pinterest" style="transition-delay: 100ms;">
        <i class="fa fa-pinterest"></i><?php echo ( $show_title ) ? "<span>Pinterest</span>" : ""; ?></a>
    <?php
    echo ( $list === true ) ? '</li>' : '';
}
?>

<?php
if (in_array('tumblr', $shares)) {
    $str = $permalink;
    $str = preg_replace('#^https?://#', '', $str);
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a onClick="window.open('http://www.tumblr.com/share/link?url=<?php echo esc_url($str); ?>&amp;name=<?php echo str_replace(" ", "%20", $titleget); ?>', 'Tumblr', 'width=600,height=300,left=' + (screen.availWidth / 2 - 300) + ',top=' + (screen.availHeight / 2 - 150) + '');
                        return false;" href="http://www.tumblr.com/share/link?url=<?php echo esc_url($str); ?>&amp;name=<?php echo str_replace(" ", "%20", $titleget); ?>" class="tumbler">
        <i class="fa fa-tumblr"></i><?php echo ( $show_title ) ? "<span>Tumblr</span>" : ""; ?></a>
       <?php
       echo ( $list === true ) ? '</li>' : '';
   }
   ?>
<?php
if (in_array('envelope-o', $shares)) {
    echo ( $list === true ) ? '<li>' : '';
    ?>
    <a href="mailto:?Subject=<?php echo str_replace(" ", "%20", $titleget); ?>&amp;Body=<?php echo esc_url($permalink); ?>"><i class="fa fa-envelope"></i></a>
    <?php
    echo ( $list === true ) ? '</li>' : '';
}
}

    static public function provide_posts($post_type) {
        $result = array();
        $args = array('post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => - 1,);
        $posts = get_posts($args);
        if ($posts) {
            foreach ($posts as $post) {
                $result[$post->ID] = $post->post_title;
            }
        }

        return $result;
    }

    public function provide_vcArray($list = array(), $multi = array()) {
        $array = require_once( provide_Root . 'app/lib/shortcodes/arrayset.php' );
        $temp = array();
        if (!empty($list)) {
            foreach ($list as $item) {
                $temp[] = $array[$item];
            }
        }
        if (!empty($multi)) {
            $hasMulti[] = array("type" => "multiselect", "heading" => sprintf(esc_html__('%s', 'provide'), self::provide_set($multi, 'h')), "param_name" => self::provide_set($multi, 'n'), "value" => self::provide_set($multi, 'v'), "description" => self::provide_set($multi, 'd'),);
            $temp = array_merge_recursive($temp, $hasMulti);
        }

        return $temp;
    }

    public function provide_pagi($args = array(), $echo = 1) {
        global $wp_query, $wp_rewrite;
        $current = max(1, get_query_var('paged'));
        $default = array('base' => str_replace(99999, '%#%', esc_url(get_pagenum_link(99999))), 'format' => '?paged=%#%', 'current' => $current, 'total' => $wp_query->max_num_pages, 'show_all' => false, 'end_size' => 2, 'mid_size' => 2, 'total' => self::provide_set($args, 'total'), 'next_text' => '<i class="fa fa-angle-right"></i>', 'prev_text' => '<i class="fa fa-angle-left"></i>', 'type' => 'array');
        $pagination = wp_parse_args($args, $default);
        if ($wp_rewrite->using_permalinks()) {
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
        }
        if (!empty($wp_query->query_vars['s'])) {
            $pagination['add_args'] = array('s' => get_query_var('s'));
        }
        $pages = paginate_links($pagination);
        if (!empty($pages)) {
            echo '<div class="provide-pagination"><ul>';
            if ($current == 1) {
                echo '<li><a class="prev" href="javascript:void(0)" title=""><i class="fa fa-angle-left"></i></a></li>';
            }
            $counter = 0;
            foreach ($pages as $page) :
                if ($current > 1 && $counter == 0) {
                    echo '<li>' . $page . '</li>';
                } else {
                    echo '<li>' . $page . '</li>';
                }
                $counter ++;
            endforeach;
            if ($current == self::provide_set($args, 'total')) {
                echo '<li><a class="next" href="javascript:void(0)" title=""><i class="fa fa-angle-right"></i></a></li>';
            }
            echo '</ul></div>';
        }
    }

    public function provide_resHeader() {
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $logo = $h->provide_set($opt, 'optHeaderLogo');
        $topBar = $h->provide_set($opt, 'optResponsiveHeaderTopBar');
        $topBarAddress = $h->provide_set($opt, 'optResponsiveHeaderTopBarAddress');
        $topBarSocial = $h->provide_set($opt, 'optResponsiveHeaderTopBarSocial');
        $socialList = $h->provide_set($opt, 'optHeaderSixTopBarSocialIcons');
        $topBarSearch = $h->provide_set($opt, 'optResponsiveHeaderTopBarSearch');
        $headerContactinfo = $h->provide_set($opt, 'optResponsiveHeaderContactInfo');
        $optcontact_one_header = $h->provide_set($opt, 'optcontact_one_header');
        $optcontact_one_icon = $h->provide_set($opt, 'optcontact_one_icon');
        $optcontact_one_text = $h->provide_set($opt, 'optcontact_one_text');
        $optcontact_one_content = $h->provide_set($opt, 'optcontact_one_content');
        $optcontact_two_header = $h->provide_set($opt, 'optcontact_two_header');
        $optcontact_two_icon = $h->provide_set($opt, 'optcontact_two_icon');
        $optcontact_two_text = $h->provide_set($opt, 'optcontact_two_text');
        $optcontact_two_content = $h->provide_set($opt, 'optcontact_two_content');
        $optcontact_three_header = $h->provide_set($opt, 'optcontact_three_header');
        $optcontact_three_icon = $h->provide_set($opt, 'optcontact_three_icon');
        $optcontact_three_text = $h->provide_set($opt, 'optcontact_three_text');
        $optcontact_three_content = $h->provide_set($opt, 'optcontact_three_content');
        $optcontact_four_icon = $h->provide_set($opt, 'optcontact_four_icon');
        $optcontact_four_content = $h->provide_set($opt, 'optcontact_four_content');


        $mediaList = array();
        if (!empty($socialList)) {
            foreach ($socialList as $s) {
                $data = json_decode(urldecode($h->provide_set($s, 'data')));
                if ($data->enable == 'true') {
                    $mediaList[] = $data;
                }
            }
        }
        ?>
        <div class="responsive-header">
        <?php if ($topBar == '1'): ?>
                <div class="responsive-topbar">
                <?php if ($topBarAddress == '1'): ?>
                        <p class="top-address">
                            <i class="<?php echo $optcontact_four_icon; ?>"></i> 
                        <?php $i = 0;
                        if($optcontact_four_content) {
                        foreach ($optcontact_four_content as $content) {
                            ?>
                                <?php echo $optcontact_four_content[$i]; ?>
                                <?php $i++;
                            }
                        }
                            ?>
                            
                        </p>
                    <?php endif; ?>
                    <?php if ($topBarSocial == '1' || $topBarSearch == '1'): ?>
                        <div class="responsive-header-exts">
                            <?php
                            if ($topBarSocial == '1' && count($mediaList) > 0) {
                                echo '<div class="socials">';
                                foreach ($mediaList as $list) {
                                    echo '<a href="' . esc_url($list->url) . '"><i class="fa ' . esc_attr($list->icon) . '"></i></a>';
                                }
                                echo '</div>';
                            }
                            ?>
                            <?php if ($topBarSearch == '1'): ?>
                                <div class="header-search">
                                    <a href="javascript:void(0)" title=""><i class="fa fa-search"></i></a>
                                    <form>
                                        <input type="text" name="s" placeholder="<?php esc_html_e('Enter Your Search', 'provide') ?>"/>
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- Responsive Topbar -->
            <?php endif; ?>
            <div class="responsive-logobar">
                <div class="responsive-logo">
                    <?php
                    if ($h->provide_set($logo, 'url') == ''):
                        if (is_front_page() && is_home()) :
                            ?>
                            <h1>
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                            </h1>
                        <?php else : ?>
                            <p>
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                            </p>
                        <?php
                        endif;
                    else:
                        ?>

                        <a href="<?php echo esc_url(home_url('/')) ?>" title="">
                            <img src="<?php echo esc_url($h->provide_set($logo, 'url')) ?>" alt=""/>
                        </a>

                    <?php endif; ?>
                </div>
                <a class="menu-button" href="javascript:void(0)" title=""><i class="fa fa-bars"></i></a>
            </div><!-- Responsive Logbar -->
            <div class="responsive-menu">
                <a class="close-menu" href="javascript:void(0)" title=""><i class="fa fa-remove"></i></a>
                <?php
                $args = array(
                    'theme_location' => 'responsive',
                    'items_wrap' => '%3$s',
                    'container' => '',
                    'echo' => false,
                );
                $list = array('<div class="menu">', '</div>');
                echo '<ul>' . str_replace($list, '', wp_nav_menu($args)) . '</ul>';
                ?>
                <?php if ($headerContactinfo == '1'): ?>
                    <div class="header-contact">
                        <div class="row">
                            <?php if ($optcontact_one_header == '1'): ?>
                                <div class="col-md-4">
                                    <div class="info">
                                        <i class="<?php echo $optcontact_one_icon; ?>"></i>
                                        <strong><?php echo esc_html($optcontact_one_text) ?> 
                <?php $i = 0;
                if($optcontact_one_content) {
                foreach ($optcontact_one_content as $content) {
                    ?>
                                                <span><?php echo $optcontact_one_content[$i]; ?></span>
                                                <?php $i++;
                                            }
                }
                                            ?>
                                        </strong>
                                    </div><!-- Info -->
                                </div>
                            <?php endif; ?>
                            <?php if ($optcontact_two_header == '1'): ?>
                                <div class="col-md-4">
                                    <div class="info">
                                        <i class="<?php echo $optcontact_two_icon; ?>"></i>
                                        <strong><?php echo esc_html($optcontact_two_text) ?> 
                                            <?php $i = 0;
                                            if($optcontact_two_content) {
                                            foreach ($optcontact_two_content as $content) {
                                                ?>
                                                <span><a href="mailto:<?php echo $optcontact_two_content[$i]; ?>"><?php echo $optcontact_two_content[$i]; ?></a></span>
                                                <?php $i++;
                                            }
                                            }
                                            ?>
                                        </strong>
                                    </div><!-- Info -->
                                </div>
                            <?php endif; ?>
                            <?php if ($optcontact_three_header == '1'): ?>
                                <div class="col-md-4">
                                    <div class="info">
                                        <i class="<?php echo $optcontact_three_icon; ?>"></i>
                                        <strong><?php echo esc_html($optcontact_three_text) ?> 
                                            <?php $i = 0;
                                            if($optcontact_three_content) {
                                            foreach ($optcontact_three_content as $content) {
                                                ?>
                                                <span><a href="tel:<?php echo $optcontact_three_content[$i]; ?>"><?php echo $optcontact_three_content[$i]; ?></a></span>
                                                <?php $i++;
                                            }
                                            }
                                            ?>
                                        </strong>
                                    </div><!-- Info -->
                                </div>
                    <?php endif; ?>
                        </div>
                    </div>
        <?php endif; ?>

            </div>
        </div><!-- Responsive Header -->

        <?php
    }

    public function provide_siteLoader() {
        $h = new provide_Helper();
        $opt = ( new provide_Helper())->provide_opt();
        $isLoader = $h->provide_set($opt, 'optSiteLoader');
        if ($isLoader == 1) {
            $loader = $h->provide_set($opt, 'optThemeLoader');
            switch ($loader) {
                case '1':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-pulse">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '2':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-grid-pulse">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '3':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-clip-rotate">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '4':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-clip-rotate-pulse">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '5':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner square-spin">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '6':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-clip-rotate-multiple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '7':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-pulse-rise">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '8':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-rotate">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '9':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner cube-transition">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '10':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-zig-zag">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '11':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-zig-zag-deflect">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '12':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-triangle-path">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '13':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-scale">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '14':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner line-scale">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '15':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner line-scale-party">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '16':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-scale-multiple">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '17':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-pulse-sync">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '18':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '19':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner line-scale-pulse-out">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '20':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner line-scale-pulse-out-rapid">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '21':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-scale-ripple">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '22':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-scale-ripple-multiple">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '23':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-spin-fade-loader">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '24':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner line-spin-fade-loader">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '25':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner triangle-skew-spin">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '26':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner pacman">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '27':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner ball-grid-beat">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
                case '28':
                    ?>
                    <div class="pageloader">
                        <div class="loader">
                            <div class="loader-inner semi-circle-spin">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    break;
            }
        }
    }

    public function provide_vcTitle($style = '', $title, $subTitle, $desc) {
        $titleHtml = '';
        switch ($style) {
            case '1':
                $titleHtml .= '<div class="detailed-title">
					<h2>' . esc_html($title) . '</h2>
					' . esc_html($desc) . '
				</div>';
                break;
            case '2':
                $titleHtml .= '<div class="title">
					<h2>' . esc_html($title) . '</h2>
					<span>' . esc_html($subTitle) . '</span>
				</div>';
                break;
            case '3':
                $titleHtml .= '<div class="fancy-title">
					<h2>' . esc_html($title) . '</h2>
					<span>' . esc_html($subTitle) . '</span>
				</div>';
                break;
            case '4':
                $titleHtml .= '<div class="side-title">
					<h2>' . esc_html($title) . '</h2>
					<span>' . esc_html($subTitle) . '</span>
				</div>';
                break;
            case '5':
                $titleHtml .= '<div class="simple-title">
					<h2>' . esc_html($title) . '</h2>
					' . esc_html($desc) . '
				</div>';
                break;
            case '6':
                $titleHtml .= '<h3 class="elegent-title">' . esc_html($title) . '</h3>';
                break;
            case '7':
                $titleHtml .= '<div class="title style2">
					<h2>' . esc_html($title) . '</h2>
					<span>' . esc_html($subTitle) . '</span>
				</div>';
                break;
            case '8':
                $titleHtml .= '<div class="parallax-title">
                    <span>' . esc_html($subTitle) . '</span>
					<h2>' . esc_html($title) . '</h2>
					' . esc_html($desc) . '
				</div>';
                break;
        }

        return $titleHtml;
    }

    public function provide_queryFilter($filter, $post_type = 'post') {
        $args = array();

        if ($filter == 'random') {
            $args = array(
                'post_type' => $post_type,
                'order' => 'ASC',
                'orderby' => 'rand',
            );
        } elseif ($filter == 'asc_title') {
            $args = array(
                'post_type' => $post_type,
                'order' => 'ASC',
                'orderby' => 'title',
            );
        } elseif ($filter == 'desc_title') {
            $args = array(
                'post_type' => $post_type,
                'order' => 'DESC',
                'orderby' => 'title',
            );
        } elseif ($filter == 'author') {
            $args = array(
                'post_type' => $post_type,
                'orderby' => 'author',
            );
        } elseif ($filter == 'commented') {
            $args = array(
                'post_type' => $post_type,
                'orderby' => 'comment_count',
            );
        } elseif ($filter == 'today') {
            $today = getdate();
            $args = array(
                'post_type' => $post_type,
                'date_query' => array(
                    array(
                        'year' => $today['year'],
                        'month' => $today['mon'],
                        'day' => $today['mday'],
                    ),
                ),
            );
        } elseif ($filter == 'today_rand') {
            $today = getdate();
            $args = array(
                'post_type' => $post_type,
                'orderby' => 'rand',
                'date_query' => array(
                    array(
                        'year' => $today['year'],
                        'month' => $today['mon'],
                        'day' => $today['mday'],
                    ),
                ),
            );
        } elseif ($filter == 'weekly') {
            $args = array(
                'post_type' => $post_type,
                'date_query' => array(
                    array(
                        'year' => date('Y'),
                        'week' => date('W'),
                    ),
                ),
            );
        } elseif ($filter == 'weekly_random') {
            $args = array(
                'post_type' => $post_type,
                'orderby' => 'rand',
                'date_query' => array(
                    array(
                        'year' => date('Y'),
                        'week' => date('W'),
                    ),
                ),
            );
        } elseif ($filter == 'upcoming') {
            $args = array(
                'post_type' => $post_type,
                'post_status' => 'future',
                'orderby' => 'date',
                'order' => 'ASC'
            );
        } elseif ($filter == 'popular') {
            $args = array(
                'post_type' => $post_type,
                'meta_key' => 'provide_post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            );
        } elseif ($filter == 'featured') {
            $args = array(
                'post_type' => $post_type,
                'meta_query' => array(
                    array(
                        'key' => 'magup_featured_metabox',
                        'value' => 'true',
                        'compare' => '=',
                    )
                )
            );
        }

        return $args;
    }

    public function provide_commentsNumber($nooped_plural) {
        $count = get_comments_number();
        printf(translate_nooped_plural($nooped_plural, $count), $count);
    }

    public function provide_getCommentNo() {
        $num_comments = get_comments_number();
        if ($num_comments == 0) {
            echo '0';
        } else {
            echo esc_html($this->provide_restyleText((int) $num_comments));
        }
    }

    public function provide_setView($postId) {
        $count_key = 'provide_post_views_count';
        $count = get_post_meta($postId, $count_key, true);
        $count ++;
        update_post_meta($postId, $count_key, $count);
    }

    public function provide_getView($postId, $echo = true) {
        $count_key = 'provide_post_views_count';
        $count = get_post_meta($postId, $count_key, true);
        if (count($count) > 0) {
            $view = $this->provide_restyleText((int) $count);
        } else {
            $view = 0;
        }
        if ($echo == true) {
            echo esc_html($view);
        } else {
            return esc_html($view);
        }
    }

    public function provide_timeZone() {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
        }

        $zoneList = array();
        foreach ($zones_array as $list) {
            $zoneList[$list['zone'] . '|||' . $list['diff_from_GMT']] = 'UTC/GMT ' . $list['diff_from_GMT'] . ' ' . $list['zone'];
        }

        return $zoneList;
    }

    public static function provide_singleton() {
        if (!isset(self::$instance)) {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }

        return self::$instance;
    }

    
    public function provide_cart_dropdown() {
        global $woocommerce;
        ?>
        
        <?php if ($woocommerce->cart->get_cart()): ?>
            
            <div class="cart-item-list">
                <span class="close-cart-list">x</span>
                <div class="cart-item-sec">
                    <span class="sub-total"><?php echo esc_html__('SUBTOTAL ', 'provide'); ?><strong><?php echo "( ".WC()->cart->get_cart_total()." ) "; ?></strong></span>
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="" class="proceed-checkout"><?php echo esc_html__('PROCEED TO CHECKOUT', 'provide'); ?></a>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="" class="proceed-cart"><?php echo esc_html__('GOTO CART PAGE', 'provide'); ?></a>
                </div>
                <ul>
                    <?php
                        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('provide_100x115'), $cart_item, $cart_item_key);
                    ?>
                    <li>
                        <div class="cart-item">
                            <div class="cart-item-thumb">
                                <?php 
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="del-cart-item" title="%s"><i class="fa fa-close"></i></a>', esc_url(WC()->cart->get_remove_url($cart_item_key)), ''), $cart_item_key); 
                                    if (!$_product->is_visible())
                                        printf('<span>$</span>', $thumbnail);
                                    else
                                        printf('<span><a href="%s">%s</a></span>', $_product->get_permalink(), $thumbnail);
                                ?>
                            </div>
                            <?php
                                if (!$_product->is_visible())
                                    echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key);
                                else
                                    echo apply_filters('woocommerce_cart_item_name', sprintf('<h3><a href="%s">%s</a></h3>', $_product->get_permalink(), $_product->get_title()), $cart_item, $cart_item_key);
                            ?>
                            <div class="price-quantity">
                                <?php 
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); 
                                    echo WC()->cart->get_item_data($cart_item);
                                ?>
                            </div>
                        </div>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="cart-item-list">
                <span class="close-cart-list">x</span>
                <h5><?php esc_html_e('Cart is Empty', 'provide'); ?></h5>
            </div>
        <?php
        endif;
    }

    public function __clone() {
        trigger_error(esc_html__('Cloning the registry is not permitted', 'provide'), E_USER_ERROR);
    }

}
