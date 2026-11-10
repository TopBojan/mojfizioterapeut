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
                'eyebrow' => 'LIVE termini',
                'title' => 'Zakazivanje je deo LIVE pretplate.',
                'text' => 'PDF i video vežbe ostaju dostupni nakon kupovine vodiča. Tri termina za razgovor otključava samo aktivna pretplata.',
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
