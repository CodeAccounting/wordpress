<?php
/* Custom field for Table shortcode */
function table_field($settings, $value) {       
    if($value == "") {
    	$value = "[table_head][table_row][table_heading_cell][/table_heading_cell][/table_row][/table_head][table_body][table_row][table_cell][/table_cell][/table_row][/table_body]";
    }

    $matches = array();
    $match_vals = array(
        'row-start' => array('[table_row]', '<tr>'),
        'row-end' => array('[/table_row]', '</tr>'),
        'heading-start' => array('[table_heading_cell]', '<th><input type="text" placeholder="' . __("Table heading", 'accounting') . '" value="'),
        'heading-end' => array('[/table_heading_cell]', '" /></th>'),
        'cell-start' => array('[table_cell]', '<td><input type="text" placeholder="' . __("Table cell", 'accounting') . '" value="'),
        'cell-end' => array('[/table_cell]', '" /></td>')
    );
    /* Get table head */
    $head = preg_match('/\[table_head\](.*?)\[\/table_head\]/s', $value, $matches);
    $head = $matches[1];
    $head = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $head);
    $head = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $head);
    $head = str_replace($match_vals['heading-start'][0], $match_vals['heading-start'][1], $head);
    $head = str_replace($match_vals['heading-end'][0], $match_vals['heading-end'][1], $head);
    /* Get table body */
    $body = preg_match('/\[table_body\](.*?)\[\/table_body\]/s', $value, $matches);
    $body = $matches[1];
    $body = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $body);
    $body = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $body);
    $body = str_replace($match_vals['cell-start'][0], $match_vals['cell-start'][1], $body);
    $body = str_replace($match_vals['cell-end'][0], $match_vals['cell-end'][1], $body);
    /* Get table foot */
    $foot = preg_match('/\[table_foot\](.*?)\[\/table_foot\]/s', $value, $matches);
    if( isset($matches[1]) ) {
    	$foot = $matches[1];
	}
    $foot = str_replace($match_vals['row-start'][0], $match_vals['row-start'][1], $foot);
    $foot = str_replace($match_vals['row-end'][0], $match_vals['row-end'][1], $foot);
    $foot = str_replace($match_vals['cell-start'][0], $match_vals['cell-start'][1], $foot);
    $foot = str_replace($match_vals['cell-end'][0], $match_vals['cell-end'][1], $foot);
    
    $number_of_rows = substr_count($value, '[table_row]');
    $number_of_cells = substr_count($head, '<th>');

    $data = '<input type="text" value="'.$value.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select anps_custom_val '.$settings['param_name'].' '.$settings['type'].'" id="anps_custom_prod">';
    $data .= '<div class="anps-table-field">';
        $data .= '<div class="anps-table-field-remove-rows">';
        for($i=0;$i<$number_of_rows;$i++) {
        	if( $i == 0 ) {
        		$data .= '<button style="visibility: hidden;" title="' . __("Remove row", 'accounting') . '">&#215;</button>';
        	} else {
        		$data .= '<button title="' . __("Remove row", 'accounting') . '">&#215;</button>';
        	}
        }
        $data .= '</div>';
        $data .= '<table class="anps-table-field-remove-cells"><tbody><tr>';
        for($i=0;$i<$number_of_cells;$i++) {
            $data .= '<td><button title="' . __("Remove cell", 'accounting') . '">&#215;</button></td>';
        }
        $data .= '</tr></tbody></table>';
        $data .= '<table data-heading-placeholder="' . __("Table heading", 'accounting') . '" data-cell-placeholder="' . __("Table cell", 'accounting') . '" class="anps-table-field-vals">';
        $data .= '<thead>' . $head . '</thead>';
        $data .= '<tbody>' . $body . '</tbody>';
        //$data .= '<tfoot>' . $foot . '</tfoot>';
        $data .= '</table>';
        $data .= '<div class="anps-table-field-add-cells">';
            $data .= '<button title="' . __("Add cells", 'accounting') . '">+</button>';
        $data .= '</div>';
        $data .= '<div class="anps-table-field-add-rows">';
            $data .= '<button title="' . __("Add row", 'accounting') . '">+</button>';
        $data .= '</div>';
    $data .= '</div>';
    return $data;
}
vc_add_shortcode_param('table' , 'table_field', get_template_directory_uri() . "/js/vc-table.js", __FILE__);
/* Shortcodes */
/* Testimonials */
global $testimonial_counter, $testimonials_style;
$testimonial_counter = 0;
class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {
    static  function anps_testimonials_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'style' => 'style-1'
        ), $atts ) );
        if ($style=="") {$style = 'style-1';}
        $testimonials_number = substr_count($content, "[testimonial");
        $class = "testimonials testimonials-"  . $style;
        $data_return = "";
        $style_class = "";
        $randomid = substr( md5(rand()), 0, 7);    
        
        if( $style == 'style-3' ) {
            global $testimonials_style;
            $testimonials_style = 'style-3';
            $data_return .= '<div class="relative-wrapper">';
            $data_return .= "<div id='".$randomid."' class='owl-carousel " . $class . "' data-col='2'>";
            $data_return .= do_shortcode($content);
            $data_return .= "</div>";  

            if($testimonials_number > 2) {
                $data_return .= '<div class="owl-navigation">'; 
                $data_return .= '<a class="owlprev"><i class="fa fa-chevron-left"></i> <span class="sr-only">Left<span></a></a>';
                $data_return .= '<a class="owlnext"><i class="fa fa-chevron-right"></i></a>'; 
                $data_return .= '</div>'; 
            }
            $data_return .= '</div>';
            
        } else {
            if($testimonials_number > 1) {
                $data_return .= "<div id='".$randomid."' class='carousel " . $class . " slide' data-ride='carousel'>";
                $class = "carousel-inner";
            }
            global $testimonial_counter;
            $testimonial_counter = 0;
            $data_return .= '<div class="'.$class.'">'.do_shortcode($content).'</div>';
            if($testimonials_number>1) {
                $data_return .= '<a class="left carousel-control" href="#'.$randomid.'" data-slide="prev">';
                $data_return .= '<i class="fa fa-chevron-left"></i> <span class="sr-only">Left<span></a>';
                $data_return .= "</a>";
                $data_return .= '<a class="right carousel-control" href="#'.$randomid.'" data-slide="next">';
                $data_return .= '<i class="fa fa-chevron-right"></i>';
                $data_return .= '</a>';
                $data_return .= "</div>";
            }            
        }

        return $data_return;
    }
} 
add_shortcode('testimonials', array('WPBakeryShortCode_testimonials','anps_testimonials_func'));
/* END Testimonials */
/* Testimonial item */
class WPBakeryShortCode_anps_testimonial extends WPBakeryShortCode {
    static function anps_testimonial_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'image' => '',
            'image_u' => "",
            "user_name" => "",
            "user_url" => "",
            "position" => ''
        ), $atts ) ); 
        global $testimonial_counter, $testimonials_style;
        $testimonial_counter++;
        $class = "";
        if($testimonial_counter=='1') {
            $class = " active";
        }
        if($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        } 
        $data = "";
        $data .= "<blockquote class='testimonial item".$class."'>";

        if( $testimonials_style == 'style-3' ) {
            $data .= '<div class="row">';
            if($image) {
                $data .= '<div class="col-md-6">';
                $data .= "<img class='testimonial-image' src='".$image."' alt='".$user_name."' >";
                $data .= '</div>';
                $data .= '<div class="col-md-6">';
            } else  {
                $data .= '<div class="col-md-12">';
            }
            $data .= "<h4 class='testimonial-user'>";
            $data .= $user_name;
            $data .= '</h4>';
            if($position) {
                $data .= "<p class='testimonial-position'>".$position."</p>";
            }
            $data .= "<p class='testimonial-content'>".$content."</p>";
            $data .= '</div>';
            $data .= '</div>';
        } else {
                $data .= "<p class='testimonial-content'>".$content."</p>";
                $data .= "<cite class='testimonial-footer'>";
                    if($image) {
                        $data .= "<img class='testimonial-image' src='".$image."' alt='".$user_name."' >";
                    }
                    $data .= "<span class='testimonial-user'>";
                        $data .= $user_name;
                        if($user_url) {
                            $data .= " / ";
                            $data .= "<a href='".$user_url."' target='_blank'>".$user_url."</a>";
                        }
                    $data .= "</span>";
            $data .= "</cite>";
        }
        $data .= "</blockquote>";  
        return $data;
    }
}
add_shortcode('testimonial', array('WPBakeryShortCode_anps_testimonial','anps_testimonial_func'));
/* END Testimonial */

