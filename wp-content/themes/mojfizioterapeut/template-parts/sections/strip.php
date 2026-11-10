<?php if (!get_sub_field('text')) {
    return;
} ?>
<section class="landing-strip">
    <div class="container"><?php echo esc_html(get_sub_field('text')); ?></div>
</section>
