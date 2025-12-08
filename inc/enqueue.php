<?php

/*
@package bmv_aca
=========================
ADMIN ENQUEUE FUNCTIONS
=========================
*/

/* FRONT-END SCRIPTS */
function bmv_aca_script_enqueue()
{
    // fonts and icons
    wp_enqueue_style(
        'source-sans-3',
        'https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap',
        array(),
        null
    );

    // css
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/bmv_aca.css', array(), '1.0.0', 'all');

    // js
    wp_enqueue_script('customjs', get_template_directory_uri() . '/js/bmv_aca.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'bmv_aca_script_enqueue');
