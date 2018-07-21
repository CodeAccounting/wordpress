<?php
/* Shortcodes */
/* Testimonials */
global $testimonial_counter, $testimonials_style;
$testimonial_counter = 0;
class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {
    static  function anps_testimonials_func( $atts,  $content ) {
        global $text_color, $secondary_color, $bg_color, $bg_opacity, $min_height_lg;

        extract( shortcode_atts( array(
            'style' => 'style-1',
            'text_color' => '',
            'secondary_color' => '',
            'bg_color' => '',
            'bg_opacity' => '',
            'min_height_lg' => ''
        ), $atts ) );

        if ($style=="") {$style = 'style-1';}
        $testimonials_number = substr_count($content, "[testimonial");
        $class = "testimonials testimonials-"  . $style;
        $data_return = "";
        $style_class = "";
        $randomid = substr( md5(rand()), 0, 7);

        if( $style == 'style-4' || $style == 'style-5' ) {
            global $testimonials_style;
            $testimonials_style = $style;

            $lg_style = 'style-1';

            if($style == 'style-5') {
                $lg_style = 'style-2';
            }

            $data_return .= '<div id="' . $randomid . '" class="testimonials-lg testimonials-lg--' . $lg_style . '">';
            $data_return .= do_shortcode($content);
            $data_return .= "</div>";
        } else if( $style == 'style-3' ) {
            global $testimonials_style;
            $testimonials_style = 'style-3';
            $data_return .= '<div class="relative-wrapper">';
            $data_return .= "<div id='".$randomid."' class='owl-carousel " . $class . "' data-col='2'>";
            $data_return .= do_shortcode($content);
            $data_return .= "</div>";

            if($testimonials_number > 2) {
                $data_return .= '<div class="owl-navigation">';
                $data_return .= '<a class="owlprev"><i class="fa fa-chevron-left"></i> <span class="sr-only">'.__('Previous', 'accounting').'<span></a>';
                $data_return .= '<a class="owlnext"><i class="fa fa-chevron-right"></i> <span class="sr-only">'.__('Next', 'accounting').'<span></a>';
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

        if( $testimonials_style == 'style-4' || $testimonials_style == 'style-5' ) {
            global $text_color, $secondary_color, $bg_color, $bg_opacity, $min_height_lg;

            $text_style = '';
            $secondary_style = '';
            $bg_style = '';
            $secondary_style_bg = '';
            $container_style = '';

            /* Min height */

            if($min_height_lg != '') {
                $container_style = ' style="min-height: ' . $min_height_lg . 'px"';
            }

            /* Text color */

            if($text_color != '') {
                $text_style = ' style="color: ' . $text_color . ';"';
            }

            /* Secondary color */

            if($secondary_color != '') {
                $secondary_style = ' style="color: ' . $secondary_color . ';"';
                $secondary_style_bg = ' style="background-color: ' . $secondary_color . ';"';
            }

            /* Testimonials color */

            if($bg_color != '') {
                $bg_style .= 'background-color: ' . $bg_color . ';';
            }

            if($bg_opacity != '') {
                $bg_style .= 'opacity: ' . ($bg_opacity/100) . ';';
            }

            if($bg_style != '') {
                $bg_style = ' style="' . $bg_style . '"';
            }

            $data = '<div class="testimonial-lg">';
                $data .= '<div class="testimonial-lg__image-wrap">';
                    $data .= '<div class="testimonial-lg__image" style="background-image: url('.$image.')"></div>';
                $data .= '</div>';

                $data .= '<div class="container"'.$container_style.'>';
                    $data .= '<div class="testimonial-lg__content"'.$text_style.'>';
                        $data .= '<div class="testimonial-lg__bg"' . $bg_style . '></div>';

                        $data .= "<p class='testimonial-lg__desc'>";
                            if($testimonials_style == 'style-4') {
                                $data .= '<i class="fa fa-quote-left testimonial-lg__quote"' . $secondary_style . '></i>';
                            }
                            $data .= $content;
                        $data .= "</p>";
                        if($testimonials_style == 'style-5') {
                            $data .= '<div class="testimonial-lg__divider"' . $secondary_style_bg . '></div>';
                        }
                        $data .= "<div class='testimonial-lg__user'>$user_name</div>";
                        if($position) {
                            $data .= '<div class="testimonial-lg__position"'.$secondary_style.'>'.$position.'</div>';
                        }
                        $data .= '<div class="testimonial-lg__nav">';
                            $data .= '<button class="testimonial-lg__nav-btn testimonial-lg__nav-btn--prev"><i class="fa fa-angle-left"></i></button>';
                            $data .= '<button class="testimonial-lg__nav-btn testimonial-lg__nav-btn--next"><i class="fa fa-angle-right"></i></button>';
                        $data .= '</div>';
                    $data .= '</div>';
                $data .= '</div>';
            $data .= '</div>';
            return $data;
        } else if( $testimonials_style == 'style-3' ) {
            $data .= '<div class="row">';
            if($image) {
                $data .= '<div class="col-md-6">';
                if($user_url != '') {
                    $data .= "<a class='testimonials-image-link' href='".$user_url."' target='_blank'>";
                }
                $data .= "<img class='testimonial-image' src='".$image."' alt='".$user_name."' >";
                if($user_url != '') {
                    $data .= '</a>';
                }
                $data .= '</div>';
                $data .= '<div class="col-md-6">';
            } else  {
                $data .= '<div class="col-md-12">';
            }
            if($user_url != '') {
                $data .= "<a href='".$user_url."' target='_blank'>";
            }
            $data .= "<h4 class='testimonial-user'>";
            $data .= $user_name;
            $data .= '</h4>';
            if($user_url != '') {
                $data .= '</a>';
            }
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
/* About us */
class WPBakeryShortCode_about_us extends WPBakeryShortCodesContainer {
    static function anps_about_us_func($atts, $content) {
        return anps_about_us_func($atts, $content);
    }
}
/* END About us */
/* About us item */
class WPBakeryShortCode_about_us_item extends WPBakeryShortCode {
    static function anps_about_us_item_func($atts, $content) {
        return anps_about_us_item_func($atts, $content);
    }
}
/* About us shortcode */
function anps_au_image($image, $image_position, $position) {
    if($image != '' &&  $image_position == $position) {
        return '<div class="col-md-6">' . wp_get_attachment_image($image, 'full', '', array('class' => 'about-us__image')) . '</div>';
    }

    return '';
}

if(!function_exists('anps_about_us_func')) {
    function anps_about_us_func($atts, $content) {
        extract( shortcode_atts( array(
            'title' => '',
            'subtitle' => '',
            'desc' => '',
            'text' => '',
            'image' => '',
            'image_position' => 'right'
        ), $atts ) );

        $timeline_class = '';

        $col = '12';

        if($image != '') {
            $col = '6';
        } else {
            $timeline_class = ' timeline-h--large';
        }

        ob_start();
        ?>
        <div class="about-us">
            <?php if($subtitle != ''): ?>
            <div class="about-us__title">
                <?php echo esc_html($title); ?>
            </div>
            <?php endif; ?>

            <?php if($subtitle != ''): ?>
            <div class="about-us__subtitle">
                <?php echo esc_html($subtitle); ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <?php echo anps_au_image($image, $image_position, 'left'); ?>

                <div class="col-md-<?php echo esc_attr($col); ?>">
                    <div class="about-us__desc">
                        <?php echo esc_html($desc); ?>
                    </div>
                    <div class="about-us__text">
                        <?php echo esc_html($text); ?>
                    </div>
                    <div class="timeline-h<?php echo $timeline_class; ?>">
                        <?php echo do_shortcode($content); ?>
                    </div>
                </div>

                <?php echo anps_au_image($image, $image_position, 'right'); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('about_us', array('WPBakeryShortCode_about_us','anps_about_us_func'));
/* About us item shortcode */
if(!function_exists('anps_about_us_item_func')) {
    function anps_about_us_item_func($atts, $content) {
        extract( shortcode_atts( array(
            'year' => '',
            'title' => '',
        ), $atts ) );

        $data = '';
        ob_start();
        ?>
        <div class="timeline-h__item">
            <div class="timeline-h__indicator">
                <div class="timeline-h__indicator-inner"></div>
            </div>
            <div class="timeline-h__year"><?php echo $year; ?></div>
            <div class="timeline-h__title"><?php echo $title; ?></div>
        </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode('about_us_item', array('WPBakeryShortCode_about_us_item','anps_about_us_item_func'));
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
        $info = str_replace('"', '\"', $info);

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
