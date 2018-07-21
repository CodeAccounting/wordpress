<?php

class provide_sidebarSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = 'el-th-large';
        $this->id = 'widget-sidebar';
        $this->title = esc_html__('Dynamic Sidebar', 'provide');
        $this->desc = esc_html__('Theme dynamic Sidebar Settings', 'provide');
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
                'id' => 'optDynamicSidebar',
                'type' => 'multi_text',
                'title' => esc_html__('Dynamic Sidebar Name', 'provide'),
                'desc' => esc_html__('Enter the name of dynamic sidebar', 'provide')
            )
        );
    }

}
