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
        $logo = $h->provide_set($opt, 'optHeaderFourLogo');
        $headerSearch = $h->provide_set($opt, 'optHeaderFourSearch');
        $googleAnalytics = $h->provide_set($opt, 'optGoogleAnalytics');

        $optcontact_three_icon = $h->provide_set($opt, 'optcontact_three_icon');
        $optcontact_three_content = $h->provide_set($opt, 'optcontact_three_content');
        $optcontact_four_icon = $h->provide_set($opt, 'optcontact_four_icon');
        $optcontact_four_content = $h->provide_set($opt, 'optcontact_four_content');
        $screen_bg = $h->provide_set($h->provide_set($opt, 'optHeaderFourScreenbg'), 'url');
        $show_header = $h->provide_set($opt, 'optShowHeaderFour');


        wp_head();
        $boxed = ( $h->provide_set($opt, 'themeBoxedLayout') == '1' ) ? 'boxed' : '';
        ?>
        <script><?php echo $googleAnalytics; ?></script>
    </head>
    <body <?php body_class(); ?>>
        <div class="theme-layout <?php echo esc_attr($boxed) ?>">
            <?php if ($show_header) : ?>
                <a class="header-icon" href="javascript:void(0)" title=""><i class="fa fa-bars"></i></a>
                <div class="creative-header" style="background:url(<?php echo esc_url($screen_bg); ?>) no-repeat scroll 0 0; ">
                    <div class="creative-header-wrap">
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
                        </div>
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
                    </div>
                    <?php if ($headerSearch == '1' && !empty($optcontact_three_content) && !empty($optcontact_four_content)): ?>
                        <div class="creative-header-bottom">
                            <?php if (!empty($optcontact_three_content)): ?>
                                <span><i class="<?php echo $optcontact_three_icon; ?>"></i> <?php echo esc_html($optcontact_three_content[0]) ?></span>
                            <?php endif; ?>
                            <?php if ($headerSearch == '1'): ?>
                                <form class="header-simple-search" method="get" action="<?php echo esc_url(home_url('/')) ?>">
                                    <input type="text" name="s"/>
                                    <button><i class="fa fa-search"></i></button>
                                </form>
                            <?php endif; ?>
                            <?php if (!empty($optcontact_four_content)): ?>
                                <span><i class="<?php echo $optcontact_four_icon; ?>"></i> <?php echo esc_html($optcontact_four_content[0]) ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php $h->provide_resHeader(); ?>
