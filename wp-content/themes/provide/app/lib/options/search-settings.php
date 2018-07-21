<?php

class provide_SearchSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'search';
        $this->title = esc_html__('Search', 'provide');
        $this->desc = esc_html__('Theme Search Template Settings', 'provide');
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
                'id' => 'optSearchHeader',
                'type' => 'switch',
                'title' => esc_html__('Header Section', 'provide'),
                'desc' => esc_html__('Show or hide search page header section', 'provide'),
                'default' => false,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optSearchHeaderTitle',
                'type' => 'text',
                'title' => esc_html__('Header Title', 'provide'),
                'required' => array('optSearchHeader', '=', true)
            ),
            array(
                'id' => 'optSearchHeaderBg',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('Header Background', 'provide'),
                'compiler' => 'true',
                'required' => array('optSearchHeader', '=', true)
            ),
            array(
                'id' => 'optSearchTheme',
                'type' => 'select',
                'title' => esc_html__('Select Blog Layout', 'provide'),
                'options' => array(
                    'style1' => esc_html__('Image Cover Style', 'provide'),
                    'style2' => esc_html__('Grid Style', 'provide'),
                    'style3' => esc_html__('List Style', 'provide')
                )
            ),
            array(
                'id' => 'optSearchLayout',
                'type' => 'image_select',
                'title' => esc_html__('Sidebar Layout', 'provide'),
                'subtitle' => esc_html__('Select the sidebar layout of all blog posts.', 'provide'),
                'full_width' => false,
                'options' => array(
                    'left' => array(
                        'alt' => esc_html__('Left', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => esc_html__('Right', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                    ),
                    'full' => array(
                        'alt' => esc_html__('Full', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/1c.png'
                    ),
                ),
            ),
            array(
                'id' => 'optSearchSidebar',
                'type' => 'select',
                'title' => esc_html__('Sidebar', 'provide'),
                'options' => (new provide_Helper)->provide_sidebar(),
                'select2' => array('allowClear' => true),
                'required' => array('optSearchLayout', '!=', 'full')
            )
        );
    }

}
