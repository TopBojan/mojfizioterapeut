<?php mf_section_open('landing-steps'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>

    <?php if (have_rows('steps')) : ?>
        <div class="row landing-steps-row">
            <?php while (have_rows('steps')) : the_row(); ?>
                <div class="col-lg-4 col-md-12">
                    <article class="landing-step">
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

    <?php if (get_sub_field('show_booking')) : ?>
        <div class="landing-booking">
            <?php if (get_sub_field('booking_title')) : ?>
                <h3 class="heading h4"><?php echo esc_html(get_sub_field('booking_title')); ?></h3>
            <?php endif; ?>

            <?php if (get_sub_field('booking_text')) : ?>
                <p><?php echo wp_kses_post(get_sub_field('booking_text')); ?></p>
            <?php endif; ?>

            <?php if (get_sub_field('booking_note')) : ?>
                <p class="landing-note"><?php echo wp_kses_post(get_sub_field('booking_note')); ?></p>
            <?php endif; ?>

            <?php mf_render_link(get_sub_field('booking_button')); ?>

            <?php if (get_sub_field('booking_footnote')) : ?>
                <p class="landing-note"><?php echo wp_kses_post(get_sub_field('booking_footnote')); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php mf_section_close(); ?>
