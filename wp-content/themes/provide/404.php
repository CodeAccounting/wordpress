<?php
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop(get_the_ID());
$text = $h->provide_set($opt, 'opt404Text');
$bottomText = $h->provide_set($opt, 'opt404BottomText');
$bottomDesc = $h->provide_set($opt, 'opt404BottomDesc');
$buttonText = $h->provide_set($opt, 'opt404ButtonText');
?>
    <section>
        <div class="block less-space">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="error-page">
                            <?php
                            if (!empty($text)) {
                                echo '<h1>' . esc_html($text) . '</h1>';
                            }
                            if (!empty($bottomText)) {
                                echo '<strong>' . esc_html($bottomText) . '</strong>';
                            }
                            if (!empty($bottomDesc)) {
                                echo '<p>' . esc_html($bottomDesc) . '</p>';
                            }
                            if (!empty($buttonText)) {
                                echo ' <a class="color-btn" href="' . esc_url(home_url('/')) . '" title="">' . esc_html($buttonText) . '</a>';
                            }
                            ?>
                        </div><!-- Error Page -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
