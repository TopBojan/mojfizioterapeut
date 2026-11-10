<?php
$anchor = ltrim((string) get_sub_field('anchor'), '#');
?>
<section class="landing-section landing-hero"<?php echo $anchor ? ' id="' . esc_attr(sanitize_title($anchor)) . '"' : ''; ?>>
    <div class="container">
        <div class="row middle between">
            <div class="col-lg-7 col-md-12">
                <?php if (get_sub_field('eyebrow')) : ?>
                    <div class="eyebrow"><?php echo esc_html(get_sub_field('eyebrow')); ?></div>
                <?php endif; ?>

                <?php if (get_sub_field('title')) : ?>
                    <h1 class="heading h1"><?php echo esc_html(get_sub_field('title')); ?></h1>
                <?php endif; ?>

                <?php if (get_sub_field('text')) : ?>
                    <p class="landing-lead"><?php echo wp_kses_post(get_sub_field('text')); ?></p>
                <?php endif; ?>

                <?php mf_render_link(get_sub_field('button')); ?>

                <?php if (have_rows('checks')) : ?>
                    <ul class="landing-checks">
                        <?php while (have_rows('checks')) : the_row(); ?>
                            <?php if (get_sub_field('text')) : ?>
                                <li><?php echo esc_html(get_sub_field('text')); ?></li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if (get_sub_field('image')) : ?>
                <div class="col-lg-5 col-md-12">
                    <div class="landing-mock">
                        <?php mf_image(get_sub_field('image'), 'landing-mock-image', 'large'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
