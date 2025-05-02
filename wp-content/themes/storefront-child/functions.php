<?php
function storefront_child_enqueue_assets() {
    // Стили
    wp_enqueue_style(
        'storefront-child-style',
        get_stylesheet_uri(),
        array( 'storefront-style' ),
        '1.0.0'
    );
    wp_enqueue_style(
        'storefront-child-custom',
        get_stylesheet_directory_uri() . '/front/css/main.css',
        array(),
        '1.0.0'
    );

    // Скрипты
    wp_enqueue_script(
        'storefront-child-custom',
        get_stylesheet_directory_uri() . '/front/js/main.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );

    // Локализация для AJAX
    wp_localize_script(
        'storefront-child-custom',
        'citySearch',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'city_search_nonce' )
        )
    );
}
add_action( 'wp_enqueue_scripts', 'storefront_child_enqueue_assets' );

require_once get_stylesheet_directory() . '/inc/cities/custom-post-type.php';
require_once get_stylesheet_directory() . '/inc/cities/custom-taxonomy.php';
require_once get_stylesheet_directory() . '/inc/cities/metabox.php';
require_once get_stylesheet_directory() . '/inc/cities/template-functions.php';
require_once get_stylesheet_directory() . '/inc/widgets/class-weather.php';