/* Timeline */
if(!function_exists('anps_timeline_func')) {
    function anps_timeline_func($atts, $content) {
        extract( shortcode_atts( array(), $atts ) );
        
        return '<div class="timeline">' . do_shortcode($content) . '</div>';
    }
}
/* END Timeline */
add_shortcode('timeline', array('WPBakeryShortCode_timeline','anps_timeline_func'));
/* Timeline Item */
if(!function_exists('anps_timeline_item_func')) {
    function anps_timeline_item_func($atts, $content) {
        extract( shortcode_atts( array(
            'title' => '',
            'year'  => '2016'
        ), $atts ) );
        
        $return = '<div class="timeline-item">';
            $return .= '<div class="timeline-year">' . $year . '</div>';
            $return .= '<div class="timeline-content">';
                $return .= '<h3 class="timeline-title">' . $title . '</h3>';
                $return .= '<div class="timeline-text">' . $content . '</div>';
            $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
}
add_shortcode('timeline_item', array('WPBakeryShortCode_timeline_item','anps_timeline_item_func'));
/* END Timeline Item */
/* Google maps */
$google_maps_counter = 0;
class WPBakeryShortCode_google_maps extends WPBakeryShortCodesContainer {
    static function anps_google_maps_func( $atts,  $content ) {        
        global $google_maps_counter;
        $google_maps_counter++;
        extract( shortcode_atts( array(
	        'zoom'     => '15',
	        'scroll'   => '',
	        'height'   => '550',
	        'map_type' => 'ROADMAP',
            'style'   => ''
        ), $atts ) ); 
        $style = str_replace('``', '"', $style);
        $style = str_replace('`{`', '[', $style);  
        $style = str_replace('`}`', ']', $style);           
        $style = str_replace('`', '', $style); 
        $scroll_option = "true";
        if($scroll==true) {
            $scroll_option = "false";
        }
        preg_match_all( '#\](.*?)\[/google_maps_item]#', $content, $matches); 
        $location = $matches[1][0]; 
        wp_enqueue_script('gmap3_link');
        wp_enqueue_script('gmap3'); 
                
        return "<div class='map' id='map$google_maps_counter' style='height: {$height}px;' data-type='$map_type' data-styles='$style' data-zoom='$zoom' data-scroll='{$scroll_option}' data-markers='" . do_shortcode($content) . "'></div>";
    }
}
add_shortcode('google_maps', array('WPBakeryShortCode_google_maps','anps_google_maps_func'));
/* END Google maps */
/* Google maps item */
class WPBakeryShortCode_google_maps_item extends WPBakeryShortCode {
    static function anps_google_maps_item_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'info'          => '',
            'pin'           => '',
            'marker_center' => '',
        ), $atts ) ); 

        $info = preg_replace('/[\n\r]+/', "", $info);
        if( base64_encode(base64_decode($info)) === $info ) {
        	$info = base64_decode($info);
    	}

        if(isset($pin) && $pin!="") {
            $pin_icon = wp_get_attachment_image_src($pin, 'full');
            $pin_icon = $pin_icon[0];
        } else {
            $pin_icon = get_template_directory_uri()."/images/gmap/map-pin.png";
        }

        return '{ "address": "' . $content . '",  "center": "' . $marker_center . '", "data": "' . $info . '", "options": { "icon": "' . $pin_icon . '" } }|';
    }
}
add_shortcode('google_maps_item', array('WPBakeryShortCode_google_maps_item','anps_google_maps_item_func'));
/* END Google maps item */
/* Logos */
class WPBakeryShortCode_logos extends WPBakeryShortCodesContainer {
    static function anps_logos_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'in_row' => '3',
            'style' => 'style-1'
        ), $atts ) );   
        $logos_array = explode("[/logo]", $content);
        foreach($logos_array as $key=>$item) {
            if($item=="") {
                unset($logos_array[$key]);
            } 
        }
        $data_col = "";
        $logos_class = "";
        $count_logos = count($logos_array);
        if ($count_logos > $in_row && $style == 'style-2') {
           $data_col = "data-col=" . $in_row;
           $logos_class = 'owl-carousel';
        }

        $return = "<div class='logos-wrapper $style'>";
        $return .= "<ul class='logos ". $logos_class ."' ".$data_col.">";       

        $i = 0;
        foreach($logos_array as $item) {
            if($i%$in_row==0 && $i!=0 && $style == 'style-1') { 
                    $return .= "</ul><ul class='logos'>".do_shortcode($item."[/logo]");
            } else { 
                $return .= do_shortcode($item."[/logo]");
            }
            $i++;
        } 
        $return .= "</ul></div>"; 
        return $return;
    }
} 
add_shortcode('logos', array('WPBakeryShortCode_logos','anps_logos_func'));
/* END Logos */
/* Logo */
class WPBakeryShortCode_anps_logo extends WPBakeryShortCode {
    static function anps_logo_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'url' => '',
            'alt' => '',
            'image_u' => '',
            'image_u_hover' => '',
            'img_hover' => '',
            'alt_hover' => ''
        ), $atts ) ); 
        if($image_u) {
            $content = wp_get_attachment_image_src($image_u, 'full');
            $content = $content[0];
        }
        if($image_u_hover) {
            $img_hover = wp_get_attachment_image_src($image_u_hover, 'full');
            $img_hover = $img_hover[0];
        }
        
        /* Element (span or a) */
        $before = '<span>';
        $after = '</span>';
        
        if($url) {
            $before = '<a href="'.$url.'" target="_blank">';
            $after = '</a>';
        }
        
        /* Class */
        $class = '';
        if(!$image_u_hover) {
            $class = ' class="logos-fade"';
        }
        
        
        /* Retrun */
        $return = '<li' . $class . '>' . $before . "<img src='".$content."' alt='".$alt."'>";
        
        if($image_u_hover) {
            $return .=  '<span class="hover"><img src="'.$img_hover.'" alt="'.$alt_hover.'"></span>' . $after;
        }
        
        $return .= $after . '</li>';
        
        return $return;
    }
}
add_shortcode('logo', array('WPBakeryShortCode_anps_logo','anps_logo_func'));
/* END Logo */
/* Faq */
$faq_counter = 0;
class WPBakeryShortCode_faq extends WPBakeryShortCodesContainer {
    static function anps_faq_func( $atts,  $content ) {
        wp_enqueue_script('collapse');
        global $faq_counter;
        $faq_counter++;
        return "<div class='panel-group faq' id='accordion".$faq_counter."'>".do_shortcode($content)."</div>";
    }
} 
add_shortcode('faq', array('WPBakeryShortCode_faq','anps_faq_func'));
/* END faq */
/* Faq item */
$faq_item_counter = 0;
class WPBakeryShortCode_faq_item extends WPBakeryShortCode {
    static function faq_item_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'title' => '',
            'answer_title' => ''
        ), $atts ) );
        global $faq_counter;
        global $faq_item_counter;
        $faq_item_counter++;
        $faq_data = "<div class='panel'>";
        $faq_data .= "<div class='panel-heading'>";
        $faq_data .= "<h4 class='panel-title'>";
        $faq_data .= "<a class='collapsed' data-toggle='collapse' data-parent='#accordion".$faq_counter."' href='#collapse".$faq_item_counter."'>".$title."</a>";
        $faq_data .= "</h4>";
        $faq_data .= "</div>";
        $faq_data .= "<div id='collapse".$faq_item_counter."' class='panel-collapse collapse'>";
        $faq_data .= "<div class='panel-body'>";
        $faq_data .= "<h4>".$answer_title."</h4>";
        $faq_data .= "<p>".$content."</p>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        $faq_data .= "</div>";
        return $faq_data;
    }
}
add_shortcode('faq_item', array('WPBakeryShortCode_faq_item','faq_item_func'));
/* END faq item */
/* Pricing table */
class WPBakeryShortCode_pricing_table extends WPBakeryShortCodesContainer {
    static function pricing_table_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'title' => '',
            'currency' => '&euro;',
            'price' => '0',
            'period' => '',
            'button_text' => '',
            'button_url' => '',
            'featured' => ""
        ), $atts ) );

        if( $button_text != '' ) {
        	$button_text = '<li><a class="btn btn-md" href="' . $button_url . '">' . $button_text . '</a></li>';
        }
        $exposed_class = "";
        if($featured) {
            $exposed_class = " exposed";
        }
        $pricing_data = "<div class='pricing-table$exposed_class'>";
        $pricing_data .= "<header>";
        $pricing_data .= "<h2>".$title."</h2>";
        $pricing_data .= "<span class='currency'>".$currency."</span><span class='price'>".$price."</span>";
        if($period) {
            $pricing_data .= "<div class='date'>".$period."</div>";
        }
        $pricing_data .= "</header>";
        $pricing_data .= "<ul>".do_shortcode($content).$button_text."</ul>";
        $pricing_data .= "</div>";
        return $pricing_data;
    }
} 
add_shortcode('pricing_table', array('WPBakeryShortCode_pricing_table','pricing_table_func'));
/* END pricing table */
/* Pricing item */
class WPBakeryShortCode_pricing_item extends WPBakeryShortCode {
    static function pricing_item_func( $atts,  $content ) { 
        extract( shortcode_atts( array(), $atts ) );
        return '<li>'.$content ."</li>";
    }
}
add_shortcode('pricing_table_item', array('WPBakeryShortCode_pricing_item','pricing_item_func'));
/* END pricing item */
/* Contact info */
class WPBakeryShortCode_contact_info extends WPBakeryShortCodesContainer {
    static function contact_info_func( $atts,  $content ) {
        return "<ul class='contact-info'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('contact_info', array('WPBakeryShortCode_contact_info','contact_info_func'));
/* END Contact info */
/* Contact info item */
class WPBakeryShortCode_contact_info_item extends WPBakeryShortCode {
    static function contact_info_item( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'icon' => '',
            'icon_type' => '',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypo' => '',
            'icon_linecons' => '',
            'icon_monosocial' => ''
        ), $atts ) );
        
