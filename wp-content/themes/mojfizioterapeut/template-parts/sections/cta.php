<?php mf_section_open('landing-cta'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>
    <div class="landing-cta-action">
        <?php mf_render_link(get_sub_field('button')); ?>
    </div>
<?php mf_section_close(); ?>
