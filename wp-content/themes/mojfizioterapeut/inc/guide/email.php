<?php

add_action('woocommerce_payment_complete', 'mf_guide_send_access_email');
add_action('woocommerce_order_status_processing', 'mf_guide_send_access_email');
add_action('woocommerce_order_status_completed', 'mf_guide_send_access_email');

function mf_guide_send_access_email($order_id)
{
    if (!function_exists('wc_get_order')) {
        return;
    }

    $order = wc_get_order($order_id);

    if (!$order || $order->get_meta('_mf_guide_email_sent')) {
        return;
    }

    if (!in_array($order->get_status(), array('processing', 'completed'), true)) {
        return;
    }

    if (!mf_order_has_guide($order)) {
        return;
    }

    $email = $order->get_billing_email();

    if (!$email) {
        return;
    }

    $page_url = mf_guide_page_url();
    $account_url = wc_get_page_permalink('myaccount');
    $name = $order->get_billing_first_name();
    $pdf_path = mf_guide_pdf_path();

    $message = '<p>Zdravo' . ($name ? ' ' . esc_html($name) : '') . ',</p>';
    $message .= '<p>Hvala na kupovini. PDF vodič je sada na vašem profilu i možete ga preuzeti kad god poželite.</p>';

    if ($account_url) {
        $message .= '<p><a href="' . esc_url($account_url) . '">Otvorite profil</a></p>';
    }

    if ($page_url) {
        $message .= '<p>Video vežbe i PDF vodič su na posebnoj stranici, dostupnoj sa naloga kojim ste kupili vodič:</p>';
        $message .= '<p><a href="' . esc_url($page_url) . '">' . esc_html($page_url) . '</a></p>';
    }

    if (!$pdf_path) {
        $message .= '<p>PDF fajl će se pojaviti na profilu čim bude postavljen.</p>';
    }

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $attachments = $pdf_path ? array($pdf_path) : array();
    $sent = wp_mail($email, 'Vaš PDF vodič', $message, $headers, $attachments);

    if ($sent) {
        $order->update_meta_data('_mf_guide_email_sent', 1);
        $order->save();
    }
}
