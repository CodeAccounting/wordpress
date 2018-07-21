<?php

class provide_responsiveheaderSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'responsiveheader';
        $this->title = esc_html__('Responsive Header', 'provide');
        $this->desc = esc_html__('Theme Responsive Header Settings', 'provide');
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

    public function provide_init(){
        return array(
            array(
                'id' => 'optResponsiveHeaderTopBar',
                'type' => 'switch',
                'title' => esc_html__('Top Bar', 'provide'),
                'default' => true,
				'indent'   => true,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
            ),
			array(
				'id'       => 'optresponsiveheaderSection',
				'type'     => 'section',
				'title'    => esc_html__( '', 'provide' ),
				'subtitle' => esc_html__( '', 'provide' ),
				'indent'   => true,
			),
            array(
                'id' => 'optResponsiveHeaderTopBarAddress',
                'type' => 'switch',
                'title' => esc_html__('Show Address', 'provide'),
                'default' => true,
				
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
                'required' => array('optResponsiveHeaderTopBar', '=', '1')
            ),
			 array(
                'id' => 'optResponsiveHeaderTopBarSocial',
                'type' => 'switch',
                'title' => esc_html__('Show Social', 'provide'),
                'default' => true,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
                'required' => array('optResponsiveHeaderTopBar', '=', '1')
            ),
			array(
                'id' => 'optResponsiveHeaderTopBarSearch',
                'type' => 'switch',
                'title' => esc_html__('Show Search Bar', 'provide'),
                'default' => true,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
                'required' => array('optResponsiveHeaderTopBar', '=', '1')
            ),
			array(
				'id'       => 'optresponsiveheaderSection2',
				'type'     => 'section',
				'title'    => esc_html__( '', 'provide' ),
				'subtitle' => esc_html__( '', 'provide' ),
				'indent'   => false,
			),
             array(
                'id' => 'optResponsiveHeaderContactInfo',
                'type' => 'switch',
                'title' => esc_html__('Show Contact Info', 'provide'),
                'default' => true,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
        );
    }

}
