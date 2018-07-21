<?php

class provide_BlogsingleSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'blogSingle';
        $this->title = esc_html__('Single Post', 'provide');
        $this->desc = esc_html__('Theme Blog Single Post Settings', 'provide');
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
                'id' => 'optBlogSingleLayout',
                'type' => 'image_select',
                'title' => esc_html__('Sidebar Layout', 'provide'),
                'subtitle' => esc_html__('Select the sidebar layout of all blog posts.', 'provide'),
                'full_width' => false,
                'options' => array(
                    'left' => array(
                        'alt' => esc_html__('Left', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
                    ),
                    'right' => array(
                        'alt' => esc_html__('Right', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
                    ),
                    'full' => array(
                        'alt' => esc_html__('Full', 'provide'),
                        'img' => ReduxFramework::$_url . 'assets/img/1c.png'
                    ),
                ),
                'default' => '3'
            ),
            array(
                'id' => 'optBlogSingleSidebar',
                'type' => 'select',
                'title' => esc_html__('Sidebar', 'provide'),
                'options' => (new provide_Helper)->provide_sidebar(),
                'select2' => array('allowClear' => true),
                'required' => array('optBlogSingleLayout', '!=', 'full')
            ),
            array(
                'id' => 'optBlogSingleDate',
                'type' => 'switch',
                'title' => esc_html__('Date', 'provide'),
                'desc' => esc_html__('Show or hide blog post date', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleTitle',
                'type' => 'switch',
                'title' => esc_html__('Title', 'provide'),
                'desc' => esc_html__('Show or hide blog post title', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleAuthor',
                'type' => 'switch',
                'title' => esc_html__('Author', 'provide'),
                'desc' => esc_html__('Show or hide blog post author', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleComments',
                'type' => 'switch',
                'title' => esc_html__('Comments Count', 'provide'),
                'desc' => esc_html__('Show or hide blog post comments counter', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleViews',
                'type' => 'switch',
                'title' => esc_html__('Views', 'provide'),
                'desc' => esc_html__('Show or hide blog post views', 'provide'),
                'default' => false,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleCat',
                'type' => 'switch',
                'title' => esc_html__('Categories', 'provide'),
                'desc' => esc_html__('Show or hide blog post categories', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleTag',
                'type' => 'switch',
                'title' => esc_html__('Post Tag\'s', 'provide'),
                'desc' => esc_html__('Show or hide blog post tag\'s', 'provide'),
                'default' => true,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            ),
            array(
                'id' => 'optBlogSingleAuthorBox',
                'type' => 'switch',
                'title' => esc_html__('Author Box', 'provide'),
                'desc' => esc_html__('Show or hide blog post author', 'provide'),
                'default' => false,
                'on' => esc_html__('Yes', 'provide'),
                'off' => esc_html__('No', 'provide')
            )
        );
    }

}
