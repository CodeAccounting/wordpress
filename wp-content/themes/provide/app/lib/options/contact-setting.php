<?php

class provide_ContactSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = 'el-envelope';
        $this->id = 'contact';
        $this->title = esc_html__('Contact Us', 'provide');
        $this->desc = esc_html__('provide Theme Contact Settings', 'provide');
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function provide_init()
    {
        return array(

            array(
                'id' => 'optContactdesc',
                'type' => 'textarea',
                'title' => esc_html__('Enter the contact form description', 'provide')
            ),
            array(
                'id' => 'optContactMail',
                'type' => 'text',
                'title' => esc_html__('Email', 'provide'),
                'desc' => esc_html__('Enter email address to receive email from contact form', 'provide'),
            ),
            array(
                'id' => 'optMapApiKey',
                'type' => 'text',
                'title' => esc_html__('Google Map API Key', 'provide'),
                'desc' => esc_html__('Enter google map API key', 'provide'),
            ),
            array(
                'id' => 'optContactMap',
                'type' => 'text',
                'title' => esc_html__('Google Map', 'provide'),
                'desc' => esc_html__('Enter google map Latitude & Longitude with Comma seprated', 'provide'),
            ),
            array(
                'id' => 'optContactMessage',
                'type' => 'textarea',
                'title' => esc_html__('Success Message', 'provide')
            ),
            array(
                'id' => 'optContactInfoEnd',
                'type' => 'section',
                'indent' => false,
            ),


            /********** contact info section ************/
            
            array(
                'id'       => 'optHeaderOneSectioncontact',
                'type'     => 'section',
                'title'    => esc_html__( 'Contact Info', 'provide' ),
                'subtitle' => esc_html__( 'In this section set header contact info.', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_one',
                'type' => 'section',
                'title'    => esc_html__( 'Contact Time', 'provide' ),
                'subtitle' => esc_html__( 'In this section set contact time.', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_one_icon',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Icon', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_one_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'=>'optcontact_one_content',
                'type' => 'multi_text',
                'title' => __('Content', 'provide'),
                'desc' => __('Contact info Content', 'provide'),
                'indent'   => true,
            ),
            array(
                'id'      => 'optcontact_one_header',
                'type'    => 'switch',
                'title'   => esc_html__( 'Show in header', 'provide' ),
                'default' => true,
                'on'      => esc_html__( 'Show', 'provide' ),
                'off'     => esc_html__( 'Hide', 'provide' ),
            ),


            array(
                'id'       => 'optcontact_two',
                'type' => 'section',
                'title'    => esc_html__( 'Contact Email', 'provide' ),
                'subtitle' => esc_html__( 'In this section set contact email.', 'provide' ),
                'indent'   => true,
            ),
            
            array(
                'id'       => 'optcontact_two_icon',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Icon', 'provide' ),
                'indent'   => true,
            ),
            
            array(
                'id'       => 'optcontact_two_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'provide' ),
                'indent'   => true,
            ),
            
            array(
                'id'=>'optcontact_two_content',
                'type' => 'multi_text',
                'title' => __('Content', 'provide'),
                'desc' => __('Contact info Content', 'provide'),
                'indent'   => true,
            ),
                
            array(
                'id'      => 'optcontact_two_header',
                'type'    => 'switch',
                'title'   => esc_html__( 'Show in header', 'provide' ),
                'default' => true,
                'on'      => esc_html__( 'Show', 'provide' ),
                'off'     => esc_html__( 'Hide', 'provide' ),
            ),

            
            array(
                'id'       => 'optcontact_three',
                'type' => 'section',
                'title'    => esc_html__( 'Contact Number', 'provide' ),
                'subtitle' => esc_html__( 'In this section set contact number.', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_three_icon',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Icon', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_three_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'=>'optcontact_three_content',
                'type' => 'multi_text',
                'title' => __('Content', 'provide'),
                'desc' => __('Contact info Content', 'provide'),
                'indent'   => true,
            ),

            array(
                'id'      => 'optcontact_three_header',
                'type'    => 'switch',
                'title'   => esc_html__( 'Show in header', 'provide' ),
                'default' => true,
                'on'      => esc_html__( 'Show', 'provide' ),
                'off'     => esc_html__( 'Hide', 'provide' ),
            ),

            array(
                'id'       => 'optcontact_four',
                'type'     => 'section',
                'title'    => esc_html__( 'Contact Address', 'provide' ),
                'subtitle' => esc_html__( 'In this section set contact address.', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_four_icon',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Icon', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'       => 'optcontact_four_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'provide' ),
                'indent'   => true,
            ),

            array(
                'id'=>'optcontact_four_content',
                'type' => 'multi_text',
                'title' => __('Content', 'provide'),
                'desc' => __('Contact info Content', 'provide'),
                'indent'   => true,
            ),
            array(
                'id'      => 'optcontact_show_address',
                'type'    => 'switch',
                'title'   => esc_html__( 'Show in header', 'provide' ),
                'default' => true,
                'on'      => esc_html__( 'Show', 'provide' ),
                'off'     => esc_html__( 'Hide', 'provide' ),
            ),
            
            /********** contact info section ************/
        );
    }

}
