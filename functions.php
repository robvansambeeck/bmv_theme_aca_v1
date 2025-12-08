<?php

/*
@package (theme_name)
=========================
functions.php
=========================
*/

require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/theme-support.php';

function enqueue_jquery()
{
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');
