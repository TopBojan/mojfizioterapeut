<?php
add_action('wp_enqueue_scripts', 'wp_theme_header_scripts');

function wp_theme_header_scripts()
{
    // Enqueue mainscript
    wp_enqueue_script('mainscript', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.01', true);

    // Pass ajax_url to scripts.js
    wp_localize_script('mainscript', 'afp_vars', array(
        'afp_nonce' => wp_create_nonce('afp_nonce'), // Create nonce for AJAX request
        'afp_ajax_url' => admin_url('admin-ajax.php')
    ));
}
