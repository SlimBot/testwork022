<?php

// Поиска городов

function sb_search_cities() {
    check_ajax_referer( 'city_search_nonce', 'nonce' );

    global $wpdb;
    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';

    $query = "
        SELECT p.ID, p.post_title, t.name AS country, 
               pm1.meta_value AS latitude, pm2.meta_value AS longitude
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
        LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        LEFT JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
        LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id AND pm1.meta_key = '_sb_city_latitude'
        LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_sb_city_longitude'
        WHERE p.post_type = 'city'
        AND p.post_status = 'publish'
        AND tt.taxonomy = 'country'
    ";

    if ( $search ) {
        $query .= $wpdb->prepare( " AND p.post_title LIKE %s", '%' . $wpdb->esc_like( $search ) . '%' );
    }

    $results = $wpdb->get_results( $query );

    $output = array();
    foreach ( $results as $result ) {
        $temperature = ( new SB_City_Weather_Widget() )->get_city_temperature( $result->latitude, $result->longitude );
        $output[] = array(
            'city'        => $result->postseason_title,
            'country'     => $result->country ?: __( 'No country', 'storefront-child' ),
            'temperature' => $temperature,
        );
    }

    wp_send_json_success( $output );
}
add_action( 'wp_ajax_sb_search_cities', 'sb_search_cities' );
add_action( 'wp_ajax_nopriv_sb_search_cities', 'sb_search_cities' );