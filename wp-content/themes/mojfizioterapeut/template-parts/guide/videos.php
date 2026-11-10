<?php if (have_rows('videos')) : ?>
    <div class="guide-videos">
        <?php while (have_rows('videos')) : the_row();
            $vimeo = preg_replace('/\D+/', '', (string) get_sub_field('vimeo_id'));
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            ?>
            <article class="guide-video">
                <button
                    class="guide-video-play"
                    type="button"
                    data-vimeo="<?php echo esc_attr($vimeo); ?>"
                    <?php echo $title ? 'aria-label="' . esc_attr($title) . '"' : ''; ?>
                >
                    <?php if (!empty($image['url'])) : ?>
                        <span class="guide-video-cover" style="background-image: url('<?php echo esc_url($image['url']); ?>')"></span>
                    <?php else : ?>
                        <span class="guide-video-cover is-empty"></span>
                    <?php endif; ?>
                    <span class="guide-video-icon" aria-hidden="true"></span>
                </button>
                <?php if ($title) : ?>
                    <h2 class="heading h5"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if (get_sub_field('duration')) : ?>
                    <p class="guide-video-duration"><?php echo esc_html(get_sub_field('duration')); ?></p>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <p class="guide-videos-empty">Video snimci će biti dodati ovde.</p>
<?php endif; ?>
