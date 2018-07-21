<?php

class provide_ImagecoverstyleSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'blogImageCoverStyle';
        $this->title = esc_html__('Blog Image Cover Style', 'provide');
        $this->desc = esc_html__('Theme Blog Image Cover Style Settings', 'provide');
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
                'id' => 'optBlogImageCoverStyleDate',
                'type' => 'switch',
                'title' => esc_html__('Post Date', 'provide'),
                'desc' => esc_html__('Show or hide post date', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogImageCoverStyleTitle',
                'type' => 'switch',
                'title' => esc_html__('Post Title', 'provide'),
                'desc' => esc_html__('Show or hide post title', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogImageCoverStyleAuthor',
                'type' => 'switch',
                'title' => esc_html__('Post Author', 'provide'),
                'desc' => esc_html__('Show or hide post Author', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogImageCoverStyleComment',
                'type' => 'switch',
                'title' => esc_html__('Post Comment', 'provide'),
                'desc' => esc_html__('Show or hide post comments', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogImageCoverStyleViews',
                'type' => 'switch',
                'title' => esc_html__('Post Views', 'provide'),
                'desc' => esc_html__('Show or hide post Views', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            )
        );
    }

}
