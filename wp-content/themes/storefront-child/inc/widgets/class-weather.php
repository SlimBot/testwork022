<?php
class SB_City_Weather_Widget extends WP_Widget {

    // Инициализируем виджет
    public function __construct() {
        parent::__construct(
            'sb_city_weather_widget',
            __( 'City Weather', 'storefront-child' ),
            array( 'description' => __( 'Displays weather for a selected city', 'storefront-child' ) )
        );
    }

    /**
     * Вывод виджета
     */
    public function widget( $args, $instance ) {
        // Проверка id города
        $city_id = ! empty( $instance['city_id'] ) ? absint( $instance['city_id'] ) : 0;
        if ( ! $city_id ) {
            return;
        }

        // Проверка записи по id города
        $city = get_post( $city_id );
        if ( ! $city || $city->post_type !== 'city' ) {
            return;
        }

        // Получаем кастомные поля по id города
        $latitude  = get_post_meta( $city_id, '_sb_city_latitude', true );
        $longitude = get_post_meta( $city_id, '_sb_city_longitude', true );

        // Получение погоды через API
        $temperature = $this->get_city_temperature( $latitude, $longitude );

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html( $city->post_title ) . $args['after_title'];
        echo '<p>' . sprintf( __( 'Temperature: %s°C', 'storefront-child' ), esc_html( $temperature ) ) . '</p>';
        echo $args['after_widget'];
    }

    //  Настройки виджета в админке
    public function form( $instance ) {
        // Проверка id города
        $city_id = ! empty( $instance['city_id'] ) ? absint( $instance['city_id'] ) : 0;

        // Получаем все города
        $cities = get_posts( array(
            'post_type'      => 'city',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ) );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'city_id' ) ); ?>">
                <?php _e( 'Select City:', 'storefront-child' ); ?>
            </label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'city_id' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'city_id' ) ); ?>"
                    class="widefat">
                <option value="0"><?php _e( '— Select City —', 'storefront-child' ); ?></option>
                <?php foreach ( $cities as $city ) : ?>
                    <option value="<?php echo esc_attr( $city->ID ); ?>"
                        <?php selected( $city_id, $city->ID ); ?>>
                        <?php echo esc_html( $city->post_title ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    // Сохранение настроек
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['city_id'] = ! empty( $new_instance['city_id'] ) ? absint( $new_instance['city_id'] ) : 0;
        return $instance;
    }

    // Получение температуры
    public function get_city_temperature( $latitude, $longitude ) {
        // Проверка валидности координат
        if ( ! is_numeric( $latitude ) || ! is_numeric( $longitude ) ||
            $latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180 ) {
            return 'N/A';
        }

        // Ключ кэша на основе координат
        $cache_key = 'sb_weather_' . md5( $latitude . $longitude );
        $temperature = get_transient( $cache_key );
        if ( false === $temperature ) {
            // Получение API-ключа из настроек
            $api_key = get_option( 'sb_yandex_weather_api_key', 'c2d62034-7774-465f-9118-cfcd1440fc79' );
            $url = sprintf(
                'https://api.weather.yandex.ru/v2/forecast?lat=%s&lon=%s',
                $latitude,
                $longitude
            );

            $response = wp_remote_get( $url, array(
                'headers' => array(
                    'X-Yandex-API-Key' => $api_key,
                ),
            ) );

            if ( is_wp_error( $response ) ) {
                $temperature = 'N/A';
            } else {
                $data = json_decode( wp_remote_retrieve_body( $response ), true );
                $temperature = isset( $data['fact']['temp'] ) ? round( floatval( $data['fact']['temp'] ), 1 ) : 'N/A';
                if ( $temperature !== 'N/A' ) {
                    set_transient( $cache_key, $temperature, HOUR_IN_SECONDS );
                }
            }
        }

        return $temperature;
    }
}

// Регистрация виджета
function sb_register_city_weather_widget() {
    register_widget( 'SB_City_Weather_Widget' );
}
add_action( 'widgets_init', 'sb_register_city_weather_widget' );