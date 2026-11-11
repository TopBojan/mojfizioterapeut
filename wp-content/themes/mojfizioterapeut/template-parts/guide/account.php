<?php
$can_guide = mf_user_can_access_guide();
$can_book = mf_user_can_access_booking();
$page_url = mf_guide_page_url();
$booking_url = mf_booking_page_url();
?>
<div class="guide-account">
    <?php if ($can_guide) : ?>
        <h2 class="heading h4">Moj vodič</h2>
        <p>Video vežbe i PDF vodič su na stranici vodiča.</p>
        <?php if ($page_url) : ?>
            <p><a class="button-primary" href="<?php echo esc_url($page_url); ?>">Otvori vodič</a></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($can_book) : ?>
        <h2 class="heading h4">Zakazivanje</h2>
        <p>LIVE pretplata otvara kalendar za termine.</p>
        <?php if ($booking_url) : ?>
            <p><a class="button-primary" href="<?php echo esc_url($booking_url); ?>">Zakaži termin</a></p>
        <?php endif; ?>
        <p class="guide-account-note">LIVE pretplata uključuje još <?php echo (int) mf_calendly_credits(); ?> od <?php echo (int) MF_CALENDLY_CREDITS; ?> termina.</p>
    <?php endif; ?>
</div>
