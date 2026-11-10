<?php
$eyebrow = get_field('eyebrow');
$title = get_field('title');
$text = get_field('text');
?>
<div class="section-intro">
    <?php if ($eyebrow) : ?>
        <div class="eyebrow"><?php echo esc_html($eyebrow); ?></div>
    <?php endif; ?>
    <?php if ($title) : ?>
        <h1 class="heading h2"><?php echo esc_html($title); ?></h1>
    <?php else : ?>
        <h1 class="heading h2"><?php the_title(); ?></h1>
    <?php endif; ?>
    <?php if ($text) : ?>
        <div class="section-text"><?php echo wp_kses_post($text); ?></div>
    <?php endif; ?>
</div>
