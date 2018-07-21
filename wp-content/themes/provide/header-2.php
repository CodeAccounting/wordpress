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
        $logo = $h->provide_set($opt, 'optHeaderTwoLogo');
        $isSticky = $h->provide_set($opt, 'optHeaderTwoSticky');
        $headerSearch = $h->provide_set($opt, 'optHeaderTwoSearch');
        $headerQuote = $h->provide_set($opt, 'optHeaderTwoQuoteButton');
        $googleAnalytics = $h->provide_set($opt, 'optGoogleAnalytics');

        $optcontact_three_icon = $h->provide_set($opt, 'optcontact_three_icon');
        $optcontact_three_content = $h->provide_set($opt, 'optcontact_three_content');
        $optcontact_four_icon = $h->provide_set($opt, 'optcontact_four_icon');
        $optcontact_four_content = $h->provide_set($opt, 'optcontact_four_content');
        

        $show_address = $h->provide_set($opt, 'optcontact_show_address');
        $show_phone = $h->provide_set($opt, 'optcontact_three_header');
        
        wp_head();
        $boxed = ( $h->provide_set($opt, 'themeBoxedLayout') == '1' ) ? 'boxed' : '';
        ?>
        <script><?php echo $googleAnalytics; ?></script>
    </head>
    <body <?php body_class(); ?>>
        <div class="theme-layout <?php echo esc_attr($boxed) ?>">
            <header class="style3">
                <?php if ($headerSearch == '1'): ?>
                    <div class="topbar">
                        <div class="container">
                            
                            
                                <ul class="top-list">
                                    
                                        <?php if($show_phone && !empty($optcontact_three_content)) : ?>
                                        <li><i class="<?php echo $optcontact_three_icon; ?>"></i>
                                            <?php
                                                $i = 0;
                                                foreach ($optcontact_three_content as $content) {
                                                    
                                                    if($i==0) {
                                                        echo esc_html($content);
                                                    }
                                                    $i++;
                                                }
                                            ?>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php if($show_address && !empty($optcontact_four_content)) : ?>
                                        <li><i class="<?php echo $optcontact_four_icon; ?>"></i>
                                            <?php 
                                                $i = 0; 
                                                foreach ($optcontact_four_content as $content) :
                                                    if($i==0) {
                                                        echo esc_html($content);
                                                    }
                                                $i++;
                                                endforeach; 
                                            ?>
                                        </li>
                                        <?php endif; ?>
                      
                                </ul>
                            
    <?php if ($headerSearch == '1'): ?>
                                <div class="header-search">
                                    <a href="javascript:void(0)" title=""><i class="fa fa-search"></i></a>
                                    <form method="get" action="<?php echo esc_url(home_url('/')) ?>">
                                        <input type="text" name="s" placeholder="<?php esc_html_e('Enter Your Search', 'provide') ?>"/>
                                        <button><i class="fa fa-search"></i></button>
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
                    </div>
<?php endif; ?>
                <div class="logobar-height"></div>
                <div class="logobar <?php echo esc_attr(( $isSticky == '1' ) ? 'stick' : '' ) ?>">
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
                        </div>
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
                            $buttonText = $h->provide_set($opt, 'optHeaderTwoQuoteButtonText');
                            $buttonLink = $h->provide_set($opt, 'optHeaderTwoQuoteLink');
                            $linkUrl = (!empty($buttonLink) ) ? get_page_link($buttonLink) : 'javascript:void(0)';
                            ?>
                            <a class="round-btn" href="<?php echo esc_url($linkUrl) ?>" title=""><?php echo esc_html($buttonText) ?></a>
<?php endif; ?>
                    </div>
                </div>
            </header><!-- Header -->

<?php $h->provide_resHeader(); ?>
