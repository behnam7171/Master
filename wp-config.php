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
define('DB_NAME', 'security');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'rAO-;T}0WnsFSbXQ:x01<qiLv8E=1]iaHU#W>[K4!gyz17VQmwJ=`Ea/XFHt+vj5');
define('SECURE_AUTH_KEY',  '&W(}rj!%Powa`sO+Qb>.8kYSPEy^{Y/TK)I Y} ..b}!`argz6eEN7Hy~*aaHG9h');
define('LOGGED_IN_KEY',    'ZQ,PWEOIEwB=-xNU`nG.Rt nXMp[8EI[>TJ:_B%qYszuKnuJ6z7Eed<C0u?@ptCm');
define('NONCE_KEY',        'RTV01 ?&<N/zXwk,7!gi0(A2?Y`5RrSN3eEn[MYw*8& lHfqS4ZE]%BBb!Smz&J#');
define('AUTH_SALT',        'vqiE^it)&:u15}erh4T~+;H<X;2{{DQtue08iR?0 ?K%Ob5, Ik>CF5AZoDXo=k.');
define('SECURE_AUTH_SALT', 'AyaLiv=x]z-{gEk>9&SvVbJDnp(lo`H0t0W?vNL;pTQ}5;hl+dwOyb?,iY<;f]WX');
define('LOGGED_IN_SALT',   'HP l`gD|-kvmQF>T824_nEs,T;h!ON4@MA=xo]40_ Qk4}}=]TD1S-uu$K:RC/(l');
define('NONCE_SALT',       'xdX{iTM<pti9LE-YqTZ;EDN8yge3E`3OYE,cN>Q?gl.zcOiJ}E0@NRA;#tR9qZZq');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
