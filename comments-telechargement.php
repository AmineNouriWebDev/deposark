<?php

/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required())
    return;
?>
<?php if (have_comments()) : ?>
    <div class="comments-area">
        <div class="comments-heading">
            <h3><?php comments_number(esc_html__('0 Commentaire', 'graphbit'), esc_html__('1 Commentaire', 'graphbit'), esc_html__('% Commentaires', 'graphbit')); ?></h3>
        </div>
        <div class="comments-list">
            <ul>
                <?php wp_list_comments('callback=graphbit_theme_comment'); ?>
            </ul>
        </div>
    </div>
    <?php
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
    ?>
        <div class="pagination_area">
            <nav>
                <ul class="pagination">
                    <li> <?php paginate_comments_links(
                                array(
                                    'prev_text' => wp_specialchars_decode('<i class="fa fa-angle-left"></i>', ENT_QUOTES),
                                    'next_text' => wp_specialchars_decode('<i class="fa fa-angle-right"></i>', ENT_QUOTES),
                                )
                            );  ?>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
    <!-- END PAGINATION -->
<?php endif; ?>
<?php
if (is_singular()) wp_enqueue_script("comment-reply");
$aria_req = ($req ? " aria-required='true'" : '');
$comment_args = array(
    'id_form' => '',
    'class_form' => '',
    'title_reply' => esc_html__('Laisser un commentaire', 'graphbit'),
    'title_reply_before' => '<h3 class="comment-reply-title">',
    'title_reply_after'  => '</h3>',
    'fields' => apply_filters('comment_form_default_fields', array(
        'author' => '<div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <input class="text-white" type="text" name="author" placeholder="' . esc_attr__('Nom Complet', 'graphbit') . '" required="' . esc_attr__('required', 'graphbit') . '" data-error="' . esc_attr__('Le nom est obligatoire.', 'graphbit') . '"/>
                                    </div>',
        'email' => '        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <input class="text-white" type="email" name="email" placeholder="' . esc_attr__('Addresse Email', 'graphbit') . '" required="' . esc_attr__('required', 'graphbit') . '" data-error="' . esc_attr__('Une adresse e-mail valide est requise.', 'graphbit') . '"/>
                                    </div>
                                </div>',
    )),
    'comment_field' => '<div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 comment-form-comment ">
                                        <textarea class="text-white" name="comment" id="message-box" cols="30" rows="10" placeholder="' . esc_attr__('Ecrire un commentaire...', 'graphbit') . '" required="' . esc_attr__('required', 'graphbit') . '" data-error="' . esc_attr__('S\'il vous plaît, laissez-nous un message.', 'graphbit') . '"></textarea>',
    'label_submit' =>   esc_html__('Poster le commentaire', 'graphbit'),
    'submit_button' =>  '<input class=" ready-btn coin-btn" type="submit" name="submit" id=" %2$s" value="' . esc_attr__('%4$s', 'graphbit') . '" />',
    'submit_field' =>   esc_attr__('%1$s', 'graphbit') . ' ' . esc_attr__('%2$s', 'graphbit') . '
                                    </div>
                                </div>',
    'comment_notes_before' => '',
    'comment_notes_after' => '',
)
?>
<?php if (comments_open()) : ?>
    <div class="comment-respond">
        <?php comment_form($comment_args); ?>
    </div>
<?php endif; ?>