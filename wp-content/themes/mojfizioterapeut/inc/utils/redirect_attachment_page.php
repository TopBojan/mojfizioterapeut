<?php
// redirect attachment page
// This helps in avoiding users landing on empty or irrelevant attachment pages.
add_action('template_redirect', 'redirect_attachment_page');

function redirect_attachment_page()
{
    if (is_attachment()) {
        global $post;
        if ($post && $post->post_parent) {
            wp_redirect(esc_url(get_permalink($post->post_parent)), 301);
            exit;
        } else {
            wp_redirect(esc_url(home_url('/')), 301);
            exit;
        }
    }
}