        $icon_class = 'fa fa-' . $icon;
        /* Check for VC icon types */
        vc_icon_element_fonts_enqueue( $icon_type );
        $icon_type = 'icon_' . $icon_type;
        if( $$icon_type ) { $icon_class = $$icon_type; }
            
        return "<li><i class='".$icon_class."'></i>".$content."</li>";
    }
}
add_shortcode('contact_info_item', array('WPBakeryShortCode_contact_info_item','contact_info_item'));
/* END contact info item */
/* Social icons */
class WPBakeryShortCode_social_icons extends WPBakeryShortCodesContainer {
    static function social_icons_func( $atts,  $content ) {
        return "<ul class='socialize'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('social_icons', array('WPBakeryShortCode_social_icons','social_icons_func'));
/* END Social icons */
/* Social icon */
class WPBakeryShortCode_social_icon extends WPBakeryShortCode {
    static function social_icon_item_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'url' => '#',
            'icon' => '',
            'target' => '_blank',
            'title' => '',
            'icon_type' => '',
            'icon_fontawesome' => '',
            'icon_openiconic' => '',
            'icon_typicons' => '',
            'icon_entypo' => '',
            'icon_linecons' => '',
            'icon_monosocial' => ''
        ), $atts ) );
        
        $icon_class = 'fa fa-' . $icon;
        /* Check for VC icon types */
        vc_icon_element_fonts_enqueue( $icon_type );
        $icon_type = 'icon_' . $icon_type;
        if( $$icon_type ) { $icon_class = $$icon_type; }
        
        if( $title ) {
            $title = "<span class='sr-only'>$title</span>";
        }
        
        return "<li><a href='".$url."' target='".$target."'><i class='".$icon_class."'></i>$title</a></li>";
    }
}
add_shortcode('social_icon_item', array('WPBakeryShortCode_social_icon','social_icon_item_func'));
/* END Social icon */
/* Statement */
class WPBakeryShortCode_statement extends WPBakeryShortCodesContainer {
    static function statement_func( $atts,  $content ) {
        extract( shortcode_atts( array( 
            'parallax' => 'false',
            'parallax_overlay' => 'false',
            'image' => '',
            'color' => '',
            'container' => 'false',
            'slug' => '',
            'image_u' => ''
        ), $atts ) );
        if($image_u) {
            $image = wp_get_attachment_image_src($image_u, 'full');
            $image = $image[0];
        }
        global $anps_parallax_slug;
        $parallax_class = "";
        $parallax_id = "";
        if($parallax=="true") {
            $parallax_class = " parallax";
            $anps_parallax_slug[] = $slug;
            $parallax_id = "id='$slug'";
        } 
        $parallax_overlay_class = "";
        if($parallax_overlay=="true") {
            $parallax_overlay_class = " parallax-overlay";
        } 
        $containe_class = "";
        $container_before = "";
        $container_after = "";
        $container_class='';
        if($container=="true") {
            $container_before = '<div class="container text-center">';
            $container_after = '</div>';
        } 
        $style = '';
        if($image) {
            $style = "background-image: url('$image');";
        } elseif($color) {
            $style = "background-color: $color;";
        } 
        return '<section '.$parallax_id.' class="statement'.$parallax_class.$parallax_overlay_class.'" style="'.$style.'">'.$container_before.do_shortcode($content).$container_after.'</section>';
    }
}
add_shortcode('statement',array('WPBakeryShortCode_statement','statement_func'));
/* END Statement */
/* Tabs */
global $tabs_counter, $indiv_tab_counter;
$tabs_counter = 0;
$indiv_tab_counter = 0;
class WPBakeryShortCode_tabs extends WPBakeryShortCodesContainer {
    static function tabs_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            'type' => ''
        ), $atts ) );
        wp_enqueue_script('tab');
        global $tabs_counter, $indiv_tab_counter, $tabs_single;
        $tabs_counter++;
        $sub_tabs_counter = 1;
        $indiv_tab_counter = 0;
        $tabs_single = 0;
        /* Everything inside [tab] shortcode */ 
        preg_match_all( '#\[tab(.*?)\]#', $content, $matches); 
        if ( isset($matches[1]) ) { $tab_titles = $matches[1]; } 
        $class = "";
        $class_before = "";
        $class_after = "";
        $class_content = "";
        if($type == 'vertical') {
            $class = ' vertical';
            $class_before = "<div class='col-2-5'>";
            $class_after = "</div>";
            $class_content = " col-9-5";
        }
        $tabs_menu = '';
        $tabs_menu .= $class_before;
        $tabs_menu .= '<ul class="nav nav-tabs'.$class.'" id="tab-' . $tabs_counter . '">';
        $i=0;
        foreach ( $tab_titles as $tab ) { 
            preg_match_all( '/title="(.*?)\"/', $tab, $title_match); 
            preg_match_all( '/icon="(.*?)\"/', $tab, $icon_match); 
            if(isset($icon_match[1][0])) {
                $icon[$i] = " <i class='fa fa-".$icon_match[1][0]."'></i>";
            } else {
                $icon[$i] = "";
            } 
            if( $sub_tabs_counter == 1 ) {
                $tabs_menu .= '<li class="active"><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
            } else {
                $tabs_menu .= '<li><a data-toggle="tab" href="#tab' . $tabs_counter . '-' . $sub_tabs_counter . '">' . $title_match[1][0].$icon[$i] . '</a></li>';
            }
            $i++;
            $sub_tabs_counter++; 
        }
        $tabs_menu .= '</ul>';
        $tabs_menu .= $class_after;
        return $tabs_menu . '<div class="tab-content'.$class_content.'">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('tabs', array('WPBakeryShortCode_tabs','tabs_func'));
