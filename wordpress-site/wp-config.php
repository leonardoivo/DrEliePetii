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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dreliepetii_wp' );

/** Database username */
define( 'DB_USER', 'dreliepetii_wp' );

/** Database password */
define( 'DB_PASSWORD', 'CheniauxWp_2026!qz' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'N#<*AJk%AWMpQC#os@{l++.FT,r`cDZ4S~tEo%On#E7V8 iy)<I#giHn/4cF5E=s' );
define( 'SECURE_AUTH_KEY',   '*/9!Q$I3,Aj@D;PsA+.AkReN7c|7,;r=EKjh_8<QEN)D w_Ss/SSGgw?.*r*znm2' );
define( 'LOGGED_IN_KEY',     '27AO>*n_;0r=0zkv<P9[g=n@m?K0.oyu~eDIaon#/R?0(KZLM:eeo{]l^)8Y@9eX' );
define( 'NONCE_KEY',         'uVwR((H*%;nN$ Aap:YTKG9S&w<V6Q|F,$<<+R0#Pco5PF:R9Ql^Q(**jA:n]?[Q' );
define( 'AUTH_SALT',         'lrz*(f?m:$6VutH&~8j!l9(?E9/Zi}zwl>W.GrmR+5B$#Imu7AeiegOP->Noskr4' );
define( 'SECURE_AUTH_SALT',  'bG3FT>i<{)J#?]NSL8ryAriD5jIcBM3}{:/7,v+Za:@!G3?Ij]?3`5OW;37j!MMi' );
define( 'LOGGED_IN_SALT',    '(OGpTBCT<@%/m[)Wu=R_K}Ir/.pn]N}N,[S9f:3|S[/91y8c~B`[@mm5l7vNIz~W' );
define( 'NONCE_SALT',        'I[.wm[d[kHpxjS=XTGSivN3^K|O`LEqld?ZLY2HF^8%z&`IErY#e$^h9sXBq~a*G' );
define( 'WP_CACHE_KEY_SALT', '|G`$WHU;@scWdzG&K`anP,=}xf,X483RmwSBry4#U]#w6=c$pWXq;rydPR-qSq`a' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */
define('DEC_SMTP_HOST', 'smtp.titan.email');
define('DEC_SMTP_PORT', 465);
define('DEC_SMTP_SECURE', 'ssl');
define('DEC_SMTP_USER', 'contato@eliecheniaux.com');
define('DEC_SMTP_PASS', 'ElieCheniaux2026!');
define('DEC_SMTP_FROM', 'contato@eliecheniaux.com');
define('DEC_SMTP_FROM_NAME', 'Site Elie Cheniaux');


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
