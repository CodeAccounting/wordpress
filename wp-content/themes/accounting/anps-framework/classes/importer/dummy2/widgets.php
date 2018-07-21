<?php
/* Widgets */
$widget_anpssocial = 'anpssocial';
$widget_spacings = 'anpsspacings';
$widget_anpstext = 'anpstext';
$widget_anpsimage = 'anpsimages';
$widget_wptext = 'text';
$widget_navigation = 'nav_menu';
$widget_opening_time = 'anpsopeningtime';
$widget_download = 'anpsdownload';
$widget_anpsnewsletter = 'newsletterwidget';
$widget_recent_posts = 'recent-posts';
$widget_testimonial = 'anpstestimonial';
$widget_contact = 'anpscontact';

/* All widgets */
$anpssocial = get_option('widget_'.$widget_anpssocial);
$anpsspacings = get_option('widget_'.$widget_spacings);
$anpstext = get_option('widget_'.$widget_anpstext);
$anpsimage = get_option('widget_'.$widget_anpsimage);
$wptext = get_option('widget_'.$widget_wptext);
$wpnavigation = get_option('widget_'.$widget_navigation);
$anpsopening = get_option('widget_'.$widget_opening_time);
$anpsdownload = get_option('widget_'.$widget_download);
$anpsnewsletter = get_option('widget_'.$widget_anpsnewsletter);
$recent_posts = get_option('widget_'.$widget_recent_posts);
$anpstestimonial = get_option('widget_'.$widget_testimonial);
$anpscontact = get_option('widget_'.$widget_contact);

