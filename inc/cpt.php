<?php
/*
@package (bmv_aca)
=========================
page-notification.php

The page template. Used when an individual Page is queried.
=========================

Template Name: Page Notification
Template Post Type: page
*/


function bmv_register_opleidingen_cpt()
{
    $labels = [
        'name'               => 'Opleidingen',
        'singular_name'      => 'Opleiding',
        'menu_name'          => 'Opleidingen',
        'name_admin_bar'     => 'Opleiding',
        'add_new'            => 'Opleiding toevoegen',
        'add_new_item'       => 'Nieuwe opleiding toevoegen',
        'edit_item'          => 'Opleiding bewerken',
        'new_item'           => 'Nieuwe opleiding',
        'view_item'          => 'Bekijk opleiding',
        'search_items'       => 'Zoek opleidingen',
        'not_found'          => 'Geen opleidingen gevonden',
        'not_found_in_trash' => 'Geen opleidingen in prullenbak',
        'all_items'          => 'Alle opleidingen',
    ];
    register_post_type('opleiding', [
        'labels'         => $labels,
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-welcome-learn-more',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'       => ['slug' => 'opleidingen'],
        'show_in_rest'  => true,
        'menu_position' => 8, // <— hoger in het menu
        'taxonomies'    => ['category'], // <— ADD THIS
    ]);
}
add_action('init', 'bmv_register_opleidingen_cpt');
