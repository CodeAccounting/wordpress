<?php

class provide_price_table_VC_ShortCode extends provide_VC_ShortCode {

    public static function provide_price_table($atts = null) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Price Table", 'provide'),
                "base" => "provide_price_table_output",
                "icon" => 'provide_price_table_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__("Select Plans", 'provide'),
                        "param_name" => "plans",
                        "value" => ( new provide_Helper())->provide_posts('pr_price_table'),
                        "description" => esc_html__("Select price table from the list.", 'provide')
                    )
                )
            );

            return apply_filters('provide_price_table_output', $return);
        }
    }

    public static function provide_price_table_output($atts = null, $content = null) {
        include( provide_Root . 'app/lib/shortcodes/shortcode_atts.php' );
        ob_start();
        if (!empty($plans)) {
            $args = array(
                'post_type' => 'pr_price_table',
                'post_status' => 'publish',
                'post__in' => explode(',', $plans),
                'ignore_sticky_posts' => true,
            );
            $query = new WP_Query($args);
            ?>
            <div class="provide-pricings">
                <div class="row">
                    <?php
                    if ($query->have_posts()) {
                        $i = new provide_Imagify();
                        $sizes = array('m' => '321x262', 'i' => '321x262', 'w' => '321x262');
                        while ($query->have_posts()) {
                            $query->the_post();
                            $bg = $h->provide_m('metaBG');
                            $price = $h->provide_m('metaPlanPrice');
                            $symbol = $h->provide_m('metaCurrencySymbol');
                            $btnText = $h->provide_m('metaButtonText');
                            $btnLink = $h->provide_m('metaButtonLink');
                            $features = $h->provide_m('metaPlanFeatures');
                            $package = $h->provide_m('metaPlanType');
                            $show_plan = $h->provide_m('show_pricing_plan');
                            $src = '';
                            
                            if (!empty($bg)) {
                                $src = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $bg, 'c', true);
                            }else {
                                $src = provide_Uri. "/partial/images/pricetable-bg.png";
                            }
                            
                            ?>
                            <div class="col-md-4">
                                <div class="price-table" style="background-image: url(<?php echo esc_url($src) ?>)">
                                    <h3><i><?php echo esc_html($symbol) ?></i> 
                                        <?php echo esc_html($price) ?> 
                                        <?php if($show_plan == 'on') : ?>
                                        <i><?php echo ($package) ? '/ '.esc_html(ucfirst(str_replace('_', ' ', $package))) : ''; ?></i>
                                        <?php endif; ?>
                                    </h3>
                                    <strong><?php the_title() ?></strong>
                                        <?php if (!empty($features) && count($features) > 0): ?>
                                        <ul>
                                            <?php
                                            foreach ($features as $feature) {
                                                echo '<li>' . $feature . '</li>';
                                            }
                                            ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if (!empty($btnText)): ?>
                                        <a class="dark-btn" href="<?php echo esc_url($btnLink) ?>" title=""><?php echo esc_html($btnText) ?></a>
                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        $output = ob_get_contents();
        ob_clean();

        return do_shortcode($output);
    }

}
