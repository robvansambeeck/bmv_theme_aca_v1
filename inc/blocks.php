<?php

/*
@package rro_theme_2025_v1
=========================
blocks via acf
=========================
*/

add_action('acf/init', 'register_my_acf_block');

function register_my_acf_block()
{
    // Check function exists.
    if (function_exists('acf_register_block_type')) {
        // block-header-cta
        acf_register_block_type(array(
            'name'              => 'cta-header',
            'title'             => __('cta-header'),
            'description'       => __('block for heasder with optional cta'),
            'render_template'   => 'blocks/block-cta-header.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('header', 'cta'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
    }
}
