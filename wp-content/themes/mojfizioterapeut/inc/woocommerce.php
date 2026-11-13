<?php

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

add_action('woocommerce_single_product_summary', 'mf_product_description', 25);

function mf_product_description()
{
    if (!is_product()) {
        return;
    }

    $description = get_the_content();

    if ($description === '') {
        return;
    }

    echo '<div class="product-description">';
    echo apply_filters('the_content', $description);
    echo '</div>';
}

add_action('woocommerce_checkout_before_order_review_heading', 'mf_checkout_summary_open', 5);
add_action('woocommerce_checkout_after_order_review', 'mf_checkout_summary_close', 20);

function mf_checkout_summary_open()
{
    echo '<div class="mf-checkout-summary">';
}

function mf_checkout_summary_close()
{
    echo '</div>';
}

add_filter('woocommerce_checkout_fields', 'mf_minimal_checkout_fields');

function mf_minimal_checkout_fields($fields)
{
    $hidden = array(
        'billing_company',
        'billing_country',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_phone',
    );

    foreach ($hidden as $key) {
        unset($fields['billing'][$key]);
    }

    if (isset($fields['order']['order_comments'])) {
        unset($fields['order']['order_comments']);
    }

    return $fields;
}

add_filter('woocommerce_checkout_posted_data', 'mf_checkout_default_country');

function mf_checkout_default_country($data)
{
    if (empty($data['billing_country'])) {
        $data['billing_country'] = 'RS';
    }

    return $data;
}

add_action('woocommerce_checkout_create_order', 'mf_checkout_order_country');

function mf_checkout_order_country($order)
{
    if ($order->get_billing_country() === '') {
        $order->set_billing_country('RS');
    }
}

add_action('template_redirect', 'mf_hide_shop_page');

function mf_hide_shop_page()
{
    if (is_admin() || !function_exists('is_shop') || !is_shop()) {
        return;
    }

    global $wp_query;

    $wp_query->set_404();
    status_header(404);
    nocache_headers();
}

add_filter('woocommerce_return_to_shop_redirect', 'mf_hide_shop_return_url');

function mf_hide_shop_return_url()
{
    return home_url('/');
}

add_filter('woocommerce_currency_symbol', 'mf_latin_currency_symbol', 10, 2);

function mf_latin_currency_symbol($symbol, $currency)
{
    if ($currency === 'RSD') {
        return 'RSD';
    }

    return $symbol;
}

add_filter('woocommerce_get_breadcrumb', 'mf_hide_uncategorized_crumb');

function mf_hide_uncategorized_crumb($crumbs)
{
    return array_values(array_filter($crumbs, function ($crumb) {
        $label = isset($crumb[0]) ? wp_strip_all_tags($crumb[0]) : '';

        return !in_array($label, array('Uncategorized', 'Nekategorisano', 'Некатегорисано'), true);
    }));
}

add_filter('get_the_terms', 'mf_hide_uncategorized_product_cat', 10, 3);

function mf_hide_uncategorized_product_cat($terms, $post_id, $taxonomy)
{
    if ($taxonomy !== 'product_cat' || !is_array($terms) || is_admin()) {
        return $terms;
    }

    return array_values(array_filter($terms, function ($term) {
        return !($term instanceof WP_Term) || !in_array($term->slug, array('uncategorized', 'nekategorisano'), true);
    }));
}

add_filter('load_script_translations', 'mf_latinize_script_translations');

function mf_latinize_script_translations($translations)
{
    global $wppSrLatin;

    if (!is_string($translations) || $translations === '' || !isset($wppSrLatin)) {
        return $translations;
    }

    $decoded = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($matches) {
        $code = hexdec($matches[1]);

        if ($code < 0x0400 || $code > 0x04FF) {
            return $matches[0];
        }

        return mb_chr($code, 'UTF-8');
    }, $translations);

    return $wppSrLatin->convert_script($decoded);
}
