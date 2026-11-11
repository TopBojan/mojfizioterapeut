<?php
$product_url = mf_guide_product_url();
$membership_url = mf_membership_url();
$eyebrow = isset($args['eyebrow']) ? $args['eyebrow'] : 'Video vežbe';
$title = isset($args['title']) ? $args['title'] : 'Ovaj sadržaj je otključan kupovinom vodiča.';
$text = isset($args['text']) ? $args['text'] : 'PDF vodič i video demonstracije dostupni su nakon jednokratne kupovine. Zakazivanje termina je deo LIVE pretplate.';
$login_title = isset($args['login_title']) ? $args['login_title'] : 'Već imate nalog?';
$product_label = isset($args['product_label']) ? $args['product_label'] : 'Kupi PDF vodič';
$membership_label = isset($args['membership_label']) ? $args['membership_label'] : 'Uzmi LIVE pretplatu';
$show_product = !isset($args['show_product']) || $args['show_product'];
?>
<div class="guide-locked">
    <div class="eyebrow"><?php echo esc_html($eyebrow); ?></div>
    <h1 class="heading h2"><?php echo esc_html($title); ?></h1>
    <p><?php echo wp_kses_post($text); ?></p>

    <?php if (!is_user_logged_in()) : ?>
        <div class="guide-login">
            <h2 class="heading h5"><?php echo esc_html($login_title); ?></h2>
            <?php
            wp_login_form(array(
                'redirect' => get_permalink(),
                'label_username' => 'Email ili korisničko ime',
                'label_password' => 'Lozinka',
                'label_remember' => 'Zapamti me',
                'label_log_in' => 'Prijavi se',
            ));
            ?>
        </div>
    <?php endif; ?>

    <div class="guide-locked-actions">
        <?php if ($show_product && $product_url && !mf_user_bought_guide()) : ?>
            <a class="button-primary" href="<?php echo esc_url($product_url); ?>"><?php echo esc_html($product_label); ?></a>
        <?php endif; ?>
        <?php if ($membership_url && !mf_user_has_membership()) : ?>
            <a class="button-outline" href="<?php echo esc_url($membership_url); ?>"><?php echo esc_html($membership_label); ?></a>
        <?php endif; ?>
    </div>
</div>
