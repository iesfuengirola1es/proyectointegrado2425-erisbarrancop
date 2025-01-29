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
define( 'DB_NAME', 'proyectointegrado' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'J6E{pFerNsB@AbRYti%Ii#I?@#9i /7Vx$ UP!.)Xg1%Fm$MaPmhR3/IHCvdbyr*' );
define( 'SECURE_AUTH_KEY',  ']|w!btKa=]gCc81 s=c9q)H,j ;f^Ml~64_75L3]Vk7zT@4~THz6T`KB$#yEnnXQ' );
define( 'LOGGED_IN_KEY',    'S;J V?Y2PzE[:ol-_&Y?>@*,jZ4Ep_m9vJ4_y3gDmrMXzSzh|DvVnkZ7zxiYNOgw' );
define( 'NONCE_KEY',        'd${h/t(-ve5p,thr(,.+N?Sz2yXQ?W#[[rj+6{ZW}nQ/F-3d0?&Ul*<QwRvwm|3N' );
define( 'AUTH_SALT',        '-AM;plTxnH[b|Y;QzT~K$mZ}pFEhw@6}ir;xs5AJ{_Hk86CExrjt?sNIt>e^{PDc' );
define( 'SECURE_AUTH_SALT', '4c~otU.GBreMR#;A=Acza2pp}#.mJ)vdYGzA s2E-*s* RpAQZaN(p+o#=gwF_e$' );
define( 'LOGGED_IN_SALT',   '??;uotc7!QG|kNn+&^d,dzUXrB3{+ALE{rvca#HKS]NUj;0+r3eF0A>2kOt9l{C9' );
define( 'NONCE_SALT',       'Ifx(SY(HIp=m>#FhRK.R[X?hy e5kf[72te*P>{-KvW7~s[zylq_DZ$=`l)gP?f<' );

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
define( 'WP_DEBUG_LOG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
