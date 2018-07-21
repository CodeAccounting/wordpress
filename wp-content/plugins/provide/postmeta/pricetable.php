<?php

class provide_PricetableMetabox {

	public function __construct() {
		add_action( 'cmb2_init', array( $this, 'provide_RegisterMetabox' ) );
	}

	public function provide_RegisterMetabox() {
		$settings = array(
			'id'           => 'priceTable_meta',
			'title'        => esc_html__( 'Price Table', 'provide' ),
			'object_types' => array( 'pr_price_table' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
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
				'name'    => esc_html__( 'Background Image', 'provide' ),
				'id'      => 'metaBG',
				'type'    => 'file',
				'options' => array(
					'url' => false,
				),
				'text'    => array(
					'add_upload_file_text' => esc_html__( 'Add File', 'provide' )
				),
			),
                        array(
                            'name' => esc_html__('Show Pricing Plan', 'provide'),
                            'id' => 'show_pricing_plan',
                            'type' => 'checkbox',
                            'default'   =>  false,
                        ),
			array(
				'name'    => esc_html__( 'Plan Type', 'provide' ),
				'id'      => 'metaPlanType',
				'type'    => 'select',
				'options' => array(
					'daily'       => esc_html__( 'Daily', 'provide' ),
					'weekly'      => esc_html__( 'Weekly', 'provide' ),
					'fortnightly' => esc_html__( 'Fortnightly', 'provide' ),
					'monthly'     => esc_html__( 'Monthly', 'provide' ),
					'quarterly'   => esc_html__( 'Quarterly', 'provide' ),
					'half_year'   => esc_html__( 'Half Year', 'provide' ),
					'yearly'      => esc_html__( 'Yearly', 'provide' )
				),
                                'attributes' => array(
                                    'required' => true,
                                    'data-conditional-id' => 'show_pricing_plan',
                                )
			),
			array(
				'name'       => esc_html__( 'Plan Price', 'provide' ),
				'id'         => 'metaPlanPrice',
				'type'       => 'text',
				'attributes' => array(
					'type'    => 'number',
					'pattern' => '\d*'
				)
			),
			array(
				'name' => esc_html__( 'Currency Symbol', 'provide' ),
				'id'   => 'metaCurrencySymbol',
				'type' => 'text'
			),
			array(
				'name' => esc_html__( 'Button Text', 'provide' ),
				'id'   => 'metaButtonText',
				'type' => 'text'
			),
			array(
				'name' => esc_html__( 'Button Link', 'provide' ),
				'id'   => 'metaButtonLink',
				'type' => 'text'
			),
			array(
				'name'       => esc_html__( 'Plan Features', 'provide' ),
				'id'         => 'metaPlanFeatures',
				'type'       => 'text',
				'repeatable' => true
			)
		);
	}

}
