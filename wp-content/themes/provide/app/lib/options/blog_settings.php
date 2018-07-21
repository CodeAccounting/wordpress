<?php

class provide_BlogSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = 'el-file-edit';
        $this->id = 'blogPages';
        $this->title = esc_html__('Blog Settings', 'provide');
        $this->desc = esc_html__('Theme Blog Settings', 'provide');
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
        return array();
    }

}
