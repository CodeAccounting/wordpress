<?php

class provide_TemplateSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = 'el-file-edit';
        $this->id = 'templates';
        $this->title = esc_html__('Templates Settings', 'provide');
        $this->desc = esc_html__('provide Theme Templates Settings', 'provide');
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
