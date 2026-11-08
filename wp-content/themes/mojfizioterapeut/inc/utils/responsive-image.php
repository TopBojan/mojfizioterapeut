<?php
function custom_responsive_image($image_id, $classes = '', $alt = '', $fetchpriority = false)
{
    // Get available image sizes
    $image_sizes = wp_get_attachment_metadata($image_id);

    $srcset = '';

    // Sass breakpoints
    $breakpoints = array(
        'xs' => '575px',
        'sm' => '767px',
        'md' => '991px',
        'lg' => '1199px'
    );

    // Generate srcset based on different image sizes
    if (!empty($image_sizes) && isset($image_sizes['sizes'])) {
        // Sorting images by width
        uasort($image_sizes['sizes'], function ($a, $b) {
            return $a['width'] - $b['width'];
        });

        // Get only the sizes you want to include
        $included_sizes = array('thumbnail', 'medium', 'large'); // add more sizes from functions.php 
        foreach ($included_sizes as $size_name) {
            if (isset($image_sizes['sizes'][$size_name])) {
                $src = wp_get_attachment_image_url($image_id, $size_name);
                $srcset .= $src . ' ' . $image_sizes['sizes'][$size_name]['width'] . 'w, ';
            }
        }
    }

    $srcset = rtrim($srcset, ', ');

    $sizes = '';
    foreach ($breakpoints as $breakpoint => $width) {
        $sizes .= "(max-width: $width) 100vw, ";
    }
    $sizes .= '600px';

    // Output the <picture> tag
    echo '<picture>';
    echo '<!--[if IE 9]><video style="display: none;"><![endif]-->';
    echo '<source srcset="' . esc_attr($srcset) . '" sizes="' . esc_attr($sizes) . '" type="image/jpeg">';
    echo '<!--[if IE 9]></video><![endif]-->';
    echo '<img src="' . esc_url(wp_get_attachment_image_url($image_id, 'medium')) . '" class="' . esc_attr($classes) . '" alt="' . esc_attr($alt) . '" fetchpriority="' . ($fetchpriority ? 'high' : 'auto') . '" loading="lazy" decoding="async" width="' . esc_attr($image_sizes['width']) . '" height="' . esc_attr($image_sizes['height']) . '" title="' . esc_attr($alt) . '">';

    echo '</picture>';

    // Generate and output the preload tag 
    // $preload_src = esc_url(wp_get_attachment_image_url($image_id, 'medium'));
    // echo '<link rel="preload" as="image" href="' . $preload_src . '" imagesrcset="' . esc_attr($srcset) . '" imagesizes="' . esc_attr($sizes) . '">';
}
