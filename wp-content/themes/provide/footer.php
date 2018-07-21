<?php
$h = new provide_Helper();
$opt = $h->provide_opt();
$isFooter = $h->provide_set($opt, 'optFooter');
$isCopyright = $h->provide_set($opt, 'optShowCopyright');
$copy = $h->provide_set($opt, 'optFooterCopyright');
$position = ($h->provide_set($opt, 'optCopyrightFixed')) ? 'footer-fixed' : '';;


if ($isFooter == '1' && is_active_sidebar('footer-widget-area')) {
    ?>
    <footer>
        <div class="container">
            <div class="row">
                <?php
                if (is_active_sidebar('footer-widget-area')) {
                    dynamic_sidebar('footer-widget-area');
                }
                ?>
            </div>
        </div>
    </footer>
    <?php
}

if ($isCopyright == 1 && ($copy != '')):
    ?>
    <div class="bottom-strip <?php echo esc_attr($position); ?>">
        <div class="container"><?php echo esc_html($copy) ?></div>
    </div>
<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
