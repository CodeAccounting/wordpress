<div class="widget-wrapper">
    <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Search Site', 'provide') ?>" name="s" id="s"/>
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>