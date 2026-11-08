<?php
function koto_register_acf_blocks()
{
    /**
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     * Requires a blocks directory where each block has a separate subdirectory
     */
    register_block_type(get_template_directory() . '/blocks/testimonial');
}

add_action('init', 'koto_register_acf_blocks');
