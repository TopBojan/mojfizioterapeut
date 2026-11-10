<?php
$eyebrow = get_sub_field('eyebrow');
$title = get_sub_field('title');
$text = get_sub_field('text');

if (!$eyebrow && !$title && !$text) {
    return;
}

$tag = $args['tag'] ?? 'h2';
$heading_class = $args['heading_class'] ?? 'heading h2';
$allowed_tags = array('h1', 'h2', 'h3');

if (!in_array($tag, $allowed_tags, true)) {
    $tag = 'h2';
}
$center = !empty($args['center']);
?>
<div class="section-intro<?php echo $center ? ' is-center' : ''; ?>">
    <?php if ($eyebrow) : ?>
        <div class="eyebrow"><?php echo esc_html($eyebrow); ?></div>
    <?php endif; ?>

    <?php if ($title) : ?>
        <<?php echo $tag; ?> class="<?php echo esc_attr($heading_class); ?>">
            <?php echo esc_html($title); ?>
        </<?php echo $tag; ?>>
    <?php endif; ?>

    <?php if ($text) : ?>
        <div class="section-text"><?php echo wp_kses_post($text); ?></div>
    <?php endif; ?>
</div>