/* END Tabs */
/* Tab */
class WPBakeryShortCode_tab extends WPBakeryShortCodesContainer {
    static function tab_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            "title" => "",
            "icon" => ""
        ), $atts ) );
        global $tabs_counter, $tabs_single;
        $active = "";
        if( $tabs_single == 0 ) {
            $active = " active";
        }
        $content = str_replace('&nbsp;', '<p class="blank-line clearfix"><br /></p>', $content);
        $tabs_single++;
        return '<div id="tab' . $tabs_counter . '-' . $tabs_single . '" class="tab-pane' . $active . '">' . do_shortcode( $content ) . '</div>';
    }
}
add_shortcode('tab', array('WPBakeryShortCode_tab','tab_func'));
/* END Tab */
/* Accordion */
global $accordion_opened;
$accordion_counter = 0;
$accordion_opened = false;
class WPBakeryShortCode_accordion extends WPBakeryShortCodesContainer {
    static function accordion_func( $atts,  $content ) {
        extract( shortcode_atts( array(
            "opened" => "false",
            'style' => ''
        ), $atts ) );
        wp_enqueue_script('collapse');
        global $accordion_counter, $accordion_opened; 
        $accordion_counter++;
        if($opened=="true") {
            $accordion_opened = true;
        }
        $style_class="";
        if($style=="style-2") {
            $style_class = " style-2 collapsed";
        }
        return '<div class="panel-group'.$style_class.'" id="accordion' . $accordion_counter . '">' .  do_shortcode($content) . '</div>';
    }
}
add_shortcode('accordion', array('WPBakeryShortCode_accordion','accordion_func'));
/* END Accordion */
/* Accordion item */
$accordion_item_counter = 0;
class WPBakeryShortCode_accordion_item extends WPBakeryShortCodesContainer {
    static function accordion_item_func( $atts,  $content ) { 
        extract( shortcode_atts( array(
            'title' => ''           
    ), $atts ) );
    $opened_class = "";
    global $accordion_item_counter, $accordion_opened; 
    if( $accordion_opened ) {
        $opened_class = " in";
        $closed_class = "";
        $accordion_opened = false;
    } else {
        $closed_class = " class='collapsed'";
    } 
    $accordion_item_counter++;
    return '<div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" '.$closed_class.' href="#collapse' . $accordion_item_counter . '">' . $title . '</a>
                    </h4>
                </div>
                <div id="collapse' . $accordion_item_counter . '" class="panel-collapse collapse'.$opened_class.'">
                    <div class="panel-body">' .  do_shortcode($content) . '</div>
                </div>
            </div>';
    }
}
add_shortcode('accordion_item', array('WPBakeryShortCode_accordion_item','accordion_item_func'));
/* END Accordion item */
/* List */
global $list_number;
$list_number = false;
class WPBakeryShortCode_anps_list extends WPBakeryShortCodesContainer {
    static function anps_list_func( $atts,  $content ) {   
        extract( shortcode_atts( array(
            'class' => ''
        ), $atts ) );

        global $list_number;

        if( $class == "number" ) {
        	$list_number = true;
        	$return = "<ol class='list'>".do_shortcode($content)."</ol>";
        	$list_number = false;
        	return $return;
        }
        return "<ul class='list ".$class."'>".do_shortcode($content)."</ul>";
    }
}
add_shortcode('anps_list', array('WPBakeryShortCode_anps_list','anps_list_func'));
/* END List */
/* List item */
class WPBakeryShortCode_anps_list_item extends WPBakeryShortCodesContainer {
    static function anps_list_item_func( $atts,  $content ) {   
    	global $list_number;
    	if($list_number) {
    		return "<li><span>".$content."</span></li>";
    	} else {
    		return "<li>".$content."</li>";
    	}
    }
}
add_shortcode('list_item', array('WPBakeryShortCode_anps_list_item','anps_list_item_func'));
/* END List item */
/* END Shortcodes */
/* Remove Default VC values */
$vc_values = array(
    'vc_cta_button2',
    'vc_message',
    'vc_facebook',
    'vc_tweetmeme',
    'vc_googleplus',
    'vc_pinterest',
    'vc_toggle',
    //'vc_gallery',
    //'vc_images_carousel',
    'vc_tour',
    'vc_accordion',
    'vc_posts_grid',
    'vc_carousel',
    'vc_posts_slider',
    'vc_widget_sidebar',
    'vc_button',
    'vc_cta_button',
    'vc_video',
    'vc_gmaps',
    'vc_raw_js',
    'vc_flickr',
    'vc_progress_bar',
    'vc_pie',
);
foreach ($vc_values as $vc_value) {
    vc_remove_element($vc_value);
}
/* Blog categories new parameter */
function blog_categories_settings_field($settings, $value) {    
    $blog_data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $blog_data .= '<option class="0" value="">'.__("All", 'accounting').'</option>';
    foreach(get_categories() as $val) {
        $selected = '';
        if ($value!='' && $val->slug == $value) {
             $selected = ' selected="selected"';
        }
        $blog_data .= '<option class="'.$val->slug.'" value="'.$val->slug.'"'.$selected.'>'.$val->name.'</option>';
    }
    $blog_data .= '</select>';
    return $blog_data;
}
vc_add_shortcode_param('blog_categories' , 'blog_categories_settings_field');
/* Portfolio categories new parameter */
function portfolio_categories_settings_field($settings, $value) {   
    $categories = get_terms('portfolio_category');
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option class="0" value="0">'.__("All", 'accounting').'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!='' && $val->term_id == $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->term_id.'" value="'.$val->term_id.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('portfolio_categories' , 'portfolio_categories_settings_field');
/* Team categories new parameter */
function team_categories_settings_field($settings, $value) {   
    $categories = get_terms('team_category');
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option value="0">'.__("All", 'accounting').'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!='' && $val->term_id == $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->term_id.'" value="'.$val->term_id.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('team_categories' , 'team_categories_settings_field');
/* All pages new parameter */
function all_pages_settings_field($settings, $value) {   
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    foreach(get_pages() as $val) {
        $selected = '';
        if ($value!='' && $val->ID == $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->ID.'" value="'.$val->ID.'"'.$selected.'>'.$val->post_title.'</option>';
    }
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('all_pages' , 'all_pages_settings_field');
/* VC Appointment */
$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
$contact_form_array = array();
if($cf7) {
    foreach($cf7 as $cform) {
        $contact_form_array[$cform->post_title] = $cform->ID;
    }
} else {
    $contact_form_array[ esc_html__( 'No contact forms found', 'js_composer' ) ] = 0;
}
vc_map( array(
   "name" => esc_html__("Appointment", 'accounting'),
   "base" => "appointment",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_appointment.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "attach_image",
         "heading" => esc_html__("Image", 'accounting'),
         "param_name" => "image_u"
       ),
       array(
         "type" => "textfield",
         "heading" => esc_html__("Location", 'accounting'),
         "param_name" => "location"
      ),
       array(
         "type" => "textfield",
         "heading" => esc_html__("Title", 'accounting'),
         "param_name" => "title"
      ),
      array(
         "type" => "textarea",
         "heading" => esc_html__("Text", 'accounting'),
         "param_name" => "text"
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__("Contact form", 'accounting'),
         "param_name" => "contact_form",
         "value" => $contact_form_array,
         "save_always" => true 
       ) 
   )
) );
/* END VC Appointment */
/* VC Blog */
vc_map( array(
   "name" => __("Blog", 'accounting'),
   "base" => "blog",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_blog.png", 
   "params" => array(
      array(
         "type" => "blog_categories",
         "holder" => "div",
         "heading" => __("Blog categories", 'accounting'),
         "param_name" => "category",
         "description" => __("Select blog categories.", 'accounting')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Posts per page", 'accounting'),
         "param_name" => "content",
         "description" => __("Enter post per page.", 'accounting')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order By", 'accounting'),
         "param_name" => "orderby",
         "value" => array(__("Default", 'accounting')=>'', __("Date", 'accounting')=>'date', __("Id", 'accounting')=>'ID', __("Title", 'accounting')=>'title', __("Name", 'accounting')=>'name', __("Author", 'accounting')=>'author'), 
         "description" => __("Enter parallax.", 'accounting'),
         "save_always" => true
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order", 'accounting'),
         "param_name" => "order",
         "value" => array(__("Default", 'accounting')=>'', __("ASC", 'accounting')=>'ASC', __("DESC", 'accounting')=>'DESC'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Blog type", 'accounting'),
         "param_name" => "type",
         "value" => array(__("", 'accounting')=>'', __("Grid", 'accounting')=>'grid', __("Masonry", 'accounting')=>'masonry'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Columns", 'accounting'),
         "param_name" => "columns",
         "value" => array(__("3 columns", 'accounting')=>'3', __("4 columns", 'accounting')=>'4'),
         "save_always" => true  
       )
    )
) );
/* END VC Blog */
/* VC Portfolio */
vc_map( array(
   "name" => __("Portfolio", 'accounting'),
   "base" => "portfolio",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_portfolio.png", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of portfolio posts", 'accounting'),
         "param_name" => "per_page",
         "value" => "", 
         "description" => __("Enter number of portfolio posts.", 'accounting')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Show in row", 'accounting'),
         "param_name" => "columns",
         "value" => array(__("6", 'accounting')=>'6',__("4", 'accounting')=>'4', __("3", 'accounting')=>'3', __("2", 'accounting')=>'2' ),
         "save_always" => true 
      ),
      array(
         "type" => "portfolio_categories",
         "holder" => "div",
         "heading" => __("Portfolio categories", 'accounting'),
         "param_name" => "category",
         "description" => __("Select portfolio categories.", 'accounting')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Filter", 'accounting'),
         "param_name" => "filter",
         "value" => array(__("On", 'accounting')=>'on', __("Off", 'accounting')=>'off'),
         "save_always" => true 
      ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Filter style", 'accounting'),
         "param_name" => "style",
         "value" => array(__("Style 1", 'accounting')=>'style-1', __("Style 2", 'accounting')=>'style-2'),
         "save_always" => true  
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Portfolio type", 'accounting'),
         "param_name" => "type",
         "value" => array(__("Default", 'accounting')=>'default', __("Classic", 'accounting')=>'classic', __("Random", 'accounting')=>'random'),
         "save_always" => true 
       ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order By", 'accounting'),
         "param_name" => "orderby",
         "value" => array(__("Default", 'accounting')=>'default', __("Date", 'accounting')=>'date', __("Id", 'accounting')=>'ID', __("Title", 'accounting')=>'title', __("Name", 'accounting')=>'name'),  
         "description" => __("Enter order by.", 'accounting'),
         "save_always" => true 
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Order", 'accounting'),
         "param_name" => "order",
         "value" => array(__("Default", 'accounting')=>'', __("ASC", 'accounting')=>'ASC', __("DESC", 'accounting')=>'DESC'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Mobile view", 'accounting'),
         "param_name" => "mobile_class",
         "value" => array(__("2 columns", 'accounting')=>'2', __("1 column", 'accounting')=>'1'),
         "save_always" => true  
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Filter color", 'accounting'),
         "param_name" => "filter_color",
         "value" => "", 
         "description" => __("Filter color.", 'accounting')
       )
    )
));
/* END VC Portfolio */
/* VC team */
vc_map( array(
   "name" => __("Team", 'accounting'),
   "base" => "team",
   "class" => "",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_team.png",
   "params" => array(
       array(
         "type" => "team_categories",
         "holder" => "div",
         "heading" => __("Team categories", 'accounting'),
         "param_name" => "category",
         "description" => __("Select team category.", 'accounting')
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of items in column", 'accounting'),
         "param_name" => "columns",
         "value" => array(__("4", 'accounting')=>'4', __("2", 'accounting')=>'2', __("3", 'accounting')=>'3', __("6", 'accounting')=>'6'),
         "description" => __("Enter number of team item in column.", 'accounting'),
         "save_always" => true  
      ),
      array(
        "type" => "checkbox",
        "holder" => "div",
        "heading" => __("Use large images", 'accounting'),
        "param_name" => "large_images", 
        "description" => __("Use full sized images instead of column sized ones", 'accounting'),
        "save_always" => true 
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of team members", 'accounting'),
         "param_name" => "number_items",
         "value" => "", 
         "description" => __("Enter number of team members (if you want all than enter -1).", 'accounting')
      ), 
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Team member id/s", 'accounting'),
         "param_name" => "ids",
         "value" => "", 
         "description" => __("Enter team member id/s. Example: 1,2,3", 'accounting')
      ) 
    )
) );
/* END VC team */
/* VC recent blog */
vc_map( array(
   "name" => __("Recent blog", 'accounting'),
   "base" => "recent_blog",
   "class" => "",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_recentblog.png",
   "params" => array(
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Number of blog posts", 'accounting'),
             "param_name" => "number",
             "value" => "4", 
             "description" => __("Enter number of recent blog posts.", 'accounting')
        ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "heading" => __("Number of columns in a row", 'accounting'),
             "param_name" => "col_number",
             "value" => array(__("2", 'accounting')=>'2', __("3", 'accounting')=>'3', __("4", 'accounting')=>'4',  __("6", 'accounting')=>'6'),
             "std" => "3",
             "description" => __("Select number of items in a row.", 'accounting'),         
        ) 
    )
) );
/* END VC recent blog */
/* VC recent portfolio slider */
vc_map( array(
   "name" => __("Recent portfolio slider", 'accounting'),
   "icon" => get_template_directory_uri()."/images/visual-composer/shortcode_icons-recent.png",
   "base" => "recent_portfolio_slider",
   "class" => "",
   "category" => 'accounting',
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", 'accounting'),
         "param_name" => "recent_title",
         "value" => "", 
         "description" => __("Recent portfolio title.", 'accounting')
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Title color", 'accounting'),
         "param_name" => "title_color",
         "value" => "#c1c1c1", 
         "description" => __("Title text color.", 'accounting')
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Next/Prev color", 'accounting'),
         "param_name" => "nex_prev_color",
         "value" => "#c1c1c1", 
         "description" => __("Next/previous color.", 'accounting')
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Next/Prev background color", 'accounting'),
         "param_name" => "nex_prev_bg_color",
         "value" => "#3d3d3d", 
         "description" => __("Next/previous background color.", 'accounting')
       ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of portfolio posts", 'accounting'),
         "param_name" => "number",
         "value" => "", 
         "description" => __("Enter number of recent portfolio posts. If you want to display all posts, leave this field empty.", 'accounting')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Number in row", 'accounting'),
         "param_name" => "number_in_row",
         "value" => array(__("3", 'accounting')=>'3', __("4", 'accounting')=>'4', __("5", 'accounting')=>'5', __("6", 'accounting')=>'6'),
         "std" => "4",
         "description" => __("Select number of items in row.", 'accounting'),
         "save_always" => true 
       ),  
      array(
         "type" => "portfolio_categories",
         "holder" => "div",
         "heading" => __("Portfolio categories", 'accounting'),
         "param_name" => "category",
         "description" => __("Select portfolio categories.", 'accounting')
      ) 
    )
) );
/* END VC recent portfolio slider */
/* VC recent portfolio */
vc_map( array(
   "name" => __("Recent portfolio", 'accounting'),
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_recentportfolio.png",
   "base" => "recent_portfolio",
   "class" => "",
   "category" => 'accounting',
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number of portfolio posts", 'accounting'),
         "param_name" => "number",
         "value" => "5", 
         "description" => __("Enter number of recent portfolio posts.", 'accounting')
      ),
      array(
         "type" => "portfolio_categories",
         "holder" => "div",
         "heading" => __("Portfolio categories", 'accounting'),
         "param_name" => "category",
         "description" => __("Select portfolio categories.", 'accounting')
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Mobile view", 'accounting'),
         "param_name" => "mobile_class",
         "value" => array(__("2 columns", 'accounting')=>'2', __("1 column", 'accounting')=>'1'),
         "save_always" => true 
       ) 
       )
) );
/* END VC recent portfolio */
/* VC twitter */
vc_map( array(
   "name" => __("Twitter", 'accounting'),
   "base" => "twitter",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_twitter.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slug", 'accounting'),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", 'accounting')  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", 'accounting'),
         "param_name" => "title",
         "value" => "Stay tuned, follow us on Twitter", 
         "description" => __("Enter twitter title.", 'accounting')
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", 'accounting'),
         "param_name" => "parallax",
         "value" => array(__("False", 'accounting')=>'false', __("True", 'accounting')=>'true'), 
         "description" => __("Enter parallax.", 'accounting'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", 'accounting'),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", 'accounting')=>'', __("True", 'accounting')=>'true'), 
         "description" => __("Parallax overlay.", 'accounting'),
         "save_always" => true  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Background image url", 'accounting'),
         "param_name" => "image",
         "description" => __("Enter background image url.", 'accounting')
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", 'accounting'),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", 'accounting'),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Twitter username", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter twitter username.", 'accounting')
      )
       )
) );
/* END VC twitter */
/* VC alert */
vc_map( array(
   "name" => __("Alert", 'accounting'),
   "base" => "alert",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_alert.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter alert text.", 'accounting')
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Icon", 'accounting'),
         "param_name" => "type",
         "value" => array(__("", 'accounting')=>'', __("Warning", 'accounting')=>'warning', __("Info", 'accounting')=>'info', __("Success", 'accounting')=>'success', __("Useful", 'accounting')=>'useful', __("Normal", 'accounting')=>'normal'),
         "save_always" => true  
       )
       )
    ));
