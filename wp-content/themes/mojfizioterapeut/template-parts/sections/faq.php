<?php mf_section_open('landing-faq'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>

    <?php if (have_rows('items')) : ?>
        <div class="landing-faq-list">
            <?php while (have_rows('items')) : the_row(); ?>
                <?php if (get_sub_field('question')) : ?>
                    <details class="landing-faq-item">
                        <summary><?php echo esc_html(get_sub_field('question')); ?></summary>
                        <?php if (get_sub_field('answer')) : ?>
                            <div class="landing-faq-answer"><?php echo wp_kses_post(get_sub_field('answer')); ?></div>
                        <?php endif; ?>
                    </details>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<?php mf_section_close(); ?>
