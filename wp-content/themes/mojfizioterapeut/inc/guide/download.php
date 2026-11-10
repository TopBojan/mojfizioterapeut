<?php

add_action('admin_post_mf_guide_pdf', 'mf_guide_download_pdf');

function mf_guide_download_pdf()
{
    if (!is_user_logged_in() || !wp_verify_nonce(isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '', 'mf_guide_pdf')) {
        wp_die(esc_html__('Morate biti prijavljeni da biste preuzeli vodič.', 'mojfizioterapeut'), 403);
    }

    if (!mf_user_can_access_guide()) {
        wp_die(esc_html__('Nemate pristup ovom vodiču.', 'mojfizioterapeut'), 403);
    }

    $path = mf_guide_pdf_path();

    if (!$path) {
        wp_die(esc_html__('PDF još nije postavljen.', 'mojfizioterapeut'), 404);
    }

    $filename = str_replace(array('"', '\\'), '', basename($path));

    nocache_headers();
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($path));
    header('X-Robots-Tag: noindex, nofollow');

    readfile($path);
    exit;
}
