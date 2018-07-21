<?php 

$page_heading_full = get_post_meta(get_queried_object_id(), $key ='anps_page_heading_full', $single = true );

if( is_404() ) {
    $page_heading_full = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='anps_page_heading_full', $single = true );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php anps_is_responsive(false); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php anps_theme_styles(); ?>
	<?php anps_theme_after_styles(); ?>
        <?php if(isset($page_heading_full)&&$page_heading_full=="on") { add_action("wp_head", 'anps_page_full_screen_style', 1000); } ?> 
        <?php wp_head(); ?>             
</head>
<body <?php body_class(anps_is_responsive(true) . anps_boxed_or_vertical());?><?php anps_body_style();?>>
    <!-- Accesibility menu -->
    <a class="sr-shortcut sr-shortcut-content" href="#site-content"><?php _e('Skip to main content', 'accounting'); ?></a>
    <a class="sr-shortcut sr-shortcut-search" href="#site-search"><?php _e('Skip to search', 'accounting'); ?></a>
    

    <?php 
    $coming_soon = get_option('coming_soon', '0'); 
    if($coming_soon=="0"||is_super_admin()) : ?> 
      <div class="site-wrapper <?php if(get_option('anps_vc_legacy', "0")=="on") {echo "legacy";} ?>">
      <?php
        $anps_menu_type = get_option('anps_menu_type', '2');
      ?>

      <div class="site-search" id="site-search">
              <?php anps_get_search(); ?>
      </div>

      <?php if(isset($page_heading_full)&&$page_heading_full=="on") : ?>
          <?php
              $heading_value = get_post_meta(get_queried_object_id(), $key ='heading_bg', $single = true );

              if( is_404() ) {
                  $heading_value = get_post_meta(anps_get_option($anps_page_data, 'error_page'), $key ='heading_bg', $single = true );   
              }
          ?>

          <?php if( get_option('anps_menu_type', '2')!='5' ): ?>
          <?php
              $height_value = get_post_meta(get_queried_object_id(), $key ='anps_full_height', $single = true );

              if( $height_value ) {
                  $height_value = 'height: ' . $height_value . 'px; ';
              }
          ?>
              <div class="paralax-header parallax-window" data-type="background" data-speed="2" style="<?php echo $height_value; ?>background-image: url(<?php echo esc_url($heading_value); ?>);">
          <?php endif; ?>

      <?php endif; ?>
    <?php endif; ?>
		<?php anps_get_header(); ?>