<?php

class provide_ListstyleSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'blogListStyle';
        $this->title = esc_html__('Blog List Style', 'provide');
        $this->desc = esc_html__('Theme Blog List Style Settings', 'provide');
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
                'id' => 'optBlogListStyleContentLimit',
                'type' => 'text',
                'title' => esc_html__('Content Limit', 'provide'),
                'desc' => esc_html__('Enter the number of words to shown in content', 'provide'),
                'validate' => 'numeric',
                'default' => '20'
            ),
            array(
                'id' => 'optBlogListStyleDate',
                'type' => 'switch',
                'title' => esc_html__('Post Date', 'provide'),
                'desc' => esc_html__('Show or hide post date', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogListStyleTitle',
                'type' => 'switch',
                'title' => esc_html__('Post Title', 'provide'),
                'desc' => esc_html__('Show or hide post title', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogListStyleAuthor',
                'type' => 'switch',
                'title' => esc_html__('Post Author', 'provide'),
                'desc' => esc_html__('Show or hide post Author', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogListStyleComment',
                'type' => 'switch',
                'title' => esc_html__('Post Comment', 'provide'),
                'desc' => esc_html__('Show or hide post comments', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogListStyleViews',
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
