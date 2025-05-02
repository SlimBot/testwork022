<?php

// Создание кастомного типа записи "Cities"
function sb_register_cpt_cities() {
    $labels = array(
        'name'               => __( 'Cities', 'storefront-child' ),
        'singular_name'      => __( 'City', 'storefront-child' ),
        'menu_name'          => __( 'Cities', 'storefront-child' ),
        'add_new'            => __( 'Add New City', 'storefront-child' ),
        'add_new_item'       => __( 'Add New City', 'storefront-child' ),
        'edit_item'          => __( 'Edit City', 'storefront-child' ),
        'new_item'           => __( 'New City', 'storefront-child' ),
        'view_item'          => __( 'View City', 'storefront-child' ),
        'search_items'       => __( 'Search Cities', 'storefront-child' ),
        'not_found'          => __( 'No cities found', 'storefront-child' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'cities' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-location-alt'
    );

    register_post_type( 'city', $args );
}
add_action( 'init', 'sb_register_cpt_cities' );