<?php

class provide_UserMetabox {

	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'provide_RegisterMetabox' ) );
	}

	public function provide_RegisterMetabox() {
		$settings = array(
			'id'           => 'user_meta',
			'title'        => esc_html__( 'Additional Fields', 'provide' ),
			'object_types' => array( 'user' ),
			'names'        => true,
			//'new_user_section' => 'add-new-user',
		);
		$meta     = new_cmb2_box( $settings );
		$fields   = $this->provide_fields();
		foreach ( $fields as $field ) {
			$meta->add_field( $field );
		}
	}

	public function provide_fields() {
		return array(
			array(
				'name'    => esc_html__( 'Profile Picture', 'provide' ),
				'id'      => 'metaProfilePic',
				'type'    => 'file',
				'options' => array(
					'url' => false,
				),
			),
			array(
				'name' => esc_html__( 'Designation', 'provide' ),
				'id'   => 'metaDesignation',
				'type' => 'text_medium',
			),
			array(
				'name' => esc_html__( 'Facebook URL', 'provide' ),
				'id'   => 'metaFB',
				'type' => 'text_url',
			),
			array(
				'name' => esc_html__( 'Google Plus URL', 'provide' ),
				'id'   => 'metaGB',
				'type' => 'text_url',
			),
			array(
				'name' => esc_html__( 'Twitter URL', 'provide' ),
				'id'   => 'metaTW',
				'type' => 'text_url',
			),
			array(
				'name' => esc_html__( 'linkedin URL', 'provide' ),
				'id'   => 'metaLK',
				'type' => 'text_url',
			)
		);
	}

}
