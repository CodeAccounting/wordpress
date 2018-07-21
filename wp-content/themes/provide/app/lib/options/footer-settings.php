<?php

class provide_footerSettings {
	public $icon;
	public $id;
	public $title;
	public $desc;

	public function __construct() {
		$this->icon  = '';
		$this->id    = 'footer';
		$this->title = esc_html__( 'Footer', 'provide' );
		$this->desc  = esc_html__( 'Theme Footer Settings', 'provide' );
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
				'id'      => 'optFooter',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Footer', 'provide' ),
				'default' => true,
				'on'      => esc_html__( 'Yes', 'provide' ),
				'off'     => esc_html__( 'No', 'provide' )
			),
			array(
				'id'       => 'optFooterSectionStart',
				'type'     => 'section',
				'title'    => esc_html__( 'Footer Options', 'provide' ),
				'indent'   => true,
				'required' => array( 'optFooter', '=', true )
			),
			array(
				'id'         => 'optFooterSocialicons',
				'type'       => 'social_media',
				'heading'    => true,
				'title'      => esc_html__( 'Footer Social Media Builder', 'provide' ),
				'full_width' => true,
			),
                        array(
                                'id' => 'optFooterWidgtColumn',
                                'type' => 'select',
                                'title' => esc_html__('Widget Layout', 'provide'),
                                'options' => array(
                                    'col-md-6' => esc_html__('2 Column', 'provide'),
                                    'col-md-4' => esc_html__('3 Column', 'provide'),
                                    'col-md-3' => esc_html__('4 Column', 'provide'),
                                ),
                                'default' => 'col-md-3',
                        ),
                        array(
				'id'      => 'optShowCopyright',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Copyright', 'provide' ),
				'default' => true,
				'on'      => esc_html__( 'Yes', 'provide' ),
				'off'     => esc_html__( 'No', 'provide' )
			),
                        array(
                            'id'      => 'optCopyrightFixed',
                            'type'    => 'switch',
                            'title'   => esc_html__( 'Copyright Position', 'provide' ),
                            'default' => false,
                            'on'      => esc_html__( 'Fixed', 'provide' ),
                            'off'     => esc_html__( 'Moveable', 'provide' ),
                            'required'    =>  array('optShowCopyright', '=', true),
			),
			array(
				'id'       => 'optFooterCopyright',
				'type'     => 'textarea',
				'default'  => esc_html__( '&copy; 2017 WordPress Theme. Powered By Bitlers', 'provide' ),
				'validate' => 'html',
				'title'    => esc_html__( 'Footer Copyright Text', 'provide' ),
                                'required'    =>  array('optShowCopyright', '=', true),
			),
			array(
				'id'     => 'optFooterSectionEnd',
				'type'   => 'section',
				'indent' => false,
			),
			array(
				'id'       => 'optThemeJsEditor',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'Javascript Code', 'provide' ),
				'subtitle' => esc_html__( 'Paste your javascript code here. Note: please do not use script tag', 'provide' ),
				'mode'     => 'javascript',
				'theme'    => 'monokai',
			),
		);
	}

}
