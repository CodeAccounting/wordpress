<?php

class provide_ComingsoonSettings {

	public $icon;
	public $id;
	public $title;
	public $desc;

	public function __construct() {
		$this->icon  = '';
		$this->id    = 'comingsoon';
		$this->title = esc_html__( 'Coming Soon', 'provide' );
		$this->desc  = esc_html__( 'provide Theme Coming Soon Settings', 'provide' );
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
				'id'      => 'optComingSoon',
				'type'    => 'switch',
				'title'   => esc_html__( 'Coming Soon', 'provide' ),
				'desc'    => esc_html__( 'Enable or Disable Coming soon', 'provide' ),
				'default' => false,
				'on'      => esc_html__( 'Yes', 'provide' ),
				'off'     => esc_html__( 'No', 'provide' )
			),
			array(
				'id'       => 'optComingSoonBG',
				'type'     => 'media',
				'url'      => false,
				'title'    => esc_html__( 'Upload Background Image', 'provide' ),
				'compiler' => 'true',
				'required' => array( 'optComingSoon', '=', true )
			),
			array(
				'id'       => 'optComingSoonTitle',
				'type'     => 'text',
				'title'    => esc_html__( 'Coming Soon Title', 'provide' ),
				'required' => array( 'optComingSoon', '=', true )
			),
			array(
				'id'       => 'optComingSoonDate',
				'type'     => 'extra_datetime',
				'title'    => esc_html__( 'Select date and time for coming soon', 'provide' ),
				'required' => array( 'optComingSoon', '=', true )
			),
			array(
				'id'       => 'optComingSoonTimeZone',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Your Time Zone', 'provide' ),
				'options'  => ( new provide_Helper() )->provide_timeZone(),
				'required' => array( 'optComingSoon', '=', true )
			),
			array(
				'id'       => 'optComingSoonNewsletter',
				'type'     => 'switch',
				'title'    => esc_html__( 'Coming Soon Newsletter', 'provide' ),
				'desc'     => esc_html__( 'Enable or Disable Coming soon Newsletter', 'provide' ),
				'default'  => false,
				'on'       => esc_html__( 'Yes', 'provide' ),
				'off'      => esc_html__( 'No', 'provide' ),
				'required' => array( 'optComingSoon', '=', true )
			),
		);
	}

}
