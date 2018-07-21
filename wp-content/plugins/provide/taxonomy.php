<?php

class provide_Taxonomy
{

    public $meta = array(
        'category',
    );

    public function __construct()
    {
        $path = WP_PLUGIN_DIR . '/provide/taxonomy-meta';
        foreach ($this->meta as $m) {
            $file = $path . '/' . $m . '.php';
            if (file_exists($file)) {
                include $path . '/' . $m . '.php';
                $class = 'provide_' . ucfirst($m) . 'Taxonomy';
                new $class();
            }
        }
    }

}

new provide_Taxonomy();
new CMB2_Taxonomy();