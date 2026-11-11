<?php
/* Template Name: Guide Booking */
get_header();

$can_book = is_user_logged_in() && mf_user_can_access_booking();
?>

<section class="landing-section guide-library">
    <div class="container">
        <?php if (!$can_book) : ?>
            <?php
            get_template_part('template-parts/guide/locked', null, array(
                'eyebrow' => mf_guide_copy('booking_locked_eyebrow', 'LIVE termini'),
                'title' => mf_guide_copy('booking_locked_title', 'Zakazivanje je deo LIVE pretplate.'),
                'text' => mf_guide_copy('booking_locked_text', 'PDF i video vežbe ostaju dostupni nakon kupovine vodiča. Tri termina za razgovor otključava samo aktivna pretplata.'),
                'login_title' => mf_guide_copy('booking_locked_login', 'Već imate nalog?'),
                'membership_label' => mf_guide_copy('booking_locked_membership', 'Uzmi LIVE pretplatu'),
                'show_product' => false,
            ));
            ?>
        <?php else : ?>
            <?php get_template_part('template-parts/guide/calendly'); ?>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
