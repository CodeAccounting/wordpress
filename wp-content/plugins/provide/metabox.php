<?php

class provide_Metabox
{

    public $meta = array(
        'post',
        'page',
        'branches',
        'portfolio',
        'team2',
        'team',
        'pricetable',
        'testimonial',
        'user',
        'product'
    );

    public function __construct()
    {
        $path = WP_PLUGIN_DIR . '/provide/postmeta';
        foreach ($this->meta as $m) {
            $file = $path . '/' . $m . '.php';
            if (file_exists($file)) {
                include $path . '/' . $m . '.php';
                $class = 'provide_' . ucfirst($m) . 'Metabox';
                new $class();
            }
        }
    }

}

new provide_Metabox();
