<?php mf_section_open('landing-plans'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>

    <?php if (have_rows('plans')) : ?>
        <div class="row landing-plans-row center">
            <?php while (have_rows('plans')) : the_row(); ?>
                <div class="col-lg-6 col-md-12">
                    <?php $plan = mf_plan_card(); ?>
                    <article class="landing-plan<?php echo get_sub_field('featured') ? ' is-featured' : ''; ?>">
                        <?php if (get_sub_field('eyebrow')) : ?>
                            <div class="eyebrow"><?php echo esc_html(get_sub_field('eyebrow')); ?></div>
                        <?php endif; ?>

                        <?php if ($plan['title']) : ?>
                            <h3 class="heading h4"><?php echo esc_html($plan['title']); ?></h3>
                        <?php endif; ?>

                        <?php if ($plan['price']) : ?>
                            <div class="landing-plan-price">
                                <?php echo esc_html($plan['price']); ?>
                                <?php if ($plan['suffix']) : ?>
                                    <span><?php echo esc_html($plan['suffix']); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (get_sub_field('text')) : ?>
                            <p><?php echo wp_kses_post(get_sub_field('text')); ?></p>
                        <?php endif; ?>

                        <?php if (have_rows('features')) : ?>
                            <ul>
                                <?php while (have_rows('features')) : the_row(); ?>
                                    <?php if (get_sub_field('text')) : ?>
                                        <li><?php echo esc_html(get_sub_field('text')); ?></li>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>

                        <?php mf_render_link($plan['button'], 'button-primary wide'); ?>

                        <?php if (get_sub_field('note')) : ?>
                            <p class="landing-note"><?php echo wp_kses_post(get_sub_field('note')); ?></p>
                        <?php endif; ?>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<?php mf_section_close(); ?>
