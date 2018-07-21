<?php
$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $opt = $h->provide_opt();
    $h->provide_headerTop(get_the_ID());
    $column = $h->provide_column(get_the_ID());
    $h = new provide_Helper();
    ?>
    <section>
        <div class="block less-space">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID()) ?>
                    <div class="<?php echo esc_attr($column) ?>">
                        <div class="page-contents">
                            <?php
                            the_content();
                            if (comments_open() || get_comments_number(get_the_ID())) :
                                comments_template();
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php $h->provide_themeRightSidebar(get_the_ID()) ?>
                </div>
            </div>
    </section>
    <?php
}
get_footer();
