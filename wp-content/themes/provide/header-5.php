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
        $logo = $h->provide_set($opt, 'optHeaderFiveLogo');
        
        wp_head();
        $boxed = ( $h->provide_set($opt, 'themeBoxedLayout') == '1' ) ? 'boxed' : '';
        global $woocommerce;
        
        $script = '
            jQuery(document).ready(function() {
            
                jQuery(".cart-lists-btn").live("click", function(){
                    jQuery(this).addClass("active");
                    jQuery(".cart-item-list").addClass("active");
                    jQuery("html").addClass("no-scroll");
                });
                jQuery(".close-cart-list").live("click", function(){
                    jQuery(".cart-lists-btn").removeClass("active");
                    jQuery(".cart-item-list").removeClass("active");
                    jQuery("html").removeClass("no-scroll");
                });
                jQuery(".del-cart-item").live("click", function(){
                    jQuery(this).parent().parent().parent().fadeOut();
                });

                jQuery(".open-search").on("click", function(){
                    jQuery(this).addClass("active");
                    jQuery(".search-big").addClass("active");
                });
                jQuery(".close-search").on("click", function(){
                    jQuery(".open-search").removeClass("active");
                    jQuery(".search-big").removeClass("active");
                });
            
            });
        ';
        wp_add_inline_script('provide-script', $script);
        
        ?>
        
    </head>
    <body <?php body_class(); ?>>
        <div class="theme-layout <?php echo esc_attr($boxed) ?>">
            
            <div class="search-big">
                <span class="close-search"><i class="fa fa-close"></i><?php echo esc_html__('Close Search', 'provide'); ?></span>
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="text" name="s" placeholder="<?php echo esc_attr__('Search Here...', 'provide'); ?> " />
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div><!-- Search Big -->
            
            
            <header class="style5">
                <div class="menu-area">

                    <div class="account-btn-sec">
                        <span class="account-popup-btn">
                            <a href="#" class="account-login" title=""><?php echo esc_html__('Login', 'provide'); ?></a>
                            <a href="#" class="account-register" title=""><?php echo esc_html__('Register', 'provide'); ?></a>
                        </span>
                    </div>

                    <nav>
                        <?php wp_nav_menu(array('theme_location' => 'left', 'menu_class'=>'', 'container'=>false)); ?>
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
                        <?php wp_nav_menu(array('theme_location' => 'right', 'menu_class'=>'', 'container'=>false)); ?>
                    </nav>

                    <div class="cart-search">
                        <span class="open-search"><i class="fa fa-search"></i></span>
                        <?php if(is_object($woocommerce)) : ?>
                        <span class="cart-lists-btn">
                            <?php echo esc_html__('Cart :', 'provide'); ?>  
                            <strong><?php echo "( ".WC()->cart->get_cart_total()." ) "; ?></strong>
                        </span>
                        <?php $h->provide_cart_dropdown(); ?>
                        <?php endif; ?>
                    </div>

                </div>
            </header><!-- Header -->



            <?php  $h->provide_resHeader(); ?>
