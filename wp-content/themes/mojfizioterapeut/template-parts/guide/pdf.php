<?php $pdf = mf_guide_pdf_path(); ?>
<div class="guide-pdf">
    <h2 class="heading h5">PDF vodič</h2>
    <?php if ($pdf) : ?>
        <a class="button-primary" href="<?php echo esc_url(mf_guide_download_url()); ?>">Preuzmi PDF</a>
    <?php else : ?>
        <p>PDF će biti dostupan ovde čim bude postavljen.</p>
    <?php endif; ?>
</div>
