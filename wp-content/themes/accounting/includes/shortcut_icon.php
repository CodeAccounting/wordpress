<?php 
global $anps_media_data;
$anps_favicon = get_option('anps_favicon', $anps_media_data['favicon']);
if (isset($anps_favicon) && $anps_favicon != "") : ?>
    <link rel="shortcut icon" href="<?php echo esc_url($anps_favicon); ?>" type="image/x-icon" />
<?php endif; ?>