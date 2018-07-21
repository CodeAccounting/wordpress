<?php

class provide_google_map_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_google_map($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Google Map", 'provide'),
                "base" => "provide_google_map_output",
                "icon" => 'provide_google_map_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Latitude", 'provide'),
                        "param_name" => "latitude",
                        "description" => esc_html__("Enter the latitude for google map.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Longitude", 'provide'),
                        "param_name" => "longitude",
                        "description" => esc_html__("Enter the longitude for google map.", 'provide')
                    )
                )
            );
            return apply_filters('provide_google_map_output', $return);
        }
    }

    public static function provide_google_map_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        echo '<div class="map"><div id="map-canvas"></div></div>';
        provide_Media::provide_singleton()->provide_eq(array('map'));
        $jsOutput = "var myLatlng = new google.maps.LatLng(" . esc_js($latitude) . ", " . esc_js($longitude) . ");
                    var mapOptions ={
                    zoom:14,
                    disableDefaultUI:true,
                    scrollwheel:false,
                    center:myLatlng
                    }
                    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                    var image = '';
                    var myLatLng = new google.maps.LatLng(" . esc_js($latitude) . ", " . esc_js($longitude) . ");
                    var beachMarker = new google.maps.Marker({
                      position:myLatLng,
                      map:map,
                      icon:image
                    });";
        wp_add_inline_script('map', $jsOutput);
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
