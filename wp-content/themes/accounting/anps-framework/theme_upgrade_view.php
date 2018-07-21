<?php
include_once 'classes/AnpsUpgrade.php';
$tf_username = get_option("tf_username", "");
$tf_api_key = get_option("tf_api_key", "");
if(isset($_GET['save_user_data'])) {
    update_option('tf_username',$_POST['tf_username']);
    update_option('tf_api_key',$_POST['tf_api_key']);
    header("Location: themes.php?page=theme_options&sub_page=theme_upgrade"); 
}
?>
<form action="themes.php?page=theme_options&sub_page=theme_upgrade&save_user_data" method="post">   
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", 'accounting'); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <!-- Theme upgrade data -->
        <h3><?php _e("Theme upgrade", 'accounting'); ?></h3>

        <div class="alert">
        <i class="fa fa-exclamation-triangle"></i>
        <?php esc_html_e('Please backup all your files before upgrading (in case you did any custom work). The upgrade will overide all theme files, any custom changes will be lost.', 'accounting'); ?>
        </div>
        
        <!-- Username -->
        <div class="input fullwidth">
            <label for="tf_username"><?php _e("Themeforest username", 'accounting'); ?></label>
            <input type="text" name="tf_username" value="<?php echo esc_attr($tf_username); ?>" />
        </div>
        <!-- API key -->
        <div class="input fullwidth">
            <label for="tf_api_key"><?php _e("Themeforest API key", 'accounting'); ?></label>
            <input type="text" name="tf_api_key" value="<?php echo esc_attr($tf_api_key); ?>" />
        </div>
        <!-- Submit button -->
        <div class="save left">
            <input type="submit" value="<?php _e("Save all changes", 'accounting'); ?>">
        </div>
        <p class="eightyfive"><?php esc_html_e('To get your API key, log in to your themeforest account and click settings -> API Keys. Please see the screnshot below. If you do not have any generated API keys, please generate one.', 'accounting'); ?><br/><br/>
        <img class="shadow" src="<?php echo get_stylesheet_directory_uri(); ?>/anps-framework/images/api.jpg" />
        </p>
    </div>
</form>
<?php 
if(empty($tf_username) || empty($tf_api_key)) :
?>
<div class="content-bottom" style="border-style: solid none; margin-top: 70px">
<center><p><?php esc_html_e('Please enter username and api key.', 'accounting');?></p></center>
</div>
<?php elseif($update = AnpsUpgrade::check_theme_update()) : 
    ob_start();
    wp_nonce_field('upgrade-core');
    $nonce = ob_get_clean();
?>
<h3 class="action-required"><?php _e('You are using and outdated version of the theme, please upgrade it to get the latest features and ensure safety!', 'accounting'); ?></h3>
<form action="<?php echo network_admin_url('update-core.php?action=do-theme-upgrade'); ?>" method="post">
    <div class="content-bottom" style="border-style: solid none;">
        <input type="hidden" name="checked[]" value="<?php echo AnpsUpgrade::get_theme_name(); ?>" />
        <?php echo $nonce; ?>
        <input type="hidden" name="_wp_http_referer" value="/wp-admin/update-core.php?action=do-theme-upgrade" />
        <div class="twothirds">
            <div class="alert">
            <i class="fa fa-exclamation-triangle"></i>
            <?php esc_html_e('Please backup all your files before upgrading (in case you did any custom work). The upgrade will overide all theme files, any custom changes will be lost.', 'accounting');?>
            </div>
        </div>
        <div class="onethird">
            <input class="green right" onclick="return confirm('I want to upgrade the theme, I understand that this will overwrite all theme files.');" type="submit" value="<?php _e("Upgrade theme", 'accounting'); ?>">
        </div>
        <div class="clear"></div>
    </div>
</form>
<?php else : ?>
<div class="content-bottom" style="border-style: solid none; margin-top: 70px">
<center><p><?php esc_html_e('You are using the latest version of Constructo theme.', 'accounting');?></p></center>
</div>
<?php endif;