<?php
$h = new provide_Helper();
$opt = $h->provide_opt();
if (post_password_required()) {
    return;
}
if (have_comments()) {
    ?>
    <div class="provide-comments">
        <div class="comments-count">
            <?php $h->provide_commentsNumber(_n_noop('%s comment', '%s comments', 'provide')) ?>
        </div>
        <ul>
            <?php
            wp_list_comments(array('short_ping' => true, 'callback' => 'provide_CommentsListing'));
            ?>
        </ul>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) {
            ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'provide'); ?></h2>
                <div class="nav-links">
                    <div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments', 'provide')); ?></div>
                    <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'provide')); ?></div>
                </div>
            </nav>
            <?php
        }
        if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) {
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'provide'); ?></p>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
    <div class="comment-form">
        <?php
        if (comments_open()) {
            provide_comment_form();
        }
        ?>
    </div>
<?php
function provide_comment_form($args = array(), $post_id = null)
{
    if (null === $post_id) {
        $post_id = get_the_ID();
    } else {
        $id = $post_id;
    }

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';
    $args = wp_parse_args($args);
    if (!isset($args['format'])) {
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    }
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html5 = 'html5' === $args['format'];
    $fields = array(
        'author' => '<div class="col-md-6"><label class="th-label">' . esc_html__('First Name', 'provide') . '*</label><input id="author" class="th-textfield" placeholder="' . esc_html__('Enter Your Name', 'provide') . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . ' /></div>',
        'email' => '<div class="col-md-6"><label class="th-label">' . esc_html__('Email', 'provide') . '*</label><input id="email" class="th-textfield" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__('Enter Email Address', 'provide') . '" /></div>',
        'url' => '<div class="col-md-12"><label class="th-label">' . esc_html__('Website', 'provide') . '*</label><input id="url" class="th-textfield" placeholder="' . esc_html__('Url', 'provide') . '" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '"  /></div>',
    );

    $required_text = sprintf(' ' . esc_html__('Required fields are marked %s', 'provide'), '<span class="required">*</span>');
    $defaults = array(
        'fields' => apply_filters('comment_form_default_fields', $fields),
        'comment_field' => '<div class="col-md-12"><label class="th-label">' . esc_html__('Comment', 'provide') . '</label><textarea class="th-textarea" id="comment" name="comment" aria-required="true" placeholder="' . esc_html__('Enter Your Comment', 'provide') . '" ></textarea></div>',
        'must_log_in' => '<p class="must-log-in">' . sprintf(esc_html__('You must be %s to post a comment.', 'provide'), '<a href="%s">' . esc_html__('logged in', 'provide') . '</a>', ucfirst(wp_login_url(apply_filters('the_permalink', get_permalink($post_id))))) . '</p>',
        'logged_in_as' => '<div class="col-md-12"><p class="logged-in-as">' . sprintf(esc_html__('Logged in as ', 'provide') . '<a href="%1$s">%2$s</a>. <a href="%3$s" title="' . esc_html__('Log out of this account', 'provide') . '">' . esc_html__('Log out', 'provide') . '?</a>', get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p></div>',
        'comment_notes_before' => esc_html__('Your email address will not be published.', 'provide'),
        'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf(esc_html__('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'provide'), ' <code>' . allowed_tags() . '</code>') . '</p>',
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => esc_html__('Leave a Comment', 'provide'),
        'title_reply_to' => esc_html__('Leave a Reply to %s', 'provide'),
        'cancel_reply_link' => esc_html__('Cancel reply', 'provide'),
        'label_submit' => esc_html__('POST COMMENT', 'provide'),
        'format' => 'xhtml',
    );
    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

    if (comments_open($post_id)) :
        do_action('comment_form_before');
        if (get_option('comment_registration') && !is_user_logged_in()) :
            echo wst_set($args, 'must_log_in');
            do_action('comment_form_must_log_in_after');
        else :
            ?>
            <div id="respond">
                <?php echo '<h3 class="border-title">' . $args['title_reply'] . '</h3>'; ?>
                <small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?></small>
                <div class="reply-form">
                    <form class="simple-form" action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="<?php echo esc_attr($args['id_form']); ?>" <?php echo esc_attr($html5) ? ' novalidate' : ''; ?>>
                        <div class="row">
                            <?php
                            do_action('comment_form_top');
                            if (is_user_logged_in()) :
                                echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity);
                                do_action('comment_form_logged_in_after', $commenter, $user_identity);
                            else :
                                do_action('comment_form_before_fields');
                                foreach ((array)$args['fields'] as $name => $field) {
                                    echo apply_filters("comment_form_field_{$name}", $field) . "\n";
                                }
                                do_action('comment_form_after_fields');
                            endif;
                            echo apply_filters('comment_form_field_comment', $args['comment_field']);
                            ?>
                            <div class="col-md-12">
                                <button type="submit" class="yellow-btn" id="<?php echo esc_attr($args['id_submit']); ?>"><?php echo esc_attr($args['label_submit']); ?></button>
                            </div>
                            <?php comment_id_fields($post_id); ?>
                        </div>
                        <?php do_action('comment_form', $post_id); ?>
                    </form>
                </div>
            </div>
            <?php
        endif;
        do_action('comment_form_after');
    else :
        do_action('comment_form_comments_closed');
    endif;
}

function provide_CommentsListing($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $noAvatar = (get_avatar($comment, 86) == '') ? 'no-avatar' : '';
    ?>
    <span>
    <div id="comment-<?php echo comment_ID(); ?>" itemprop="name" class="comment <?php echo esc_attr($noAvatar) ?>">
        <div class="comment-avatar">
            <?php echo get_avatar($comment, 86); ?>
        </div>
        <div class="comment-details">
            <div class="comment-info">
                <strong class="comment-author">
                    <?php echo ucfirst(get_comment_author_link()); ?>
                </strong>
            <span class="comment-time">
                <?php
                echo comment_date(get_option('post_format'));
                ?>
            </span>
            </div>
            <?php comment_text(); ?>
            <?php comment_reply_link(
                array_merge($args,
                    array(
                        'reply_text' => esc_html__('Reply ', 'provide') . '<i class="fa fa-reply"></i>',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth']
                    )))
            ?>
        </div>
    </div>
    <?php
}
	