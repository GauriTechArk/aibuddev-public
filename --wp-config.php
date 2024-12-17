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
define( 'AUTH_KEY',          '$]#c?+IgBVL3J-T(_nTEi&x{6NJfY*[&K2-ukRNkSV|t).R3>;_6so0S&q/?rc%D' );
define( 'SECURE_AUTH_KEY',   'kx0h({QX;|p=u&Lql?(cRZJvqQ)<zEv~9]0SmhK2&a?wf<y{ eM;Gx%L Py0kLh_' );
define( 'LOGGED_IN_KEY',     '.*qIMEx]N;`bsa[O;viQP-t8}_>zKGav!6.2=TXaU9>YrdLHH{!v3dw(WWAYa`a2' );
define( 'NONCE_KEY',         '[R5YE^nfMLj_F<$P@~FIEQo}vi2k&eS_Whf[OY,X#*2L|U&,PC4+Wn^9U?x?BW9Q' );
define( 'AUTH_SALT',         '[$}bK46;WI5eY3J>g-yJMSBH~blX:A<`R/nVj8j-<T>lqS>!XU0^X?!8/U_MYvs^' );
define( 'SECURE_AUTH_SALT',  'v|<NOD}12bB}A,0up$1XmoY/E4Ce1rMo*nA}Dz9464VWD~%,.c%/eVe6lFlnFGw)' );
define( 'LOGGED_IN_SALT',    '*#L1@3rF |z ?UeOWgRwp+zJo1a6,YAk6rG<Z)l%/J8:d*:`),5ZO^wJ,nGP5Yt9' );
define( 'NONCE_SALT',        'Rk>J0FL=B#Bg^i`xz$_yri9Ok#9h,N?vGoRLU8YR^R^L0ipj3]rV[y$a}lNRv*%5' );
define( 'WP_CACHE_KEY_SALT', 'ckkWnqp&S)5,yxZ[U-!8_nU={$)&6Al+Y|ER8WVhas=p1)(FW:t?eA8S(AontQ%h' );


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
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
