<?php

class provide_languageSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = 'el-fontsize';
        $this->id = 'language-uploader';
        $this->title = esc_html__('Language Uploader', 'provide');
        $this->desc = esc_html__('Provide Theme localization Settings', 'provide');
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
                'id' => 'optLanguage',
                'type' => 'language'
            )
        );
    }

}
