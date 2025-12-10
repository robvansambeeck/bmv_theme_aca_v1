<?php

/*
@package bmv_aca
=========================
THEME SUPPORT FUNCTIONS
=========================
*/

/* MENUS */
function bmv_aca_theme_setup()
{
  add_theme_support('menus');
  register_nav_menu('main', 'Main Header Navigation Menu');
  register_nav_menu('footer_pages_alg', 'Footer Menu Pages Algemeen');
  register_nav_menu('footer_pages_legal', 'Footer Menu Pages Legal');
}
add_action('after_setup_theme', 'bmv_aca_theme_setup');

/* POSTS and FORMATS */
function bmv_aca_post_formats_setup()
{
  add_theme_support('custom-logo');
  add_theme_support('custom-background');
  add_theme_support('custom-header');
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', array('aside', 'image', 'video', 'gallery'));
  add_theme_support('html5', array('search-form'));
  add_post_type_support('page', 'excerpt');
}

add_action('after_setup_theme', 'bmv_aca_post_formats_setup');


// ACF OPTION PAGE

if (function_exists('acf_add_options_page')) {
  acf_add_options_page([
    'page_title' => 'Global Settings',
    'menu_title' => 'Global Settings',
    'menu_slug'  => 'global-settings',
    'capability' => 'edit_posts',
    'redirect'   => false
  ]);
}
