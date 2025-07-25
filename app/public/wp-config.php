<?php
define( 'WP_CACHE', true );

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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          '8X#Q>BwpTl4nj3HI]F{2YK3~}:>Z[Ug8<UPf0^1O${s,}C!is{%C[K8]e b G]%#' );
define( 'SECURE_AUTH_KEY',   'M*>BTp[ 8?#jNT9X[*S7HQkL-#`O;gAx78%^DX8`{%>X.am+TzE?nS)XX]O6W}ru' );
define( 'LOGGED_IN_KEY',     'RYLKf%G3[CO0yu&DBI!I+ARJ$q`:zika.~IeA2lu7znVws_ks<|jw@s)9tFNE$Q5' );
define( 'NONCE_KEY',         'rN<Pj-r8{E-GezayN9Q#n3b^mAkcmC0ZsOt00RU7$Ze45,zQ$pRyzbbl$I=[kW1k' );
define( 'AUTH_SALT',         'D`2A-ZsIU>bTevph~ewv/lslE^>!S|;0]FfE&8ot5@Hd[F0S}KA]eH(8-zh2#$p{' );
define( 'SECURE_AUTH_SALT',  'B:XGd<Q/U%Q4^@5n3BU}<TMvjnC){[4<G?_FXNY^>=H-L+F]lf&Y`#()Wxm8+2M/' );
define( 'LOGGED_IN_SALT',    '5FS$x?.#,Nz>XCq;c%@>RMVEI~42{3B9TBB7jB T7GJ;QtEoxo<#rBS-~SOQyMkG' );
define( 'NONCE_SALT',        'i.&_My%SK_?tu7U/}_a4UNF$iwq>17)/dYy&=o]1&DK^]O&Mc^_U|Us2H[)%`JGM' );
define( 'WP_CACHE_KEY_SALT', ']-s9iLd!2>S#wdv,=e<tXXk`aHId}B+/O=gMe6M0L fWH|<CDI#]FRw>[9?q+Z}+' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );

switch ( WP_ENVIRONMENT_TYPE ) {
	case 'staging':
		define( 'WP_HOME', 'https://staging.smdcheights.com' );
		define( 'WP_SITEURL', 'https://staging.smdcheights.com' );
		break;

	case 'production':
		define( 'WP_HOME', 'https://www.smdcheights.com' );
		define( 'WP_SITEURL', 'https://www.smdcheights.com' );
		break;

	case 'local':
	default:
		define( 'WP_HOME', 'http://localhost:10028' );
		define( 'WP_SITEURL', 'http://localhost:10028' );
		break;
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
