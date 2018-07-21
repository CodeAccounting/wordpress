<?php
function provide_custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
	if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
		$class_string = str_replace( 'vc_row-fluid', 'my_row-fluid', $class_string ); // This will replace "vc_row-fluid" with "my_row-fluid"
	}
	if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
		$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-md-$1', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
	}

	return $class_string;
}

add_filter( 'vc_shortcodes_css_class', 'provide_custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function vc_theme_vc_row( $atts, $content = null ) {
	$el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = '';
	extract( shortcode_atts( array(
		'base'            => '',
		'css'             => '',
		'el_class'        => '',
		'el_id'           => '',
		'bg_image'        => '',
		'bg_color'        => '',
		'bg_image_repeat' => '',
		'border_color'    => '',
		'font_color'      => '',
		'padding'         => '',
		'margin_bottom'   => '',
		// start my param
		'show_title'      => '',
		'col_title'       => '',
		'col_sub_title'   => '',
		'col_title_desc'  => '',
		'title_style'     => '',
		// star parallax
		'show_parallax'   => '',
		'parallax_layer'  => '',
		'parallax_bg'     => '',
		// start miscellaneous
		'miscellaneous'   => '',
		'less_space'      => '',
		'remove_gap'      => '',
		'remove_bottom'   => '',
		'no_padding'      => '',
		'row_background'  => '',
		'container'       => '',
	), $atts ) );
	$atts['base'] = '';
	wp_enqueue_style( 'js_composer_front' );
	wp_enqueue_script( 'wpb_composer_front_js' );
	wp_enqueue_style( 'js_composer_custom_css' );
	$vc_row    = new WPBakeryShortCode_VC_Row( $atts );
	$rowID     = isset( $atts['el_id'] ) ? $atts['el_id'] : '';
	$el_class  = $vc_row->getExtraClass( $el_class );
	$output    = '';
	$css_class = $el_class;
	$css_class = ( $css ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['base'], $atts ) . ' ' . $css_class : $css_class;
	$style     = customBuildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );
	$my_class  = '';
	if ( $miscellaneous == 'on' && $less_space == 'on' ) {
		$my_class .= 'less-space' . ' ';
	}
	if ( $miscellaneous == 'on' && $remove_gap == 'on' ) {
		$my_class .= 'remove-gap' . ' ';
	}
	if ( $miscellaneous == 'on' && $remove_bottom == 'on' ) {
		$my_class .= 'remove-bottom' . ' ';
	}
	if ( $miscellaneous == 'on' && $no_padding == 'on' ) {
		$my_class .= 'no-padding' . ' ';
	}
	if ( $miscellaneous == 'on' && $row_background != '' ) {
		$my_class .= $row_background . ' ';
	}
	if ( $show_parallax == 'on' && ! empty( $parallax_layer ) ) {
		$my_class .= $parallax_layer;
	}
	$my_parallax = '';
	if ( $show_parallax == 'on' && ! empty( $parallax_bg ) ) {
		if ( $parallax_bg ):
			$img = wp_get_attachment_url( $parallax_bg, 'full' );
		else:
			$img = '';
		endif;
		$my_parallax .= ( $img ) ? '<div class="fixed-bg" style="background:url(' . $img . ')"></div>' : '';
	}
	$titlesStyle = '';
	if ( $show_title == 'on' ):
		$titlesStyle .= ( new provide_Helper )->provide_vcTitle( $title_style, $col_title, $col_sub_title, $col_title_desc );
	endif;
	$output = '<section id="' . $rowID . '"><div class="block ' . $my_class . ' ' . $css_class . '"' . $style . '>';
	$output .= $my_parallax;
	$output .= ( $container == 'on' ) ? '<div class="container">' : '';
	$output .= '<div class="row">';
	if ( $titlesStyle != '' ) {
		$output .= '<div class="col-md-12 pro-col">' . $titlesStyle . '</div>';
	}
	$output .= wpb_js_remove_wpautop( $content );
	$output .= '</div>';
	$output .= ( $container == 'on' ) ? '</div>' : '';
	$output .= '</div></section>';

	return $output;
}

