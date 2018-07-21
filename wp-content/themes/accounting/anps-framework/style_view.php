<?php 
include_once 'classes/Style.php';
wp_enqueue_script('font_subsets');
/* Save form */
if(isset($_GET['save_style']))
    $style->save();
/* get all fonts */
$fonts = $style->all_fonts(); 
?>
<div class="content">
    <form action="themes.php?page=theme_options&save_style" method="post">
        <div class="content-top">
            <input type="submit" value="<?php _e("Save all changes", 'accounting'); ?>">
            <div class="clear"></div>
        </div>
        <div class="content-inner">
            <h3><?php esc_html_e('Font family', 'accounting'); ?></h3>
            <h4><?php esc_html_e('Custom font styles', 'accounting'); ?></h4>
            <div class="input onethird">
                <label for="font_type_1"><?php esc_html_e('Font type 1', 'accounting'); ?></label>                    
                <select name="font_type_1" id="font_type_1">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) : 
                            $selected = '';
                            if ($font['value'] == get_option('font_type_1', 'PT+Serif')) {
                                $selected = 'selected="selected"';   
                                if($name=="Google fonts") {
                                    $subsets = $font['subsets'];
                                } else {
                                    $subsets = "";
                                }
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_1" class="font_subsets">
                    <?php if(isset($subsets)&&$subsets!='') : 
                        $i=0;
                        foreach($subsets as $item) :
                            if(is_array(get_option("font_type_1_subsets"))&&in_array($item, get_option("font_type_1_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_1_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_2"><?php _e("Font type 2", 'accounting'); ?></label>
                <select name="font_type_2" id="font_type_2">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) : 
                            $selected = ''; 
                            if ($font['value'] == get_option('font_type_2', "PT+Sans")) { 
                                $selected = 'selected="selected"';
                                if($name=="Google fonts") {
                                    $subsets2 = $font['subsets'];
                                } else {
                                    $subsets2 = "";
                                }
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_2" class="font_subsets">
                    <?php if(isset($subsets2)&&$subsets2!='') : 
                        $i=0;
                        foreach($subsets2 as $item) :
                            if(is_array(get_option("font_type_2_subsets"))&&in_array($item, get_option("font_type_2_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_2_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="input onethird">
                <label for="font_type_navigation"><?php _e("Navigation font type", 'accounting'); ?></label>
                <select name="font_type_navigation" id="font_type_navigation">
                    <?php foreach($fonts as $name=>$value) : ?>
                    <optgroup label="<?php echo esc_attr($name); ?>">
                    <?php foreach ($value as $font) :
                            $selected = '';
                            if ($font['value'] == get_option('font_type_navigation', 'PT+Serif')) {
                                $selected = 'selected="selected"';
                                if($name=="Google fonts") {
                                    $subsets3 = $font['subsets'];
                                } else {
                                    $subsets3 = "";
                                }
                            }
                            ?>
                            <option value="<?php echo esc_attr($font['value'])."|".esc_attr($name); ?>" <?php echo $selected; ?>><?php echo esc_attr($font['name']); ?></option>
                    <?php endforeach; ?>
                    </optgroup>  
                    <?php endforeach; ?>
                </select>
                <div id="font_subsets_navigation" class="font_subsets">
                    <?php if(isset($subsets3)&&$subsets3!='') : 
                        $i=0;
                        foreach($subsets3 as $item) :
                            if(is_array(get_option("font_type_navigation_subsets"))&&in_array($item, get_option("font_type_navigation_subsets"))) {
                                $checked = " checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                        <input type="checkbox" name="font_type_navigation_subsets[]" value="<?php echo $item; ?>" <?php echo $checked;?> /><?php echo $item; ?><br />
                        <?php $i++; 
                        endforeach; 
                    endif;
                    ?>
                </div>
            </div>
            <div class="clear"></div>

            <h3><?php _e("Font sizes", 'accounting'); ?></h3>
            <div class="input onequarter two-line-label">
                <label for="body_font_size"><?php _e("Body Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="body_font_size" value="<?php echo esc_attr(get_option('body_font_size', '14')); ?>" id="body_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="menu_font_size"><?php _e("Menu Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="menu_font_size" value="<?php echo esc_attr(get_option('menu_font_size', '14')); ?>" id="menu_font_size" placeholder="14"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="h1_font_size"><?php _e("Content Heading 1 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="h1_font_size" value="<?php echo esc_attr(get_option('h1_font_size', '31')); ?>" id="h1_font_size" placeholder="31"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="h2_font_size"><?php _e("Content Heading 2 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="h2_font_size" value="<?php echo esc_attr(get_option('h2_font_size', '24')); ?>" id="h2_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="h3_font_size"><?php _e("Content Heading 3 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="h3_font_size" value="<?php echo esc_attr(get_option('h3_font_size', '21')); ?>" id="h3_font_size" placeholder="21" /><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="h4_font_size"><?php _e("Content Heading 4 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="h4_font_size" value="<?php echo esc_attr(get_option('h4_font_size', '18')); ?>" id="h4_font_size" placeholder="18"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="h5_font_size"><?php _e("Content Heading 5 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="h5_font_size" value="<?php echo esc_attr(get_option('h5_font_size', '16')); ?>" id="h5_font_size" placeholder="16"/><span>px</span>

            </div>
            <div class="input onequarter two-line-label">
                <label for="page_heading_h1_font_size"><?php _e("Page Heading 1 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="page_heading_h1_font_size" value="<?php echo esc_attr(get_option('page_heading_h1_font_size', '24')); ?>" id="page_heading_h1_font_size" placeholder="24"/><span>px</span>
            </div>
            <div class="input onequarter two-line-label">
                <label for="blog_heading_h1_font_size"><?php _e("Single blog page heading 1 Font Size", 'accounting'); ?></label>
                <input class="size" type="text" name="blog_heading_h1_font_size" value="<?php echo esc_attr(get_option('blog_heading_h1_font_size', '28')); ?>" id="blog_heading_h1_font_size" placeholder="28"/><span>px</span>
            </div>
            <div class="clear"></div>
            <h3><?php esc_html_e('Predefined color Scheme', 'accounting'); ?></h3>
            <h4><?php esc_html_e('Choose a predefined colour scheme', 'accounting'); ?></h4>
            <p><?php _e("Selecting one of this schemes will import the predefined colors below, which you can then edit as you like.", 'accounting'); ?></p>
            <div class="clear" ></div> 
            <div class="fullwidth" id="predefined_colors">
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="default" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#26507a;"></span><span class="colorspantext"><?php esc_html_e('Default', 'accounting'); ?></span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="orange" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#d54900;"></span><span class="colorspantext"><?php esc_html_e('Orange', 'accounting'); ?></span></div>
                </label>
                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="yellow" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#f9e60d;"></span><span class="colorspantext"><?php esc_html_e('Yellow', 'accounting'); ?></span></div>
                </label>

                <label class="onequarter palette">
                    <input class="hidden" type="radio" name="predefined_colors" value="green" />
                    <div class="wninety"><span class="colorspan floatleft" style="background:#43b425;"></span><span class="colorspantext"><?php esc_html_e('Green', 'accounting'); ?></span></div>
                </label>
                <div class="clear"></div>
            </div>
            <h3><?php _e("Main theme colors", 'accounting'); ?></h3>
            <h4><?php esc_html_e('Set your custom colors', 'accounting'); ?></h4>
            <p><?php esc_html_e('Not satisfied with the premade color schemes? Here you can set your custom colors.', 'accounting'); ?></p>
            <div class="input onequarter two-line-label">
                <label for="text_color"><?php _e("Text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('text_color', '#727272')); ?>" readonly style="background: <?php echo esc_attr(get_option('text_color', '#727272')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="text_color" value="<?php echo esc_attr(get_option('text_color', '#727272')); ?>" id="text_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="primary_color"><?php _e("Primary color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('primary_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('primary_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="primary_color" value="<?php echo esc_attr(get_option('primary_color', '#26507a')); ?>" id="primary_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="hovers_color"><?php _e("Hovers color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('hovers_color', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('hovers_color', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="hovers_color" value="<?php echo esc_attr(get_option('hovers_color', '#3178bf')); ?>" id="hovers_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="menu_text_color"><?php _e("Menu text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="menu_text_color" value="<?php echo esc_attr(get_option('menu_text_color', '#000')); ?>" id="hovers_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="headings_color"><?php _e("Headings color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('headings_color', '#000000')); ?>" readonly style="background: <?php echo esc_attr(get_option('headings_color', '#000000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="headings_color" value="<?php echo esc_attr(get_option('headings_color', '#000000')); ?>" id="headings_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="top_bar_color"><?php _e("Top bar text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" readonly style="background: <?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="top_bar_color" value="<?php echo esc_attr(get_option('top_bar_color', '#c1c1c1')); ?>" id="top_bar_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="top_bar_bg_color"><?php _e("Top bar background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" readonly style="background: <?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="top_bar_bg_color" value="<?php echo esc_attr(get_option('top_bar_bg_color', '#f9f9f9')); ?>" id="top_bar_bg_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="footer_bg_color"><?php _e("Footer background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('footer_bg_color', '#0f0f0f')); ?>" readonly style="background: <?php echo esc_attr(get_option('footer_bg_color', '#0f0f0f')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="footer_bg_color" value="<?php echo esc_attr(get_option('footer_bg_color', '#0f0f0f')); ?>" id="footer_bg_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="copyright_footer_bg_color"><?php _e("Copyright footer text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('copyright_footer_text_color', '#c4c4c4')); ?>" readonly style="background: <?php echo esc_attr(get_option('copyright_footer_text_color', '#242424')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="copyright_footer_text_color" value="<?php echo esc_attr(get_option('copyright_footer_text_color', '#c4c4c4')); ?>" id="copyright_footer_text_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="copyright_footer_bg_color"><?php _e("Copyright footer background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('copyright_footer_bg_color', '#242424')); ?>" readonly style="background: <?php echo esc_attr(get_option('copyright_footer_bg_color', '#242424')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="copyright_footer_bg_color" value="<?php echo esc_attr(get_option('copyright_footer_bg_color', '#242424')); ?>" id="copyright_footer_bg_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="footer_text_color"><?php _e("Footer text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('footer_text_color', '#c4c4c4')); ?>" readonly style="background: <?php echo esc_attr(get_option('footer_text_color', '#c4c4c4')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="footer_text_color" value="<?php echo esc_attr(get_option('footer_text_color', '#c4c4c4')); ?>" id="footer_text_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="footer_text_color"><?php _e("Footer divider color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('footer_divider_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('footer_divider_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="footer_divider_color" value="<?php echo esc_attr(get_option('footer_divider_color', '#fff')); ?>" id="footer_divider_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="nav_background_color"><?php _e("Page header background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="nav_background_color" value="<?php echo esc_attr(get_option('nav_background_color', '#fff')); ?>" id="nav_background_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="nav_divider_color"><?php _e("Main divider color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('main_divider_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('main_divider_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="main_divider_color" value="<?php echo esc_attr(get_option('main_divider_color', '')); ?>" id="main_divider_color" />
            </div>              
            <div class="input onequarter two-line-label">
                <label for="submenu_background_color"><?php _e("Submenu background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="submenu_background_color" value="<?php echo esc_attr(get_option('submenu_background_color', '#fff')); ?>" id="submenu_background_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="submenu_text_color"><?php _e("Submenu text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" readonly style="background: <?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="submenu_text_color" value="<?php echo esc_attr(get_option('submenu_text_color', '#000')); ?>" id="submenu_text_color" />
            </div>         
            <div class="input onequarter two-line-label">
                <label for="side_submenu_background_color"><?php _e("Side submenu background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_background_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_background_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_background_color" value="<?php echo esc_attr(get_option('side_submenu_background_color', '')); ?>" id="side_submenu_background_color" />
            </div>  
            <div class="input onequarter two-line-label">
                <label for="side_submenu_text_color"><?php _e("Side submenu text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_text_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_text_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_text_color" value="<?php echo esc_attr(get_option('side_submenu_text_color', '')); ?>" id="side_submenu_text_color" />
            </div>       
            <div class="input onequarter two-line-label">
                <label for="side_submenu_text_hover_color"><?php _e("Side submenu text hover color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('side_submenu_text_hover_color', '')); ?>" readonly style="background: <?php echo esc_attr(get_option('side_submenu_text_hover_color', '')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="side_submenu_text_hover_color" value="<?php echo esc_attr(get_option('side_submenu_text_hover_color', '')); ?>" id="side_submenu_text_hover_color" />
            </div>    
            <div class="input onequarter two-line-label">
                <label for="icon_shortcode_text_hover_color"><?php _e("Icon shortcode heading hover color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('icon_shortcode_text_hover_color', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('icon_shortcode_text_hover_color', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="icon_shortcode_text_hover_color" value="<?php echo esc_attr(get_option('icon_shortcode_text_hover_color', '#3178bf')); ?>" id="icon_shortcode_text_hover_color" />
            </div>    
            <div class="input onequarter two-line-label">
                <label for="anps_woo_cart_items_number_bg_color"><?php _e("Shopping cart item number background color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_bg_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_bg_color', '#26507a')); ?>" id="anps_woo_cart_items_number_bg_color" />
            </div>
            <div class="input onequarter two-line-label">
                <label for="anps_woo_cart_items_number_color"><?php _e("Shoping cart item number text color", 'accounting'); ?></label>
                <input data-value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="anps_woo_cart_items_number_color" value="<?php echo esc_attr(get_option('anps_woo_cart_items_number_color', '#fff')); ?>" id="anps_woo_cart_items_number_color" />
            </div>   
            <div class="clear"></div>
        
        <h3><?php esc_html_e('Button styles', 'accounting'); ?></h3>
            <div class="input fullwidth">
                <p><?php esc_html_e('Button styles will refresh after clicking "Save all changes".', 'accounting'); ?></p>
                <hr>
                <div class="fullwidth">
                    <h4><?php esc_html_e('Default button', 'accounting'); ?></h4>
                    <a class="btn btn-sm" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="default_button_bg"><?php _e("Default button background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_bg', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_bg', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_bg" value="<?php echo esc_attr(get_option('default_button_bg', '#26507a')); ?>" id="default_button_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="default_button_color"><?php _e("Default button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_color" value="<?php echo esc_attr(get_option('default_button_color', '#fff')); ?>" id="default_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="default_button_hover_bg"><?php _e("Default button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_hover_bg', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_hover_bg', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_hover_bg" value="<?php echo esc_attr(get_option('default_button_hover_bg', '#3178bf')); ?>" id="default_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="default_button_hover_color"><?php _e("Default button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="default_button_hover_color" value="<?php echo esc_attr(get_option('default_button_hover_color', '#fff')); ?>" id="default_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-1", 'accounting');?></h4>
                    <a class="btn btn-sm style-1" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_1_button_bg"><?php _e("button background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_bg', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_bg', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_bg" value="<?php echo esc_attr(get_option('style_1_button_bg', '#26507a')); ?>" id="style_1_button_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_1_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_color" value="<?php echo esc_attr(get_option('style_1_button_color', '#fff')); ?>" id="style_1_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_1_button_hover_bg"><?php _e("button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_hover_bg', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_hover_bg', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_hover_bg" value="<?php echo esc_attr(get_option('style_1_button_hover_bg', '#3178bf')); ?>" id="style_1_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_1_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_1_button_hover_color" value="<?php echo esc_attr(get_option('style_1_button_hover_color', '#fff')); ?>" id="style_1_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="clear"></div>
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-2", 'accounting');?></h4>
                    <a class="btn btn-sm style-2" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_2_button_bg"><?php _e("button background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_bg', '#000000')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_bg', '#000000')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_bg" value="<?php echo esc_attr(get_option('style_2_button_bg', '#000000')); ?>" id="style_2_button_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_2_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_color" value="<?php echo esc_attr(get_option('style_2_button_color', '#fff')); ?>" id="style_2_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_2_button_hover_bg"><?php _e("button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_hover_bg', '#ffffff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_hover_bg', '#ffffff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_hover_bg" value="<?php echo esc_attr(get_option('style_2_button_hover_bg', '#ffffff')); ?>" id="style_2_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_2_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_2_button_hover_color" value="<?php echo esc_attr(get_option('style_2_button_hover_color', '#fff')); ?>" id="style_2_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-3", 'accounting');?></h4>
                    <a class="btn btn-sm style-3" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_3_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_color" value="<?php echo esc_attr(get_option('style_3_button_color', '#26507a')); ?>" id="style_3_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_3_button_hover_bg"><?php _e("button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_hover_bg', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_hover_bg', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_hover_bg" value="<?php echo esc_attr(get_option('style_3_button_hover_bg', '#26507a')); ?>" id="style_3_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_3_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_hover_color', '#ffffff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_hover_color', '#ffffff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_hover_color" value="<?php echo esc_attr(get_option('style_3_button_hover_color', '#ffffff')); ?>" id="style_3_button_hover_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_3_button_border_color"><?php _e("button border color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_3_button_border_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_3_button_border_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_3_button_border_color" value="<?php echo esc_attr(get_option('style_3_button_border_color', '#26507a')); ?>" id="style_3_button_border_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-4", 'accounting');?></h4>
                    <a class="btn btn-sm style-4" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_4_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_4_button_color', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_4_button_color', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_4_button_color" value="<?php echo esc_attr(get_option('style_4_button_color', '#26507a')); ?>" id="style_4_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_4_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_4_button_hover_color', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_4_button_hover_color', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_4_button_hover_color" value="<?php echo esc_attr(get_option('style_4_button_hover_color', '#3178bf')); ?>" id="style_4_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button slider", 'accounting');?></h4>
                    <a class="btn btn-sm slider" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_slider_button_bg"><?php _e("button background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_bg', '#26507a')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_bg', '#26507a')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_bg" value="<?php echo esc_attr(get_option('style_slider_button_bg', '#26507a')); ?>" id="style_slider_button_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_slider_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_color" value="<?php echo esc_attr(get_option('style_slider_button_color', '#fff')); ?>" id="style_slider_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_slider_button_hover_bg"><?php _e("button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_hover_bg', '#3178bf')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_hover_bg', '#3178bf')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_hover_bg" value="<?php echo esc_attr(get_option('style_slider_button_hover_bg', '#3178bf')); ?>" id="style_slider_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_slider_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_slider_button_hover_color" value="<?php echo esc_attr(get_option('style_slider_button_hover_color', '#fff')); ?>" id="style_slider_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
            <div class="input fullwidth">
                <div class="fullwidth">
                    <h4><?php _e("Button style-5", 'accounting');?></h4>
                    <a class="btn btn-sm style-5" href="#"><?php esc_html_e('Button', 'accounting'); ?></a>
                </div>
                <div class="input onequarter two-line-label">
                    <label for="style_style_5_button_bg"><?php _e("button background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_bg" value="<?php echo esc_attr(get_option('style_style_5_button_bg', '#c3c3c3')); ?>" id="style_style_5_button_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_style_5_button_color"><?php _e("button color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_color" value="<?php echo esc_attr(get_option('style_style_5_button_color', '#fff')); ?>" id="style_style_5_button_color" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_style_5_button_hover_bg"><?php _e("button hover background", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_hover_bg" value="<?php echo esc_attr(get_option('style_style_5_button_hover_bg', '#737373')); ?>" id="style_style_5_button_hover_bg" />
                </div>  
                <div class="input onequarter two-line-label">
                    <label for="style_style_5_button_hover_color"><?php _e("button hover color", 'accounting'); ?></label>
                    <input data-value="<?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" readonly style="background: <?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" class="color-pick-color"><input class="color-pick" type="text" name="style_style_5_button_hover_color" value="<?php echo esc_attr(get_option('style_style_5_button_hover_color', '#fff')); ?>" id="style_style_5_button_hover_color" />
                </div>  
                <div class="clear"></div>
                <hr>
            </div> 
        </div>
        <div class="clear"></div>
        <div class="content-top" style="border-style: solid none">
            <input type="submit" value="<?php _e("Save all changes", 'accounting'); ?>">
            <div class="clear"></div>
        </div>
        <div class="submit-right">
            <button type="submit" class="fixsave fixed fontawesome"><i class="fa fa-floppy-o"></i></button>
        <div class="clear"></div>        
    </form>
    <div class="clear"></div>    
</div>