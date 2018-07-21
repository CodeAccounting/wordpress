<?php

class provide_generalSettings {
	public $icon;
	public $id;
	public $title;
	public $desc;

	public function __construct() {
		$this->icon  = 'el-home';
		$this->id    = 'general';
		$this->title = esc_html__( 'General', 'provide' );
		$this->desc  = esc_html__( 'provide Theme General Settings', 'provide' );
	}

	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->$property;
		}
	}

	public function __set( $property, $value ) {
		if ( property_exists( $this, $property ) ) {
			$this->$property = $value;
		}
	}

	public function provide_init() {
		return array(
			array(
				'id'          => 'optThemeColor',
				'type'        => 'color',
				'title'       => esc_html__( 'Primary Theme Color', 'provide' ),
				'default'     => '#ca0002',
				'transparent' => false
			),
			array(
				'id'          => 'optThemeColor2',
				'type'        => 'color',
				'title'       => esc_html__( 'Secondary Theme Color', 'provide' ),
				'default'     => '#eeb013',
				'transparent' => false
			),
			array(
				'id'          => 'themeRtl',
				'type'        => 'switch',
				'title'       => esc_html__( 'Theme RTL', 'provide' ),
				'description' => esc_html__( 'Enable theme RTL', 'provide' ),
			),

			// start boxed layout
			array(
				'id'          => 'themeBoxedLayout',
				'type'        => 'switch',
				'title'       => esc_html__( 'Boxed Layout', 'provide' ),
				'description' => esc_html__( 'Enable boxed layout', 'provide' ),
			),
			array(
				'id'       => 'optBoxedLayoutStart',
				'type'     => 'section',
				'title'    => esc_html__( 'Boxed Layout Settings', 'provide' ),
				'indent'   => true,
				'required' => array( 'themeBoxedLayout', '=', true ),
			),
			array(
				'id'      => 'optBoxedBackgroundType',
				'type'    => 'select',
				'title'   => esc_html__( 'Background Type', 'provide' ),
				'options' => array(
					'1' => esc_html__( 'Image', 'provide' ),
					'2' => esc_html__( 'Pattern', 'provide' )
				),
				'default' => '1'
			),

			// image layout settings
			array(
				'id'       => 'optBoxedBackgroundImage',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__( 'Upload Background Image', 'provide' ),
				'compiler' => 'true',
				'required' => array( 'optBoxedBackgroundType', '=', '1' ),
			),
			array(
				'id'       => 'optBoxedBackgroundRepeat',
				'type'     => 'select',
				'title'    => esc_html__( 'Background Repeat', 'provide' ),
				'desc'     => esc_html__( 'Select to repeat the background or not', 'provide' ),
				'options'  => array(
					'repeat'    => esc_html__( 'Repeat', 'provide' ),
					'no-repeat' => esc_html__( 'No Repeat', 'provide' )
				),
				'default'  => 'repeat',
				'required' => array( 'optBoxedBackgroundType', '=', '1' ),
			),
			array(
				'id'       => 'optBoxedBackgroundAttachment',
				'type'     => 'select',
				'title'    => esc_html__( 'Background Attachment', 'provide' ),
				'desc'     => esc_html__( 'Select background attachment to fixed or scroll the image', 'provide' ),
				'options'  => array(
					'fixed'  => esc_html__( 'Fixed', 'provide' ),
					'scroll' => esc_html__( 'Scroll', 'provide' )
				),
				'default'  => 'repeat',
				'required' => array( 'optBoxedBackgroundType', '=', '1' ),
			),
			// end image layout settings
			// start background pattern
			array(
				'id'       => 'optBoxedBackgroundPattern',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Select Pattern', 'provide' ),
				'subtitle' => esc_html__( 'Choose the patterns for boxed version.', 'provide' ),
				'required' => array( 'optBoxedBackgroundType', '=', '2' ),
				'options'  => array(
					'1'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/none.png'
					),
					'2'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-1.png'
					),
					'3'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-2.png'
					),
					'4'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-3.png'
					),
					'5'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-4.png'
					),
					'6'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-5.png'
					),
					'7'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-6.png'
					),
					'8'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-7.png'
					),
					'9'  => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-8.png'
					),
					'10' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-9.png'
					),
					'11' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-10.png'
					),
					'12' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-11.png'
					),
					'13' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-12.png'
					),
					'14' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-13.png'
					),
					'15' => array(
						'alt' => esc_html__( 'Background Pattern', 'provide' ),
						'img' => provide_Uri . 'partial/images/patterns/pattern-14.png'
					)
				),
				'default'  => '1'
			),
			//end background pattern
			array(
				'id'     => 'optBoxedLayoutEnd',
				'type'   => 'section',
				'indent' => false,
			),
			// end boxed layout

			// templates pagination
			array(
				'id'     => 'optTemplatePaginationStart',
				'type'   => 'section',
				'title'  => esc_html__( 'Templates Pagination', 'provide' ),
				'indent' => true,
			),
			array(
				'id'       => 'optBranchesPagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Branches Template', 'provide' ),
			),
			array(
				'id'       => 'optPortfolioPagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Portfolio Style 1 Template', 'provide' ),
			),
			array(
				'id'       => 'optPortfolio2Pagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Portfolio Style 2 Template', 'provide' ),
			),
			array(
				'id'       => 'optPriceTableoPagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Price Table Template', 'provide' ),
			),
			array(
				'id'       => 'optTeamPagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Team Template', 'provide' ),
			),
			array(
				'id'       => 'optTestimonialPagination',
				'type'     => 'text',
				'validate' => 'numeric',
				'title'    => esc_html__( 'Enter the number of posts to show on Testimonial Template', 'provide' ),
			),
			array(
				'id'     => 'optTemplatePaginationEnd',
				'type'   => 'section',
				'indent' => false,
			),
			// end templates pagination
			// end google map api key
			array(
				'id'       => 'optThemeCssEditor',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'Custom Css Code', 'provide' ),
				'subtitle' => esc_html__( 'Paste your Custom Css code here. Note: please do not use style tag', 'provide' ),
				'mode'     => 'css',
				'theme'    => 'monokai',
			),
			array(
				'id'       => 'optGoogleAnalytics',
				'type'     => 'textarea',
				'default'  => esc_html__( '', 'provide' ),
				'validate' => 'html',
				'title'    => esc_html__( 'Paste The google analytics here', 'provide' ),
			),
			
		);
	}

}
