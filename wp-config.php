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
define( 'DB_NAME', 'toni_janis_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',          'y*1Thl7GT=pN?tvNf>fkfwq2y}m9%_oX9W=GR#-0m6W.N&im]c&T@hyIL}V=WH;a' );
define( 'SECURE_AUTH_KEY',   'fD>5z<89AY1fOJ[@q3d}#EgPS Hj6>Yml/zEeESZcN42^TzD#i]+A(DI6~+cv]b{' );
define( 'LOGGED_IN_KEY',     'h33Q.]aZCATl9>kT!g| rWnyLjOo=e-qN$By2s9RUk=2(==96)h{WY&[|<2iB[o+' );
define( 'NONCE_KEY',         '{[0H<MZ5x<-2W<s-tf1&@d94]hsk6ByWix!0 V2tR-905#V?)I,n:LAD$[Yc%<VB' );
define( 'AUTH_SALT',         'M1~#v+O>v&e(pkhqoJ9t5p*&(1w[gv(loUv-yR2my5b=jh]haY(f%MALp,i61B4~' );
define( 'SECURE_AUTH_SALT',  '}9Tt^^UhI! ypH_| HRp8)|-]P9E~Q0_=goo8}Q?x|MDdpl)d.t~f@Q 7LDkB>a<' );
define( 'LOGGED_IN_SALT',    'lK&eb)4Xt3Yh@*UIXyOx:6ht9@zT]334Y]xJmJ;X~6,CXSPHzpyc[0#r-*G2v!0R' );
define( 'NONCE_SALT',        'KJbQ&[/w,iT71nFa1r!(y.-V.T>;+OIsLvb&,)O2D&/xgyj;G<SoX%$Mj+>jJ:W$' );
define( 'WP_CACHE_KEY_SALT', '?j#^Gaz OO@/LPHk(h8B$I ,pakSz<CI*2,;QLy|c4/#9n{K+JjytcR|6<3Of)+a' );


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

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
