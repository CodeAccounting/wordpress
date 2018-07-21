<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
        <?php
        $h = new provide_Helper;
        $opt = $h->provide_opt();
        $logo = $h->provide_set($opt, 'optHeaderLogo');
        $social = $h->provide_set($opt, 'optHeaderTopBarSocial');
        $socialList = $h->provide_set($opt, 'optHeaderSixTopBarSocialIcons');
        $mediaList = array();
        $topBar = $h->provide_set($opt, 'optHeaderTopBar');
        $topBarSocial = $h->provide_set($opt, 'optHeaderTopBarSocial');
        $topBarSearch = $h->provide_set($opt, 'optHeaderTopBarSearch');
        $headerQuote = $h->provide_set($opt, 'optHeaderQuoteButton');
        $headerSticky = $h->provide_set($opt, 'optHeaderSticky');
        $headerTranasparent = $h->provide_set($opt, 'optHeaderTransparent');
        $googleAnalytics = $h->provide_set($opt, 'optGoogleAnalytics');


        $show_time = $h->provide_set($opt, 'optcontact_one_header');
        $show_email = $h->provide_set($opt, 'optcontact_two_header');
        $show_phone = $h->provide_set($opt, 'optcontact_three_header');
        
        $optcontact_one_icon = $h->provide_set($opt, 'optcontact_one_icon');
        $optcontact_one_text = $h->provide_set($opt, 'optcontact_one_text');
        $optcontact_one_content = $h->provide_set($opt, 'optcontact_one_content');
        $optcontact_two_icon = $h->provide_set($opt, 'optcontact_two_icon');
        $optcontact_two_text = $h->provide_set($opt, 'optcontact_two_text');
        $optcontact_two_content = $h->provide_set($opt, 'optcontact_two_content');
        $optcontact_three_icon = $h->provide_set($opt, 'optcontact_three_icon');
        $optcontact_three_text = $h->provide_set($opt, 'optcontact_three_text');
        $optcontact_three_content = $h->provide_set($opt, 'optcontact_three_content');

        $show_address = $h->provide_set($opt, 'optcontact_show_address');

        $optcontact_four_icon = $h->provide_set($opt, 'optcontact_four_icon');
        $optcontact_four_content = $h->provide_set($opt, 'optcontact_four_content');
        



        if (!empty($socialList)) {
            foreach ($socialList as $s) {
                $data = json_decode(urldecode($h->provide_set($s, 'data')));
                if ($data->enable == 'true') {
                    $mediaList[] = $data;
                }
            }
        }

        wp_head();
        $boxed = ( $h->provide_set($opt, 'themeBoxedLayout') == '1' ) ? 'boxed' : '';
        ?>
        <script><?php echo $googleAnalytics; ?></script>
    </head>
    <body <?php body_class(); ?>>
        <div class="theme-layout <?php echo esc_attr($boxed) ?>">
            <header class="<?php echo esc_attr(( $headerTranasparent == '1' ) ? 'style2' : '' ) ?>">
                <?php if ($topBar == '1'): ?>
                    <div class="topbar">
                        <div class="container">
                            <?php if($show_address && !empty($optcontact_four_content)) : ?>
                            <p class="top-address">
                                <i class="<?php echo $optcontact_four_icon; ?>"></i>
                                <?php
                                    $i = 0;                                
                                    foreach ($optcontact_four_content as $content) {
                                        if($i==0) {
                                            echo $content;
                                        }
                                        $i++;
                                    }
                                ?>
                            </p>
                            <?php endif; ?>
                            
                            
                                <?php if ($topBarSocial == '1' || $topBarSearch == '1'): ?>
                                <div class="header-exts">
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
                                            <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                                                <input type="text" name="s" placeholder="<?php esc_html_e('Enter Your Search', 'provide') ?>"/>
                                                <button type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                    if (function_exists('icl_get_languages')) {
                                        $languages = icl_get_languages('skip_missing=0');
                                        if (!empty($_GET)) {
                                            $selected_language = $h->provide_set($languages[$_GET['lang']], 'native_name');
                                        } else {
                                            $selected_language = 'English';
                                        }
                                        if (!empty($languages)) {
                                            ?>
                                            <div class="lang-selector">
                                                <span><i class="fa fa-globe"></i><?php echo esc_html($selected_language); ?></span>
                                                <ul>
                                                    <?php
                                                    $items = '';
                                                    foreach ($languages as $l) {
                                                        if (!$l['active']) {
                                                            echo '<li><a href="' . $l['url'] . '">' . $l['native_name'] . '</a></li>';
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                </div>
    <?php endif; ?>
                        </div>
                    </div><!-- Topbar -->
<?php endif; ?>
                <div class="logobar">
                    <div class="container">
                        <div class="logo">
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
                        </div><!-- Logo -->
                        <div class="header-contact">
                            <div class="row">
                                <?php if ($show_time): ?>
                                    <div class="col-md-4">
                                        <div class="info">
                                            <i class="<?php echo $optcontact_one_icon; ?>"></i>
                                            <strong><?php echo esc_html($optcontact_one_text) ?> 
                                                <?php
                                                $i = 0;
                                                if ($optcontact_one_content != '') {
                                                    foreach ($optcontact_one_content as $content) {
                                                        ?>
                                                        <span><?php echo $optcontact_one_content[$i]; ?></span>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </strong>
                                        </div><!-- Info -->
                                    </div>
                            <?php endif; ?>
                            <?php if ($show_email): ?>
                                    <div class="col-md-4">
                                        <div class="info">
                                            <i class="<?php echo $optcontact_two_icon; ?>"></i>
                                            <strong><?php echo esc_html($optcontact_two_text) ?> 
                                                <?php
                                                $i = 0;
                                                if ($optcontact_two_content != '') {
                                                    foreach ($optcontact_two_content as $content) {
                                                        ?>
                                                        <span><a href="mailto:<?php echo $optcontact_two_content[$i]; ?>"><?php echo $optcontact_two_content[$i]; ?></a></span>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </strong>
                                        </div><!-- Info -->
                                    </div>
<?php endif; ?>
                                <?php if ($show_phone): ?>
                                    <div class="col-md-4">
                                        <div class="info">
                                            <i class="<?php echo $optcontact_three_icon; ?>"></i>
                                            <strong><?php echo esc_html($optcontact_three_text) ?> 
                                                <?php
                                                $i = 0;
                                                if ($optcontact_three_content != '') {
                                                    foreach ($optcontact_three_content as $content) {
                                                        ?>
                                                        <span><a href="tel:<?php echo $optcontact_three_content[$i]; ?>"><?php echo $optcontact_three_content[$i]; ?></a></span>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </strong>
                                        </div><!-- Info -->
                                    </div>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div><!-- Logobar -->
                <div class="menu-height"></div>
                <div class="menubar <?php echo esc_attr(( $headerSticky == '1' ) ? 'stick' : '' ) ?>">
                    <div class="container">
                        <nav>
                            <?php
                            $args = array(
                                'theme_location' => 'primary',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'container' => '',
                                'echo' => false,
                            );
                            $list = array('<div class="menu">', '</div>');
                            echo str_replace($list, '', wp_nav_menu($args));
                            ?>
                        </nav>
                        <?php
                        if ($headerQuote == '1'):
                            $buttonText = $h->provide_set($opt, 'optHeaderQuoteButtonText');
                            $buttonLink = $h->provide_set($opt, 'optHeaderQuoteLink');
                            $linkUrl = (!empty($buttonLink) ) ? get_page_link($buttonLink) : 'javascript:void(0)';
                            ?>
                            <a class="round-btn" href="<?php echo esc_url($linkUrl) ?>" title=""><?php echo esc_html($buttonText) ?></a>
            <?php endif; ?>
                    </div>
                </div><!-- Menu Bar -->
            </header><!-- Header -->

<?php $h->provide_resHeader(); ?>
