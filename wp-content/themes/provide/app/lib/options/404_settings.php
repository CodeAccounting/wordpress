<?php

class provide_404Settings
{

    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = '404';
        $this->title = esc_html__('404', 'provide');
        $this->desc = esc_html__('provide Theme 404 Settings', 'provide');
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
                'id' => 'opt404Header',
                'type' => 'switch',
                'title' => esc_html__('Header Section', 'provide'),
                'desc' => esc_html__('Show or hide 404 page header section', 'provide'),
                'default' => false,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'opt404HeaderTitle',
                'type' => 'text',
                'title' => esc_html__('Header Title', 'provide'),
                'required' => array('opt404Header', '=', true)
            ),
            array(
                'id' => 'opt404HeaderBg',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('Header Background', 'provide'),
                'compiler' => 'true',
                'required' => array('opt404Header', '=', true)
            ),
            array(
                'id' => 'opt404Text',
                'type' => 'text',
                'title' => esc_html__('404 Text', 'provide')
            ),
            array(
                'id' => 'opt404BottomText',
                'type' => 'text',
                'title' => esc_html__('404 Bottom Text', 'provide')
            ),
            array(
                'id' => 'opt404BottomDesc',
                'type' => 'textarea',
                'title' => esc_html__('404 Bottom Description', 'provide')
            ),
            array(
                'id' => 'opt404ButtonText',
                'type' => 'text',
                'title' => esc_html__('404 Button Text', 'provide')
            ),
        );
    }

}
