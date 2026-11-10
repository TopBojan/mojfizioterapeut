<?php
/**
 * Allow SVG uploads in the media library and ACF image fields.
 *
 * WordPress omits SVG from allowed mime types, then rejects the file when
 * fileinfo reports it as text/plain, text/xml, or text/html.
 */

add_filter('upload_mimes', 'mf_allow_svg_uploads');
add_filter('wp_check_filetype_and_ext', 'mf_fix_svg_filetype', 10, 4);
add_filter('wp_handle_upload_prefilter', 'mf_sanitize_svg_upload');
add_filter('wp_prepare_attachment_for_js', 'mf_svg_media_preview', 10, 2);
add_action('admin_head', 'mf_svg_admin_preview_css');

function mf_allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

function mf_fix_svg_filetype($data, $file, $filename, $mimes)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if ($ext !== 'svg') {
        return $data;
    }

    $data['ext'] = 'svg';
    $data['type'] = 'image/svg+xml';

    return $data;
}

function mf_sanitize_svg_upload($file)
{
    $name = isset($file['name']) ? $file['name'] : '';

    if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'svg') {
        return $file;
    }

    if (!empty($file['error']) || empty($file['tmp_name']) || !is_readable($file['tmp_name'])) {
        return $file;
    }

    $contents = file_get_contents($file['tmp_name']);

    if ($contents === false || !mf_svg_looks_like_svg($contents)) {
        $file['error'] = 'This file is not a valid SVG.';

        return $file;
    }

    $sanitized = mf_sanitize_svg($contents);

    if ($sanitized === '') {
        $file['error'] = 'This SVG could not be cleaned for upload. Export it again without scripts or embedded HTML.';

        return $file;
    }

    file_put_contents($file['tmp_name'], $sanitized);

    return $file;
}

function mf_svg_looks_like_svg($contents)
{
    return (bool) preg_match('/<svg[\s>]/i', $contents);
}

function mf_is_svg_event_attribute($name)
{
    return (bool) preg_match('/^on(?:abort|activate|begin|click|end|error|focusin|focusout|focus|load|mousedown|mousemove|mouseout|mouseover|mouseup|mouseleave|mouseenter|repeat|resize|scroll|unload|start|toggle|wheel|pointerdown|pointerup|pointermove|pointerenter|pointerleave|pointercancel|animationstart|animationend|animationiteration|transitionend|drag|drop|keydown|keyup|keypress|input|change|submit|reset|select|copy|cut|paste|contextmenu|dblclick|auxclick)$/i', $name);
}

function mf_sanitize_svg($contents)
{
    $contents = preg_replace('/^\xEF\xBB\xBF/', '', $contents);
    $contents = preg_replace('/<\?xml.*?\?>/s', '', $contents);
    $contents = preg_replace('/<!DOCTYPE.*?>/is', '', $contents);
    $contents = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $contents);
    $contents = preg_replace('/<foreignObject\b[^>]*>.*?<\/foreignObject>/is', '', $contents);
    $contents = preg_replace('/\s+on(?:abort|activate|begin|click|end|error|focusin|focusout|focus|load|mousedown|mousemove|mouseout|mouseover|mouseup|mouseleave|mouseenter|repeat|resize|scroll|unload|start|toggle|wheel|pointerdown|pointerup|pointermove|pointerenter|pointerleave|pointercancel|animationstart|animationend|animationiteration|transitionend|drag|drop|keydown|keyup|keypress|input|change|submit|reset|select|copy|cut|paste|contextmenu|dblclick|auxclick)\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $contents);
    $contents = preg_replace('/\s+(href|xlink:href)\s*=\s*("|\')\s*javascript:[^"\']*\2/i', '', $contents);

    if (!class_exists('DOMDocument')) {
        return mf_svg_looks_like_svg($contents) ? trim($contents) : '';
    }

    $dom = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $loaded = $dom->loadXML($contents, LIBXML_NONET);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    if (!$loaded || strtolower($dom->documentElement->tagName) !== 'svg') {
        return mf_svg_looks_like_svg($contents) ? trim($contents) : '';
    }

    foreach (array('script', 'foreignObject') as $tag) {
        $nodes = $dom->getElementsByTagName($tag);

        for ($i = $nodes->length - 1; $i >= 0; $i--) {
            $node = $nodes->item($i);

            if ($node && $node->parentNode) {
                $node->parentNode->removeChild($node);
            }
        }
    }

    $elements = $dom->getElementsByTagName('*');

    for ($i = 0; $i < $elements->length; $i++) {
        $element = $elements->item($i);

        if (!$element->hasAttributes()) {
            continue;
        }

        $remove = array();

        foreach ($element->attributes as $attribute) {
            $attr_name = strtolower($attribute->name);
            $attr_value = strtolower($attribute->value);

            if (mf_is_svg_event_attribute($attr_name) || strpos($attr_value, 'javascript:') !== false) {
                $remove[] = $attribute->name;
            }
        }

        foreach ($remove as $attr_name) {
            $element->removeAttribute($attr_name);
        }
    }

    $svg = $dom->saveXML($dom->documentElement);

    return is_string($svg) ? $svg : '';
}

function mf_svg_media_preview($response, $attachment)
{
    if (empty($response['mime']) || $response['mime'] !== 'image/svg+xml') {
        return $response;
    }

    $url = isset($response['url']) ? $response['url'] : '';

    $response['sizes'] = array(
        'full' => array(
            'url' => $url,
            'width' => 300,
            'height' => 150,
            'orientation' => 'landscape',
        ),
    );

    return $response;
}

function mf_svg_admin_preview_css()
{
    echo '<style>
        .attachment img[src$=".svg"],
        .media-icon img[src$=".svg"],
        img[src$=".svg"].attachment-post-thumbnail {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
