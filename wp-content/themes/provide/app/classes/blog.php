<?php

class provide_blog {

    public function __call($method, $args) {
        echo esc_html__("unknown method ", "provide") . $method;

        return false;
    }

    public function provide_blogTemplate() {
        
    }

    public function provide_imageCoverBlogStyle() {
        global $wp_query;
        $tp = $this->provide_templatePrefix();
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogImageCoverStyleDate');
        $title = $h->provide_set($opt, 'optBlogImageCoverStyleTitle');
        $author = $h->provide_set($opt, 'optBlogImageCoverStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogImageCoverStyleComment');
        $views = $h->provide_set($opt, 'optBlogImageCoverStyleViews');
        $column = $h->provide_column('', 'opt' . $tp . 'Layout', 'opt' . $tp . 'Sidebar');
        if ($column == 'col-md-12') {
            $sizes = array('m' => '515x260', 'i' => '720x364', 'w' => '1170x591');
        } else {
            $sizes = array('m' => '267x135', 'i' => '720x364', 'w' => '870x440');
        }
        $this->provide_isSearch();
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                $authorName = ucwords(get_the_author());
                $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                ?>
                <div <?php post_class('provide-news wow fadeIn') ?>>
                    <div class="news-img <?php echo esc_attr($noThumb) ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                        }
                        if ($date == '1') {
                            echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                        }
                        ?>
                    </div>
                    <?php
                    if ($title == '1'):
                        if (get_the_title() == '') {
                            ?>
                            <h3><a href="<?php the_permalink() ?>" title=""><?php echo strtoupper($h->provide_date(false, 'd M Y')) ?></a></h3>
                            <?php
                        } else {
                            ?>
                            <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                            <?php
                        }
                    endif;
                    if ($author == '1' || $comments == '1' || $views == '1'):
                        ?>
                        <ul class="meta">
                            <?php if ($author == '1'): ?>
                                <li class="posted-by"><?php esc_html_e('by ', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                            <?php if ($comments == '1'): ?>
                                <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                    <?php if ($views == '1'): ?>
                                <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                        </ul>
                <?php endif; ?>
                    <p class="paragraph"><?php echo get_the_excerpt() ?></p>
                </div><!-- Provide News -->
                <?php
            }
            $h->provide_pagi(array('total' => $wp_query->max_num_pages));
        }
    }

    public function provide_gridBlogStyle() {
        global $wp_query;
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogGridStyleDate');
        $title = $h->provide_set($opt, 'optBlogGridStyleTitle');
        $author = $h->provide_set($opt, 'optBlogGridStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogGridStyleComment');
        $views = $h->provide_set($opt, 'optBlogGridStyleViews');
        $column = $h->provide_set($opt, 'optBlogGridStyleColumn');
        if ($column == 'col-md-6') {
            $sizes = array('m' => '292x220', 'i' => '470x354', 'w' => '570x429');
        } else if ($column == 'col-md-4') {
            $sizes = array('m' => '292x220', 'i' => '303x228', 'w' => '370x279');
        } else if ($column == 'col-md-3') {
            $sizes = array('m' => '292x220', 'i' => '220x165', 'w' => '270x203');
        }else {
            $sizes = array('m' => '292x220', 'i' => '470x354', 'w' => '570x429');
        }
        $this->provide_isSearch();
        if (have_posts()) {
            ?>
            <div class="latest-news">
                <div class="row">
                    <?php
                    while (have_posts()) {
                        the_post();
                        $authorName = ucwords(get_the_author());
                        $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                        ?>
                        <div class="<?php echo esc_attr($column) ?>">
                            <div <?php post_class('provide-news wow fadeIn') ?>>
                                <div class="news-img <?php echo esc_attr($noThumb) ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                                    }
                                    if ($date == '1') {
                                        echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                                    }
                                    ?>
                                </div>
                                <?php if ($title == '1'): ?>
                                    <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                    <?php
                                endif;
                                if ($author == '1' || $comments == '1' || $views == '1'):
                                    ?>
                                    <ul class="meta">
                                        <?php if ($author == '1'): ?>
                                            <li class="posted-by"><?php esc_html_e('by', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                                        <?php if ($comments == '1'): ?>
                                            <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                    <?php if ($views == '1'): ?>
                                            <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                                    </ul>
                <?php endif; ?>
                            </div><!-- Provide News -->
                        </div>
                        <?php
                    }
                    $h->provide_pagi(array('total' => $wp_query->max_num_pages));
                    ?>
                </div>
            </div>
            <?php
        }
    }

    public function provide_listBlogStyle() {
        global $wp_query;
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogListStyleDate');
        $title = $h->provide_set($opt, 'optBlogListStyleTitle');
        $author = $h->provide_set($opt, 'optBlogListStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogListStyleComment');
        $views = $h->provide_set($opt, 'optBlogListStyleViews');
        $limit = $h->provide_set($opt, 'optBlogListStyleContentLimit');
        $sizes = array('m' => '515x388', 'i' => '715x548', 'w' => '370x279');
        $this->provide_isSearch();
        if (have_posts()) {
            ?>
            <div class="latest-news list-style">
                <?php
                while (have_posts()) {
                    the_post();
                    $authorName = ucwords(get_the_author());
                    $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                    ?>

                    <div <?php post_class('provide-news wow fadeIn') ?>>
                        <div class="news-img <?php echo esc_attr($noThumb) ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                            }
                            if ($date == '1') {
                                echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                            }
                            ?>
                        </div>
                        <div class="news-description">
                            <?php if ($title == '1'): ?>
                                <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                <?php
                            endif;
                            if (!empty($limit)) {
                                echo '<p>' . wp_trim_words(get_the_content(), $limit, '') . '</p>';
                            } else {
                                the_excerpt();
                            }
                            if ($author == '1' || $comments == '1' || $views == '1'):
                                ?>
                                <ul class="meta">
                                    <?php if ($author == '1'): ?>
                                        <li class="posted-by"><?php esc_html_e('by ', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                                    <?php if ($comments == '1'): ?>
                                        <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                                    <?php if ($views == '1'): ?>
                                        <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div><!-- Provide News -->
                    <?php
                }
                $h->provide_pagi(array('total' => $wp_query->max_num_pages));
                ?>
            </div>
            <?php
        }
    }

    public function provide_templatePrefix() {
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

        return $tp;
    }

    public function provide_isSearch() {
        global $wp_query;
        if (is_search()) {
            ?>
            <div class="search-result">
                <h3><?php esc_html_e('Search Result Found For', 'provide') ?>: <span>"<?php echo esc_html(get_search_query()) ?>"</span></h3>
                <p><?php
                    echo esc_html($wp_query->found_posts);
                    esc_html_e(' Result Found. If This is not what you search try again.', 'provide')
                    ?>
                </p>
                <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                    <input type="text" name="s" placeholder="<?php esc_html_e('Enter Your Keyword', 'provide') ?>"/>
                </form>
            </div>
            <?php
        }
    }

    public function provide_imageCoverBlogStyleTemplate() {
        global $wp_query;
        $tp = $this->provide_templatePrefix();
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogImageCoverStyleDate');
        $title = $h->provide_set($opt, 'optBlogImageCoverStyleTitle');
        $author = $h->provide_set($opt, 'optBlogImageCoverStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogImageCoverStyleComment');
        $views = $h->provide_set($opt, 'optBlogImageCoverStyleViews');
        $column = $h->provide_column('', 'opt' . $tp . 'Layout', 'opt' . $tp . 'Sidebar');
        if ($column == 'col-md-12') {
            $sizes = array('m' => '515x260', 'i' => '720x364', 'w' => '1170x591');
        } else {
            $sizes = array('m' => '267x135', 'i' => '720x364', 'w' => '870x440');
        }
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => ( isset($wp_query->query['paged']) ) ? $wp_query->query['paged'] : 1
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $authorName = ucwords(get_the_author());
                $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                ?>
                <div <?php post_class('provide-news wow fadeIn') ?>>
                    <div class="news-img <?php echo esc_attr($noThumb) ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                        }
                        if ($date == '1') {
                            echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                        }
                        ?>
                    </div>
                    <?php if ($title == '1'): ?>
                        <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                        <?php
                    endif;
                    if ($author == '1' || $comments == '1' || $views == '1'):
                        ?>
                        <ul class="meta">
                            <?php if ($author == '1'): ?>
                                <li class="posted-by"><?php esc_html_e('by ', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                            <?php if ($comments == '1'): ?>
                                <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                    <?php if ($views == '1'): ?>
                                <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                        </ul>
                <?php endif; ?>
                </div><!-- Provide News -->
                <?php
            }
            $h->provide_pagi(array('total' => $query->max_num_pages));
            wp_reset_postdata();
        }
    }

    public function provide_gridBlogStyleTemplate() {
        global $wp_query;
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogGridStyleDate');
        $title = $h->provide_set($opt, 'optBlogGridStyleTitle');
        $author = $h->provide_set($opt, 'optBlogGridStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogGridStyleComment');
        $views = $h->provide_set($opt, 'optBlogGridStyleViews');
        $column = $h->provide_set($opt, 'optBlogGridStyleColumn');

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => ( isset($wp_query->query['paged']) ) ? $wp_query->query['paged'] : 1
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            if ($column == 'col-md-6') {
                $sizes = array('m' => '325x220', 'i' => '470x354', 'w' => '570x429');
            } else if ($column == 'col-md-4') {
                $sizes = array('m' => '325x220', 'i' => '303x228', 'w' => '370x279');
            } else if ($column == 'col-md-3') {
                $sizes = array('m' => '325x220', 'i' => '220x165', 'w' => '270x203');
            }else {
                $sizes = array('m' => '325x220', 'i' => '470x354', 'w' => '570x429');
            }
            ?>
            <div class="latest-news">
                <div class="row">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        $authorName = ucwords(get_the_author());
                        $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                        ?>
                        <div class="<?php echo esc_attr($column) ?>">
                            <div <?php post_class('provide-news wow fadeIn') ?>>
                                <div class="news-img <?php echo esc_attr($noThumb) ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                                    }
                                    if ($date == '1') {
                                        echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                                    }
                                    ?>
                                </div>
                                <?php if ($title == '1'): ?>
                                    <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                    <?php
                                endif;
                                if ($author == '1' || $comments == '1' || $views == '1'):
                                    ?>
                                    <ul class="meta">
                                        <?php if ($author == '1'): ?>
                                            <li class="posted-by"><?php esc_html_e('by ', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                                        <?php if ($comments == '1'): ?>
                                            <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                    <?php if ($views == '1'): ?>
                                            <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                                    </ul>
                <?php endif; ?>
                            </div><!-- Provide News -->
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            $h->provide_pagi(array('total' => $query->max_num_pages));
            wp_reset_postdata();
        }
    }

    public function provide_listBlogStyleTemplate() {
        global $wp_query;
        $h = new provide_Helper();
        $opt = $h->provide_opt();
        $i = new provide_Imagify();
        $date = $h->provide_set($opt, 'optBlogListStyleDate');
        $title = $h->provide_set($opt, 'optBlogListStyleTitle');
        $author = $h->provide_set($opt, 'optBlogListStyleAuthor');
        $comments = $h->provide_set($opt, 'optBlogListStyleComment');
        $views = $h->provide_set($opt, 'optBlogListStyleViews');
        $limit = $h->provide_set($opt, 'optBlogListStyleContentLimit');
        $sizes = array('m' => '515x388', 'i' => '715x548', 'w' => '370x279');
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => ( isset($wp_query->query['paged']) ) ? $wp_query->query['paged'] : 1
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            ?>
            <div class="latest-news list-style">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $authorName = ucwords(get_the_author());
                    $noThumb = (!has_post_thumbnail() ) ? 'no-thumbnail' : '';
                    ?>

                    <div <?php post_class('provide-news wow fadeIn') ?>>
                        <div class="news-img <?php echo esc_attr($noThumb) ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                echo wp_kses($i->provide_thumb($sizes, true, array(true, true, true)), true);
                            }
                            if ($date == '1') {
                                echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                            }
                            ?>
                        </div>
                        <div class="news-description">
                            <?php if ($title == '1'): ?>
                                <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                <?php
                            endif;
                            if (!empty($limit)) {
                                echo '<p>' . wp_trim_words(get_the_content(), $limit, '') . '</p>';
                            } else {
                                the_excerpt();
                            }
                            if ($author == '1' || $comments == '1' || $views == '1'):
                                ?>
                                <ul class="meta">
                                    <?php if ($author == '1'): ?>
                                        <li class="posted-by"><?php esc_html_e('by ', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li><?php endif; ?>
                                    <?php if ($comments == '1'): ?>
                                        <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li><?php endif; ?>
                                    <?php if ($views == '1'): ?>
                                        <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li><?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div><!-- Provide News -->
                    <?php
                }
                $h->provide_pagi(array('total' => $query->max_num_pages));
                wp_reset_postdata();
                ?>
            </div>
            <?php
        }
    }

    public static function provide_singleton() {
        if (!isset(self::$instance)) {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }

        return self::$instance;
    }

    public function __clone() {
        trigger_error(esc_html__('Cloning the registry is not permitted', 'provide'), E_USER_ERROR);
    }

}
