<?php
/* Template Name: Guide Library */
get_header();

$can_access = is_user_logged_in() && mf_user_can_access_guide();
?>

<section class="landing-section guide-library">
    <div class="container">
        <?php if (!$can_access) : ?>
            <?php get_template_part('template-parts/guide/locked'); ?>
        <?php else : ?>
            <?php get_template_part('template-parts/guide/intro'); ?>
            <?php get_template_part('template-parts/guide/pdf'); ?>
            <?php get_template_part('template-parts/guide/videos'); ?>
        <?php endif; ?>
    </div>
</section>

<?php if ($can_access) : ?>
    <div class="guide-modal" hidden>
        <div class="guide-modal-backdrop"></div>
        <div class="guide-modal-dialog" role="dialog" aria-modal="true" aria-label="Video">
            <button class="guide-modal-close" type="button" aria-label="Zatvori">×</button>
            <div class="guide-modal-frame">
                <iframe
                    src=""
                    title="Vimeo video"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
get_footer();
