<?php
mf_section_open('landing-gallery');
get_template_part('template-parts/sections/partials/intro', null, array('center' => true));

$images = get_sub_field('images');

if ($images) : ?>
    <div class="row landing-gallery-row">
        <?php foreach ($images as $image) : ?>
            <div class="col-lg-4 col-md-12">
                <figure class="landing-shot">
                    <?php mf_image($image, 'landing-shot-image', 'medium-img'); ?>
                </figure>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;

mf_section_close();
