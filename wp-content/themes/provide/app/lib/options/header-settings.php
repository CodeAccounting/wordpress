<?php

class provide_headerSettings {

    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct() {
        $this->icon = '';
        $this->id = 'header';
        $this->title = esc_html__('Header Settings', 'provide');
        $this->desc = esc_html__('In this section set all available header options.', 'provide');
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function provide_init() {
        return array(
            array(
                'id' => 'optHeaderStyle',
                'type' => 'image_select',
                'title' => __('Select Header Style', 'provide'),
                'subtitle' => __('Select the header style for this theme.', 'provide'),
                'full_width' => true,
                'options' => array(
                    '1' => array(
                        'alt' => esc_html__('Header Style 1', 'provide'),
                        'img' => provide_Uri . 'partial/images/headers/1.jpg'
                    ),
                    '2' => array(
                        'alt' => esc_html__('Header Style 2', 'provide'),
                        'img' => provide_Uri . 'partial/images/headers/2.jpg'
                    ),
                    '3' => array(
                        'alt' => esc_html__('Header Style 3', 'provide'),
                        'img' => provide_Uri . 'partial/images/headers/3.jpg'
                    ),
                    '4' => array(
                        'alt' => esc_html__('Header Style 4', 'provide'),
                        'img' => provide_Uri . 'partial/images/headers/4.jpg'
                    ),
                    '5' => array(
                        'alt' => esc_html__('Header Style 5', 'provide'),
                        'img' => provide_Uri . 'partial/images/headers/5.jpg'
                    )
                ),
                'default' => '1'
            ),
            // start header one styling
            array(
                'id' => 'optHeaderOneSection',
                'type' => 'section',
                'title' => esc_html__('Header One Settings', 'provide'),
                'subtitle' => esc_html__('In this section set all available header one options.', 'provide'),
                'indent' => true,
                'required' => array('optHeaderStyle', '=', '1')
            ),
            array(
                'id' => 'optHeaderLogo',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Upload Logo', 'provide'),
                'compiler' => 'true'
            ),
            array(
                'id' => 'optHeaderSticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Header', 'provide'),
                'default' => false,
                'on' => esc_html__('Enable', 'provide'),
                'off' => esc_html__('Disable', 'provide'),
            ),
            array(
                'id' => 'optHeaderTransparent',
                'type' => 'switch',
                'title' => esc_html__('Transparent Header', 'provide'),
                'default' => false,
                'on' => esc_html__('Enable', 'provide'),
                'off' => esc_html__('Disable', 'provide'),
            ),
            array(
                'id' => 'optHeaderTopBar',
                'type' => 'switch',
                'title' => esc_html__('Top Bar', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
            ),
            array(
                'id' => 'optHeaderTopBarSocial',
                'type' => 'switch',
                'title' => esc_html__('Show Social', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
                'required' => array('optHeaderTopBar', '=', '1')
            ),
            array(
                'id' => 'optHeaderSixTopBarSocialIcons',
                'type' => 'social_media',
                'heading' => true,
                'title' => esc_html__('Header Top Bar Social Media Builder', 'provide'),
                'full_width' => true,
                'required' => array(
                    array('optHeaderTopBar', '=', '1'),
                    array('optHeaderTopBarSocial', '=', '1')
                )
            ),
            array(
                'id' => 'optHeaderTopBarSearch',
                'type' => 'switch',
                'title' => esc_html__('Show Search Bar', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
                'required' => array('optHeaderTopBar', '=', '1')
            ),
            array(
                'id' => 'optHeaderQuoteButton',
                'type' => 'switch',
                'title' => esc_html__('Show Quote Button', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
            array(
                'id' => 'optHeaderQuoteButtonText',
                'type' => 'text',
                'title' => esc_html__('Enter the button text', 'provide'),
                'required' => array('optHeaderQuoteButton', '=', '1')
            ),
            array(
                'id' => 'optHeaderQuoteLink',
                'type' => 'select',
                'multi' => false,
                'data' => 'page',
                'title' => esc_html__('Select Page for link', 'provide'),
                'required' => array('optHeaderQuoteButton', '=', '1')
            ),
            // end header one styling
            // start header two styling
            array(
                'id' => 'optHeaderTwoSection',
                'type' => 'section',
                'title' => esc_html__('Header Two Settings', 'provide'),
                'subtitle' => esc_html__('In this section set all available header Two options.', 'provide'),
                'indent' => true,
                'required' => array('optHeaderStyle', '=', '2')
            ),
            array(
                'id' => 'optHeaderTwoLogo',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Upload Logo', 'provide'),
                'compiler' => 'true'
            ),
            array(
                'id' => 'optHeaderTwoSticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Header', 'provide'),
                'default' => false,
                'on' => esc_html__('Enable', 'provide'),
                'off' => esc_html__('Disable', 'provide'),
            ),
            array(
                'id' => 'optHeaderTwoSearch',
                'type' => 'switch',
                'title' => esc_html__('Show Header Search', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
            array(
                'id' => 'optHeaderTwoQuoteButton',
                'type' => 'switch',
                'title' => esc_html__('Show Quote Button', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
            array(
                'id' => 'optHeaderTwoQuoteButtonText',
                'type' => 'text',
                'title' => esc_html__('Enter the button text', 'provide'),
                'required' => array('optHeaderTwoQuoteButton', '=', '1')
            ),
            array(
                'id' => 'optHeaderTwoQuoteLink',
                'type' => 'select',
                'multi' => false,
                'data' => 'page',
                'title' => esc_html__('Select Page for link', 'provide'),
                'required' => array('optHeaderTwoQuoteButton', '=', '1')
            ),
            array(
                'id' => 'optHeaderTwoSectionEnd',
                'type' => 'section',
                'indent' => false,
            ),
            // end header Two styling
            // start header Three styling
            array(
                'id' => 'optHeaderThreeSection',
                'type' => 'section',
                'title' => esc_html__('Header Three Settings', 'provide'),
                'subtitle' => esc_html__('In this section set all available header Three options.', 'provide'),
                'indent' => true,
                'required' => array('optHeaderStyle', '=', '3')
            ),
            array(
                'id' => 'optHeaderThreeLogo',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Upload Logo', 'provide'),
                'compiler' => 'true'
            ),
            array(
                'id' => 'optHeaderThreeSticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Header', 'provide'),
                'default' => false,
                'on' => esc_html__('Enable', 'provide'),
                'off' => esc_html__('Disable', 'provide'),
            ),
            array(
                'id' => 'optHeaderThreeSearch',
                'type' => 'switch',
                'title' => esc_html__('Show Header Search', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
            array(
                'id' => 'optHeaderThreeSectionEnd',
                'type' => 'section',
                'indent' => false,
            ),
            // end header Three styling
            // start header Four styling
            array(
                'id' => 'optHeaderFourSection',
                'type' => 'section',
                'title' => esc_html__('Header Four Settings', 'provide'),
                'subtitle' => esc_html__('In this section set all available header Four options.', 'provide'),
                'indent' => true,
                'required' => array('optHeaderStyle', '=', '4')
            ),
            array(
                'id' => 'optShowHeaderFour',
                'type' => 'switch',
                'title' => esc_html__('Show Header', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
            ),
            array(
                'id' => 'optHeaderFourLogo',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Upload Logo', 'provide'),
                'compiler' => 'true'
            ),
            array(
                'id' => 'optHeaderFourSearch',
                'type' => 'switch',
                'title' => esc_html__('Show Header Search', 'provide'),
                'default' => false,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide')
            ),
            array(
                'id' => 'optHeaderFourScreenbg',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Screen Background', 'provide'),
                'compiler' => 'true'
            ),
            array(
                'id' => 'optHeaderFourSectionEnd',
                'type' => 'section',
                'indent' => false,
            ),
            // end header Four styling
            // start breadcumb setting
            array(
                'id' => 'optBreadcumbSection',
                'type' => 'section',
                'title' => esc_html__('Breadcumb Settings', 'provide'),
                'subtitle' => esc_html__('In this section set all available Breadcumb options.', 'provide'),
                'indent' => true,
            ),
            array(
                'id' => 'optBreadcumbSetting',
                'type' => 'switch',
                'title' => esc_html__('Hide and Show Breadcumb', 'provide'),
                'default' => true,
                'on' => esc_html__('Show', 'provide'),
                'off' => esc_html__('Hide', 'provide'),
            ),
                // end breadcumb setting
            
            array(
                'id' => 'optHeaderFiveLogo',
                'type' => 'media',
                'url' => false,
                'title' => esc_html__('Upload Logo', 'provide'),
                'compiler' => 'true',
                'required'  =>  array('optHeaderStyle', '=', '5'),
            ),
        );
    }

}
