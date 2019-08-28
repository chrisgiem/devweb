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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpressuser' );

/** MySQL database password */
define( 'DB_PASSWORD', '3a3uyB!j%KDQD4M7Qg59Wk@m' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */


define('AUTH_KEY',         'iJBZ,vBg_t:b^qM:aQah6VZpr/0[qn6^Ba+wc-v>TF(7K1)8^A,jy}9O:<h#5a;r');
define('SECURE_AUTH_KEY',  'mDjb;$>h@r=s`h3j,Tv;-U{eX+VS}U4h~Cw-MK-VgWY]:k{ MKb_V9V3R3!F/~d&');
define('LOGGED_IN_KEY',    'n^P,,ANAXr#y]sA+o,<ePyo(o:}]4xIjti$17X64swjM<%2|?SY_t*m2QpLF@KYB');
define('NONCE_KEY',        '[Mf}RL7pgdZ;N9FNM.RMfuoV2Vjud$vkqj~!k8RJ.=qq>R<gJSFzMt|G)(:1p0t%');
define('AUTH_SALT',        '5Y(l58mEY_{#o?(+/YXhhY,Yd=lLdZ$=M4k8A[w2=u|QknKSCvl3-X*:ZxMTYz#&');
define('SECURE_AUTH_SALT', 'Am+skEY=4,CPwSz~:L_y[~?8|X;6#!&=~?VN5<ECo|j-z}p&I01<yK7zP38TGohY');
define('LOGGED_IN_SALT',   '+e80mh<-++8S~?d1^o`_pr.q=b8?.lqUTpU&#RScRs4OxK y#yE(V(>~R8cMv>Xi');
define('NONCE_SALT',       'ZOwpaps6}@yo|TGfG$G,|:9*{^ISH&!_U2BK>E2-^vn/&bv|TEYL$)Q<l|nPhM~l');





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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
