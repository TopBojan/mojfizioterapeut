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
