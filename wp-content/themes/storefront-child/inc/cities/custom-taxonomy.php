<?php

// Создание кастомной таксономии для CPT "Cities"
function sb_register_taxonomy_countries() {
    $labels = array(
        'name'              => __( 'Countries', 'storefront-child' ),
        'singular_name'     => __( 'Country', 'storefront-child' ),
        'search_items'      => __( 'Search Countries', 'storefront-child' ),
        'all_items'         => __( 'All Countries', 'storefront-child' ),
        'edit_item'         => __( 'Edit Country', 'storefront-child' ),
        'update_item'       => __( 'Update Country', 'storefront-child' ),
        'add_new_item'      => __( 'Add New Country', 'storefront-child' ),
        'new_item_name'     => __( 'New Country Name', 'storefront-child' ),
        'menu_name'         => __( 'Countries', 'storefront-child' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'country' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'country', array( 'city' ), $args );
}
add_action( 'init', 'sb_register_taxonomy_countries' );