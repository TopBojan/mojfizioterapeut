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

    acf_add_options_sub_page(array(
        'page_title'  => 'Header and footer',
        'menu_title'  => 'Header and footer',
        'parent_slug' => 'theme-general-settings',
        'menu_slug'   => 'theme-header-footer',
    ));

    acf_add_options_sub_page(array(
        'page_title'  => 'Guide',
        'menu_title'  => 'Guide',
        'parent_slug' => 'theme-general-settings',
        'menu_slug'   => 'theme-guide',
    ));
}
