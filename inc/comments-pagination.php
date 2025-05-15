<?php
// Comment Form
function graphbit_theme_comment($comment, $args, $depth)
{
    //echo 's';
    $GLOBALS['comment'] = $comment; ?>
    <?php if (get_avatar($comment, $size = '80') != '') { ?>
        <li>
            <div class="comments-details">
                <div class="comments-list-img">
                    <?php echo get_avatar($comment, $size = '80'); ?>
                </div>
                <div class="comments-content-wrap">
                    <span>
                        <b class="name"><?php printf(esc_html__('%s', 'graphbit'), get_comment_author_link()) ?></b>
                        <br>
                        <span class="post-time"><i class="fa fa-calendar"></i> <?php printf(
                                                                                    _x('%s ago', '%s = temps écoulé', 'graphbit'),
                                                                                    human_time_diff(get_comment_time('U'), current_time('timestamp'))
                                                                                );  ?></span>
                    </span>
                    <?php comment_text() ?>
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
            </div>
        </li>
    <?php } else { ?>
        <li>
            <div class="comments-details">
                <div class="comments-content-wrap">
                    <span>
                        <b class="name"><?php printf(esc_html__('%s', 'graphbit'), get_comment_author_link()) ?></b>
                        <br>
                        <span class="post-time"><i class="fa fa-calendar"></i> <?php printf(
                                                                                    _x('%s ago', '%s = temps écoulé', 'graphbit'),
                                                                                    human_time_diff(get_comment_time('U'), current_time('timestamp'))
                                                                                );  ?></span>
                    </span>
                    <?php comment_text() ?>
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
            </div>
        </li>
    <?php } ?>
<?php
}
function move_comment_field_to_bottom($fields)
{
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter('comment_form_fields', 'move_comment_field_to_bottom');


function graphbit_theme_scripts_styles()
{


    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');
}
add_action('wp_enqueue_scripts', 'graphbit_theme_scripts_styles');


// Charger le template de commentaires approprié
add_filter('comments_template', function ($template) {
    if (is_singular('telechargement')) {
        return locate_template('comments-telechargement.php');
    }
    return $template;
});

// Séparer les commentaires par type de contenu
add_action('pre_get_comments', function ($query) {
    if (is_admin()) return;

    if (isset($_GET['post_type']) && $_GET['post_type'] === 'telechargement') {
        $query->query_vars['post_type'] = 'telechargement';
    }
});