/* Large above menu sidebar */
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$large_above_menu][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-home',
    'icon_color' => '#26507a',
    'text' => '<span class="important">112 Your Adress 23</span><br />Washington DC 1234'
);
$textcount++;
/* END Text and icon */
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$large_above_menu][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-envelope',
    'icon_color' => '#26507a',
    'text' => '<span class="important">Send us a mail</span><br />mail@domain.com'
);
$textcount++;
/* END Text and icon */
/* Social icons */
if(!is_array($anpssocial))$anpssocial = array();
$socialcount = count($anpssocial)+1;
$sidebar_options[$large_above_menu][] = $widget_anpssocial.'-'.$socialcount;
$anpssocial[$socialcount] = array(
    'icon_color' => '#26507a',
    'social' => 'fa-twitter;#|fa-linkedin;#|fa-facebook;#',
);
$socialcount++;
/* END Social icons */
/* END Large above menu sidebar */
/* Footer 1 */
/* Image widget */
if(!is_array($anpsimage))$anpsimage = array();
$imagecount = count($anpsimage)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_anpsimage.'-'.$imagecount;
$anpsimage[$imagecount] = array(
    'image' => 2230
);
$imagecount++;
/* END Image widget */
/* Text */
if(!is_array($wptext))$wptext = array();
$wptextcount = count($wptext)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'text' => "Accounting Corporation has been established in 2001. We have offices situated in North America and in Europe."
);
$wptextcount++;
/* END Text */
/* Spacing widget */   
if(!is_array($anpsspacings))$anpsspacings = array();
$spacingcount = count($anpsspacings)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_spacings.'-'.$spacingcount;
$anpsspacings[$spacingcount] = array(
    'spacing' => 15
);
$spacingcount++;
/* END Spacing widget */ 
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-map-marker',
    'text' => 'Accounting ltd. inc.<br /> 300 Pennsylvania Ave NW'
);
$textcount++;
/* END Text and icon */
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-phone',
    'text' => '+386 40 222 455'
);
$textcount++;
/* END Text and icon */
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-mobile',
    'text' => '+386 40 112 555'
);
$textcount++;
/* END Text and icon */
/* Text and icon */
if(!is_array($anpstext))$anpstext = array();
$textcount = count($anpstext)+1;
$sidebar_options[$footer_1_sidebar][] = $widget_anpstext.'-'.$textcount;
$anpstext[$textcount] = array(
    'icon' => 'fa-print',
    'text' => '+386 40 4444 1155'
);
$textcount++;
/* END Text and icon */
/* END Footer 1 */
/* Footer 2 */
/* Navigation */
if(!is_array($wpnavigation))$wpnavigation = array();
$navigationcount = count($wpnavigation)+1;    
$locations = get_theme_mod('nav_menu_locations');
$menu = 2;
if($locations && $locations['primary']) {
    $menu = $locations['primary'];
}
$sidebar_options[$footer_2_sidebar][] = $widget_navigation.'-'.$navigationcount;
$wpnavigation[$navigationcount] = array(
    'title' => 'NAVIGATION',
    'nav_menu' => $menu
);
$navigationcount++;
/* END Navigation */
/* Social icons */
if(!is_array($anpssocial))$anpssocial = array();
$socialcount = count($anpssocial)+1;
$sidebar_options[$footer_2_sidebar][] = $widget_anpssocial.'-'.$socialcount;
$anpssocial[$socialcount] = array(
    'title' => 'SOCIALIZE WITH US',
    'social' => 'fa-twitter;#|fa-facebook;#|fa-skype;#|fa-linkedin;#|fa-dribbble;#',
);
$socialcount++;
/* END Social icons */
/* END Footer 2 */
/* Footer 3 */
/* Text */
if(!is_array($wptext))$wptext = array();
$wptextcount = count($wptext)+1;
$sidebar_options[$footer_3_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'title' => 'WORKING HOURS',
    'text' => 'Visit us at our HQ for a mean cup of coffe and a fantastic consulting team.'
);
$wptextcount++;
/* END Text */
/* Spacing widget */   
if(!is_array($anpsspacings))$anpsspacings = array();
$spacingcount = count($anpsspacings)+1;
$sidebar_options[$footer_3_sidebar][] = $widget_spacings.'-'.$spacingcount;
$anpsspacings[$spacingcount] = array(
    'spacing' => 15
);
$spacingcount++;
/* END Spacing widget */
/* Opening time */
if(!is_array($anpsopening))$anpsopening = array();
$openingcount = count($anpsopening)+1;
$sidebar_options[$footer_3_sidebar][] = $widget_opening_time.'-'.$openingcount;
$anpsopening[$openingcount] = array(
    'opening_times' => 'Monday;9am > 1pm;false|Tuesday;9am > 1pm;false|Wendsday;9am > 1pm;false|Thursday;9am > 1pm;false|Friday;9am > 1pm;false|Saturday;9am > 1pm;false|Sunday;Closed;true'
);
$openingcount++;
/* END Opening time */
/* END Footer 3 */
/* Footer 4 */
/* Recent posts */
if(!is_array($recent_posts))$recent_posts = array();
$recent_postscount = count($recent_posts)+1;
$sidebar_options[$footer_4_sidebar][] = $widget_recent_posts.'-'.$recent_postscount;
$recent_posts[$recent_postscount] = array(
    'number' => "3",
    'title' => 'LATEST NEWS',
    'show_date' => 'on'
);
$recent_postscount++;
/* END Recent posts */
/* Spacing widget */   
if(!is_array($anpsspacings))$anpsspacings = array();
$spacingcount = count($anpsspacings)+1;
$sidebar_options[$footer_4_sidebar][] = $widget_spacings.'-'.$spacingcount;
$anpsspacings[$spacingcount] = array(
    'spacing' => 15
);
$spacingcount++;
/* END Spacing widget */
/* Newsletter */
if(!is_array($anpsnewsletter))$anpsnewsletter = array();
$anpsnewslettercount = count($anpsnewsletter)+1;
$sidebar_options[$footer_4_sidebar][] = $widget_anpsnewsletter.'-'.$anpsnewslettercount;
$anpsnewsletter[$anpsnewslettercount] = array(
    'title' => 'SUBSCRIBE'
);
$anpsnewslettercount++;
/* END Newsletter */
/* END Footer 4 */
/* Copyright Footer 1 */
/* Text */
$sidebar_options[$copyright_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
$wptext[$wptextcount] = array(
    'text' => "Accounting wordpress theme | &copy; 2015 Anpsthemes, All rights reserved"
);
$wptextcount++;
/* END Text */
/* END Copyright Footer 1 */
/* Secondary sidebar */
/* Navigation */
if(!is_array($wpnavigation))$wpnavigation = array();
$navigationcount = count($wpnavigation)+1;
$term = get_term_by('name', 'Side Menu', 'nav_menu');
$menu_id = $term->term_id;
$sidebar_options[$secondary_sidebar][] = $widget_navigation.'-'.$navigationcount;
$wpnavigation[$navigationcount] = array(
    'title' => 'Navigation',
    'nav_menu' => $menu_id
);
$navigationcount++;
/* END Navigation */
/* Download */
if(!is_array($anpsdownload))$anpsdownload = array();
$downloadcount = count($anpsdownload)+1;
$sidebar_options[$secondary_sidebar][] = $widget_download.'-'.$downloadcount;
$anpsdownload[$downloadcount] = array(
    'title' => 'Documentation',
    'file_title' => 'Vat regulations',
    'icon' => 'fa-file-pdf-o',
    'icon_color' => '#ffffff',
    'bg_color' => '#26507a'
);
$downloadcount++;
/* END Download */
/* Spacing widget */   
if(!is_array($anpsspacings))$anpsspacings = array();
$spacingcount = count($anpsspacings)+1;
$sidebar_options[$secondary_sidebar][] = $widget_spacings.'-'.$spacingcount;
$anpsspacings[$spacingcount] = array(
    'spacing' => 20
);
$spacingcount++;
/* END Spacing widget */
/* Testimonial */
if(!is_array($anpstestimonial))$anpstestimonial = array();
$testimonialcount = count($anpstestimonial)+1;
$sidebar_options[$secondary_sidebar][] = $widget_testimonial.'-'.$testimonialcount;
$anpstestimonial[$testimonialcount] = array(
    'image' => 2195,
    'text' => 'Accounting solutions really rocketed our company to the clouds. They organised our books, got our taxes to the tolerant levels.',
    'name' => 'MICHELL RUSSO',
    'job_title' => 'FieldCom Company CEO'
);
$testimonialcount++;
/* END Testimonial */
/* Contact */
if(!is_array($anpscontact))$anpscontact = array();
$contactcount = count($anpscontact)+1;
$sidebar_options[$secondary_sidebar][] = $widget_contact.'-'.$contactcount;
$anpscontact[$contactcount] = array(
    'title' => "Don't be shy, do contact us.",
    'text' => 'Our expert team is standing by to bring you the best possible plan to get your business were it deserves',
    'button_text' => 'CONTACT US',
    'title_color' => '#26507a',
    'text_color' => '#ffffff',
    'bg_color' => '#1abc9c',
    'button_text_color' => '#ffffff',
    'button_bg_color' => '#26507a'
);
$contactcount++;
/* END Contact */
/* END Secondary sidebar */
update_option('sidebars_widgets',$sidebar_options);
update_option('widget_'.$widget_anpssocial, $anpssocial);
update_option('widget_'.$widget_anpstext, $anpstext);
update_option('widget_'.$widget_anpsimage, $anpsimage);
update_option('widget_'.$widget_wptext, $wptext);
update_option('widget_'.$widget_navigation, $wpnavigation);
update_option('widget_'.$widget_opening_time, $anpsopening);
update_option('widget_'.$widget_spacings, $anpsspacings);
update_option('widget_'.$widget_download, $anpsdownload);
update_option('widget_'.$widget_anpscontactnumber, $anpscontactnumber);
update_option('widget_'.$widget_anpsnewsletter, $anpsnewsletter);
update_option('widget_'.$widget_recent_posts, $recent_posts);
update_option('widget_'.$widget_testimonial, $anpstestimonial);
update_option('widget_'.$widget_contact, $anpscontact);