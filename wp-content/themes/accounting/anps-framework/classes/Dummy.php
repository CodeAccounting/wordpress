<?php 
include_once 'Framework.php';
class Dummy extends Framework {
        
    public function select() {
        return get_option('anps_dummy');
    }
    
    public function save() { 
        $dummy_xml = "dummy1";
        if(isset($_POST['dummy1'])) {
            $dummy_xml = "dummy1";
        } elseif(isset($_POST['dummy2'])) {
            $dummy_xml = "dummy2";
        } elseif(isset($_POST['dummy3'])) {
            $dummy_xml = "dummy3";
        } elseif(isset($_POST['dummy4'])) {
            $dummy_xml = "dummy4";
        } elseif(isset($_POST['dummy5'])) {
            $dummy_xml = "dummy5";
        } elseif(isset($_POST['dummy6'])) {
            $dummy_xml = "dummy6";
        }
        
        include(get_template_directory() . '/anps-framework/classes/importer/' . $dummy_xml . '/theme-options.php');
        
        /* Import dummy xml */
        include_once 'importer/wordpress-importer.php';
        $parse = new WP_Import();
        $parse->import(get_template_directory() . "/anps-framework/classes/importer/$dummy_xml/dummy.xml");
      
        /* set dummy to 1 */
        update_option('anps_dummy', 1);
      
        global $wp_rewrite;
        $blog_id = get_page_by_title("News")->ID;
        $error_id = get_page_by_title("404 Page")->ID;
        $first_id = get_page_by_title("Home")->ID;
        $arr = array(
            'error_page'=>$error_id
        );
        
        update_option($this->prefix.'page_setup', $arr); 
        update_option('page_for_posts', $blog_id);
        update_option('page_on_front', $first_id);                                
        update_option('show_on_front', 'page'); 
        update_option('permalink_structure', '/%postname%/'); 
        $wp_rewrite->set_permalink_structure('/%postname%/');    
        $wp_rewrite->flush_rules();
        
        /* Set menu as primary */
	    $menu_id = wp_get_nav_menus();
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id[0]->term_id;
        set_theme_mod('nav_menu_locations', $locations);
        update_option('menu_check', true);
        
        /* Install all widgets */
        $this->__add_widgets($dummy_xml);
        
        /* Add revolution slider demo data */
        $this->__add_revslider($dummy_xml);
    }
    
    protected function __add_revslider($dummy_xml) {
        /* Check if slider is installed */
        if(is_plugin_active("revslider/revslider.php")) {
            $slider = new RevSlider();
            $slider_name = "main-slider";
            $response = $slider->importSliderFromPost('', '', get_template_directory() . "/anps-framework/classes/importer/$dummy_xml/main-slider.zip");
            //handle error
            if($response["success"] == false){
                $message = $response["error"];
                dmp("<b>Error: ".$message."</b>");
                exit;
            }
        } else {
            echo "Revolution slider is not active. Demo data for revolution slider can't be inserted.";
        }
    }  
    
    protected function __add_widgets($dummy_xml) {
        $secondary_sidebar = 'secondary-widget-area';
        $top_left_sidebar = 'top-bar-left';
        $top_right_sidebar = 'top-bar-right';
        $above_navigation_bar = 'above-navigation-bar';
        $footer_1_sidebar = "footer-1";
        $footer_2_sidebar = "footer-2";
        $footer_3_sidebar = "footer-3";
        $footer_4_sidebar = "footer-4";
        $copyright_1_sidebar = "copyright-1";
        $large_above_menu = 'large-above-menu';
        $sidebar_options = get_option('sidebars_widgets');
        if(!isset($sidebar_options[$secondary_sidebar])){
            $sidebar_options[$secondary_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$top_left_sidebar])){
            $sidebar_options[$top_left_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$top_right_sidebar])){
            $sidebar_options[$top_right_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$above_navigation_bar])){
            $sidebar_options[$above_navigation_bar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_1_sidebar])){
            $sidebar_options[$footer_1_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_2_sidebar])){
            $sidebar_options[$footer_2_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_3_sidebar])){
            $sidebar_options[$footer_3_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_4_sidebar])){
            $sidebar_options[$footer_4_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$copyright_1_sidebar])){
            $sidebar_options[$copyright_1_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$large_above_menu])){
            $sidebar_options[$large_above_menu] = array('_multiwidget'=>1);
        }
        include(get_template_directory() . '/anps-framework/classes/importer/' . $dummy_xml . '/widgets.php');
    }
}
$dummy = new Dummy();