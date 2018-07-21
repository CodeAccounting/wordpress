<?php 
include_once 'classes/Style.php';

if (isset($_GET['save_font']))
            $style->update_gfonts();
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_google_font&save_font" method="post">
    <div class="content-inner">
        <h3><?php _e("Update google fonts", 'accounting'); ?></h3>    
        <p><?php esc_html_e('As we do not update google fonts automatically, you can update the google fonts with clicking the below button.', 'accounting');?></p>
        <center><input type="submit" class="dummy martop" value="<?php _e("Update google fonts", 'accounting'); ?>" /></center>
    </div>
</form>