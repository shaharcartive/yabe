<?php
//The entry below were created by iThemes Security to disable the file editor
define( 'DISALLOW_FILE_EDIT', true );

/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'htcvreseifpatas');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'htcvreseifpatas');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'Patasbox84');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'htcvreseifpatas.mysql.db');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'd:g2k@4L]uI,Uxtb[H6^&fWYqS_KN{hceOri}CAyJo)F~#sED7p3MRZ/X(5m0nP9 ');
define('SECURE_AUTH_KEY', ']8ky26Y,^#&suqfOldo%p$mgN<.[_9vSxV~!;IB{Q5RcTi4|/1JwrLEF)CAPGhM0 ');
define('LOGGED_IN_KEY', 'ZF`S|<O8}TMDsqko?t,Xbur{2ywE^mp;4.hWcP9jCU#0KH@IR!5>A&N/axG6QvV1 ');
define('NONCE_KEY', '_fHI]FG?`1eTqLR6PpKM>nBc[N4xmja&z5JvQ*,8/d!$tZWu7DSEb#g|Y3O.X@yi ');
define('AUTH_SALT', 'ZRmvOb2ogWd:DuP`03J,%xp]&_zIHF~Si{nfwq/c!BrK>7Nk4YQC$.E|A@[?UXjh ');
define('SECURE_AUTH_SALT', '7I5Q`HWy&?(B0qsSop_:E]L!~w[e%j4KX6ZuFb8aV9,@}l1)<$mdNkJA*;D|^P/. ');
define('LOGGED_IN_SALT', 'HvWd.|s9?$R^}GOthQFUewoS_&nb*/qC(y52]c6jz!ZBKf<8YPk`ml%I{:~7x3E4 ');
define('NONCE_SALT', '>yiMWnIpeS?m3]CNdjz}Uvh6Z{KuPYD%|QRb5^f9x4(gB@o_E:`c$L~,1*)[F7!O ');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'pb_';

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

define('WP_MEMORY_LIMIT', '96M');

define( 'AUTOMATIC_UPDATER_DISABLED', true );

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');