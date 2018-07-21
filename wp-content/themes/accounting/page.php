<?php
$coming_soon = get_option('coming_soon', '0');
if(($coming_soon || $coming_soon!="0")&&!is_super_admin()) {
    get_header();
    $post_soon = get_post($coming_soon);
    echo '<div class="container">';
    echo do_shortcode($post_soon->post_content);
    echo '</div>';
    get_footer();
} else {
get_header();?>


<?php
//$legacy = '0';
//exit (get_option('anps_vc_legacy', '0'));
?>
<?php if (get_option('anps_vc_legacy', '0') == 'on') {
    get_template_part( 'templates/template-legacy', 'page' );
} else {
    get_template_part( 'templates/template', 'page' );    
}
?>

<?php get_footer(); 
} ?>