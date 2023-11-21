<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecomerse' );

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
define( 'AUTH_KEY',         'FW9nV=A3&:qh2o;j<C7hA`G)]QHg<|]*K!.FmG=nm$3=J/=ZN$#^v//0~+Buz]^L' );
define( 'SECURE_AUTH_KEY',  '@2F4,>.Z<n.R3[FfHlp=#|LQaZ$c2XdD6n-4KGpG3- ~L*g+rwc$3A{G^U:.JCD(' );
define( 'LOGGED_IN_KEY',    'E1@Z:<rG#vzvdrCKE(hVug[&3gj745l7em_ugVgh9=~pYkm= >YLC8gk1c.+_gR6' );
define( 'NONCE_KEY',        ']QM;2mC,@7aXTVa~GHpXd S,4|1V;+2dh*aJvDxnZ5s+IrF+y:Rr/~Iuzp0%=Coo' );
define( 'AUTH_SALT',        'w5IB>}^B],DwY1,]*I{h+(gYNRAMAO~RxUrG2$&nOcRLiJm4$z6@j cC4S@8Z?+E' );
define( 'SECURE_AUTH_SALT', 'Eb%`pm=[3]nG>R;}0g8tkfv5aH]`V-2,byZg[_OxW3}yKVk UE>s{vKX7W6gCBTi' );
define( 'LOGGED_IN_SALT',   '@q?_l+:vE%[3NK8gdA~,Bvr@Ra{q.)l_mN5pWx&9DioHi{|HZW$w{Y<{rg,I6LtE' );
define( 'NONCE_SALT',       'OtX{;XlRjgta>U{d7IA;g*z:~sYq3SDWC9%.HZ3i.,4uo,trox3s(]]tSop-{Y{c' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
