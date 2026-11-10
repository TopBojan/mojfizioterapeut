<?php

/**
 * Open a flexible-content section.
 *
 * @param string $modifier Extra class names.
 */
function mf_section_open($modifier = '')
{
    $background = get_sub_field('background');
    $anchor = ltrim((string) get_sub_field('anchor'), '#');
    $classes = array_filter(array(
        'landing-section',
        $modifier,
        $background === 'muted' ? 'is-muted' : '',
    ));

    echo '<section class="' . esc_attr(implode(' ', $classes)) . '"';

    if ($anchor) {
        echo ' id="' . esc_attr(sanitize_title($anchor)) . '"';
    }

    echo '><div class="container">';
}

/**
 * Close a flexible-content section.
 */
function mf_section_close()
{
    echo '</div></section>';
}

/**
 * Render an ACF link as a button.
 *
 * @param array|false $link  ACF link field value.
 * @param string      $class Button class.
 */
function mf_render_link($link, $class = 'button-primary')
{
    if (empty($link['url']) || empty($link['title'])) {
        return;
    }

    $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '" rel="noopener"' : '';

    printf(
        '<a class="%1$s" href="%2$s"%3$s>%4$s</a>',
        esc_attr($class),
        esc_url($link['url']),
        $target,
        esc_html($link['title'])
    );
}

/**
 * Render an ACF image array.
 *
 * @param array|false $image Image field value.
 * @param string      $class Image class.
 * @param string      $size  Registered image size.
 */
function mf_image($image, $class = '', $size = 'large')
{
    if (empty($image) || !is_array($image)) {
        return;
    }

    $id = $image['ID'] ?? $image['id'] ?? 0;

    if ($id) {
        echo wp_get_attachment_image((int) $id, $size, false, array(
            'class' => $class,
            'alt'   => $image['alt'] ?? '',
        ));
        return;
    }

    if (empty($image['url'])) {
        return;
    }

    printf(
        '<img class="%1$s" src="%2$s" alt="%3$s">',
        esc_attr($class),
        esc_url($image['url']),
        esc_attr($image['alt'] ?? '')
    );
}