/* END VC alert */
/* VC counter */
vc_map( array(
   "name" => __("Counter", 'accounting'),
   "base" => "counter",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_counter.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter counter text.", 'accounting')
       ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
                __( 'Mono Social', 'js_composer' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'save_always' => true,
            'description' => __( 'Select icon library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Max number", 'accounting'),
         "param_name" => "max",
         "value" => "", 
         "description" => __("Enter max number.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Min number", 'accounting'),
         "param_name" => "min",
         "value" => "0", 
         "description" => __("Enter min number.", 'accounting')
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Icon color", 'accounting'),
         "param_name" => "icon_color"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Number color", 'accounting'),
         "param_name" => "number_color"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Subtitle color", 'accounting'),
         "param_name" => "subtitle_color"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Border color", 'accounting'),
         "param_name" => "border_color"
       )
       )
    ) );
/* END VC counter */
/* VC progress */
vc_map( array(
   "name" => __("Progress", 'accounting'),
   "base" => "progress",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_progress.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Progress procent", 'accounting'),
         "param_name" => "procent",
         "value" => "", 
         "description" => __("Enter progress procent.", 'accounting')
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Striped", 'accounting'),
         "param_name" => "striped",
         "value" => array(__("No", 'accounting')=>'', __("Yes", 'accounting')=>'true'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Active", 'accounting'),
         "param_name" => "active",
         "value" => array(__("No", 'accounting')=>'', __("Yes", 'accounting')=>'true'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Color class", 'accounting'),
         "param_name" => "color_class",
         "value" => array(__("Success", 'accounting')=>'progress-bar-success', __("Info", 'accounting')=>'progress-bar-info', __("Warning", 'accounting')=>'progress-bar-warning', __("Danger", 'accounting')=>'progress-bar-danger'),
         "save_always" => true  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Progress title", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter progress title.", 'accounting')
      )
       )
) );
/* END VC progress */
/* VC icon */
vc_map( array(
   "name" => __("Icon", 'accounting'),
   "base" => "icon",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_icon.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", 'accounting'),
         "param_name" => "title"
      ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Subtitle", 'accounting'),
         "param_name" => "subtitle"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Link", 'accounting'),
         "param_name" => "url"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Target", 'accounting'),
         "param_name" => "target",
         "value" => "_self"
      ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
                __( 'Mono Social', 'js_composer' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            'save_always' => true
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Position", 'accounting'),
         "param_name" => "position",
         "value" => array(__("Left", 'accounting')=>'left', __("Right", 'accounting')=>'right'),
         "save_always" => true 
      ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Class", 'accounting'),
         "param_name" => "class",
         "value" => array(__("Style 1", 'accounting')=>'', __("Style 2", 'accounting')=>'style-2'),
         "save_always" => true  
          ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title color", 'accounting'),
         "param_name" => "title_color"
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Subtitle color", 'accounting'),
         "param_name" => "subtitle_color"
      ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Icon color", 'accounting'),
         "param_name" => "icon_color"
      ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Icon background color", 'accounting'),
         "param_name" => "icon_bg_color"
      )
   )
) );
/* END VC icon */
/* VC quote */
vc_map( array(
   "name" => __("Quote", 'accounting'),
   "base" => "quote",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_quote.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Quote text", 'accounting'),
         "param_name" => "content"
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style",
         "value" => array(__("Style 1", 'accounting')=>'style-1', __("Style 2", 'accounting')=>'style-2'),
         "save_always" => true 
       ) 
   )
) );
/* END VC quote */
/* VC color */
vc_map( array(
   "name" => __("Color", 'accounting'),
   "base" => "color",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_color.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Color text", 'accounting'),
         "param_name" => "content"
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style",
         "value" => array(__("Style 1", 'accounting')=>'', __("Style 2", 'accounting')=>'style-2'),
         "save_always" => true 
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "class" => "",
         "heading" => __("Custom color", 'accounting'),
         "param_name" => "custom"
      )
   )
) );
/* END VC color */
/* VC dropcaps */
vc_map( array(
   "name" => __("Dropcaps", 'accounting'),
   "base" => "dropcaps",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_dropcaps.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Dropcaps text", 'accounting'),
         "param_name" => "content"
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style",
         "value" => array(__("Style 1", 'accounting')=>'', __("Style 2", 'accounting')=>'style-2'),
         "save_always" => true 
       )
   )
) );
/* END VC dropcaps */
/* VC statement */
vc_map( array(
   "name" => __("Statement", 'accounting'),
   "base" => "statement",
   "content_element" => true,
   "is_container" => true, 
   "js_view" => 'VcColumnView',
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_statement.png", 
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slug", 'accounting'),
         "param_name" => "slug",
         "description" => __("This is used for both for none page navigation and the parallax effect (if you do not have the navigation need you enter a unique slug if you want parallax effect to function)", 'accounting')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax", 'accounting'),
         "param_name" => "parallax",
         "value" => array(__("False", 'accounting')=>'false', __("True", 'accounting')=>'true'), 
         "description" => __("Enter parallax.", 'accounting'),
         "save_always" => true  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Parallax overlay", 'accounting'),
         "param_name" => "parallax_overlay",
         "value" => array(__("False", 'accounting')=>'', __("True", 'accounting')=>'true'), 
         "description" => __("Parallax overlay.", 'accounting'),
         "save_always" => true  
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Background image url", 'accounting'),
         "param_name" => "image"
       ),
       array(
         "type" => "attach_image",
         "holder" => "div",
         "heading" => __("Background image", 'accounting'),
         "param_name" => "image_u"
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background color", 'accounting'),
         "param_name" => "color",
         "value" => "", 
         "description" => __("Background color.", 'accounting')
       )
   )
) );
/* END VC statement */
/* VC heading */
vc_map( array(
   "name" => __("Heading", 'accounting'),
   "base" => "heading",
   "class" => "",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_heading.png", 
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter title.", 'accounting')
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Size", 'accounting'),
         "param_name" => "size",
         "value" => array(__("H1", 'accounting')=>'1', __("H2", 'accounting')=>'2', __("H3", 'accounting')=>'3', __("H4", 'accounting')=>'4', __("H5", 'accounting')=>'5'), 
         "description" => __("Enter title size.", 'accounting'),
         "save_always" => true 
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Heading class", 'accounting'),
         "param_name" => "heading_class",
         "value" => array(__("Middle heading", 'accounting')=>'heading', __("Content heading", 'accounting')=>'content_heading', __("Left heading", 'accounting')=>'style-3'), 
         "description" => __("Choose heading.", 'accounting'),
         "save_always" => true 
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Heading style", 'accounting'),
         "param_name" => "heading_style",
         "value" => array(esc_html__("Style 1", 'accounting')=>'style-1', esc_html__("Style 2", 'accounting')=>'divider-sm', esc_html__("Style 3", 'accounting')=>'divider-lg'), 
         "description" => esc_html__("Choose heading style.", 'accounting'),
         "save_always" => true 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Id", 'accounting'),
         "param_name" => "h_id",
         "value" => "", 
         "description" => __("Enter id.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class", 'accounting'),
         "param_name" => "h_class",
         "value" => "", 
         "description" => __("Enter class.", 'accounting')
       ),
       array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => esc_html__("Color", 'accounting'),
         "param_name" => "color",
         "description" => __("Heading text color.", 'accounting')
      )
    )
) );
/* END VC heading */
/* VC Google maps (as parent) */
vc_map( array(
   "name" => __("Google maps", 'accounting'),
   "base" => "google_maps",
   "category" => 'accounting',
   "content_element" => true,
   "is_container" => true,
   "as_parent" => array('only' => 'google_maps_item'), 
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_googlemaps.png",
   "js_view" => 'VcColumnView',
   "params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Zoom", 'accounting'),
			"param_name" => "zoom",
			"value" => "15", 
			"description" => __("Enter zoom.", 'accounting')
		),
		array(
			"type"       => "dropdown",
			"holder"     => "div",
			"heading"    => __("Map Type", 'accounting'),
			"param_name" => "map_type",
			"value"      => array(
				__("Road map", 'accounting')  => 'ROADMAP',
				__("Satellite", 'accounting') => 'SATELLITE',
				__("Hybrid", 'accounting')    => 'HYBRID',
				__("Terrain", 'accounting')   => 'TERRAIN'
			),
			"description" => __("Choose between four types of maps.", 'accounting'),
			"save_always" => true,
		),
		array(
			"type" => "textfield",
			"heading" => __("Height", 'accounting'),
			"param_name" => "height",
			"value" => "550",
			"description" => __("Enter height in px.", 'accounting')
		),
		array(
			"type" => "checkbox",
			"holder" => "div",
			"heading" => __("Disable scrolling", 'accounting'),
			"param_name" => "scroll", 
			"description" => __("Disable scrolling and dragging (mobile).", 'accounting'),
			"save_always" => true 
		),
		array(
			"type" => "textarea",
			"heading" => __("Style", 'accounting'),
			"param_name" => "style",
			"description" => __("Custom styles", 'accounting'),
		),
     )
) );
/* END VC Google maps */
/* VC Google maps item (as child) */
vc_map( array(
    "name" => __("Google maps item", 'accounting'),
    "base" => "google_maps_item",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_googlemaps.png",
    "as_child" => array('only' => 'google_maps'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Location", 'accounting'),
            "param_name" => "content",
            "description" => __("Enter address.", 'accounting')
        ),
		array(
			"type" => "checkbox",
			"holder" => "div",
			"heading" => __("Show marker at center", 'accounting'),
			"param_name" => "marker_center", 
			"save_always" => true ,
		),
        array(
            "type" => "attach_image",
            "heading" => __("Pin", 'accounting'),
            "param_name" => "pin",
            "description" => __("Select or upload pin icon.", 'accounting')
        ),
        array(
            "type" => "textarea_raw_html",
            "heading" => __("Info", 'accounting'),
            "param_name" => "info",
            "value" => "",
            "description" => __("Enter info about location.", 'accounting')
        )
    )
) );
/* END VC Google maps item */
/* VC vimeo */
vc_map( array(
   "name" => __("Vimeo", 'accounting'),
   "base" => "vimeo",
   "class" => "",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_vimeo.png", 
   "category" => 'accounting',
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Video id", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter vimeo video id.", 'accounting')
      ) 
       )
) );
/* END VC vimeo */
/* VC youtube */
vc_map( array(
   "name" => __("Youtube", 'accounting'),
   "base" => "youtube",
   "class" => "",
   "icon" => "icon-wpb-film-youtube", 
   "category" => 'accounting',
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Video id", 'accounting'),
         "param_name" => "content",
         "value" => "", 
         "description" => __("Enter youtube video id.", 'accounting')
      ) 
       )
) );
/* END VC youtube */
/* VC social icons */
vc_map( array(
    "name" => __("Social icons", 'accounting'),
    "base" => "social_icons",
    "content_element" => true,
    "as_parent" => array('only' => 'social_icon_item'), 
    "show_settings_on_create" => false,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_social.png",
    "js_view" => 'VcColumnView'
) );
/* END VC social icons */
/* VC social icon */
vc_map( array(
    "name" => __("Social icon item", 'accounting'),
    "base" => "social_icon_item",
    "content_element" => true,
    "is_container" => true,
    "category" => 'accounting',
    "as_child" => array('only' => 'social_icons'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_social.png",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Url", 'accounting'),
            "param_name" => "url",
            "description" => __("Enter url.", 'accounting'),
            "value" => "#"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Title", 'accounting'),
            "param_name" => "title",
            "description" => __("Text that will display on mouse hover and the alternative icon text.", 'accounting'),
            "value" => ""
        ),
       array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
                __( 'Mono Social', 'js_composer' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            "save_always" => true
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            "type" => "textfield",
            "heading" => __("Target", 'accounting'),
            "param_name" => "target",
            "value" => "_blank",
            "description" => __("Enter target.", 'accounting')
        )
    )
));
/* END VC social icon */
/* VC contact info */
vc_map( array(
    "name" => __("Contact info", 'accounting'),
    "base" => "contact_info",
    "as_parent" => array('only' => 'contact_info_item'), 
    "content_element" => true,
    "show_settings_on_create" => false,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_contactinfo.png",
    "js_view" => 'VcColumnView'
) );
/* END VC contact info */
/* VC contact info item */
vc_map( array(
    "name" => __("Contact info item", 'accounting'),
    "base" => "contact_info_item",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_contactinfo.png",
    "as_child" => array('only' => 'contact_info'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Text", 'accounting'),
            "param_name" => "content",
            "description" => __("Enter text.", 'accounting')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
                __( 'Mono Social', 'js_composer' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            "save_always" => true
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        )
    )
) );
/* END VC contact info item */
/* VC Faq */
vc_map( array(
    "name" => __("Faq", 'accounting'),
    "base" => "faq",
    "as_parent" => array('only' => 'faq_item'), 
    "content_element" => true,
    "show_settings_on_create" => false,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_faq.png",
    "js_view" => 'VcColumnView'
) );
/* END VC Faq */
/* VC Faq item */
vc_map( array(
    "name" => __("Faq item", 'accounting'),
    "base" => "faq_item",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_faq.png",
    "as_child" => array('only' => 'faq'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", 'accounting'),
            "param_name" => "title",
            "description" => __("Enter faq title.", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Answer title", 'accounting'),
            "param_name" => "answer_title",
            "description" => __("Enter faq answer title.", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Faq content", 'accounting'),
            "param_name" => "content",
            "description" => __("Enter faq text content.", 'accounting')
        )
    )
));
/* END VC Faq item */
/* VC logos (as parent) */
vc_map( array(
    "name" => __("Logos", 'accounting'),
    "base" => "logos",
    "as_parent" => array('only' => 'logo'), 
    "content_element" => true,
    "is_container" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_logo.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Logos in row", 'accounting'),
            "param_name" => "in_row",
            "description" => __("Logos in one row.", 'accounting'),
            "value" => "3", 
        ),
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style",
         "value" => array(esc_html__("Style 1", 'accounting')=>'style-1', esc_html__("Carousel Logos", 'accounting')=>'style-2'), 
         "description" => __("Select logos style.", 'accounting'),
         "save_always" => true   
      )
    )
) );
/* END VC logos*/
/* VC logo (as child) */
vc_map( array(
    "name" => __("Logo", 'accounting'),
    "base" => "logo",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_logo.png",
    "as_child" => array('only' => 'logos'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Image url", 'accounting'),
            "param_name" => "content",
            "description" => __("Enter image url.", 'accounting')
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image", 'accounting'),
            "param_name" => "image_u"
        ),
        array(
            "type" => "attach_image",
            "heading" => __("Image on hover", 'accounting'),
            "param_name" => "image_u_hover"
        ),
        array(
            "type" => "textfield",
            "heading" => __("Url", 'accounting'),
            "param_name" => "url",
            "description" => __("Logo url.", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Alt", 'accounting'),
            "param_name" => "alt",
            "description" => __("Logo alt.", 'accounting')
        )
    )
) );


