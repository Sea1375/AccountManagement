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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'account_management' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'GPTTN}C*z<n3(iIyPov-s>pO]&]3,+o7F@i4E?dA7N2G]%I]pw-`m8F4!@g&50xj' );
define( 'SECURE_AUTH_KEY',  'AD[55MAQ/4pW$+jXBvOXRP.je-gmNOQ_OGK]luIuE$wb/J!y@i1#da,=3F~ p67{' );
define( 'LOGGED_IN_KEY',    'cX5mP}oA-ddhNVXqHSZ[XrR p`j2Kb!6-vS=j@7!q0C$ri|Ps%m(ymHkPC^Pl?Tu' );
define( 'NONCE_KEY',        ',7YEm0^;QgJ1D}u~!7ej.t@Xf12$)ls_E8i:D;A>M8UfFFN/pC_tK3>E5fDwry[9' );
define( 'AUTH_SALT',        '#.b2rC%9pAd@`@mvjc|DJ+f56e-83KCrRyX_HuS &HYd!WF%aKT&#^V>>2q7Ba04' );
define( 'SECURE_AUTH_SALT', '?#jhRj+)|?a5f|:L^J:,L5)f]q2B31Wn+tvR0b/V8+pEyeRuhvbp8;3J| )b:pHV' );
define( 'LOGGED_IN_SALT',   '6InQT[OTSjn`Zn^a!25hms;mACo-<55O=mfn;zk;$n=e wnnwd7t0mnJl^tcPWG`' );
define( 'NONCE_SALT',       'b`ovbp$|9fnKaS=yJ0Q7uw*Ns+S?); =%6_i=od2BL7Y^h}hOr_KEI*z6-d`FF <' );

/**#@-*/

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
