<?php
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop(get_the_ID());
$column = $h->provide_column('', 'optCategoryLayout', 'optCategorySidebar');
$theme = $h->provide_set($opt, 'optCategoryTheme');
$blog = new provide_blog();
?>
    <section>
        <div class="block less-space">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar('', 'optCategoryLayout', 'optCategorySidebar') ?>
                    <div class="<?php echo esc_attr($column) ?> pro-col">
                        <?php
                        if ($theme == 'style1') {
                            $blog->provide_imageCoverBlogStyle();
                        } else if ($theme == 'style2') {
                            $blog->provide_gridBlogStyle();
                        } else if ($theme == 'style3') {
                            $blog->provide_listBlogStyle();
                        }
                        ?>
                    </div>
                    <?php $h->provide_themeRightSidebar('', 'optCategoryLayout', 'optCategorySidebar') ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
