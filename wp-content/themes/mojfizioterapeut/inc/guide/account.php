<?php

add_action('init', 'mf_guide_account_endpoint');

function mf_guide_account_endpoint()
{
    add_rewrite_endpoint('vodic', EP_PAGES);

    if (get_option('mf_vodic_endpoint') !== '1') {
        flush_rewrite_rules(false);
        update_option('mf_vodic_endpoint', '1');
    }
}

add_filter('woocommerce_get_query_vars', 'mf_guide_account_query_var');

function mf_guide_account_query_var($vars)
{
    $vars['vodic'] = 'vodic';

    return $vars;
}

add_filter('woocommerce_account_menu_items', 'mf_guide_account_menu');

function mf_guide_account_menu($items)
{
    $has_guide = mf_user_can_access_guide();
    $has_booking = mf_user_can_access_booking();

    if (!$has_guide && !$has_booking) {
        return $items;
    }

    if ($has_guide && $has_booking) {
        $label = 'Vodič i termini';
    } elseif ($has_guide) {
        $label = 'Moj vodič';
    } else {
        $label = 'Zakazivanje';
    }
    $updated = array();

    foreach ($items as $key => $label_item) {
        $updated[$key] = $label_item;

        if ($key === 'dashboard') {
            $updated['vodic'] = $label;
        }
    }

    if (!isset($updated['vodic'])) {
        $updated['vodic'] = $label;
    }

    return $updated;
}

add_action('woocommerce_account_vodic_endpoint', 'mf_guide_account_content');

function mf_guide_account_content()
{
    if (!mf_user_can_access_guide() && !mf_user_can_access_booking()) {
        echo '<p>Video vežbe i PDF otključava kupovina vodiča. Zakazivanje termina otključava LIVE pretplata.</p>';
        return;
    }

    get_template_part('template-parts/guide/account');
}
