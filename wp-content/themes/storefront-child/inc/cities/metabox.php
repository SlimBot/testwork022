<?php

// Создание кастомных полей для CPT "Cities"
function sb_add_city_metabox() {
    $post_type = 'city';
    add_meta_box(
        'sb_city_coordinates',
        __( 'City Coordinates', 'storefront-child' ),
        'sb_city_metabox_callback',
        $post_type,
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sb_add_city_metabox' );

// Вывод полей
function sb_city_metabox_callback( $post ) {
    $latitude  = get_post_meta( $post->ID, '_sb_city_latitude', 1 );
    $longitude = get_post_meta( $post->ID, '_sb_city_longitude', 1 );
    ?>
    <p>
        <label for="sb_city_latitude"><?php _e( 'Latitude:', 'storefront-child' ); ?></label>
        <input type="number" step="any" id="sb_city_latitude" name="sb_city_latitude" value="<?= esc_attr( $latitude ); ?>" />
    </p>
    <p>
        <label for="sb_city_longitude"><?php _e( 'Longitude:', 'storefront-child' ); ?></label>
        <input type="number" step="any" id="sb_city_longitude" name="sb_city_longitude" value="<?= esc_attr( $longitude ); ?>" />
    </p>
    <?php
    wp_nonce_field( 'sb_city_metabox', 'sb_city_metabox_nonce' );
}

// Сохранение полей
function sb_save_city_metabox( $post_id ) {

    // Проверка
    if (empty($_POST['sb_city_metabox_nonce'])
        || !wp_verify_nonce($_POST['sb_city_metabox_nonce'], 'sb_city_metabox')
        || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)
    ) {
        return false;
    }

    // Доп. проверка пользователя на редактироваени записи
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array( 'sb_city_latitude', 'sb_city_longitude' );
    foreach ( $fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[$field] ) );
        }
    }
}
add_action( 'save_post', 'sb_save_city_metabox' );