/* Timeline */
class WPBakeryShortCode_timeline extends WPBakeryShortCodesContainer {
    static function anps_timeline_func($atts, $content) {     
        return anps_timeline_func($atts, $content);
    }
}
/* END Timeline */
/* Timeline item */
class WPBakeryShortCode_timeline_item extends WPBakeryShortCode {
    static function anps_timeline_item_func($atts, $content) { 
        return anps_timeline_item_func($atts, $content);
    }
}

/* VC Timeline (as parent) */
vc_map( array(
   "name" => esc_html__("Timeline", 'accounting'),
   "base" => "timeline",
   "category" => 'accounting',
   "content_element" => true,
   "is_container" => true,
   "show_settings_on_create" => false,
   "as_parent" => array('only' => 'timeline_item'),
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_timeline.png",
   "js_view" => 'VcColumnView',
   "params" => array(

     )
) );
/* END VC Timeline */
/* VC Timeline item (as child) */
vc_map( array(
    "name" => esc_html__("Timeline item", 'accounting'),
    "base" => "timeline_item",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_timeline.png",
    "as_child" => array('only' => 'timeline'),
    "params" => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Year", 'accounting'),
            "param_name" => "year",
            "value" => "2016",
            "description" => esc_html__("Enter year number.", 'accounting')
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Title", 'accounting'),
            "param_name" => "title",
            "description" => esc_html__("Enter title.", 'accounting')
        ),
        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__("Content", 'accounting'),
            "param_name" => "content",
            "description" => esc_html__("Enter content.", 'accounting')
        )
    )
) );
/* END VC Timeline item */

