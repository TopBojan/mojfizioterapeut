<?php
$anchor = ltrim((string) get_sub_field('anchor'), '#');
?>
<section class="landing-section landing-offer-section"<?php echo $anchor ? ' id="' . esc_attr(sanitize_title($anchor)) . '"' : ''; ?>>
    <div class="container">
        <div class="landing-offer">
            <?php if (get_sub_field('eyebrow')) : ?>
                <div class="eyebrow"><?php echo esc_html(get_sub_field('eyebrow')); ?></div>
            <?php endif; ?>

            <?php if (get_sub_field('title')) : ?>
                <h2 class="heading h2"><?php echo esc_html(get_sub_field('title')); ?></h2>
            <?php endif; ?>

            <?php if (get_sub_field('text')) : ?>
                <p><?php echo wp_kses_post(get_sub_field('text')); ?></p>
            <?php endif; ?>

            <?php if (get_sub_field('price')) : ?>
                <div class="landing-offer-price"><?php echo esc_html(get_sub_field('price')); ?></div>
            <?php endif; ?>

            <?php if (get_sub_field('price_note')) : ?>
                <p><?php echo wp_kses_post(get_sub_field('price_note')); ?></p>
            <?php endif; ?>

            <?php mf_render_link(get_sub_field('button')); ?>

            <?php if (get_sub_field('note')) : ?>
                <p class="landing-note"><?php echo wp_kses_post(get_sub_field('note')); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
