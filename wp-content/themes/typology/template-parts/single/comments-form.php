<?php
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $comment_form_args = array(
        'title_reply' => '',
        'label_submit' => __typology( 'comment_submit' ),
        'cancel_reply_link' => __typology( 'comment_cancel_reply' ),
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . __typology( 'comment_text' ) .'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .'</textarea></p>',
        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' =>
                '<p class="comment-form-author">' .
                '<label for="author">' . __typology( 'comment_name' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                '" size="30"' . $aria_req . ' /></p>',

                'email' =>
                '<p class="comment-form-email"><label for="email">' . __typology( 'comment_email' ) . ( $req ? '<span class="required"> *</span>' : '' ).'</label> '  .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                '" size="30"' . $aria_req . ' /></p>',

                'url' =>
                '<p class="comment-form-url"><label for="url">' .
                __typology( 'comment_website' ) . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                '" size="30" /></p>'
            ) ),
    );

    comment_form( $comment_form_args );

?>