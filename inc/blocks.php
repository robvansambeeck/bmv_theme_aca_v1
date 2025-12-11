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
            'name'              => 'header',
            'title'             => __('header'),
            'description'       => __('block for header with optional cta'),
            'render_template'   => 'parts/block-header.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('header', 'cta'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-image-grid-1
        acf_register_block_type(array(
            'name'              => 'image-grid-1',
            'title'             => __('image-grid-1'),
            'description'       => __('block to display a grid image with quotes'),
            'render_template'   => 'parts/block-image-grid-1.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('grid', 'image', '1'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-info
        acf_register_block_type(array(
            'name'              => 'info',
            'title'             => __('info'),
            'description'       => __('block to display info'),
            'render_template'   => 'parts/block-info.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('info'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-program
        acf_register_block_type(array(
            'name'              => 'program',
            'title'             => __('program'),
            'description'       => __('block to display a program'),
            'render_template'   => 'parts/block-program.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('program'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-bullet-block-list
        acf_register_block_type(array(
            'name'              => 'bullet-list',
            'title'             => __('bullet-list'),
            'description'       => __('block to display a bullet list'),
            'render_template'   => 'parts/block-bullet-list.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('bullet', 'list'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-cta-register
        acf_register_block_type(array(
            'name'              => 'cta-register',
            'title'             => __('cta-register'),
            'description'       => __('block to display a register with cta'),
            'render_template'   => 'parts/block-cta-register.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('cta', 'register'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-filter
        acf_register_block_type(array(
            'name'              => 'filter',
            'title'             => __('filter'),
            'description'       => __('block to display a filter with opleidingen'),
            'render_template'   => 'parts/block-filter.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('filter', 'opleidingen'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-image-grid-2
        acf_register_block_type(array(
            'name'              => 'image-grid-2',
            'title'             => __('image-grid-2'),
            'description'       => __('block to display a grid image with quotes'),
            'render_template'   => 'parts/block-image-grid-2.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('grid', 'image', '2'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-steps
        acf_register_block_type(array(
            'name'              => 'steps',
            'title'             => __('steps'),
            'description'       => __('block to display steps'),
            'render_template'   => 'parts/block-steps.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('steps'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-students
        acf_register_block_type(array(
            'name'              => 'students',
            'title'             => __('students'),
            'description'       => __('block to display students'),
            'render_template'   => 'parts/block-students.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('students'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-image-grid-3
        acf_register_block_type(array(
            'name'              => 'image-grid-3',
            'title'             => __('image-grid-3'),
            'description'       => __('block to display a grid image with quotes'),
            'render_template'   => 'parts/block-image-grid-3.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('grid', 'image', '3'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-faq
        acf_register_block_type(array(
            'name'              => 'faq',
            'title'             => __('faq'),
            'description'       => __('block to display a faq - Frequently Asked Questions'),
            'render_template'   => 'parts/block-faq.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('faq'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
        // block-contact
        acf_register_block_type(array(
            'name'              => 'contact',
            'title'             => __('contact'),
            'description'       => __('block to display a contact form'),
            'render_template'   => 'parts/block-contact.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
            'keywords'          => array('contact'),
            'mode'              => 'edit', // or 'edit'
            'supports'          => array(
                'align' => true,
                'jsx'   => true,
            ),
        ));
    }
}
