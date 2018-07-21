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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_codeaccounting');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '5eK-c5J-Pfn-yc5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ar?ma#`Vl6e]1xE{pyZ5)9Ba<hhv_U@ntr3+-MlSs#6VCFeFn%eOF>K4&`XLow6(');
define('SECURE_AUTH_KEY',  'AS@^3r!^KLTzWp^@%-%OLB!ibLk(8>su`RZ:+2+^.-O-OgJ)h9cKO/on?+?{w-Ze');
define('LOGGED_IN_KEY',    'sCfGXYqn[]A(bX4,m:9096AEK*B_ptW$^EzK `Uf^OqANG?AhCmU+7.9x~^W=aiP');
define('NONCE_KEY',        'gAIvX*|jY4})D4FT:1@&12[G?zQ{F?F]!)%k_~|~A6NSPP=)~%RUH~=>h+R(IzGu');
define('AUTH_SALT',        '+,$d y7h1Y+qBOyuL_Y4#=F2|)| ~4=J 9NF4DtZ|Pxa)*b-Lh9Bn V[^p!#Fu8|');
define('SECURE_AUTH_SALT', '[(|7K)KUvE{pzKj9+8dTJ(=}zl-5n8tVEraTeg en{vq]jNEfP;ezt&`|}45|*<9');
define('LOGGED_IN_SALT',   'CnPr1,#NlCqp7Gy^/B2d6H)|#+,4MZIZ@YRP<1SlVVZ$=]dez&8H 0o7so/CJ7fY');
define('NONCE_SALT',       '8U}cV{GNas9,r/w|k[lN1yrCBT`br3F467lfSEI3<y~o0T<[eKL2..Jx`ZWr4MW~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_v3h9s1rwwc_';


define( 'WP_HOME', 'https://www.codeaccounting.com' );
define( 'WP_SITEURL', 'https://www.codeaccounting.com' );

define('RELOCATE',true);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
