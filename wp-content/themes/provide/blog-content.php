<?php
global $wp_query;
$h = new provide_Helper();
$opt = $h->provide_opt();
$i = new provide_Imagify();
$tp = '';
if (is_archive()) {
    $tp = 'Archive';
}
if (is_author()) {
    $tp = 'Author';
}
if (is_category()) {
    $tp = 'Category';
}
if (is_tag()) {
    $tp = 'Tag';
}
if (is_search()) {
    $tp = 'Search';
}
$comments = $h->provide_set($opt, 'opt' . $tp . 'Comment');
$views = $h->provide_set($opt, 'opt' . $tp . 'Views');
$likes = $h->provide_set($opt, 'opt' . $tp . 'Likes');
$column = (new provide_Helper())->provide_column('', 'opt' . $tp . 'Layout', 'opt' . $tp . 'Sidebar');
if ($column == 'col-md-12') {
    $sizes = array('m' => '470x430', 'i' => '470x430', 'w' => '555x308');
} else {
    $sizes = array('m' => '470x430', 'i' => '470x430', 'w' => '360x200');
}
if (is_search()) {
    ?>
    <div class="col-md-12">
        <div class="search-bar">
            <label><?php esc_html_e('Refine Your Search', 'provide') ?>:</label>
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <div class="row">
                    <div class="col-md-10">
                        <input name="s" type="text" placeholder="<?php esc_html_e('Enter your Keyword', 'provide') ?>"/>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="theme-btn"><i class="fa fa-paper-plane"></i> <?php esc_html_e('SEARCH NOW', 'provide') ?>
                        </button>
                    </div>
                </div>
            </form>
            <h4><?php esc_html_e('Search Results Found', 'provide') ?>:
                <span>"<?php echo get_search_query(); ?>"</span></h4>
        </div>
    </div>
    <?php
}
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
        $noThumbCol = (empty($noThumb)) ? 'col-md-6' : 'col-md-12';
        ?>
        <div <?php post_class('hrz-post mb30 ' . esc_attr($noThumb)) ?>>
            <?php if (has_post_thumbnail()): ?>
                <div class="col-md-6">
                    <?php echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true) ?>
                </div>
            <?php endif; ?>
            <div class="<?php echo esc_attr($noThumbCol) ?>">
                <div class="hrz-metas">
                    <h4><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
                    <?php if ($comments == '1' || $views == '1' || $likes == '1'): ?>
                        <ol class="hrz-small">
                            <?php if ($comments == '1'): ?>
                                <li><i class="fa fa-comment"></i><?php $h->provide_getCommentNo() ?></li>
                            <?php endif; ?>
                            <?php if ($views == '1'): ?>
                                <li><i class="fa fa-heart"></i><?php echo esc_html($h->provide_likesCounter()) ?></li>
                            <?php endif; ?>
                            <?php if ($likes == '1'): ?>
                                <li><i class="fa fa-eye"></i><?php $h->provide_getView(get_the_ID()) ?></li>
                            <?php endif; ?>
                        </ol>
                    <?php endif; ?>
                    <?php the_excerpt() ?>
                    <a class="readmore" title="" href="<?php the_permalink() ?>"><?php esc_html_e('Read More', 'provide') ?></a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="col-md-12">
        <?php $h->provide_pagi(array('total' => $wp_query->max_num_pages)); ?>
    </div>
    <?php
} else {
    ?>
    <div class="not-found">
        <div class="notfound-content">
            <h3><?php esc_html_e('S', 'provide') ?><img src="<?php echo esc_url(provide_Uri . 'partial/images/not-found.png') ?>" alt=""/></h3>
            <strong><?php esc_html_e('No Record Found', 'provide') ?></strong>
            <span><?php esc_html_e('The Link Might Be Corrupted ', 'provide') ?>
                <strong><?php esc_html_e('OR', 'provide') ?></strong>
                <i><?php esc_html_e(' The Page May Have Been Removed', 'provide') ?></i>
            </span>
            <a href="<?php echo esc_url(home_url('/')); ?>" title="" class="theme-btn">
                <i class="fa fa-paper-plane"></i> <?php esc_html_e('GO BACK HOME', 'provide') ?>
            </a>
        </div>
    </div>
    <?php
}