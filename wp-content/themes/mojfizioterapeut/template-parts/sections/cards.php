<?php mf_section_open('landing-cards'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>

    <?php if (have_rows('cards')) : ?>
        <div class="row landing-cards-row">
            <?php while (have_rows('cards')) : the_row(); ?>
                <div class="col-lg-4 col-md-12">
                    <article class="landing-card">
                        <?php if (get_sub_field('number')) : ?>
                            <div class="landing-card-number"><?php echo esc_html(get_sub_field('number')); ?></div>
                        <?php endif; ?>

                        <?php if (get_sub_field('title')) : ?>
                            <h3 class="heading h5"><?php echo esc_html(get_sub_field('title')); ?></h3>
                        <?php endif; ?>

                        <?php if (get_sub_field('text')) : ?>
                            <p><?php echo wp_kses_post(get_sub_field('text')); ?></p>
                        <?php endif; ?>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<?php mf_section_close(); ?>
