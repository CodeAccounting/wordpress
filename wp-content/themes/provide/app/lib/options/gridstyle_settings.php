<?php

class provide_GridstyleSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'blogGridStyle';
        $this->title = esc_html__('Blog Grid Style', 'provide');
        $this->desc = esc_html__('Theme Blog Grid Style Settings', 'provide');
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
                'id' => 'optBlogGridStyleColumn',
                'type' => 'select',
                'title' => esc_html__('Select Blog Column', 'provide'),
                'options' => array(
                    'col-md-6' => esc_html__('2 Col', 'provide'),
                    'col-md-4' => esc_html__('3 Col', 'provide'),
                    'col-md-3' => esc_html__('4 Col', 'provide')
                )
            ),
            array(
                'id' => 'optBlogGridStyleDate',
                'type' => 'switch',
                'title' => esc_html__('Post Date', 'provide'),
                'desc' => esc_html__('Show or hide post date', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogGridStyleTitle',
                'type' => 'switch',
                'title' => esc_html__('Post Title', 'provide'),
                'desc' => esc_html__('Show or hide post title', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogGridStyleAuthor',
                'type' => 'switch',
                'title' => esc_html__('Post Author', 'provide'),
                'desc' => esc_html__('Show or hide post Author', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogGridStyleComment',
                'type' => 'switch',
                'title' => esc_html__('Post Comment', 'provide'),
                'desc' => esc_html__('Show or hide post comments', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogGridStyleViews',
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
