<?php


/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function koto_nav_menu_add_submenu_class($classes, $args, $depth)
{
    if (isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }

    if (isset($args->{"submenu_class_$depth"})) {
        $classes[] = $args->{"submenu_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_submenu_css_class', 'koto_nav_menu_add_submenu_class', 10, 3);
