<?php
// Register Custom Post Type
add_action('init', 'create_post_types');

function create_post_types()
{

    $labels_questions = array(
        'name' => 'Services',
        'singular_name' => 'Service'
    );

    $args_questions = array(
        'labels' => $labels_questions,
        'public' => true,
        'hierarchical' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ),
        'can_export' => true
    );

    register_post_type('services', $args_questions);
}
