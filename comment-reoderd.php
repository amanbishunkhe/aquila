<?php

function reorder_comment_fields($fields) {
    // Save the comment field in a variable and remove it from the array
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    
    // Create a new array with the desired order
    $new_fields = array(
        'author' => $fields['author'],
        'email' => $fields['email'],
        'url' => isset($fields['url']) ? $fields['url'] : '', // Check if URL field exists
        'comment' => $comment_field,
    );

    return $new_fields;
}
add_filter('comment_form_fields', 'reorder_comment_fields');
