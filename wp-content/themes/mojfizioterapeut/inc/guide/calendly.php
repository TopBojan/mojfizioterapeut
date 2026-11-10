<?php

add_action('pmpro_after_change_membership_level', 'mf_calendly_grant_credits', 10, 2);
add_action('pmpro_subscription_payment_completed', 'mf_calendly_grant_credits_on_renewal');
add_action('rest_api_init', 'mf_calendly_register_webhook');

function mf_calendly_credits($user_id = 0)
{
    $user_id = $user_id ? (int) $user_id : get_current_user_id();

    if (!$user_id || !mf_user_has_membership($user_id)) {
        return 0;
    }

    $credits = get_user_meta($user_id, 'mf_calendly_credits', true);

    if ($credits === '') {
        update_user_meta($user_id, 'mf_calendly_credits', MF_CALENDLY_CREDITS);
        return MF_CALENDLY_CREDITS;
    }

    return max(0, (int) $credits);
}

function mf_calendly_grant_credits($level_id, $user_id)
{
    if ((int) $level_id > 0 && (int) $user_id > 0) {
        update_user_meta((int) $user_id, 'mf_calendly_credits', MF_CALENDLY_CREDITS);
    }
}

function mf_calendly_grant_credits_on_renewal($order)
{
    $user_id = 0;

    if (is_object($order) && !empty($order->user_id)) {
        $user_id = (int) $order->user_id;
    }

    if ($user_id && mf_user_has_membership($user_id)) {
        update_user_meta($user_id, 'mf_calendly_credits', MF_CALENDLY_CREDITS);
    }
}

function mf_calendly_register_webhook()
{
    register_rest_route('mf/v1', '/calendly', array(
        'methods'             => 'POST',
        'callback'            => 'mf_calendly_webhook',
        'permission_callback' => '__return_true',
    ));
}

function mf_calendly_signature_ok($body, $header, $secret)
{
    if (!$body || !$header || !$secret) {
        return false;
    }

    $parts = array();

    foreach (explode(',', $header) as $piece) {
        $pair = explode('=', trim($piece), 2);

        if (count($pair) === 2) {
            $parts[$pair[0]] = $pair[1];
        }
    }

    if (empty($parts['t']) || empty($parts['v1'])) {
        return false;
    }

    $expected = hash_hmac('sha256', $parts['t'] . '.' . $body, $secret);

    return hash_equals($expected, $parts['v1']);
}

function mf_calendly_webhook(WP_REST_Request $request)
{
    $secret = function_exists('get_field') ? (string) get_field('calendly_webhook_secret', 'option') : '';
    $body = $request->get_body();
    $header = $request->get_header('calendly-webhook-signature');

    if (!$secret || !mf_calendly_signature_ok($body, $header, $secret)) {
        return new WP_REST_Response(array('ok' => false), 401);
    }

    $data = json_decode($body, true);

    if (!is_array($data) || ($data['event'] ?? '') !== 'invitee.created') {
        return new WP_REST_Response(array('ok' => true, 'ignored' => true), 200);
    }

    $email = sanitize_email($data['payload']['email'] ?? '');
    $event_uri = sanitize_text_field($data['payload']['scheduled_event']['uri'] ?? ($data['payload']['uri'] ?? ''));
    $user = $email ? get_user_by('email', $email) : false;

    if (!$user || !$event_uri || !mf_user_has_membership($user->ID)) {
        return new WP_REST_Response(array('ok' => true, 'matched' => false), 200);
    }

    $seen = get_user_meta($user->ID, 'mf_calendly_event_uris', true);
    $seen = is_array($seen) ? $seen : array();

    if (!in_array($event_uri, $seen, true)) {
        $credits = mf_calendly_credits($user->ID);

        if ($credits > 0) {
            update_user_meta($user->ID, 'mf_calendly_credits', $credits - 1);
        }

        $seen[] = $event_uri;
        update_user_meta($user->ID, 'mf_calendly_event_uris', $seen);
    }

    return new WP_REST_Response(array('ok' => true), 200);
}
