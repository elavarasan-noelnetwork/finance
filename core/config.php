<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

/* ========== .env related functions ================ */
    $dotenv = Dotenv::create(__DIR__ . '/..'); // project root where .env is located
    $dotenv->load();
    // Helper function to fetch environment variables
    if (!function_exists('env')) {
        function env(string $key, $default = null) {
            return $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key) ?: $default;
        }
    }
    // Configure error reporting based on APP_DEBUG
    $debug = filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN);
    ini_set('display_errors', $debug ? '1' : '0');
    error_reporting($debug ? E_ALL : (E_ALL & ~E_NOTICE & ~E_WARNING));

/* ========= .env related functions end ================== */

//$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://";
} elseif (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
    || $_SERVER['SERVER_PORT'] == 443
) {
    $protocol = "https://";
} else {
    $protocol = "http://";
}


$domain = $_SERVER['HTTP_HOST'];
$currentUrl = $protocol . $domain;

define('APP_NAME', env('APP_NAME'));
define('BASE_URL', "$currentUrl".'/' );
define('ASSETS_DIR', $currentUrl."/assets" );

define('PDF_UPLOAD_PATH', dirname(__DIR__) . '/pdf_documents/');
define('PDF_UPLOAD_URL', BASE_URL . "pdf_documents/");


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/*========= Set database connections, This variables used in model.php autoload() function ============== */
    if( $_SERVER['HTTP_HOST']=="localhost:8081"){
        //Local ENV DB and Other configs
        define('DB_HOST',env('DB_HOST'));
        define('DB_USERNAME',env('DB_USER'));
        define('DB_PASSWORD',env('DB_PASS'));
        define('DB_DATABASE_NAME',env('DB_NAME'));
    }else{
        //Production ENV DB and Other configs    
        define('DB_HOST',env('DB_HOST'));
        define('DB_USERNAME',env('DB_USER'));
        define('DB_PASSWORD',env('DB_PASS'));
        define('DB_DATABASE_NAME',env('DB_NAME'));
    }
/*========= Set database connections, This variables used in model.php autoload() function end ============== */
