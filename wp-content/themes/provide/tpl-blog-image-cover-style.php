<?php
/*
 * Template Name:   Blog Image Cover Style
 * */
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop(get_the_ID());
$column = $h->provide_column(get_the_ID());
$blog = new provide_blog();
?>
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID()) ?>
                    <div class="<?php echo esc_attr($column) ?> pro-col">
                        <?php
                        $blog->provide_imageCoverBlogStyleTemplate();
                        ?>
                    </div>
                    <?php $h->provide_themeRightSidebar(get_the_ID()) ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
