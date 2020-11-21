<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bitnami_wordpress1' );

/** MySQL database username */
define( 'DB_USER', 'ubaid' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ubaid123' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1:3307' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@<s{%.)_od.J{qVAY`<1S_hQkw><>5hHsDL5AH1x>[}pov &^]o]n.5yP{x6@_qg' );
define( 'SECURE_AUTH_KEY',  '_6<a.P0d5qf</+^8OF36rQq%Nij}5H{)XYU$)`ZCq:_pkG6/O(tZ],HAl)](4?^d' );
define( 'LOGGED_IN_KEY',    'E>t0E*|cfIC,pDkjWL.OmN3v,Btps%{Y&p9=v*#ew=Yr75`wUS/&{8GrPw-sN`K1' );
define( 'NONCE_KEY',        'Fy q,bd^c)JQ;rH7sjV<Dv3M/FXdZ-al>]=8FG*f(9(z&ZyVdgONg<@+cVmY;ShX' );
define( 'AUTH_SALT',        'cJ?R?OMTi|LdDr,=4W032<Hw}JtK]Ni7;{5qU.2hg;&Ua16/%r &+iO9e?aks9yD' );
define( 'SECURE_AUTH_SALT', 'w~Xd@c4_+|j9c/L}Ds;^)(IvN]>19`]74}fnKlMHCJMRd hc3] enPje[>Vd%4S:' );
define( 'LOGGED_IN_SALT',   'F=L9P{WPOj9htAM.9YRk %ITms*BOScx4Ar,+m a)YoQU5Q;}6P#6dC#(&tGH]G2' );
define( 'NONCE_SALT',       'bJA<T#@gbR7jdO3|xB?IF(TALfCs2i9{:S:H{/Kyaw~0 :sWUQI=s[>tySnqm.s@' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
