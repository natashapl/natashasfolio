<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL

//Begin Really Simple SSL Load balancing fix
if ((isset($_ENV["HTTPS"]) && ("on" == $_ENV["HTTPS"]))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "1") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_SSL"]) && (strpos($_SERVER["HTTP_X_FORWARDED_SSL"], "on") !== false))
|| (isset($_SERVER["HTTP_CF_VISITOR"]) && (strpos($_SERVER["HTTP_CF_VISITOR"], "https") !== false))
|| (isset($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_CLOUDFRONT_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strpos($_SERVER["HTTP_X_FORWARDED_PROTO"], "https") !== false))
|| (isset($_SERVER["HTTP_X_PROTO"]) && (strpos($_SERVER["HTTP_X_PROTO"], "SSL") !== false))
) {
$_SERVER["HTTPS"] = "on";
}
//END Really Simple SSL
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/natashapl/natashasfolio.com/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'natashasfolio_com');
/** MySQL database username */
define('DB_USER', 'natashasfoliocom');
/** MySQL database password */
define('DB_PASSWORD', 'tyTsL*uk');
/** MySQL hostname */
define('DB_HOST', 'mysql.natashasfolio.com');
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
define('AUTH_KEY',         '?Ac>CPP+|g-oXT7Jr]Ot<)a7XLxKgEoGp]X>epwv/_Pl?%99t%&.t4VlhqEGc6Ru');
define('SECURE_AUTH_KEY',  ']HyWrF3C$R/n+ooT~/W3B+|o/1,a{MSE<sed9q#Q~3zjiU#`aF|ea?Cz/fJ/lYf?');
define('LOGGED_IN_KEY',    ';-7ISv?{Cck!>P0XG*E}e,nX|)3}pz#0lu3Pm2s;yAc;(Oj@|b1J`xB/p0|8m-e ');
define('NONCE_KEY',        'ES8Ku,@l(V+BqH 7oBFyZ4(2OO046lJ~`etgpxQOmmg-S zomkeX|VoSs+7%F|e)');
define('AUTH_SALT',        '|V:{LMJ^k!7>>KSzOCJyp~EcZc:wI`Du&ZR?*LseSo mIZt)4wMz>X:49M+^XIcp');
define('SECURE_AUTH_SALT', '$Bh}@hcU}}Wi%|(_Jy1NFrbkq=~Zw#2dWgv/t/!Vg)*ODy|ym?,JY*D++YEHLJ|)');
define('LOGGED_IN_SALT',   'k>/)-2b>(n}k6&u3{_P,tzSZWRW|S=kIp!Xq)}0/qT} 4BgXo<[om8K&(F=8Ap1Y');
define('NONCE_SALT',       'pOGg{ST9pS=qNn,UC37BFq98$F1^,Dkf}}vu4FZo0%3xn|D2`tPnw%QZ)|&+fkxp');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_u4dfg6_';
/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);
/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
