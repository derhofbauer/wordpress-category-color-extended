<?php
/**
 * The base configuration for WordPress.
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
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'wordpress');

/* MySQL database username */
define('DB_USER', 'wordpress');

/* MySQL database password */
define('DB_PASSWORD', 'password');

/* MySQL hostname */
define('DB_HOST', 'wordpressdb:3306');

/* Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/* The Database Collate type. Don't change this if in doubt. */
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
define('AUTH_KEY', '*1lk5z(b?0(CQ-%t(U9-H:IP+|D[!qT4Qy&O[(p,G,x/`Zw2~p`/nU#^8g|4,Xrl');
define('SECURE_AUTH_KEY', '^R>7mY/W#2!WOp[$hH[95*I8A4~GkpwWQx&D!f8WgK++jR$C#}>g2f4#O !DU?fB');
define('LOGGED_IN_KEY', '$]q| Q>i|<*TSM,MK+?p<j;IMr_?(,bN)oSao4H_5CZAIl3kjg}gzr#1KHAFwG{k');
define('NONCE_KEY', '~:/O>gNjdyvY| !_5*s%n+-Y?B)^F yo20nX,4d/5v%@NbLN#cx^M6 +CN|@bc([');
define('AUTH_SALT', 'vmHHe;.iu9^@EoZ$hYxH,GLv~<-B@VN7N.P=IJu^x#*|A-(GC#x?g^`VV)`S{AY2');
define('SECURE_AUTH_SALT', 'olKDs[Q,P$G-Lwdl0{KB(R+S=kqGP^KYdK(8$G+XrrS2-Nl4WO+7,fv)!E?edLiD');
define('LOGGED_IN_SALT', '4-D^<uLdTA|MrgcugZkHJ}?x0J0|FnK77[O3;TOh_9Y{&^,|j%FPknV5+LJ6*[Fb');
define('NONCE_SALT', 'p-fr)n4,,L[0d@3ZQGHMrc6!3xlfmGge(opC(MKPI:bY,ow4hElbowBZ_d?5GZCI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/*
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

/* Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__).'/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH.'wp-settings.php';
