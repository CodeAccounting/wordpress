<?php
$widget_anpssocial = 'anpssocial';
$widget_anpstext = 'anpstext';
$widget_anpsimage = 'anpsimages';
$widget_wptext = 'text';
$widget_navigation = 'nav_menu';
/* Top left sidebar */
$anpssocial = get_option('widget_'.$widget_anpssocial);
if(!is_array($anpssocial))$anpssocial = array();
$socialcount = count($anpssocial)+1;
$sidebar_options[$top_left_sidebar][] = $widget_anpssocial.'-'.$socialcount;
$anpssocial[$socialcount] = array(
    'sidebar_content' => 'on',
    'icon_0' => 'facebook',
    'url_0' => "#",
    'icon_1' => 'twitter',
    'url_1' => "#",
    'icon_2' => 'linkedin',
    'url_2' => "#",
    'icon_3' => 'google-plus',
    'url_3' => "#",
);
$socialcount++;
/* END Top left sidebar */
/* Top right sidebar */
$anpstext = get_option('widget_'.$widget_anpstext);
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
/* First widget */
$sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'clock-o',
    'text' => "Mon - Sat: 7:00 - 17:00"
);
$textcount++;
/* Second widget */
$sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'phone',
    'text' => "<span style='color:#1ab8cf;'>+ 386 40 111 5555</span>"
);
$textcount++;
/* Third widget */
$sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'envelope-o',
    'text' => '<span style="color:#1ab8cf;">info@yourdomain.com</span>'
);
$textcount++;
/* END Top right sidebar */
/* Above navigation sidebar */
/* First widget */
$sidebar_options[$above_navigation_bar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'lock',
    'text' => "Customer <a href='#'><span style='color:#25507a;'>login</span></a>"
);
$textcount++;
/* Second widget */
$sidebar_options[$above_navigation_bar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'phone',
    'text' => "Call us free: <span style='color:#25507a;'>+057 6854 456</span>"
);
$textcount++;
/* END Above navigation sidebar */
/* Footer 1 sidebar */
$anpsimage = get_option('widget_'.$widget_anpsimage);
if(!is_array($anpsimage))$anpsimage = array();
$imagecount = count($anpsimage)+1;
/* Image widget */
$sidebar_options[$footer_1_sidebar][] = $widget_anpsimage.'-'.$imagecount;
$anpsimage[$imagecount] = array(
    'image' => 1076,
    'title' => 'ABOUT US'
);
$imagecount++;
/* END Image widget */
$wptext = get_option('widget_'.$widget_wptext);
if(!is_array($wptext))$wptext = array();
$wptextcount = count($wptext)+1;
/* Text widget */
$sidebar_options[$footer_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam turpis quam, sodales in ante sagittis, varius efficitur mauris.",
    'filter' => 'on'
);
$wptextcount++;
/* END Text widget */
/* END Footer 1 sidebar */
/* Footer 2 sidebar */
$wpnavigation = get_option('widget_'.$widget_navigation);
if(!is_array($wpnavigation))$wpnavigation = array();
$navigationcount = count($wpnavigation)+1;
/* Navigation */
$locations = get_theme_mod('nav_menu_locations');
$menu = 2;
if($locations && $locations['primary']) {
    $menu = $locations['primary'];
}
$sidebar_options[$footer_2_sidebar][] = $widget_navigation.'-'.$navigationcount;
$wpnavigation[$navigationcount] = array(
    'nav_menu' => $menu,
    'title' => 'NAVIGATION'
);
$navigationcount++;
/* END Navigation */
/* END Footer 2 sidebar */
/* Footer 3 sidebar */
/* Text */
$sidebar_options[$footer_3_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'title' => 'ACCOUNTING OFFICE'
);
$wptextcount++;
/* END Text */
/* Icon 1 */
$sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'map-marker',
    'text' => 'Accounting ltd. inc.<br /> 300 Pennsylvania Ave NW, Washington<br /><br />'
);
$textcount++;
/* END Icon 1 */
/* Icon 2 */
$sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'phone',
    'text' => 'Telephone: +386 40 222 455'
);
$textcount++;
/* END Icon 2 */
/* Icon 3 */
$sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'mobile',
    'text' => 'Mobile phone: +386 40 112 555'
);
$textcount++;
/* END Icon 3 */
/* Icon 4 */
$sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'print',
    'text' => 'FAX: +386 40 4444 1155'
);
$textcount++;
/* END Icon 4 */
/* END Footer 3 sidebar */
/* Footer 4 sidebar */
/* Text */
$sidebar_options[$footer_4_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'text' => 'We work 7 days a week, every day including major holidays. Contact us for any info.<br /><br />
                Monday - Friday: <span class="right">7:00 - 17:00 </span><br />
                Saturday:   <span class="right">7:00 - 12:00</span> <br />
                Sunday and holidays:     <span class="right">8:00 - 10:00</span>',
    'title' => 'WORKING HOURS'
);
$wptextcount++;
/* END Text */
/* END Footer 4 sidebar */
/* Copyright Footer 1 sidebar */
/* Text */
$sidebar_options[$copyright_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'text' => "Accounting wordpress theme | &copy; 2015 Anpsthemes, All rights reserved"
);
$wptextcount++;
/* END Text */
/* END Copyright Footer 1 sidebar */
/* Secondary sidebar */
/* Navigation */
$locations = get_theme_mod('nav_menu_locations');
$menu = 2;
if($locations && $locations['primary']) {
    $menu = $locations['primary'];
}
$sidebar_options[$secondary_sidebar][] = $widget_navigation.'-'.$navigationcount;
$wpnavigation[$navigationcount] = array(
    'nav_menu' => $menu,
    'title' => 'Navigation'
);
$navigationcount++;
/* END Navigation */
/* END Secondary sidebar */
update_option('sidebars_widgets',$sidebar_options);
update_option('widget_'.$widget_anpssocial, $anpssocial);
update_option('widget_'.$widget_anpstext, $anpstext);
update_option('widget_'.$widget_anpsimage, $anpsimage);
update_option('widget_'.$widget_wptext, $wptext);
update_option('widget_'.$widget_navigation, $wpnavigation);
update_option('widget_'.$widget_tags, $wptags);
update_option('widget_'.$widget_anpsrecent, $anpsrecent);