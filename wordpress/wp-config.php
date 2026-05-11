<?php
/**
 * GoPrint WordPress Configuration
 * Local development environment setup
 */

// Database Configuration
define('DB_NAME', 'goprint_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Authentication Unique Keys and Salts
define('AUTH_KEY',         '^~3|~g6@11xN5E{@t+}o~o}A+}g#r|T+~*}#|cN|^~r0Z@h*}');
define('SECURE_AUTH_KEY',  ';4#60Z|08R~{:>N$N;q@+k|,wE-;k}@h>~+C:4v{`2|g|');
define('LOGGED_IN_KEY',    'Rw3!v4}0P~C-+J8~g>Jm<|;Q!M-~@#8w@2M-<Y+|R$|#');
define('NONCE_KEY',        '`L3#K~!+1BkG}06Rq~>J+3@y}5+;zQ!6r~#L8`~!-E+|');
define('AUTH_SALT',        '4X:~G2{_~;H#$Nc3F;g8!6@!M+6K`>_N~<9@!9Nv$;8');
define('SECURE_AUTH_SALT', '|>k}#x7`T!6@3G`L+~5E+|;Y#7~`9+!2H!5N}R$`Wk;');
define('LOGGED_IN_SALT',   'Y:5-@9!-}v;_~1P5G`X;~8>2Q!r!+v>@#D;3L!+`_:');
define('NONCE_SALT',       'w#2`_8<x+_`{q0;1~nY5<`l!>!>8y|#P;{>!2~7g`K+');

// WordPress Database Table prefix
$table_prefix = 'wp_';

// WordPress Debug Mode - false for production
define('WP_DEBUG', false);

// Site URL configuration for local dev - WordPress installed in /goprint/wordpress/ subdirectory
define('WP_HOME', 'http://localhost:8888/goprint/wordpress');
define('WP_SITEURL', 'http://localhost:8888/goprint/wordpress');

// Absolute path to the WordPress directory
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Load WordPress
require_once ABSPATH . 'wp-settings.php';
