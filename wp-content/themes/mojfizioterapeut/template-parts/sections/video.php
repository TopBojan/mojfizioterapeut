<?php mf_section_open('landing-video'); ?>
    <?php get_template_part('template-parts/sections/partials/intro', null, array('center' => true)); ?>

    <div class="landing-video-benefit">
        <div>
            <?php if (get_sub_field('tag')) : ?>
                <span class="landing-video-tag"><?php echo esc_html(get_sub_field('tag')); ?></span>
            <?php endif; ?>

            <?php if (get_sub_field('heading')) : ?>
                <h3 class="heading h4"><?php echo esc_html(get_sub_field('heading')); ?></h3>
            <?php endif; ?>

            <?php if (have_rows('points')) : ?>
                <ul class="landing-video-list">
                    <?php while (have_rows('points')) : the_row(); ?>
                        <?php if (get_sub_field('text')) : ?>
                            <li><?php echo esc_html(get_sub_field('text')); ?></li>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>

            <?php if (get_sub_field('note')) : ?>
                <p class="landing-note"><?php echo wp_kses_post(get_sub_field('note')); ?></p>
            <?php endif; ?>
        </div>

        <div>
            <?php
            $video = get_sub_field('video');
            $image = get_sub_field('image');
            ?>
            <?php if ($video) : ?>
                <div class="landing-video-frame is-embed"><?php echo $video; ?></div>
            <?php elseif ($image) : ?>
                <div class="landing-video-frame is-image">
                    <?php mf_image($image, '', 'large'); ?>
                </div>
            <?php else : ?>
                <div class="landing-video-frame" role="img" aria-label="<?php echo esc_attr(get_sub_field('placeholder_title') ?: 'Video'); ?>">
                    <div class="landing-video-play" aria-hidden="true">&#9654;</div>
                    <?php if (get_sub_field('placeholder_title')) : ?>
                        <strong><?php echo esc_html(get_sub_field('placeholder_title')); ?></strong>
                    <?php endif; ?>
                    <?php if (get_sub_field('placeholder_text')) : ?>
                        <span><?php echo esc_html(get_sub_field('placeholder_text')); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php mf_section_close(); ?>
