<?php

class provide_newsletterSettings
{
    public $icon;
    public $id;
    public $title;
    public $desc;

    public function __construct()
    {
        $this->icon = '';
        $this->id = 'newsletter';
        $this->title = esc_html__('Newsletter', 'provide');
        $this->desc = esc_html__('provide Theme Newsletter Settings', 'provide');
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
                'id' => 'optMailchimpApiKey',
                'type' => 'text',
                'title' => esc_html__('MailChimp API Key', 'provide'),
                'desc' => sprintf(esc_html__('Enter your MailChimp API Key. You can get it %s.', 'provide'), '<a target="_blank" href="https://admin.mailchimp.com/account/api-key-popup">' . esc_html__('here', 'provide') . '</a>'),
            ),
            array(
                'id' => 'optMailchimpListId',
                'type' => 'text',
                'title' => esc_html__('MailChimp List ID', 'provide'),
                'desc' => sprintf(esc_html__('Enter your List ID. You can get it %s.', 'provide'), '<a target="_blank" href="https://admin.mailchimp.com/lists/">' . esc_html__('here', 'provide') . '</a>')
            ),
        );
    }

}
