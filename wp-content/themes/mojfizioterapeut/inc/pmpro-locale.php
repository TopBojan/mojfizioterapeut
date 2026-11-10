<?php
/**
 * Paid Memberships Pro loads its catalog for the logged-in user's language.
 * This site is Serbian, so member-facing screens follow the site language
 * even when an administrator's profile language is English.
 */
function mf_pmpro_use_site_locale($locale, $domain)
{
    if ('paid-memberships-pro' !== $domain) {
        return $locale;
    }

    if (is_admin() && !wp_doing_ajax()) {
        return $locale;
    }

    return get_locale();
}
add_filter('plugin_locale', 'mf_pmpro_use_site_locale', 10, 2);
