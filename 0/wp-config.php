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
define( 'DB_NAME', 'wp0' );

/** Database username */
define( 'DB_USER', 'kasai' );

/** Database password */
define( 'DB_PASSWORD', '1591189@' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/** リビジョン保持数の制限（データベースの肥大化防止） */
define('WP_POST_REVISIONS', 10);

/** 連携先となるLaravel APIのベースURL */
define('LARAVEL_API_URL', 'http://localhost:8000');


//データベース修復。2025-03-25
//define('WP_ALLOW_REPAIR', true);

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
define( 'AUTH_KEY',         'ma@xH__ET{`^qr>:v77L5w*V=$yNwZ$9>Z2aW1l0z=~^mgjW;L:]rdalze:K+Ao!' );
define( 'SECURE_AUTH_KEY',  'P[~}Ss&`eeM#CudN%H=.,n}b`vUf,VL[w6iEV>zt`l:jyL=XsFT)>;Ef;b3=-r8a' );
define( 'LOGGED_IN_KEY',    '4V%[QfPnsb@%d-v?g+*Z5g@~WbxnsIOHA8?0SU@T.DdF4XqNbi8?l?ifFJYF7id{' );
define( 'NONCE_KEY',        '|nMQNceBuX$tJqN{zYU`:EUQ-@`5R)I{&y@H (mU+c+ _10TeRF[&sLN&Q:1#gt+' );
define( 'AUTH_SALT',        '2f/poH%;/1r}SzjS:c}}L>C[NF2hU4ZmVA<0Sw)sH k^V+!WTrOA?cf1O*O@|=O~' );
define( 'SECURE_AUTH_SALT', '31|riqjt-f21y;mD(IE9ODB3E8rHB$<{5!V`j:fKkH+j~bPjo_y9yp?H[%H~_Z>6' );
define( 'LOGGED_IN_SALT',   'dqY,()n_]pwwY(:5@%Md:(,{?Ehgr-4OMCM_VI] ^+0tVE)I@qoZ$3X.r&g7LsLu' );
define( 'NONCE_SALT',       'khN !wab)NjV$gah=K`(:PljlH1pu@SC#H>ZfStjC#B P6 mX0kbUE[iPxjj9k$J' );

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
