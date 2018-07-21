<?php

class provide_SmtpSettings {
	public $icon;
	public $id;
	public $title;
	public $desc;

	public function __construct() {
		$this->icon  = '';
		$this->id    = 'smtp';
		$this->title = esc_html__( 'SMTP', 'provide' );
		$this->desc  = esc_html__( 'Theme SMTP Settings', 'provide' );
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
				'id'      => 'optSMTP',
				'type'    => 'switch',
				'title'   => esc_html__( 'SMTP', 'provide' ),
				'desc'    => esc_html__( 'Enable or disable SMTP settings', 'provide' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'provide' ),
				'off'     => esc_html__( 'Disable', 'provide' )
			),
			// start smtp section
			array(
				'id'       => 'optSMTPSectionStart',
				'type'     => 'section',
				'title'    => esc_html__( 'SMTP Section', 'provide' ),
				'indent'   => true,
				'required' => array( 'optSMTP', '=', true ),
			),
			array(
				'id'      => 'optSMTPHost',
				'type'    => 'text',
				'title'   => esc_html__( 'SMTP Host Name', 'provide' ),
				'default' => 'smtp.gmail.com'
			),
			array(
				'id'      => 'optSMTPPort',
				'type'    => 'text',
				'title'   => esc_html__( 'SMTP Port', 'provide' ),
				'default' => '587'
			),
			array(
				'id'      => 'optSMTPSSL',
				'type'    => 'select',
				'title'   => esc_html__( 'SMTP SSL', 'provide' ),
				'options' => array(
					'none' => esc_html__( 'None', 'provide' ),
					'ssl'  => esc_html__( 'SSL', 'provide' ),
					'tls'  => esc_html__( 'TLS', 'provide' ),
				),
				'default' => 'none',
			),
			array(
				'id'      => 'optSMTPAuth',
				'type'    => 'switch',
				'title'   => esc_html__( 'SMTP Authentication', 'provide' ),
				'desc'    => esc_html__( 'Enable SMTP authentication', 'provide' ),
				'default' => false,
				'on'      => esc_html__( 'Yes', 'provide' ),
				'off'     => esc_html__( 'No', 'provide' )
			),
			array(
				'id'    => 'optSMTPUsername',
				'type'  => 'text',
				'title' => esc_html__( 'SMTP User Name', 'provide' )
			),
			array(
				'id'    => 'optSMTPPass',
				'type'  => 'text',
				'title' => esc_html__( 'SMTP Password', 'provide' )
			),
			array(
				'id'     => 'optSMTPSectionEnd',
				'type'   => 'section',
				'indent' => false
			)
			//end smtp section
		);
	}

}
