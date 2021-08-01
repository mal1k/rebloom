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
define('DB_NAME', 'rebloom');

/** MySQL database username */
define('DB_USER', 'db');

/** MySQL database password */
define('DB_PASSWORD', '2O8k5V6p');

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
define('AUTH_KEY',         'd%hUAyb)cahUla@WcH5t#O9Yk3vjT9suJpMnAvBCSsXnxR2Hg*&(6Cfe9Zaa%OJf');
define('SECURE_AUTH_KEY',  'dhjPkZWy&twDomWJGz)Ct%4Ypl69(l0&WEHjHY^awbsKX#I44rTLLn6YK%DV8Q*R');
define('LOGGED_IN_KEY',    'wYOkbNuyrt%Oj#FLTvSYPEXpe5L1k1j@bnF1K@sbOhOdLK%Q07vQ9pMKCs1!dzKw');
define('NONCE_KEY',        'Q9hoQzK17&Nhq^0AmkPi1y1et!MoJ!8Xppv3WfG%jvI4vtnup@R)LRCDGJ0hLgK(');
define('AUTH_SALT',        'yG*SvbGWb0VWf4)D5KRR)eqfnouOAPvlo97k#shrPgbsaVc2^vyvmzu01))CL!iP');
define('SECURE_AUTH_SALT', 'sVmt6MHAyMR8a8&bWTkNrLXl%QPOXh4hjdBV63w^nC)cnIC)BdT8Tr!u1XAf9To6');
define('LOGGED_IN_SALT',   'jEPX6qQMf%ujmNNvglcyHGp32#O2t8&5aw7E6aR9UaL7n66lS50bI(uX&KkUi3qW');
define('NONCE_SALT',       'vw*ztCJ9hb&(H*xrp8pi1H63FTK(Eys5Rng*f3Y796n4aAZiZ0zjt1W%sD4ot1Bm');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rebloom_';

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

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
