<?php 
include_once 'classes/Options.php';
$anps_page_data = $options->get_page_setup_data();
if (isset($_GET['save_page_setup'])) {  
    $options->save_page_setup();
}
?>
<form action="themes.php?page=theme_options&sub_page=options_page_setup&save_page_setup" method="post">
    <div class="content-top">
        <input type="submit" value="<?php esc_html_e('Save all changes', 'accounting'); ?>" />
        <div class="clear"></div>
    </div>
    <div class="content-inner">
        <!-- Page setup -->
        <h3><?php esc_html_e('Page setup', 'accounting'); ?></h3>
        <!-- Coming soon page -->
        <div class="input onehalf">
            <label for="coming_soon"><?php esc_html_e('Coming soon page', 'accounting'); ?></label>
            <select name="coming_soon" id="coming_soon">
                <option value="0"><?php esc_html_e('*** Select ***', 'accounting'); ?></option>
                <?php $pages = get_pages();
                foreach ($pages as $item) : ?>      
                    <option value="<?php echo esc_attr($item->ID); ?>" <?php if(get_option('coming_soon', '0')== $item->ID) {echo esc_attr('selected');}else {echo '';} ?>><?php echo esc_html($item->post_title); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <!-- Error page -->
        <div class="input onehalf">
            <label for="anps_error_page"><?php esc_html_e('404 error page', 'accounting'); ?></label>
            <select name="anps_error_page" id="anps_error_page">
                <option value="0"><?php esc_html_e('*** Select ***', 'accounting'); ?></option>
                <?php $pages = get_pages();
                foreach ($pages as $item) :?>      
                    <option value="<?php echo esc_attr($item->ID); ?>" <?php if(anps_get_option($anps_page_data, 'error_page') == $item->ID) {echo esc_attr('selected');}else {echo '';} ?>><?php echo esc_html($item->post_title); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('WooCommerce', 'accounting'); ?></h3>
        <div class="input onethird">            
            <label for="shopping_cart_header"><?php esc_html_e('Display shopping cart icon in header?', 'accounting'); ?></label>            
            <select name="shopping_cart_header" id="shopping_cart_header">                               
                <?php $pages = array('hide'=>esc_html__('Never display', 'accounting'), 'shop_only'=>esc_html__('only on Woo pages', 'accounting'), 'always'=>esc_html__('Display everywhere', 'accounting'));                
                foreach($pages as $key => $item) :                    
                    if (get_option('shopping_cart_header', 'shop_only') == $key) {                        
                        $selected = 'selected';                    
                    } else {                         
                        $selected = ''; 
                    } ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <!-- WooCommerce columns -->
        <div class="input onethird">            
            <label for="anps_products_columns"><?php _e('How many products in row?', 'accounting'); ?></label>            
            <select name="anps_products_columns">                               
                    <?php $pages = array('4'=>'4 products', '3'=>'3 products');                
                    foreach ($pages as $key => $item) :                    
                        if (get_option('anps_products_columns', '4') == $key) {                        
                            $selected = 'selected="selected"';                    
                        } else {                         
                            $selected = ''; 
                        } ?>                    
                <option value="<?php echo esc_attr($key); ?>" <?php echo $selected; ?>><?php echo esc_attr($item); ?></option>                 
                    <?php endforeach; ?>            
            </select>        
        </div>
        <!-- WooCommerce products per page -->
        <div class='input onethird'>
            <label for='anps_products_per_page'><?php _e("Products per page", 'accounting'); ?></label>
            <input type='text' value='<?php echo get_option('anps_products_per_page', '12'); ?>' name='anps_products_per_page' id='anps_products_per_page' />
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Portfolio', 'accounting'); ?></h3>
        <!-- Portfolio single style -->
        <div class="input onethird">            
            <label for="portfolio_single"><?php esc_html_e('Portfolio single style', 'accounting'); ?></label>            
            <select name="portfolio_single" id="portfolio_single">                               
                <?php $pages = array('style-1'=>esc_html__('Style 1', 'accounting'), 'style-2'=>esc_html__('Style 2', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if(get_option('portfolio_single') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <!-- Portfolio single footer -->
        <div class="input twothirds">
            <label for="portfolio_single_footer"><?php esc_html_e('Portfolio single footer', 'accounting'); ?></label>
            <?php $value2 = get_option('portfolio_single_footer', ''); 
                wp_editor(str_replace('\\"', '"', $value2), 'portfolio_single_footer', array(
                            'wpautop' => true,                
                            'media_buttons' => false,                
                            'textarea_name' => 'portfolio_single_footer',               
                            'textarea_rows' => 10,                
                            'teeny' => true )); ?>        
        </div>
        <div class="clear"></div>
        <!-- Menu -->
        <h3><?php esc_html_e('Menu Types', 'accounting'); ?></h3>
        <!-- Menu -->
        <div class="input fullwidth" id="headerstyle">
            <?php
                $i=1;
                $images_array = array(
                    'top-transparent-menu' => esc_html__('Transparent front page menu, normal menu on other pages', 'accounting'),
                    'top-background-menu' => esc_html__('Normal menu', 'accounting'),
                    'bottom-transparent-menu' => esc_html__('Bottom transparent front page menu, normal menu on other pages', 'accounting'),
                    'bottom-background-menu' => esc_html__('Bottom front page menu, normal menu on other pages', 'accounting'),
                    'full-length-menu' => esc_html__('Full page menu', 'accounting')
                );
                foreach($images_array as $item => $title) : 
            ?>
            <label title="<?php echo $title; ?>" class="onequarter" id="head-<?php echo $i; ?>"><input type="radio" name="anps_menu_type" value="<?php echo $i; ?>"<?php if(get_option('anps_menu_type', 2)==$i) {echo " checked";} else {echo "";} ?>><img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/<?php echo $item; ?>.jpg"></label>
            <?php $i++; endforeach; ?>
        </div>
        <!-- Hidden -->
        <div class="anps_menu_type_font fullwidth ">
            <div class="input onethird" >
                <label for="anps_front_text_color"><?php esc_html_e('Text color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_text_color'); ?>" readonly style="background: <?php echo get_option('anps_front_text_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_text_color" value="<?php echo get_option('anps_front_text_color'); ?>" id="anps_front_text_color" />
            </div>
            <div class="input onethird" >
                <label for="anps_front_text_hover_color"><?php esc_html_e('Text hover color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_text_hover_color'); ?>" readonly style="background: <?php echo get_option('anps_front_text_hover_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_text_hover_color" value="<?php echo get_option('anps_front_text_hover_color'); ?>" id="anps_front_text_hover_color" />
            </div>
            <div class="onoff input head-2 head-4 head-5 onethird" >
                <label for="anps_front_bg_color"><?php esc_html_e('Background color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_bg_color'); ?>" readonly style="background: <?php echo get_option('anps_front_bg_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_bg_color" value="<?php echo get_option('anps_front_bg_color'); ?>" id="anps_front_bg_color" />
            </div>
            <div class="onoff input head-1 onethird" >
                <label for="anps_front_topbar_color"><?php esc_html_e('Front page top bar color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_color" value="<?php echo get_option('anps_front_topbar_color'); ?>" id="anps_front_topbar_color" />
            </div>
            <div class="onoff input head-1 onethird" >
                <label for="anps_front_topbar_bg_color"><?php esc_html_e('Front page top bar background color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_bg_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_bg_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_bg_color" value="<?php echo get_option('anps_front_topbar_bg_color'); ?>" id="anps_front_topbar_bg_color" />
            </div>
            <div class="onoff input head-1 onethird" >
                <label for="anps_front_topbar_hover_color"><?php esc_html_e('Front page top bar link hover color', 'accounting'); ?></label>
                <input data-value="<?php echo get_option('anps_front_topbar_hover_color'); ?>" readonly style="background: <?php echo get_option('anps_front_topbar_hover_color'); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_front_topbar_hover_color" value="<?php echo get_option('anps_front_topbar_hover_color'); ?>" id="anps_front_topbar_hover_color" />
            </div>

            <div class="onoff input head-1 head-3 twothirds">
                <label for="anps_front_logo"><?php esc_html_e('Front page logo', 'accounting'); ?></label>
                <input id="anps_front_logo" type="text" size="36" name="anps_front_logo" value="<?php echo get_option('anps_front_logo'); ?>" />
                <input id="_btn" class="upload_image_button width-105" type="button" value="Upload" /> 
                <p class="fullwidth"><?php esc_html_e('This option is ment for logo color adjustments if needed. Please make sure, the logo is exact same size as logo on other pages.', 'accounting'); ?></p>
                <div class="clear"></div>
            </div>
        </div>
        <div class="onoff anps_full_screen input fullwidth head-3 head-4" >
            <label for="anps_full_screen"><?php esc_html_e('Full screen content', 'accounting'); ?></label>
            <?php $value2 = get_option('anps_full_screen', ''); 
            wp_editor(str_replace('\\"', '"', $value2), 'anps_full_screen', array(
                                                'wpautop' => true,                
                                                'media_buttons' => false,                
                                                'textarea_name' => 'anps_full_screen',               
                                                'textarea_rows' => 10,                
                                                'teeny' => true )); ?>        
            <p style="margin-top: 20px;">
                <?php printf(esc_html__('%s Important! %s The textarea above is ment for the slider shortcode. It will be shown on the home page before the rest of the site. Add slider shortcode inside the content area above for tis menu type to work. %s If you imported our demo, you will also need to remove the slider on your homepage and remove the negative margin on first row (check the screenshot below).', 'accounting'), '<h2>', '</h2>', '<br>'); ?><br/>
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/home-changes.jpg">
            </p>
        </div>
        <!-- END Hidden -->
        <div class="clearfix"></div>
        <h3><?php esc_html_e('General Top Menu Settings', 'accounting'); ?></h3>
        <!-- Top menu -->
        <div class="input onequarter">            
            <label for="topmenu_style"><?php esc_html_e('Display top bar?', 'accounting'); ?></label>            
            <select name="topmenu_style" id="topmenu_style">                               
                <?php $pages = array('1'=>esc_html__('Yes', 'accounting'), '2'=>esc_html__('Only on tablet/mobile', 'accounting'), '4'=>esc_html__('Only on desktop', 'accounting'), '3'=>esc_html__('No', 'accounting'));          
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if(get_option('topmenu_style') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <div class="input onequarter">            
            <label for="anps_above_nav_bar"><?php esc_html_e('Display above menu bar?', 'accounting'); ?></label>            
            <select name="anps_above_nav_bar" id="anps_above_nav_bar">                               
                <?php $pages = array('1'=>esc_html__('Yes', 'accounting'), '0'=>esc_html__('No', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if(get_option('anps_above_nav_bar') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <div class="input onequarter">            
            <label for="menu_style"><?php esc_html_e('Menu', 'accounting'); ?></label>            
            <select name="menu_style" id="menu_style">                               
                <?php $pages = array('1'=>esc_html__('Normal', 'accounting'), '2'=>esc_html__('Description', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if(get_option('menu_style') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <!-- Menu centered -->
        <div class="input onequarter">
            <label for="menu_center"><?php esc_html_e('Menu centered', 'accounting'); ?></label>
            <input type="hidden" value="" name="menu_center"/>
            <input id="menu_center" class="small_input" value="1" style="margin-left: 37px" type="checkbox" name="menu_center" <?php if(get_option('menu_center')=='1') {echo esc_attr('checked');} else {echo '';} ?> />
        </div>   
        <!-- Sticky menu -->
        <div class="input onequarter">
            <label for="sticky_menu"><?php esc_html_e('Sticky menu', 'accounting'); ?></label>
            <input type="hidden" value="" name="sticky_menu"/>
            <input id="sticky_menu" class="small_input" value="1" style="margin-left: 37px" type="checkbox" name="sticky_menu" <?php if(get_option('sticky_menu')=='1') {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="input onequarter">
            <label for="search_icon"><?php esc_html_e('Display search icon in menu (desktop)?', 'accounting'); ?></label>
            <input type="hidden" value="" name="search_icon"/>
            <input id="search_icon" class="small_input" value="1" style="margin-left: 37px" type="checkbox" name="search_icon" <?php if(get_option('search_icon', '1')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="input onequarter">
            <label for="search_icon_mobile"><?php esc_html_e('Display search on mobile and tablets?', 'accounting'); ?></label>
            <input type="hidden" value="" name="search_icon_mobile"/>
            <input id="search_icon_mobile" class="small_input" value="1" style="margin-left: 37px" type="checkbox" name="search_icon_mobile" <?php if(get_option('search_icon_mobile', '1')=='1') {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="clear"></div>
        <!-- Main menu settings -->
        <h3><?php esc_html_e('Main menu settings', 'accounting'); ?></h3>
        <div class="input onequarter">
            <label for="anps_main_menu_selection"><?php esc_html_e('Dropdown selection states', 'accounting'); ?></label>
            <select id="anps_main_menu_selection" name="anps_main_menu_selection">
                <option value="0"<?php if(get_option('anps_main_menu_selection', '0')=='0'){echo ' '.esc_attr('selected');}?>><?php esc_html_e('Hover color & bottom border', 'accounting'); ?></option>
                <option value="1"<?php if(get_option('anps_main_menu_selection', '0')=='1'){echo ' '.esc_attr('selected');}?>><?php esc_html_e('Hover color'); ?></option>
            </select>
        </div>
        <div class="clear"></div>
        <!-- Prefooter -->
        <h3><?php esc_html_e('Prefooter', 'accounting'); ?></h3>
        <!-- Prefooter -->
        <div class="input onehalf">
            <label for="prefooter"><?php esc_html_e('Prefooter', 'accounting'); ?></label>
            <input type='hidden' value='' name='prefooter'/>
            <input id="prefooter" class="small_input" value="1" style="margin-left: 25px" type="checkbox" name="prefooter" <?php if(get_option('prefooter')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <div class="input onehalf">            
            <label for="prefooter_style"><?php esc_html_e('Prefooter columns', 'accounting'); ?></label>            
            <select name="prefooter_style" id="prefooter_style">                
                <option value="0"><?php esc_html_e('*** Select ***', 'accounting');?></option>                
                <?php $pages = array('5'=>'2/3 + 1/3', '6'=>"1/3 + 2/3", '2'=>esc_html__('2 columns', 'accounting'), '3' =>esc_html__('3 columns', 'accounting'), '4' =>esc_html__('4 columns', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('prefooter_style') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>
        <div class="clear"></div>
        <h3><?php esc_html_e('Footer', 'accounting'); ?></h3>
        <!-- Disable footer -->
        <div class="input onethird">
            <label for="footer_disable"><?php esc_html_e('Disable footer', 'accounting'); ?></label>
            <input type='hidden' value='' name='footer_disable'/>
            <input id="footer_disable" class="small_input" style="margin-left: 37px" value="1" type="checkbox" name="footer_disable" <?php if(get_option('footer_disable')=="1") {echo esc_attr('checked');} else {echo '';} ?> />
        </div>
        <!-- Footer columns -->        
        <div class="input onethird">            
            <label for="footer_style"><?php esc_html_e('Footer columns', 'accounting'); ?></label>            
            <select name="footer_style">                
                <option value="0"><?php esc_html_e('*** Select ***', 'accounting'); ?></option>                
                <?php $pages = array('2'=>esc_html__('2 columns', 'accounting'), '3' =>esc_html__('3 columns', 'accounting'), '4' =>esc_html__('4 columns', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('footer_style') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div>    
        <!-- Footer columns -->        
        <div class="input onethird">            
            <label for="anps_footer_style"><?php esc_html_e('Footer style', 'accounting'); ?></label>            
            <select name="anps_footer_style" id="anps_footer_style">                              
                <?php $pages = array('1'=>esc_html__('style 1', 'accounting'), '2' => esc_html__('style 2', 'accounting'), '3' => esc_html__('style 3', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('anps_footer_style', '1') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div> 
        <!-- Copyright footer -->
        <div class="input onehalf">            
            <label for="copyright_footer"><?php esc_html_e('Copyright footer', 'accounting'); ?></label>            
            <select name="copyright_footer" id="copyright_footer">                
                <option value="0"><?php esc_html_e('*** Select ***', 'accounting'); ?></option>                
                <?php $pages = array('1'=>esc_html__('1 column', 'accounting'), '2' =>esc_html__('2 columns', 'accounting'));                
                foreach ($pages as $key => $item) : ?>                    
                    <option value="<?php echo esc_attr($key); ?>" <?php if (get_option('copyright_footer') == $key) {echo esc_attr('selected');} else {echo '';} ?>><?php echo esc_attr($item); ?></option>                 
                <?php endforeach; ?>            
            </select>        
        </div> 
        <div class="clear"></div>
        <h3><?php esc_html_e('Visual composer', 'accounting'); ?></h3>
        <p><?php esc_html_e('Only for backwards compatibility. Do not use on fresh install.', 'accounting'); ?></p>
        <!-- Legacy mode -->
        <div class="input onethird">
            <?php
            if(get_option('anps_vc_legacy')=="on") {
                $checked='checked';
            } else {
                $checked = '';
            }
            ?>
            <label for="anps_vc_legacy"><?php esc_html_e("Legacy mode", 'accounting'); ?></label>
            <input id="anps_vc_legacy" class="small_input" style="margin-left: 37px" type="checkbox" name="anps_vc_legacy" <?php echo esc_attr($checked); ?> />
        </div>
        <!-- END Legacy mode -->
        <div class="clear"></div>
        <!-- Post meta enable/disable -->
        <h3><?php esc_html_e('Disable Post meta elements', 'accounting'); ?></h3>
        <p><?php esc_html_e('This allows you to disable post meta on all blog elements and pages. By default no field is checked, so that all meta elements are displayed.', 'accounting'); ?></p>
        
            <?php
                $post_meta_arr = array(
                    'anps_post_meta_comments'   => esc_html__('Comments', 'accounting'),
                    'anps_post_meta_categories' => esc_html__('Categories', 'accounting'),
                    'anps_post_meta_author'     => esc_html__('Author', 'accounting'),
                    'anps_post_meta_date'       => esc_html__('Date', 'accounting')
                ); 
            ?>
            <?php foreach($post_meta_arr as $key=>$item) : ?>
              <div class="input onequarter">
                <label for="<?php echo esc_attr($key); ?>"><?php echo esc_attr($item); ?></label>
                <input type='hidden' value='' name='<?php echo esc_attr($key); ?>'/>
                <input style="margin-left: 37px;" value='1' type="checkbox" name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>" <?php checked(get_option($key), "1") ?>/>
              </div>
            <?php endforeach; ?>
        
        <div class="clear"></div>
    </div>    
    <div class="content-top" style="border-style: solid none; margin-top: 70px">        
        <input type="submit" value="<?php esc_html_e("Save all changes", 'accounting'); ?>">        
        <div class="clear"></div>    
    </div>
    <div class="submit-right">
        <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
    <div class="clear"></div>    
</form>