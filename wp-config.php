<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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
define('DB_NAME', 'hovaco_wp');

/** MySQL database username */
define('DB_USER', 'hovaco_wp');

/** MySQL database password */
define('DB_PASSWORD', 'P#oZ+M~Tu5ac');

/** MySQL hostname */
define('DB_HOST', 'dbhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define( 'WP_MAX_MEMORY_LIMIT' , '512M' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '4t07)Dlv&LP`yIu7hfo2Z[4)+`EGq Oghvu] WO+-ybK^xsl-6jM(GMC-E6hCeY6');
define('SECURE_AUTH_KEY',  '?<*Yw?=.3,gzx;9^WsGdx(I[{Df[SBYc=#2Q,Zp{%y3~?fec-Z?TAbsD>:/q!<[|');
define('LOGGED_IN_KEY',    'GuvgYjoQ`#xSuY?3+P5#ZH|:z:?|,Bgf*mBo /{HP{{FQpgii8|+w<b-evPx~#{]');
define('NONCE_KEY',        '!nXEHGPP+Ty&N1:q99D:@N69Up)nQPHYe-|(+$::iW%BJFS 7J&Xf?6hM-YbH^aS');
define('AUTH_SALT',        'h%CFOTAfw+a@@$/[_ZX/U.<>C08%`wHCDOO#gR^~{CIZ]HB+ZM!=p6mIu90HB+b+');
define('SECURE_AUTH_SALT', 'C`]-!mCTN3W#n@id- P ^0|]%#Vn5/{GHYH-!`k*;t,x4S#i*7#[^NHcE9X`RFdP');
define('LOGGED_IN_SALT',   'kj-#k xhTo;BU~u;YAcM{,sL.<u_,[tG[[VY2AS_vwM6jOhWe1]E(a(8^}3gC/s<');
define('NONCE_SALT',       'FV}HB{7s?&YdZ;JjhycQ5j(g<o(Z_~}h|p@{)tIE#=p{gx]z6@@buYwC;dklq[7s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
$debug = false;
if (isset($_GET['debug']) && $_GET['debug'] == 'true') {
	$debug = true;
}
define('WP_DEBUG', false);
// define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
// define('WP_DEBUG_LOG', true);


//define('RELOCATE',true);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
