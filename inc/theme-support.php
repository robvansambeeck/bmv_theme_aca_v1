<?php

/*
@package theme_name
=========================
THEME SUPPORT FUNCTIONS
=========================
*/

/* MENUS */
function theme_name_theme_setup()
{
  add_theme_support('menus');
  register_nav_menu('main', 'Main Header Navigation Menu');
}

add_action('init', 'theme_name_theme_setup');

/* POSTS and FORMATS */
function theme_name_post_formats_setup()
{
  add_theme_support('custom-background');
  add_theme_support('custom-header');
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', array('aside', 'image', 'video', 'gallery'));
  add_theme_support('html5', array('search-form'));
  add_post_type_support('page', 'excerpt');
}

add_action('after_setup_theme', 'theme_name_post_formats_setup');
