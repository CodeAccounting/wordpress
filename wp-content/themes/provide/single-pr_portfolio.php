 <?php
 

$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $opt = $h->provide_opt();
    $h->provide_headerTop(get_the_ID());
    $layout = $h->provide_m('metaSingleLayout');
    
     echo 'test123';
    ?>
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pro-col">
                        <?php
                        if ($layout == 'one') {
                            include_once provide_Root . 'portfolio-style1.php';
                        } else if ($layout == 'two') {
                            include_once provide_Root . 'portfolio-style2.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
get_footer();
