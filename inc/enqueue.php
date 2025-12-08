<?php

/*
@package theme_name
=========================
ADMIN ENQUEUE FUNCTIONS
=========================
*/

/* FRONT-END SCRIPTS */
function theme_name_script_enqueue()
{
    // Fonts and icons
    wp_enqueue_style('playfair_display', 'https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap', array(), null, 'all');

    // CSS
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/theme_name.css', array(), '1.0.0', 'all');

    // JS
    wp_enqueue_script('customjs', get_template_directory_uri() . '/js/theme_name.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'theme_name_script_enqueue');
