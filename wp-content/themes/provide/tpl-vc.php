<?php

// Template Name: Visual Composer
$h = new provide_Helper;
$h->provide_header();
$h->provide_headerTop(get_the_ID());
while (have_posts()): the_post();
    echo do_shortcode(get_the_content());
endwhile;

get_footer();
