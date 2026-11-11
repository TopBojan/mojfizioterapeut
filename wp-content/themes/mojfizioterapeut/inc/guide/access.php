<?php

/**
 * Guide product, PDF, and video-library access.
 */

define('MF_CALENDLY_CREDITS', 3);

function mf_guide_option_id($field)
{
    if (!function_exists('get_field')) {
        return 0;
    }

    $value = get_field($field, 'option');

    if (is_object($value) && isset($value->ID)) {
        return (int) $value->ID;
    }

    if (is_array($value) && isset($value['ID'])) {
        return (int) $value['ID'];
    }

    return absint($value);
}

function mf_guide_product_id()
{
    return mf_guide_option_id('guide_product');
}

function mf_guide_page_id()
{
    return mf_guide_option_id('guide_page');
}

function mf_guide_page_url()
{
    $page_id = mf_guide_page_id();

    return $page_id ? get_permalink($page_id) : '';
}

function mf_booking_page_id()
{
    return mf_guide_option_id('booking_page');
}

function mf_booking_page_url()
{
    $page_id = mf_booking_page_id();

    return $page_id ? get_permalink($page_id) : '';
}

function mf_guide_ensure_booking_page()
{
    if (mf_booking_page_id()) {
        return;
    }

    $existing = get_page_by_path('zakazivanje');
    $page_id = $existing ? (int) $existing->ID : 0;

    if (!$page_id) {
        $page_id = wp_insert_post(array(
            'post_title' => 'Zakazivanje',
            'post_name' => 'zakazivanje',
            'post_status' => 'publish',
            'post_type' => 'page',
        ));
    }

    if (!$page_id || is_wp_error($page_id)) {
        return;
    }

    update_post_meta($page_id, '_wp_page_template', 'page-templates/template-booking.php');

    if (function_exists('update_field')) {
        update_field('booking_page', $page_id, 'option');
    }
}
add_action('init', 'mf_guide_ensure_booking_page', 20);

function mf_header_account_url()
{
    $account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : '';

    if ($account_url) {
        return $account_url;
    }

    if (is_user_logged_in()) {
        return admin_url('profile.php');
    }

    return wp_login_url(home_url('/'));
}

function mf_guide_product_url()
{
    $product_id = mf_guide_product_id();

    return $product_id ? get_permalink($product_id) : '';
}

function mf_guide_pdf()
{
    if (!function_exists('get_field')) {
        return null;
    }

    $file = get_field('guide_pdf', 'option');

    return is_array($file) ? $file : null;
}

function mf_guide_pdf_path()
{
    $file = mf_guide_pdf();

    if (empty($file['ID'])) {
        return '';
    }

    $path = get_attached_file((int) $file['ID']);

    return ($path && file_exists($path)) ? $path : '';
}

function mf_user_bought_guide($user_id = 0)
{
    $user_id = $user_id ? (int) $user_id : get_current_user_id();
    $product_id = mf_guide_product_id();

    if (!$user_id || !$product_id || !function_exists('wc_customer_bought_product')) {
        return false;
    }

    $user = get_userdata($user_id);

    if (!$user) {
        return false;
    }

    return (bool) wc_customer_bought_product($user->user_email, $user_id, $product_id);
}

function mf_user_has_membership($user_id = 0)
{
    $user_id = $user_id ? (int) $user_id : get_current_user_id();

    if (!$user_id || !function_exists('pmpro_hasMembershipLevel')) {
        return false;
    }

    $level = function_exists('get_field') ? get_field('guide_membership_level', 'option') : '';

    if ($level) {
        return (bool) pmpro_hasMembershipLevel((int) $level, $user_id);
    }

    return (bool) pmpro_hasMembershipLevel(null, $user_id);
}

function mf_guide_access_is_shared()
{
    if (!function_exists('get_field')) {
        return false;
    }

    return (bool) get_field('guide_shared_access', 'option');
}

function mf_user_can_access_guide($user_id = 0)
{
    if (mf_user_bought_guide($user_id)) {
        return true;
    }

    return mf_guide_access_is_shared() && mf_user_has_membership($user_id);
}

function mf_user_can_access_booking($user_id = 0)
{
    if (mf_user_has_membership($user_id)) {
        return true;
    }

    return mf_guide_access_is_shared() && mf_user_bought_guide($user_id);
}

function mf_order_has_guide($order)
{
    $product_id = mf_guide_product_id();

    if (!$product_id || !$order) {
        return false;
    }

    foreach ($order->get_items() as $item) {
        if ((int) $item->get_product_id() === $product_id) {
            return true;
        }
    }

    return false;
}

function mf_guide_download_url()
{
    return wp_nonce_url(admin_url('admin-post.php?action=mf_guide_pdf'), 'mf_guide_pdf');
}

function mf_membership_url()
{
    if (!function_exists('pmpro_url')) {
        return '';
    }

    $level = function_exists('get_field') ? absint(get_field('guide_membership_level', 'option')) : 0;

    if ($level) {
        return pmpro_url('checkout', '?level=' . $level);
    }

    return home_url('/#paketi');
}
