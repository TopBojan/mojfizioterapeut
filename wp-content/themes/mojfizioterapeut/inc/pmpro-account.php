<?php

add_action('init', 'mf_pmpro_account_endpoint');

function mf_pmpro_account_endpoint()
{
    add_rewrite_endpoint('pretplata', EP_PAGES);

    if (get_option('mf_pretplata_endpoint') !== '1') {
        flush_rewrite_rules(false);
        update_option('mf_pretplata_endpoint', '1');
    }
}

add_filter('woocommerce_get_query_vars', 'mf_pmpro_account_query_var');

function mf_pmpro_account_query_var($vars)
{
    $vars['pretplata'] = 'pretplata';

    return $vars;
}

add_filter('woocommerce_account_menu_items', 'mf_pmpro_account_menu', 20);

function mf_pmpro_account_menu($items)
{
    if (!shortcode_exists('pmpro_account')) {
        return $items;
    }

    $updated = array();

    foreach ($items as $key => $label) {
        $updated[$key] = $label;

        if ($key === 'dashboard') {
            $updated['pretplata'] = 'Pretplata';
        }
    }

    if (!isset($updated['pretplata'])) {
        $updated = array('pretplata' => 'Pretplata') + $updated;
    }

    return $updated;
}

add_filter('woocommerce_endpoint_pretplata_title', 'mf_pmpro_account_title');

function mf_pmpro_account_title()
{
    return 'Pretplata';
}

add_action('woocommerce_account_pretplata_endpoint', 'mf_pmpro_account_content');

function mf_pmpro_account_content()
{
    if (!shortcode_exists('pmpro_account')) {
        echo '<p>Članstvo trenutno nije dostupno.</p>';
        return;
    }

    echo '<div class="mf-membership-account">';
    echo do_shortcode('[pmpro_account sections="membership,invoices"]');
    echo '</div>';
}

add_filter('pmpro_url', 'mf_pmpro_hide_levels_url', 20, 3);

function mf_pmpro_hide_levels_url($url, $page, $querystring)
{
    if ($page !== 'levels') {
        return $url;
    }

    $checkout = mf_pmpro_levels_destination();

    return $checkout ? $checkout : $url;
}

add_action('wp', 'mf_pmpro_redirect_levels_page', 1);

function mf_pmpro_redirect_levels_page()
{
    if (is_admin() || empty($GLOBALS['pmpro_pages']['levels']) || !is_page((int) $GLOBALS['pmpro_pages']['levels'])) {
        return;
    }

    $target = mf_pmpro_levels_destination();

    if ($target) {
        wp_safe_redirect($target, 301);
        exit;
    }
}

function mf_pmpro_levels_destination()
{
    $level = function_exists('get_field') ? absint(get_field('guide_membership_level', 'option')) : 0;

    if ($level && function_exists('pmpro_url')) {
        return pmpro_url('checkout', '?level=' . $level);
    }

    return home_url('/#paketi');
}
