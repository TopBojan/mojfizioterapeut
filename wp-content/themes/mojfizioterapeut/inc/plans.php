<?php

/**
 * Fill the membership level choices on each plan card.
 *
 * @param array $field ACF field.
 * @return array
 */
function mf_plan_membership_level_choices($field)
{
    $field['choices'] = array();

    if (!function_exists('pmpro_getAllLevels')) {
        return $field;
    }

    $levels = pmpro_getAllLevels(true, false);

    if (!is_array($levels)) {
        return $field;
    }

    foreach ($levels as $level) {
        if (empty($level->id)) {
            continue;
        }

        $field['choices'][(string) $level->id] = $level->name;
    }

    return $field;
}

add_filter('acf/load_field/key=field_mf_plans_item_level', 'mf_plan_membership_level_choices');

/**
 * Format an amount with the store currency.
 *
 * @param float $amount Amount.
 * @return string
 */
function mf_plain_price($amount)
{
    if (function_exists('wc_price')) {
        return trim(html_entity_decode(wp_strip_all_tags(wc_price($amount)), ENT_QUOTES, 'UTF-8'));
    }

    if (function_exists('pmpro_formatPrice')) {
        return trim(wp_strip_all_tags(pmpro_formatPrice($amount)));
    }

    return number_format((float) $amount, 0, ',', '.');
}

/**
 * Billing-period suffix for a membership level, such as "/ mesec".
 *
 * @param object $level PMPro level.
 * @return string
 */
function mf_membership_price_suffix($level)
{
    $amount = isset($level->billing_amount) ? (float) $level->billing_amount : 0;
    $count = isset($level->cycle_number) ? (int) $level->cycle_number : 0;
    $period = isset($level->cycle_period) ? strtolower((string) $level->cycle_period) : '';

    if ($amount <= 0 || $count < 1 || $period === '') {
        return '';
    }

    $one = array(
        'day' => 'dan',
        'week' => 'nedelju',
        'month' => 'mesec',
        'year' => 'godinu',
    );
    $many = array(
        'day' => 'dana',
        'week' => 'nedelja',
        'month' => 'meseca',
        'year' => 'godina',
    );

    if (!isset($one[$period])) {
        return '';
    }

    if ($count === 1) {
        return '/ ' . $one[$period];
    }

    return '/ ' . $count . ' ' . $many[$period];
}

/**
 * Price, title, and button for the current plan row.
 *
 * Call inside the plans repeater loop.
 *
 * @return array{title: string, price: string, suffix: string, button: array|false}
 */
function mf_plan_card()
{
    $source = (string) get_sub_field('source');
    $title = trim((string) get_sub_field('title'));
    $price = trim((string) get_sub_field('price'));
    $suffix = trim((string) get_sub_field('price_suffix'));
    $button = get_sub_field('button');
    $url = '';

    if ($source === 'product') {
        $product_id = (int) get_sub_field('product');
        $product = ($product_id && function_exists('wc_get_product')) ? wc_get_product($product_id) : null;

        if ($product) {
            $title = $product->get_name();
            $price = mf_plain_price($product->get_price());
            $url = get_permalink($product->get_id());
        }
    } elseif ($source === 'membership') {
        $level_id = (int) get_sub_field('membership_level');
        $level = ($level_id && function_exists('pmpro_getLevel')) ? pmpro_getLevel($level_id) : null;

        if ($level) {
            $title = $level->name;
            $amount = ((float) $level->billing_amount > 0) ? (float) $level->billing_amount : (float) $level->initial_payment;
            $price = mf_plain_price($amount);

            if ($suffix === '') {
                $suffix = mf_membership_price_suffix($level);
            }

            if (function_exists('pmpro_url')) {
                $url = pmpro_url('checkout', '?level=' . (int) $level->id);
            }
        }
    }

    if ($url) {
        if (!is_array($button)) {
            $button = array();
        }

        $button['url'] = $url;

        if (empty($button['title'])) {
            $button['title'] = $title !== '' ? $title : 'Izaberi';
        }

        if (empty($button['target'])) {
            $button['target'] = '';
        }
    }

    return array(
        'title' => $title,
        'price' => $price,
        'suffix' => $suffix,
        'button' => $button,
    );
}
