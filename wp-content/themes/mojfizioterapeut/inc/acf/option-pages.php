<?php
// options page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'General options',
        'menu_title'    => 'General options',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => true
    ));
}
