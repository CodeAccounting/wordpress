<?php
$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $opt = $h->provide_opt();
    $h->provide_headerTop(get_the_ID());
    $sizes = array('m' => '614x629', 'i' => '715x733', 'w' => '585x600');
    $i = new provide_Imagify();
    $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
    $designation = $h->provide_m('metaDesignation');
    $social = $h->provide_m('metaSocialProfiler');
    $skills = $h->provide_m('metaMemberSkill');
    ?>
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pro-col">
                        <div class="team-detail-page <?php echo esc_attr($noThumb) ?>">
                            <div class="team-img">
                                <?php
                                if (has_post_thumbnail()) {
                                    echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                }
                                ?>
                                <?php if (!empty($social) && count($social) > 0): ?>
                                    <ul>
                                        <?php
                                        foreach ($social as $s) {
                                            echo '<li><a href="' . esc_url($h->provide_set($s, 'metaProfileLink')) . '" title="" style="background:' . esc_url($h->provide_set($s, 'metaProfileSocialColor')) . '"><i class="fa ' . esc_attr($h->provide_set($s, 'metaProfileIcon')) . '"></i></a></li>';
                                        }
                                        ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="team-detail">
                                <h2><?php the_title() ?></h2>
                                <span><?php echo esc_attr($designation) ?></span>
                                <?php the_content() ?>

                                <?php if (!empty($skills) && count($skills) > 0): ?>
                                    <div class="provide-skills style2">
                                        <?php
                                        foreach ($skills as $s) {
                                            ?>
                                            <div class="provide-bar wow fadeIn">
                                                <strong><?php echo esc_html($h->provide_set($s, 'metaSkillName')) ?> - (<?php echo esc_html($h->provide_set($s, 'metaSkillPercentage')) ?>%)</strong>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width:<?php echo esc_attr($h->provide_set($s, 'metaSkillPercentage')) ?>%;"></div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div><!-- Team Detail -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
get_footer();
