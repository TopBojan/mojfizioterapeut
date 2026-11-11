<?php

/**
 * Build a Vimeo player iframe from a public or unlisted Vimeo URL.
 *
 * @param string $url Vimeo URL.
 * @return string|null Player markup, or null when the URL is not a Vimeo video.
 */
function mf_vimeo_embed_html($url)
{
    $url = trim((string) $url);
    $parts = wp_parse_url($url);

    if (empty($parts['host']) || !preg_match('/(^|\.)vimeo\.com$/i', $parts['host'])) {
        return null;
    }

    $path = isset($parts['path']) ? trim($parts['path'], '/') : '';
    if ($path === '' || !preg_match('#(?:^|/)(?:videos?/)?(\d+)(?:/([A-Za-z0-9]+))?$#', $path, $matches)) {
        return null;
    }

    $hash = isset($matches[2]) ? $matches[2] : '';
    if ($hash === '' && !empty($parts['query'])) {
        parse_str($parts['query'], $query);
        if (!empty($query['h']) && preg_match('/^[A-Za-z0-9]+$/', $query['h'])) {
            $hash = $query['h'];
        }
    }

    $src = 'https://player.vimeo.com/video/' . rawurlencode($matches[1]);
    if ($hash !== '') {
        $src = add_query_arg('h', $hash, $src);
    }

    return sprintf(
        '<iframe src="%1$s" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" allowfullscreen title="%2$s"></iframe>',
        esc_url($src),
        esc_attr__('Vimeo video', 'mojfizioterapeut')
    );
}

/**
 * Show a Vimeo player without calling Vimeo's oEmbed API.
 *
 * @param string|null $result Existing embed HTML.
 * @param string      $url    URL being embedded.
 * @return string|null
 */
function mf_vimeo_pre_oembed_result($result, $url)
{
    if (null !== $result) {
        return $result;
    }

    $html = mf_vimeo_embed_html($url);

    return null === $html ? $result : $html;
}

add_filter('pre_oembed_result', 'mf_vimeo_pre_oembed_result', 10, 2);
