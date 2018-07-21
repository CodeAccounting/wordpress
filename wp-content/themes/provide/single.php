<?php
$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $h->provide_setView(get_the_ID());
    $h->provide_headerTop(get_the_ID());
    $opt = $h->provide_opt();
    $column = $h->provide_column(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar');
    $date = $h->provide_set($opt, 'optBlogSingleDate');
    $title = $h->provide_set($opt, 'optBlogSingleTitle');
    $author = $h->provide_set($opt, 'optBlogSingleAuthor');
    $comments = $h->provide_set($opt, 'optBlogSingleComments');
    $views = $h->provide_set($opt, 'optBlogSingleViews');
    $cat = $h->provide_set($opt, 'optBlogSingleCat');
    $tag = $h->provide_set($opt, 'optBlogSingleTag');
    $authorBox = $h->provide_set($opt, 'optBlogSingleAuthorBox');
    $authorName = ucwords(get_the_author());
    $i = new provide_Imagify();
    $noThumb = (!has_post_thumbnail() ) ? 'no-thumb' : '';
    if ($column == 'col-md-9') {
        $size = 'provide_870x523';
    } else {
        $size = 'provide_1170x403';
    }
    ?>
    <section>
        <div class="block less-space">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar') ?>
                    <div class="<?php echo esc_attr($column) ?>">
                        <div class="blog-single">
                            <div class="news-img <?php echo esc_attr($noThumb) ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail($size);
                                }
                                if ($date == '1') {
                                    echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                                }
                                ?>
                            </div>
                            <?php if ($title == '1'): ?>
                                <h1 class="post-title"><?php the_title() ?></h1>
                                <?php
                            endif;
                            if ($author == '1'):
                                ?>
                                <span class="post-by">
        <?php esc_html_e('by', 'provide') ?>
                                    <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_attr($authorName) ?></a>
                                </span>
                                <?php
                            endif;
                            if ($comments == '1' || $views == '1' || $cat == '1'):
                                ?>
                                <ul class="meta">
                                    <?php if ($comments == '1'): ?>
                                        <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                                    <?php if ($views == '1'): ?>
                                        <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
        <?php if ($cat == '1'): ?>
                                        <li><i class="fa fa-bookmark-o"></i> <?php $h->provide_get_terms('category', 300, '', true, ', ') ?></li><?php endif; ?>
                                </ul>
                                <?php
                            endif;
                            the_content();
                            wp_link_pages();
                            ?>
                        </div><!-- Blog Single -->
    <?php if ($tag == '1'): ?>
                            <div class="tags">
                                <strong><?php esc_html_e('Tags', 'provide') ?>:</strong>
                            <?php $h->provide_getTags() ?>
                            </div>
                        <?php endif; ?>
                            <?php if ($authorBox == '1'): ?>
                            <div class="provide-author">
        <?php echo wp_kses($h->provide_avatar(array('m' => '129x103', 'i' => '129x103', 'w' => '129x103')), true) ?>
                                <div class="author-name">
                                    <h4><?php echo esc_html($authorName) ?></h4><i><?php echo esc_html(get_the_author_meta('metaDesignation')) ?></i>
                                </div>
                                <div class="colored-socials">
                                    <?php if (get_the_author_meta('metaFB')): ?>
                                        <a href="<?php echo esc_url(get_the_author_meta('metaFB')) ?>" title="" class="fb"><i class="fa fa-facebook"></i></a>
                                    <?php endif; ?>
                                    <?php if (get_the_author_meta('metaGB')): ?>
                                        <a href="<?php echo esc_url(get_the_author_meta('metaGB')) ?>" title="" class="gp"><i class="fa fa-twitter"></i></a>
                                    <?php endif; ?>
                                    <?php if (get_the_author_meta('metaTW')): ?>
                                        <a href="<?php echo esc_url(get_the_author_meta('metaTW')) ?>" title="" class="tt"><i class="fa fa-google-plus"></i></a>
                                    <?php endif; ?>
                                        <?php if (get_the_author_meta('metaLK')): ?>
                                        <a href="<?php echo esc_url(get_the_author_meta('metaLK')) ?>" title="" class="pt"><i class="fa fa-linkedin"></i></a>
        <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        if (comments_open() || get_comments_number(get_the_ID())) :
                            comments_template();
                        endif;
                        ?>
                    </div>
    <?php $h->provide_themeRightSidebar(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar') ?>
                </div>
            </div>
    </section><!-- Single Content -->
    <?php
}
get_footer();
