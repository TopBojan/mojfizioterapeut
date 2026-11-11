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
    <div class="eyebrow">Uključeno u pretplatu</div>
    <h2 class="heading h4">Zakaži termin</h2>
    <p>U ovom periodu imate <?php echo (int) MF_CALENDLY_CREDITS; ?> termina. Preostalo: <strong id="guide-calendly-remaining"><?php echo (int) $credits; ?></strong>.</p>

    <?php if (mf_user_has_membership() && $credits < 1) : ?>
        <p>Iskoristili ste sva tri termina. Novi termini se otvaraju kada se pretplata obnovi.</p>
    <?php elseif ($embed) : ?>
        <div class="calendly-inline-widget" data-url="<?php echo esc_url($embed); ?>"></div>
        <script src="https://assets.calendly.com/assets/external/widget.js" async></script>
        <script>
            window.addEventListener("message", function (event) {
                var payload = event.data && event.data.payload;
                var eventUri = payload && payload.event && payload.event.uri;

                if (event.origin !== "https://calendly.com" || !event.data || event.data.event !== "calendly.event_scheduled" || !eventUri) {
                    return;
                }

                fetch(<?php echo wp_json_encode(rest_url('mf/v1/calendly-booked')); ?>, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "X-WP-Nonce": <?php echo wp_json_encode(wp_create_nonce('wp_rest')); ?>
                    },
                    body: JSON.stringify({ event_uri: eventUri })
                }).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    var remaining = document.getElementById("guide-calendly-remaining");

                    if (remaining && typeof data.credits === "number") {
                        remaining.textContent = String(data.credits);
                    }
                });
            });
        </script>
    <?php else : ?>
        <p>Link za zakazivanje još nije podešen.</p>
    <?php endif; ?>
</section>
