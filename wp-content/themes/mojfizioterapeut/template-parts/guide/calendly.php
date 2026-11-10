<?php
$url = function_exists('get_field') ? get_field('calendly_url', 'option') : '';
$credits = mf_calendly_credits();
$user = wp_get_current_user();
$embed = $url;

if ($embed && $user && $user->user_email) {
    $embed = add_query_arg(array(
        'email' => $user->user_email,
        'name'  => trim($user->first_name . ' ' . $user->last_name),
    ), $url);
}
?>
<section class="guide-calendly">
    <div class="eyebrow"><?php echo esc_html(mf_user_has_membership() ? 'Uključeno u pretplatu' : 'Otvoreno uz vodič'); ?></div>
    <h2 class="heading h4">Zakaži termin</h2>
    <?php if (mf_user_has_membership()) : ?>
        <p>U ovom periodu imate <?php echo (int) MF_CALENDLY_CREDITS; ?> termina. Preostalo: <strong><?php echo (int) $credits; ?></strong>.</p>
    <?php else : ?>
        <p>Izaberite slobodan termin.</p>
    <?php endif; ?>

    <?php if (mf_user_has_membership() && $credits < 1) : ?>
        <p>Iskoristili ste sva tri termina. Novi termini se otvaraju kada se pretplata obnovi.</p>
    <?php elseif ($embed) : ?>
        <div class="calendly-inline-widget" data-url="<?php echo esc_url($embed); ?>"></div>
        <script src="https://assets.calendly.com/assets/external/widget.js" async></script>
    <?php else : ?>
        <p>Link za zakazivanje još nije podešen.</p>
    <?php endif; ?>
</section>