/* END Timeline item */


/* END VC logo */
/* VC testimonials (as parent) */
vc_map( array(
    "name" => __("Testimonials", 'accounting'),
    "base" => "testimonials",
    "as_parent" => array('only' => 'testimonial'), 
    "content_element" => true,
    "show_settings_on_create" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_testimonials.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style",
         "value" => array(__("Style 1", 'accounting')=>'style-1', __("Style 2", 'accounting')=>'style-2', __("Style 3", 'accounting')=>'style-3'), 
         "description" => __("Select testimonials style.", 'accounting'),
         "save_always" => true   
      )        
    )
) );
/* END VC testimonials */
/* VC testimonial (as child) */
vc_map( array(
    "name" => __("Testimonial item", 'accounting'),
    "base" => "testimonial",
    "content_element" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_testimonials.png",
    "as_child" => array('only' => 'testimonials'),
    "params" => array(  
        array(
            "type" => "textarea",
            "heading" => __("Testimonial text", 'accounting'),
            "param_name" => "content",
            "description" => __("Enter user testimonial text", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("User name", 'accounting'),
            "param_name" => "user_name",
            "description" => __("Enter user name", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Position", 'accounting'),
            "param_name" => "position",
            "description" => __("Applicable only for style-3 testimonials.", 'accounting'),      
        ),            
        array(
            "type" => "textfield",
            "heading" => __("User url", 'accounting'),
            "param_name" => "user_url",
            "description" => __("Enter user url", 'accounting')
        ),
        array(
            "type" => "attach_image",
            "heading" => __("User image", 'accounting'),
            "param_name" => "image_u",
            "description" => __("Choose image.", 'accounting')
        ),
        array(
            "type" => "textfield",
            "heading" => __("User image url", 'accounting'),
            "param_name" => "image",
            "description" => __("Enter image url.", 'accounting')
        )
    )
) );
/* END VC testimonial */
/* VC button */
vc_map( array(
   "name" => __("Button", 'accounting'),
   "base" => "button",
   "category" => 'accounting',
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_button.png", 
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content",
         "description" => __("Enter button text.", 'accounting')
      ), 
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Link", 'accounting'),
         "param_name" => "link",
         "value" => "#", 
         "description" => __("Enter button link.", 'accounting')
      ), 
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Target", 'accounting'),
         "param_name" => "target",
         "value" => "_self", 
         "description" => __("Enter button target.", 'accounting')
      ), 
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Size", 'accounting'),
         "param_name" => "size",
         "value" => array(__("Small", 'accounting')=>'small', __("Medium", 'accounting')=>'medium', __("Large", 'accounting')=>'large'), 
         "description" => __("Enter button size.", 'accounting'),
         "save_always" => true 
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Style", 'accounting'),
         "param_name" => "style_button",
         "value" => array(__("Style1", 'accounting')=>'style-1', __("Style2", 'accounting')=>'style-2', __("Style3", 'accounting')=>'style-3', __("Style4", 'accounting')=>'style-4'), 
         "description" => __("Enter button style.", 'accounting'),
         "save_always" => true 
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Color", 'accounting'),
         "param_name" => "color",
         "description" => __("Enter button text color.", 'accounting')
      ),
      array(
         "type" => "colorpicker",
         "holder" => "div",
         "heading" => __("Background", 'accounting'),
         "param_name" => "background",
         "description" => __("Enter button background color.", 'accounting')
      ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Icon library', 'js_composer' ),
            'value' => array(
                __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                __( 'Typicons', 'js_composer' ) => 'typicons',
                __( 'Entypo', 'js_composer' ) => 'entypo',
                __( 'Linecons', 'js_composer' ) => 'linecons',
                __( 'Mono Social', 'js_composer' ) => 'monosocial',
            ),
            'admin_label' => true,
            'param_name' => 'icon_type',
            'description' => __( 'Select icon library.', 'js_composer' ),
            'save_always' => true
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_fontawesome',
            'settings' => array(
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'fontawesome',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_openiconic',
            'settings' => array(
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'openiconic',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_typicons',
            'settings' => array(
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'typicons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_entypo',
            'settings' => array(
                'type' => 'entypo',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_linecons',
            'settings' => array(
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'linecons',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => __( 'Icon', 'js_composer' ),
            'param_name' => 'icon_monosocial',
            'settings' => array(
                'type' => 'monosocial',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'monosocial',
            ),
            'description' => __( 'Select icon from library.', 'js_composer' ),
        )
     )
) );
/* END VC button */
/* VC Pricing table */
vc_map( array(
    "name" => __("Pricing table", 'accounting'),
    "base" => "pricing_table",
    "content_element" => true,
    "category" => 'accounting',
    "as_parent" => array('only' => 'pricing_table_item'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_pricingtable.png",
    "params" => array(
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", 'accounting'),
         "param_name" => "title",
         "description" => __("Enter pricing table title.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Currency", 'accounting'),
         "param_name" => "currency",
         "value" => "",
         "description" => __("Enter currency symbol.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Price", 'accounting'),
         "param_name" => "price",
         "value" => "0",  
         "description" => __("Enter price.", 'accounting')
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Period", 'accounting'),
         "param_name" => "period",
         "description" => __("Enter period (optional).", 'accounting')
       ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Button Text", 'accounting'),
         "param_name" => "button_text",
         "description" => __("Enter pricing table button text.", 'accounting')
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Button Url", 'accounting'),
         "param_name" => "button_url",
         "description" => __("Enter pricing table button url.", 'accounting')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Featured", 'accounting'),
            "param_name" => "featured",
            "save_always" => true,
            "value" =>array(
                __("No", 'accounting')=>'',
                __("yes", 'accounting')=>'true'),
                "description" => __("Featured pricing table.", 'accounting')
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* END VC Pricing table */
/* VC Pricing item */
vc_map( array(
    "name" => __("Pricing item", 'accounting'),
    "base" => "pricing_table_item",
    "content_element" => true,
    "is_container" => true,
    "category" => 'accounting',
    "as_child" => array('only' => 'pricing_table'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_pricingtable.png",
    "params" => array(
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content",
         "description" => __("Enter pricing item text.", 'accounting')
       )
     )
    ));
/* END VC Pricing item */
/* VC list (as parent) */
vc_map( array(
    "name" => __("List", 'accounting'),
    "base" => "anps_list",
    "content_element" => true,
    "category" => 'accounting',
    //"is_container" => true,
    "as_parent" => array('only' => 'list_item'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_list.png",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("List icon", 'accounting'),
            "param_name" => "class",
            "save_always" => true,
            "value" =>array(
                __("Default", 'accounting')=>'',
                __("Circle arrow", 'accounting')=>'circle-arrow',
                __("Triangle", 'accounting')=>'triangle',
                __("Hand", 'accounting')=>'hand',
                __("Square", 'accounting')=>'square',
                __("Arrow", 'accounting')=>'anps_arrow',
                __("Circle", 'accounting')=>'circle',
                __("Circle check", 'accounting')=>'circle-check',
            	__("Number", 'accounting')=>'number'),
                "description" => __("Select type.", 'accounting')
        )
    )
) );
/* END VC list */
/* VC list item (as child) */
vc_map( array(
    "name" => __("List item", 'accounting'),
    "base" => "list_item",
    "content_element" => true,
    "category" => 'accounting',
    //"is_container" => true,
    "as_child" => array('only' => 'anps_list'),
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_list.png",
    "params" => array(
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Text", 'accounting'),
         "param_name" => "content",
         "description" => __("Enter list text.", 'accounting')
       )
     )
    ));
/* END VC list item */
/* VC accordion (as parent) */
vc_map( array(
    "name" => __("Accordion/Toggle", 'accounting'),
    "base" => "accordion",
    "content_element" => true,
    "as_parent" => array('only' => 'accordion_item'),     
    "show_settings_on_create" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_accordion.png",
    "params" => array(
      array(
            "type" => "dropdown",
            "heading" => __("Opened", 'accounting'),
            "param_name" => "opened",
            "value" =>array(__("No", 'accounting')=>'false', __("Yes", 'accounting')=>'true'),
            "description" => __("Opened Accordion/Toggle item.", 'accounting'),
            "save_always" => true
        ),
      array(
            "type" => "dropdown",
            "heading" => __("Style", 'accounting'),
            "param_name" => "style",
            "value" =>array(__("Style 1", 'accounting')=>'', __("Style 2", 'accounting')=>'style-2'),
            "description" => __("Select style.", 'accounting'),
            "save_always" => true
        )
    ),
    "js_view" => 'VcColumnView'
) );
/* END VC accordion */
/* VC accordion item (as child) */
vc_map( array(
    "name" => __("Accordion/Toggle item", 'accounting'),
    "base" => "accordion_item",
    "content_element" => true,
    //"is_container" => true,
    "category" => 'accounting',
    "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_accordion.png",
    "as_child" => array('only' => 'accordion'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", 'accounting'),
            "param_name" => "title",
            "description" => __("Accordion item title.", 'accounting')
        ),
        array(
         "type" => "textarea_html",
         "holder" => "div",
         "heading" => __("Content", 'accounting'),
         "param_name" => "content",
         "description" => __("Enter accordion/toggle content.", 'accounting')
       )
    )
) );
/* END VC accordion item */
/* VC Error 404 */
vc_map( array(
   "name" => __("Error 404", 'accounting'),
   "base" => "error_404",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_error404.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", 'accounting'),
         "param_name" => "title"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Subtitle", 'accounting'),
         "param_name" => "sub_title"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Button text (go back)", 'accounting'),
         "param_name" => "content"
      )
    )
));
/* VC END Error 404 */
/* VC Tables */
vc_map( array(
   "name" => __("Table", 'accounting'),
   "base" => "table",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_table.png", 
   "category" => 'accounting',
   "params" => array(
        array(
         "type" => "table",
         "holder" => "div",
         "heading" => __("Content", 'accounting'),
         "description" => "Table content",
         "param_name" => "content",
        ),
     )
));
/* END VC Tables */
/* VC Coming soon */
vc_map( array(
   "name" => __("Coming soon", 'accounting'),
   "base" => "coming_soon",
   "icon" => get_template_directory_uri()."/images/visual-composer/anpsicon_commingsoon.png", 
   "category" => 'accounting',
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Title", 'accounting'),
         "param_name" => "title"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Subtitle", 'accounting'),
         "param_name" => "subtitle"
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Date", 'accounting'),
         "param_name" => "date"
      ),
      array(
        "type" => "attach_image",
        "heading" => __("Image", 'accounting'),
        "param_name" => "image_u"
      ),  
      array(
        "type" => "textfield",
        "heading" => __("Image url", 'accounting'),
        "param_name" => "image",
        "description" => __("Enter image url.", 'accounting')
        ),
      array(
        "type" => "textarea",
        "heading" => __("Newslleter shortcode", 'accounting'),
        "param_name" => "content",
        "description" => __("Enter newsletter shortcode [newsletter /].", 'accounting')
        ) 
    )
));
/* VC END Coming soon */
/* Add parameter vc_row */
vc_add_param('vc_row', array("type" => "textfield", 'heading'=>__("Id", 'accounting'), 'param_name' =>'id')); 
if(get_option("anps_vc_legacy", "0"=="on")) {
    vc_add_param('vc_row', array("type" => "dropdown", 'heading'=>__("Content wrapper", 'accounting'), 'param_name' =>'has_content', "value" =>array(__("On", 'accounting')=>'true', __("Off", 'accounting')=>'false', __("Inside content wrapper", 'accounting')=>'inside'))); 
    /* Add parameter vc_row_inner */
    vc_add_param('vc_row_inner', array("type" => "dropdown", 'heading'=>__("Content wrapper", 'accounting'), 'param_name' =>'has_content', "value" =>array(__("On", 'accounting')=>'true', __("Off", 'accounting')=>'false'), __("Inside content wrapper", 'accounting')=>'inside')); 
}
/* Add parameter vc_tabs */
vc_add_param('vc_tta_tabs', array("type" => "dropdown", 'heading'=>__("Type", 'accounting'), 'param_name' =>'type', "value" =>array(__("Horizontal", 'accounting')=>'', __("Vertical", 'accounting')=>'vertical')));
vc_add_param('vc_tabs', array("type" => "dropdown", 'heading'=>__("Type", 'accounting'), 'param_name' =>'type', "value" =>array(__("Horizontal", 'accounting')=>'', __("Vertical", 'accounting')=>'vertical')));
/* Add anps style to backend vc_tta_tabs dropdown */
vc_add_param('vc_tta_tabs', array(
    "type" => "dropdown",
    "heading" => __( 'Style', 'js_composer' ),
    'param_name' =>'style', 
    'value' => array(
                __( 'Anpsthemes', 'js_composer' ) => 'anps_tabs',
				__( 'Anpsthemes Style 2', 'js_composer' ) => 'anps-ts-2',
                __( 'Classic', 'js_composer' ) => 'classic',
                __( 'Modern', 'js_composer' ) => 'modern',
                __( 'Flat', 'js_composer' ) => 'flat',
                __( 'Outline', 'js_composer' ) => 'outline',
        ),
    'description' => __( 'Select tabs display style.', 'js_composer' )
    )
);
/* Add anps style to backend vc_tta_accordion dropdown */
vc_add_param('vc_tta_accordion', array(
    "type" => "dropdown",
    "heading" => __( 'Style', 'js_composer' ),
    'param_name' =>'style', 
    'value' => array(
                __( 'Anpsthemes', 'js_composer' ) => 'anps_accordion',
                __( 'Anpsthemes Style 2', 'js_composer' ) => 'anps-as-2',
                __( 'Classic', 'js_composer' ) => 'classic',
                __( 'Modern', 'js_composer' ) => 'modern',
                __( 'Flat', 'js_composer' ) => 'flat',
                __( 'Outline', 'js_composer' ) => 'outline',
        ),
    'description' => __( 'Select accordion display style.', 'js_composer' )
    )
);
/* Add height to backend vc_round_chart dropdown */
vc_add_param('vc_round_chart', array(
    "name" => esc_html__("Height", 'psychiatrist'),
    "type" => "textfield",
    "heading" => esc_html__( 'Height', 'js_composer' ),
    'param_name' =>'anps_height',
    'description' => __( 'Set the graph height in px.', 'js_composer' )
    )
);

/* Add height to backend vc_line_chart dropdown */
vc_add_param('vc_line_chart', array(
    "name" => esc_html__("Height", 'psychiatrist'),
    "type" => "textfield",
    "heading" => esc_html__( 'Height', 'js_composer' ),
    'param_name' =>'anps_height',
    'description' => __( 'Set the graph height in px.', 'js_composer' )
    )
);

