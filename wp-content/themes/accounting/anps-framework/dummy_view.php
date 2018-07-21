<?php 
include_once 'classes/Dummy.php';

if (isset($_GET['save_dummy'])) {
        $dummy->save();
}
?>
<script type="text/javascript"> 
    function dummy () {
        var reply = confirm("WARNING: You have already insert dummy content and by inserting it again, you will have duplicate content.\r\n\We recommend doing this ONLY if something went wrong the first time and you have already cleared the content.");         
        return reply;
    }   
</script>
<form action="themes.php?page=theme_options&sub_page=dummy_content&save_dummy" method="post">
    <div class="content-inner envoo-dummy">
        <h3><?php _e("Insert dummy content: posts, pages, categories", 'accounting'); ?></h3>
        <p><?php _e("Importing demo content is the fastest way to get you started. <br/> Please <strong>install all plugins required by the theme</strong> before importing content. If you already have some content on your site, make a backup just in case.", 'accounting'); ?></p>                   
        
        <?php if(ini_get('max_execution_time') < 600 || ini_get('memory_limit') < 256 || ini_get('upload_max_filesize')< 32 || ini_get('post_max_size') < 32): ?>
        <div class="alert alert-danger-style-2">
            <i class="fa fa-exclamation"></i> <?php esc_html_e('One or more issues with server found! Please take a look at the System Requirements tab.', 'accounting'); ?>
        </div>        
        <?php endif; ?>
        <?php 
            $demo_names = array(
                esc_html__('Classic demo','accounting'),
                esc_html__('Header large demo', 'accounting'),
                esc_html__('Fullscreen demo', 'accounting'),
                esc_html__('Vertical menu demo', 'accounting'),
                esc_html__('Boxed demo', 'accounting'),
                esc_html__('Video slider demo', 'accounting')
            );
        ?>
        <div class="clear"></div>
        <?php for($i=1; $i<=6; $i++): ?>
        <div class="input">
            <center>          
                <img src="<?php echo get_template_directory_uri(); ?>/anps-framework/images/demo-<?php echo $i; ?>.jpg" />
                <div class="demotitle"><h4><?php echo $demo_names[$i-1]; ?></h4></div>
                <div class="demo-buttons">
                    <input type="submit" name="dummy<?php echo $i; ?>" class="dummy" <?php if ($dummy->select()) : ?> onclick = "return dummy(); " id="dummy-twice"<?php endif; ?> value="<?php _e("Insert dummy content", 'accounting'); ?>" />
                    <a class="launch" href="http://anpsthemes.com/accounting-demo-<?php echo $i; ?>/" target="_blank"><?php esc_html_e('launch demo preview', 'accounting');?></a>
                </div>
            </center>
        </div>
        <?php endfor; ?>
        <div class="clear"></div>
        <div class="absolute fullscreen importspin">
            <div class="table">
                <div class="table-cell center">
                    <div class="messagebox">
                    <i class="fa fa-cog fa-spin" style="font-size:30px;"></i>
                        <h2><strong><?php esc_html_e('Import might take some time, please be patient', 'accounting');?></strong></h2>                       
                    </div> 
                </div>
            </div>
        </div>
        
    </div>
</form>