function vc_theme_vc_row_inner( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'el_class'  => '',
		'container' => '',
		'row'       => '',
	), $atts ) );
	$atts['base'] = '';
	wp_enqueue_style( 'js_composer_front' );
	wp_enqueue_script( 'wpb_composer_front_js' );
	wp_enqueue_style( 'js_composer_custom_css' );
	$output       = '';
	$css_class    = $el_class;
	$custom_style = '';
	if ( $container ) {
		return
			'<section class="block ' . $css_class . '" ' . $custom_style . ' >
				<div class="container">
					' . wpb_js_remove_wpautop( $content ) . '
				</div>
			</section>' . "\n";
	}

	return '<section class=" block' . $css_class . ' ' . $custom_style . '" >
				' . wpb_js_remove_wpautop( $content ) . '
			</section>' . "\n";
}

function vc_theme_vc_column_inner( $atts, $content = null ) {
	extract( shortcode_atts( array( 'width' => '1/1', 'el_class' => '' ), $atts ) );
	$width    = wpb_translateColumnWidthToSpan( $width );
	$width    = str_replace( 'vc_span', 'col-md-', $width );
	$el_class = ( $el_class ) ? ' ' . $el_class : '';

	return '<div class="wpb_column ' . $width . $el_class . '">
				' . do_shortcode( $content ) . '
			</div>' . "\n";
}

function vc_theme_vc_column( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width'          => '1/1',
		'el_class'       => '',
		'show_title'     => '',
		'col_title'      => '',
		'col_sub_title'  => '',
		'col_title_desc' => '',
		'title_style'    => ''
	), $atts ) );
	$titlesStyle = '';
	if ( $show_title == 'on' ):
		$titlesStyle .= ( new provide_Helper )->provide_vcTitle( $title_style, $col_title, $col_sub_title, $col_title_desc );
	endif;
	$width    = wpb_translateColumnWidthToSpan( $width );
	$width    = str_replace( 'vc_col-sm-', 'col-md-', $width . ' column' );
	$el_class = ( $el_class ) ? ' ' . $el_class : '';
	$output   = '<div class="pro-col ' . $width . ' ' . $el_class . '">';
	$output   .= $titlesStyle;
	$output   .= do_shortcode( $content );
	$output   .= '</div>';

	return $output;
}

