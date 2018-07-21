<?php

class provide_h6typographySettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'h6typography';
        $this->title = esc_html__('H6 Styling', 'provide');
        $this->desc = esc_html__('provide Theme H6 Typography Settings', 'provide');
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
                'id' => 'optH6Typo',
                'type' => 'switch',
                'title' => esc_html__('H6 Typography', 'provide'),
                'desc' => esc_html__('Show or hide body typography', 'provide'),
                'default' => false,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'required' => array('optH6Typo', '=', true),
                'id' => 'optH6Typography',
                'type' => 'typography',
                'title' => esc_html__('H6 Typography', 'provide'),
                'font-style' => true,
                'font-size' => true,
                'line-height' => true,
                'word-spacing' => true,
                'letter-spacing' => true,
                'color' => true,
                'preview' => true,
                'all_styles' => true,
                'units' => 'px',
                'subtitle' => esc_html__('Typography option with each property can be called individually.', 'provide'),
                'default' => array(
                    'color' => '#333',
                    'font-style' => '700',
                    'font-family' => 'Abel',
                    'google' => true,
                    'font-size' => '33px',
                    'line-height' => '40px'
                ),
            ),
        );
    }

}
