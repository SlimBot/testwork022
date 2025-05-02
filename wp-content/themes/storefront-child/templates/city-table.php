<?php
// Template Name: Cities table

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <h1><?php the_title(); ?></h1>

            <!-- Поле поиска -->
            <div class="city-search">
                <input type="text" id="city-search-input"
                       placeholder="<?php _e('Search cities...', 'storefront-child'); ?>">
            </div>

            <!-- Хук перед таблицей -->
            <?php do_action('sb_before_cities_table'); ?>

            <!-- Таблица -->
            <table id="cities-table" class="cities-table">
                <thead>
                <tr>
                    <th><?php _e('City', 'storefront-child'); ?></th>
                    <th><?php _e('Country', 'storefront-child'); ?></th>
                    <th><?php _e('Temperature (°C)', 'storefront-child'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
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
                $cities = $wpdb->get_results($query);

                foreach ($cities as $city) :
                    $temperature = (new SB_City_Weather_Widget())->get_city_temperature($city->latitude, $city->longitude);
                    ?>
                    <tr>
                        <td><?php echo esc_html($city->post_title); ?></td>
                        <td><?php echo esc_html($city->country ?: __('No country', 'storefront-child')); ?></td>
                        <td><?php echo esc_html($temperature); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Хук после таблицы -->
            <?php do_action('sb_after_cities_table'); ?>

        </main>
    </div>

<?php get_footer(); ?>