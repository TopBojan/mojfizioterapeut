<?php
function add_defer_attribute($tag, $handle)
{
    if ('webfont' !== $handle && 'scripts' !== $handle)
        return $tag;
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);

function add_async_attribute($tag, $handle)
{
    if ('fa' !== $handle)
        return $tag;
    return str_replace(' src', ' async src', $tag);
}
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