// start vc row and column customized
$container     = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Container", 'provide' ),
	"param_name"  => "container",
	'value'       => 'off',
	'default_set' => false,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Enable container for this section", 'provide' ),
);
$miscellaneous = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Miscellaneous Settings", 'provide' ),
	"param_name"  => "miscellaneous",
	'value'       => 'off',
	'default_set' => false,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Show miscellaneous settings for this section.", 'provide' ),
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
);
$lessSpace     = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Less Space", 'provide' ),
	"param_name"  => "less_space",
	'value'       => 'off',
	'default_set' => true,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Add top bottom space from normal section", 'provide' ),
	'dependency'  => array(
		'element' => 'miscellaneous',
		'value'   => array( 'on' )
	),
);
$removeGap     = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Remove Top Padding", 'provide' ),
	"param_name"  => "remove_gap",
	'value'       => 'off',
	'default_set' => true,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Remove inner padding from top", 'provide' ),
	'dependency'  => array(
		'element' => 'miscellaneous',
		'value'   => array( 'on' )
	),
);
$removeBottom  = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Remove Bottom Padding", 'provide' ),
	"param_name"  => "remove_bottom",
	'value'       => 'off',
	'default_set' => true,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Remove inner padding from bottom", 'provide' ),
	'dependency'  => array(
		'element' => 'miscellaneous',
		'value'   => array( 'on' )
	),
);
$noPadding     = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "No Padding", 'provide' ),
	"param_name"  => "no_padding",
	'value'       => 'off',
	'default_set' => true,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Remove top & bottom padding ", 'provide' ),
	'dependency'  => array(
		'element' => 'miscellaneous',
		'value'   => array( 'on' )
	),
);
$rowBackground = array(
	"type"        => "dropdown",
	'group'       => esc_html__( 'Miscellaneous', 'provide' ),
	"heading"     => esc_html__( "Row Background", 'provide' ),
	"param_name"  => "row_background",
	"value"       => array(
		esc_html__( 'No Background', 'provide' ) => '',
		esc_html__( 'Dark', 'provide' )          => 'dark',
		esc_html__( 'Coloured', 'provide' )      => 'coloured',
		esc_html__( 'Gray', 'provide' )          => 'gray'
	),
	"description" => esc_html__( "Choose background for this section.", 'provide' ),
	'dependency'  => array(
		'element' => 'miscellaneous',
		'value'   => array( 'on' )
	),
);
// end vc row and column customized
// start parallax section
$show_parallax  = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Parallax', 'provide' ),
	"heading"     => esc_html__( "Show Parallax", 'provide' ),
	"param_name"  => "show_parallax",
	'value'       => 'off',
	'default_set' => false,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Make this section parallax then true.", 'provide' )
);
$parallax_layer = array(
	"type"        => "dropdown",
	'group'       => esc_html__( 'Parallax', 'provide' ),
	"heading"     => esc_html__( "Parallax Layer", 'provide' ),
	"param_name"  => "parallax_layer",
	"value"       => array(
		esc_html__( 'No Layer', 'provide' ) => 'no-layer',
		esc_html__( 'Blackish', 'provide' ) => 'blackish',
		esc_html__( 'Whitish', 'provide' )  => 'whitish',
	),
	"description" => esc_html__( "Choose Style for Parallax.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_parallax',
		'value'   => array( 'on' )
	),
);
$parallax_img   = array(
	"type"        => "attach_image",
	'group'       => esc_html__( 'Parallax', 'provide' ),
	"heading"     => esc_html__( "Parallax Background", 'provide' ),
	"param_name"  => "parallax_bg",
	"description" => esc_html__( "Make this section as parallax.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_parallax',
		'value'   => array( 'on' )
	),
);
//start title settings
$show_heading = array(
	"type"        => "un_toggle",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Show Title", 'provide' ),
	"param_name"  => "show_title",
	'value'       => 'off',
	'default_set' => false,
	'options'     => array(
		'on' => array(
			'on'  => esc_html__( 'Yes', 'provide' ),
			'off' => esc_html__( 'No', 'provide' ),
		),
	),
	"description" => esc_html__( "Make this section with title.", 'provide' )
);
$title_style  = array(
	"type"        => "dropdown",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Title Style", 'provide' ),
	"param_name"  => "title_style",
	"value"       => array(
		esc_html__( 'No Style', 'provide' )               => '',
		esc_html__( 'Detailed Title Style', 'provide' )   => '1',
		esc_html__( 'Fancy Title Style', 'provide' )      => '2',
		esc_html__( 'Fancy Title Style 2', 'provide' )    => '3',
		esc_html__( 'Side Title', 'provide' )             => '4',
		esc_html__( 'Side Title Large Style', 'provide' ) => '5',
		esc_html__( 'Side Title Fancy Style', 'provide' ) => '6',
		esc_html__( 'Parallax Title Style 1', 'provide' ) => '7',
		esc_html__( 'Parallax Title Style 2', 'provide' ) => '8',
	),
	"description" => esc_html__( "Select the title style for this section", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
$title        = array(
	"type"        => "textfield",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Enter the Title", 'provide' ),
	"param_name"  => "col_title",
	"description" => esc_html__( "Enter the title of this section.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
$sub_title    = array(
	"type"        => "textfield",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Enter the Sub Title", 'provide' ),
	"param_name"  => "col_sub_title",
	"description" => esc_html__( "Enter the sub title of this section.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
$titleDesc    = array(
	"type"        => "textarea",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Short Description", 'provide' ),
	"param_name"  => "col_title_desc",
	"description" => esc_html__( "Enter the short description.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
$titleColor   = array(
	"type"        => "textarea",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Short Description", 'provide' ),
	"param_name"  => "col_title_desc",
	"description" => esc_html__( "Enter the short description.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
$DescColor    = array(
	"type"        => "textarea",
	'group'       => esc_html__( 'Title Setting', 'provide' ),
	"heading"     => esc_html__( "Short Description", 'provide' ),
	"param_name"  => "col_title_desc",
	"description" => esc_html__( "Enter the short description.", 'provide' ),
	'dependency'  => array(
		'element' => 'show_title',
		'value'   => array( 'on' )
	),
);
// end title settings
if ( function_exists( 'vc_map' ) ) {
	//vc column settings
	vc_add_param( 'vc_column', $show_heading );
	vc_add_param( 'vc_column', $title_style );
	vc_add_param( 'vc_column', $title );
	vc_add_param( 'vc_column', $sub_title );
	vc_add_param( 'vc_column', $titleDesc );
	//vc row settings
	vc_add_param( 'vc_row', $show_heading );
	vc_add_param( 'vc_row', $title_style );
	vc_add_param( 'vc_row', $title );
	vc_add_param( 'vc_row', $sub_title );
	vc_add_param( 'vc_row', $titleDesc );
	vc_add_param( 'vc_row', $container );
	vc_add_param( 'vc_row', $miscellaneous );
	vc_add_param( 'vc_row', $lessSpace );
	vc_add_param( 'vc_row', $removeGap );
	vc_add_param( 'vc_row', $removeBottom );
	vc_add_param( 'vc_row', $noPadding );
	vc_add_param( 'vc_row', $rowBackground );
	vc_add_param( 'vc_row', $show_parallax );
	vc_add_param( 'vc_row', $parallax_layer );
	vc_add_param( 'vc_row', $parallax_img );
	$remove_param = array( 'parallax', 'video_bg', 'parallax_image', 'parallax_speed_video', 'video_bg_url', 'video_bg_parallax', 'parallax_speed_bg' );
	foreach ( $remove_param as $rparam ) {
		vc_remove_param( "vc_row", $rparam );
	}
	function customBuildStyle( $bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding = '', $margin_bottom = '' ) {
		$has_image = false;
		$style     = '';
		if ( (int) $bg_image > 0 && ( $image_url = wp_get_attachment_url( $bg_image, 'large' ) ) !== false ) {
			$has_image = true;
			$style     .= "background-image: url(" . $image_url . ");";
		}
		if ( ! empty( $bg_color ) ) {
			$style .= 'background-color: ' . $bg_color . ';';
		}
		if ( ! empty( $bg_image_repeat ) && $has_image ) {
			if ( $bg_image_repeat === 'cover' ) {
				$style .= "background-repeat:no-repeat;background-size: cover;";
			} elseif ( $bg_image_repeat === 'contain' ) {
				$style .= "background-repeat:no-repeat;background-size: contain;";
			} elseif ( $bg_image_repeat === 'no-repeat' ) {
				$style .= 'background-repeat: no-repeat;';
			}
		}
		if ( ! empty( $font_color ) ) {
			$style .= 'color: ' . $font_color . ';';
		}
		if ( $padding != '' ) {
			$style .= 'padding: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding ) ? $padding : $padding . 'px' ) . ';';
		}
		if ( $margin_bottom != '' ) {
			$style .= 'margin-bottom: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $margin_bottom ) ? $margin_bottom : $margin_bottom . 'px' ) . ';';
		}

		return empty( $style ) ? $style : ' style="' . $style . '"';
	}
}
	