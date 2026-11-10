<?php
/*
 *  Author: Presta Team
 *  URL: wearepresta.com
 */

function theme_setup()
{
    // Add support for document title tag
    add_theme_support('title-tag');
    add_theme_support('woocommerce');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');

    // Add Post Taxonomies Support
    add_theme_support('post-taxonomies');

    // Add Post Formats Support
    // add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video']);


    register_nav_menus(array(
        'header-menu' => 'Header Menu',
        'extra-menu' => 'Extra Menu'
    ));

    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // add_theme_support('custom-logo');

    // add_theme_support('align-wide');
    // add_theme_support('wp-block-styles');

    // add_theme_support('editor-styles');
    // add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Remove junk
 * Taken from https://github.com/benchmarkstudios/barebones/blob/master/functions.php
 */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts()
{
    wp_deregister_script('wp-embed');
}

add_action('wp_footer', 'deregister_scripts');


/**
 * Remove unnecessary styles
 *
 * @return void
 */

function deregister_styles()
{
    wp_dequeue_style('wp-block-library');
}

add_action('wp_print_styles', 'deregister_styles', 100);


/**
 * Remove comments feed
 * Taken from https://github.com/benchmarkstudios/barebones/blob/master/functions.php
 *
 * @return void
 */

function theme_post_comments_feed_link()
{
    return;
}

add_filter('post_comments_feed_link', 'theme_post_comments_feed_link');
/*
 * Remove default images and set new image sizes
 */

if (!function_exists('remove_default_images')) {

    function remove_default_images($sizes)
    {
        unset($sizes['medium']);
        unset($sizes['large']);
        unset($sizes['medium_large']);
        return $sizes;
    }
}

if (!function_exists('theme_image_sizes')) {
    function theme_image_sizes()
    {
        set_post_thumbnail_size(1110, 420, array('center', 'center')); // 16:9
        add_image_size('large-img', 1920, 800);
        add_image_size('medium-img', 860, 400);
        add_image_size('small-img', 640, 267);
    }
    add_action('after_setup_theme', 'theme_image_sizes');
}

/**
 * Enqueueing scripts and styles
 */

require get_template_directory() . '/inc/enqueue/enqueue-scripts.php';
require get_template_directory() . '/inc/enqueue/enqueue-styles.php';



/**
 * defer/async scripts.
 */
require get_template_directory() . '/inc/enqueue/defer_async.php';


/*
 * WP Admin Customization
 */

require_once get_template_directory() . '/inc/admin/admin-branding.php';

$args = array(
    'login_url'       => home_url('/'),
    'login_image'     => get_template_directory_uri() . '/assets/images/presta.svg',
    'login_title'     => get_bloginfo('name', 'display'),
    'login_height'    => '180px',
    'login_width'     => '326px',
    'designer_url'    => 'https://wearepresta.com',
    'designer_anchor' => 'Presta',
    'favicon_url'     => TRUE,
    'remove_wp'       => TRUE,
    'remove_gravatar' => FALSE,
    'login_style'     => get_template_directory_uri() . '/admin-login.css' // Pointing to a 'admin-login.css' file in the theme's root directory
);
$wp_basis_admin_branding = new Wp_Basis\Admin_Branding\Wp_Basis_Admin_Branding($args);


/* 
 * Register ACF Option pages
 */
require get_template_directory() . '/inc/acf/option-pages.php';
require get_template_directory() . '/inc/acf/register-acf-blocks.php';
require get_template_directory() . '/inc/template-functions.php';


/* 
 * Navigation 
 */

// Add li class
require get_template_directory() . '/inc/nav-menu/add_li_class.php';

// Add 'Submenu' class 
require get_template_directory() . '/inc/nav-menu/add_submenu_class.php';


// Theme nav
require get_template_directory() . '/inc/nav-menu/theme_nav.php';


/* 
 * Registering custom post types
*/

require get_template_directory() . '/inc/custom-post-types/services-csp.php';


/* 
 * Utils
 */
// Redirect attachment page
require get_template_directory() . '/inc/utils/redirect_attachment_page.php';
// Add google tag to head
require get_template_directory() . '/inc/utils/add_gtag.php';
// Add Custom Responsive Image Function
require get_template_directory() . '/inc/utils/responsive-image.php';
// Allow SVG uploads in the media library
require get_template_directory() . '/inc/utils/svg-upload.php';

require get_template_directory() . '/inc/guide/access.php';
require get_template_directory() . '/inc/guide/download.php';
require get_template_directory() . '/inc/guide/email.php';
require get_template_directory() . '/inc/guide/account.php';
require get_template_directory() . '/inc/guide/calendly.php';
require get_template_directory() . '/inc/woocommerce.php';
require get_template_directory() . '/inc/pmpro-locale.php';
