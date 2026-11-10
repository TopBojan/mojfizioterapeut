<?php
/* Template Name: Flexible Page */
get_header();

if (function_exists('have_rows') && have_rows('sections')) :
    while (have_rows('sections')) :
        the_row();
        get_template_part('template-parts/sections/' . get_row_layout());
    endwhile;
endif;

get_footer();
