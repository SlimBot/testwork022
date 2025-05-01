<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'admin' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'U!/o~F5RhQe*8cLK=l;dKJ ..N?U]8U3um[13;zN,*,_.Q.TdbIRe JLK2[?FWq6' );
define( 'SECURE_AUTH_KEY',  'tX<>#^ci{X8c1W4CR&,.!^ =b|j0`Vg.}ja;o!*^Oou62k`gAAJD]Q !9k3zOs.&' );
define( 'LOGGED_IN_KEY',    'nF/gjuK@s/L6paGz}!4Q8.oB?M*hTH z~C{N?/:qltfb8Cs7<Y<#/0;?93RV5s,T' );
define( 'NONCE_KEY',        'cVM0g1#h7J/^Xb+pQH|T,5qv50/wIi9p#;5c6PG?uUcohf%B>Y5sg5c9{Z+JH>8*' );
define( 'AUTH_SALT',        '(c~P.F~z &{QYT-$RgJEH7/$D7dR`$lfa08fD>9o&lEp3&l1hWF~OFA?@r|opp`/' );
define( 'SECURE_AUTH_SALT', '-:C7%7n/1@LP>tTH7`Axe341 }{Wo|f=`ju+WYD1KuEnH<j4|pI!Wo)BuzA-;x3r' );
define( 'LOGGED_IN_SALT',   '0?[]&V8dk5&EC}(c1&c=L5e.0Zo#0oSQ+H$](_T%>,FL$vHp`gAM%DK^S$Yq_ugG' );
define( 'NONCE_SALT',       'o,cn65[vh`zFXu]zcB=9s/<b5fH[EV,>drb.M!Ek^Kh>uS|)PIBXVKHHl%IA6.@N' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
